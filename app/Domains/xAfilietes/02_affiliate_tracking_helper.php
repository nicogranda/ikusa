<?php
/**
 * affiliate_tracking_helper.php
 *
 * Incluir este archivo en tu bootstrap principal (ej. index.php o el
 * archivo que se ejecuta en cada request, antes del router).
 *
 * Logica:
 * - Si llega ?ref=CODIGO en la URL, busca el afiliado por referral_code
 * - Si existe y esta approved, guarda una cookie de 30 dias con su ID
 * - Registra el clic en affiliate_clicks (para estadisticas)
 *
 * Requiere: $mysqli (conexion MySQLi ya abierta) disponible en el scope
 * donde se incluya este archivo.
 */

const AFFILIATE_COOKIE_NAME = 'mc_affiliate_ref';
const AFFILIATE_COOKIE_DAYS = 30;

function trackAffiliateReferral(mysqli $mysqli): void
{
    if (empty($_GET['ref'])) {
        return;
    }

    $referralCode = trim($_GET['ref']);
    $affiliate    = getApprovedAffiliateByCode($mysqli, $referralCode);

    if (!$affiliate) {
        // Codigo invalido o afiliado no aprobado: no hacemos nada
        return;
    }

    $affiliateId = (int) $affiliate['id'];

    // Guardamos el CODIGO (no solo el ID) para poder auto-aplicar el
    // descuento en el checkout sin que el cliente tenga que escribirlo.
    $expire = time() + (AFFILIATE_COOKIE_DAYS * 24 * 60 * 60);
    setcookie(AFFILIATE_COOKIE_NAME, $referralCode, [
        'expires'  => $expire,
        'path'     => '/',
        'secure'   => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    // Registrar el clic para estadisticas del afiliado
    $ip        = $_SERVER['REMOTE_ADDR'] ?? null;
    $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
    $landing   = substr($_SERVER['REQUEST_URI'] ?? '', 0, 255);

    $stmt = $mysqli->prepare(
        "INSERT INTO affiliate_clicks (affiliate_id, ip_address, user_agent, landing_url)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param('isss', $affiliateId, $ip, $userAgent, $landing);
    $stmt->execute();
    $stmt->close();
}

/**
 * Funcion central de validacion. Se usa en 3 momentos:
 * 1) trackAffiliateReferral() cuando llega ?ref= en la URL
 * 2) El checkout, para auto-aplicar el codigo guardado en cookie
 * 3) El checkout, si el cliente escribe el codigo a mano
 *
 * Devuelve: ['id', 'referral_code', 'commission_rate', 'customer_discount_rate'] o null
 */
function getApprovedAffiliateByCode(mysqli $mysqli, string $code): ?array
{
    $stmt = $mysqli->prepare(
        "SELECT id, referral_code, commission_rate, customer_discount_rate
         FROM affiliates
         WHERE referral_code = ? AND status = 'approved'
         LIMIT 1"
    );
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $affiliate = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $affiliate ?: null;
}

/**
 * Devuelve el codigo de afiliado activo para el checkout actual, dando
 * prioridad al codigo escrito a mano por el cliente sobre el de la cookie.
 */
function getActiveAffiliateCodeForCheckout(?string $manualCode): ?string
{
    if (!empty($manualCode)) {
        return trim($manualCode);
    }
    if (!empty($_COOKIE[AFFILIATE_COOKIE_NAME])) {
        return $_COOKIE[AFFILIATE_COOKIE_NAME];
    }
    return null;
}

/**
 * Llamar esta funcion en el momento de crear el pedido (checkout completado)
 * para vincular el pedido al afiliado, registrar el descuento dado al
 * cliente, y generar la comision sobre el subtotal YA descontado.
 *
 * IMPORTANTE: llamar a esta funcion con el MISMO $affiliateCode que ya
 * validaste y usaste para calcular el descuento del carrito — no la
 * vuelvas a resolver por separado, para evitar que el descuento mostrado
 * al cliente y la comision registrada queden basadas en afiliados distintos.
 *
 * @param mysqli $mysqli
 * @param int    $orderId
 * @param float  $orderSubtotalOriginal Subtotal sin envio, ANTES del descuento
 * @param string|null $affiliateCode Codigo ya resuelto por getActiveAffiliateCodeForCheckout()
 */
function attributeOrderToAffiliate(
    mysqli $mysqli,
    int $orderId,
    float $orderSubtotalOriginal,
    ?string $affiliateCode
): void {
    if (empty($affiliateCode)) {
        return;
    }

    $affiliate = getApprovedAffiliateByCode($mysqli, $affiliateCode);
    if (!$affiliate) {
        return; // Codigo invalido o afiliado ya no aprobado: no se atribuye nada
    }

    $affiliateId    = (int) $affiliate['id'];
    $commissionRate = (float) $affiliate['commission_rate'];
    $discountRate   = (float) $affiliate['customer_discount_rate'];

    $discountAmount        = round($orderSubtotalOriginal * ($discountRate / 100), 2);
    $subtotalAfterDiscount = round($orderSubtotalOriginal - $discountAmount, 2);
    $commissionAmt         = round($subtotalAfterDiscount * ($commissionRate / 100), 2);

    // Vincular el pedido + guardar el descuento aplicado (para la factura)
    $stmt = $mysqli->prepare(
        "UPDATE orders SET affiliate_id = ?, affiliate_discount_amount = ? WHERE id = ?"
    );
    $stmt->bind_param('idi', $affiliateId, $discountAmount, $orderId);
    $stmt->execute();
    $stmt->close();

    // Crear la comision (pendiente hasta que pase la ventana de devolucion)
    $stmt = $mysqli->prepare(
        "INSERT INTO commissions
            (affiliate_id, order_id, order_subtotal_original, discount_rate,
             discount_amount, order_subtotal_after_discount,
             commission_rate, commission_amount, status)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')"
    );
    $stmt->bind_param(
        'iidddddd',
        $affiliateId,
        $orderId,
        $orderSubtotalOriginal,
        $discountRate,
        $discountAmount,
        $subtotalAfterDiscount,
        $commissionRate,
        $commissionAmt
    );
    $stmt->execute();
    $stmt->close();
}

/**
 * Llamar en el CARRITO/CHECKOUT (antes de confirmar el pedido) para
 * calcular cuanto descuento aplicar al total mostrado al cliente.
 * No modifica nada en la DB, solo calcula.
 *
 * Devuelve: ['affiliate_code', 'discount_rate', 'discount_amount', 'subtotal_after_discount']
 * o null si no hay codigo activo/valido.
 */
function calculateAffiliateDiscountForCart(
    mysqli $mysqli,
    float $cartSubtotal,
    ?string $manualCode
): ?array {
    $code = getActiveAffiliateCodeForCheckout($manualCode);
    if (!$code) {
        return null;
    }

    $affiliate = getApprovedAffiliateByCode($mysqli, $code);
    if (!$affiliate) {
        return null;
    }

    $discountRate   = (float) $affiliate['customer_discount_rate'];
    $discountAmount = round($cartSubtotal * ($discountRate / 100), 2);

    return [
        'affiliate_code'          => $affiliate['referral_code'],
        'discount_rate'           => $discountRate,
        'discount_amount'         => $discountAmount,
        'subtotal_after_discount' => round($cartSubtotal - $discountAmount, 2),
    ];
}
