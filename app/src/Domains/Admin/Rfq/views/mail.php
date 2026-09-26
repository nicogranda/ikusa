<?php

// ----------------------------
// Seguridad básica de variables
// ----------------------------
$greeting_message = $greeting_message ?? '';
$farewell_message = $farewell_message ?? '';
$items = $items ?? [];
$rfq = $rfq ?? [];
$supplier = $supplier ?? [];

// ----------------------------
// Logo / cabecera
// ----------------------------
$head_message = "
<div style='text-align:center; padding:20px 0;'>
    <img src='https://ikusa.net/images/logo.png' width='200px' alt='Ikusa'>
</div>
<hr>
";

// ----------------------------
// BODY
// ----------------------------
$body_message = "
<table width='100%' cellpadding='8' cellspacing='0' style='font-family:Arial; font-size:14px;'>

    <tr>
        <td>
            <p>
                Estimado/a <b>" . ($supplier['name'] ?? 'Proveedor') . "</b>,
            </p>

            <p>
                A continuación le solicitamos cotización para los siguientes productos:
            </p>
        </td>
    </tr>

    <tr>
        <td>
            <table width='100%' border='1' cellspacing='0' cellpadding='6'>
                <tr style='background:#f2f2f2; text-align:center;'>
                    <th align='left'>Producto</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                </tr>
";

// ----------------------------
// ITEMS (IMPORTANTE: SIN foreach roto)
// ----------------------------
foreach ($items as $item) {

    $body_message .= "
        <tr>
            <td>" . ($item['product_name'] ?? '') . "</td>
            <td align='center'>" . ($item['qty'] ?? '') . "</td>
            <td align='center'>" . ($item['unit'] ?? '') . "</td>
        </tr>
    ";
}

$body_message .= "
            </table>
        </td>
    </tr>

    <tr>
        <td style='padding-top:20px;'>
            <p>" . nl2br($farewell_message) . "</p>
        </td>
    </tr>

    <tr>
        <td style='padding-top:20px;'>
            <b>Ikusa LLC</b><br>
            Procurement Department<br>
            contact@ikusa.net
        </td>
    </tr>

</table>
";

// ----------------------------
// FOOTER
// ----------------------------
$foot_message = "
<hr>
<div style='text-align:center; font-size:12px; color:#888;'>
    Este correo fue generado automáticamente por el sistema RFQ de Ikusa.
</div>
";

// ----------------------------
// OUTPUT FINAL (ESTO ES LO IMPORTANTE)
// ----------------------------
$body  = "<html><body>";
$body .= $head_message;
$body .= $body_message;
$body .= $foot_message;
$body .= "</body></html>";