<?php
/**
 * checkout_affiliate_hook_ejemplo.php
 *
 * Ejemplo de como se ve el flujo dentro de tu OrdersController /
 * CheckoutController real. Adapta los nombres de metodos/variables
 * a tu implementacion actual — esto muestra DONDE va cada llamada.
 *
 * Requiere haber incluido 02_affiliate_tracking_helper.php
 */

class CheckoutController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * PASO 1 — Pantalla de carrito/checkout (antes de pagar)
     * Aqui es donde el cliente VE el descuento reflejado en el total.
     */
    public function renderCheckoutTotals(float $cartSubtotal): array
    {
        // El cliente puede escribir un codigo a mano en un input "Codigo de descuento"
        $manualCode = $_POST['affiliate_code'] ?? $_GET['affiliate_code'] ?? null;

        $affiliateDiscount = calculateAffiliateDiscountForCart(
            $this->db,
            $cartSubtotal,
            $manualCode
        );

        if ($affiliateDiscount) {
            return [
                'subtotal'          => $cartSubtotal,
                'discount_applied'  => true,
                'discount_code'     => $affiliateDiscount['affiliate_code'],
                'discount_rate'     => $affiliateDiscount['discount_rate'],
                'discount_amount'   => $affiliateDiscount['discount_amount'],
                'total_to_charge'   => $affiliateDiscount['subtotal_after_discount'],
            ];
        }

        return [
            'subtotal'         => $cartSubtotal,
            'discount_applied' => false,
            'total_to_charge'  => $cartSubtotal,
        ];
    }

    /**
     * PASO 2 — Confirmar pedido (boton "Pagar" / "Finalizar compra")
     * Aqui ya se crea el pedido en la DB y se cobra al cliente el
     * total CON descuento ya aplicado.
     */
    public function completeOrder(int $userId, float $cartSubtotal, array $cartItems): array
    {
        $manualCode        = $_POST['affiliate_code'] ?? null;
        $affiliateCode     = getActiveAffiliateCodeForCheckout($manualCode);
        $affiliateDiscount = null;
        $totalToCharge     = $cartSubtotal;

        if ($affiliateCode) {
            $affiliateDiscount = calculateAffiliateDiscountForCart(
                $this->db,
                $cartSubtotal,
                $affiliateCode
            );
            if ($affiliateDiscount) {
                $totalToCharge = $affiliateDiscount['subtotal_after_discount'];
            }
        }

        // --- Aqui va tu logica actual de crear el pedido ---
        // Ejemplo simplificado:
        $stmt = $this->db->prepare(
            "INSERT INTO orders (user_id, subtotal, total, created_at)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param('idd', $userId, $cartSubtotal, $totalToCharge);
        $stmt->execute();
        $orderId = $this->db->insert_id;
        $stmt->close();

        // --- Aqui va tu logica de guardar cartItems en order_items ---
        // ... (tu codigo existente) ...

        // PASO 3 — Una vez creado el pedido, se vincula al afiliado y
        // se genera su comision. Se hace DESPUES de tener el $orderId
        // porque la tabla commissions requiere order_id.
        if ($affiliateCode) {
            attributeOrderToAffiliate(
                $this->db,
                $orderId,
                $cartSubtotal, // subtotal ORIGINAL, sin descuento
                $affiliateCode
            );
        }

        return [
            'success'  => true,
            'order_id' => $orderId,
            'total_charged' => $totalToCharge,
        ];
    }
}
