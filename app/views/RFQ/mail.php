<?php

$rfq_number = $operation['id'] ?? '000000';
$rfq_year = date('Y');

$head_message = "
<html>
<body style='margin:0;padding:0;background:#f2f2f2;font-family:Arial,sans-serif;'>

<table width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td style='padding:40px 0;'>


<table align='center' width='600' cellpadding='0' cellspacing='0'
style='background:white;border-radius:12px;overflow:hidden;'>


<tr>
<td style='text-align:center;padding:35px;background:#111;'>

<img src='https://ikusa.net/assets/img/logo-white-ikusa.png'
width='180'
alt='Ikusa'>

</td>
</tr>
";



$body_message = "

<tr>
<td style='padding:35px;'>

<h2 style='color:#222;margin-top:0;'>
Solicitud recibida correctamente
</h2>


<div style='background:#FF4500;padding:18px 20px;border-radius:8px;color:white;margin-bottom:30px;'>

<p style='margin:0 0 5px;font-size:14px;'>
Número de solicitud
</p>

<strong style='font-size:24px;'>
IK-RFQ-".$rfq_year."-".$rfq_number."
</strong>

</div>


<p style='font-size:16px;color:#555;line-height:1.6;'>

Hola <strong>".$business['name']."</strong>,<br><br>

Hemos recibido correctamente tu solicitud de presupuesto.

Nuestro equipo revisará la información enviada y nos pondremos en contacto contigo para preparar una propuesta adaptada a tus necesidades.

</p>


<hr style='border:none;border-top:1px solid #eee;margin:30px 0;'>


<h3 style='color:#222;'>
Servicios solicitados
</h3>


<table width='100%' cellpadding='10' cellspacing='0'
style='border-collapse:collapse;'>


<tr style='background:#FF4500;color:white;'>

<th align='left'>
Servicio
</th>

<th align='center'>
Unidad
</th>

<th align='center'>
Cantidad
</th>

</tr>

";



foreach ($operation_details as $operation_detail) {


$body_message .= "

<tr style='border-bottom:1px solid #eee;'>

<td>

<strong>
".$operation_detail['product_name']."
</strong>

<br>

<span style='font-size:12px;color:#777;'>
".$operation_detail['note']."
</span>

</td>


<td align='center'>
".$operation_detail['unit']."
</td>


<td align='center'>
".$operation_detail['quantity']."
</td>

</tr>

";

}



$body_message .= "

</table>



<div style='background:#f7f7f7;padding:20px;border-radius:8px;margin-top:30px;'>

<p style='margin:0;color:#555;font-size:14px;line-height:1.5;'>

Si no recibes nuestra respuesta en las próximas horas,
revisa la carpeta de <strong>spam o correo no deseado</strong>.

</p>

</div>


</td>
</tr>

";

$foot_message = "

<tr>
<td style='padding:35px;background:#fafafa;'>


<div style='margin-left:25px;text-align:left;'>

<p style='font-size:14px;color:#555;line-height:1.7;margin:0;'>


Gracias por confiar en Ikusa.


<br><br>


<strong style='font-size:16px;color:#222;'>
Nicolás Granda
</strong>

<br>

Manager

<br>


General Freire Kalea 5<br>
Irún, Gipuzkoa 20303<br>
España

<br>


WhatsApp: +34 600 14 26 63

<br>

<a href='https://ikusa.net'
style='color:#FF4500;text-decoration:none;'>
ikusa.net
</a>

</p>

</div>

<hr style='border:none;border-top:1px solid #eee;margin:25px 0;'>

<p style='font-size:11px;color:#999;text-align:center;line-height:1.5;'>

Ikusa LLC<br>

8735 Dunwoody Place, Ste R<br>
Atlanta, GA 30350<br>
United States

</p>

</td>
</tr>


</table>

</td>
</tr>

</table>

</body>
</html>

";



$body = $head_message.$body_message.$foot_message;

?>