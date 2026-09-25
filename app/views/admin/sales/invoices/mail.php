<?php
$head_message = "
<html>
<body>
<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>
    <tr><td style='height:30px;'></td></tr>
    <tr><td>
        <table align='center' width='80%' border='0' cellpadding='20' cellspacing='0' style='background-color: white;'>
            <tr>
                <td>
                <thead>
                    <tr height='30'>
                    <th colspan='5' style='text-align:center;padding:20px;'>
                        <a href=''><img src='https://ikusa.net/assets/img/logo.png' alt='Ikusa' width='200px'></a>
                    </th>
                    </tr>
                </thead>";
    
$body_message = "
            <tbody>
            
            
            <tr>
                <td colspan='5' style='padding:0 0 0 15px;'>
                    <p style='font-size:16;'>
		                Señor(es)<br>
		                <b>".$business['name']."</b>
		                <br><br><br>	
		                Estimado(s) Señor(es)<br><br>

	 	                Reciban un cordial saludo con la presente, a través de la cual hacemos entrega de la factura según servicios indicados en la misma. 
	 	            </p>
	 	        </td>
            </tr>";    
      
        

$foot_message = "
            <tr>
        	   <td colspan='5' style='padding:0 0 0 15px;'>
                    <p style='font-size:16;'>
    			        Sin otro particular al cual hacer referencia, quedamos a su disposición.<BR><BR>
    			         Atentamente<BR><BR><BR> 
    			</td>
    		</tr>



            <tr>
                <td colspan='5' style='padding:15px; text-align:center;'>
                    <a href='".$invoiceLink."' style='color:#fff; text-decoration:none; background-color:orangered; display:inline-block; padding:12px 24px; font-size:14px; border-radius:4px;'>
                        Descargar Factura (PDF)
                    </a>
                </td>
            </tr>
		
            <tr>
                <td colspan='5' style='padding:0 0 0 15px;'>
                    <p style='font-size:14px; color: #626262; line-height: 1;'>
                        <b>Ikusa LLC</b><br>
                        <span style='font-size:12px; line-height: 0.8;'>
                            8735 Dunwoody Place, Ste R<br>
                            Atlanta, GA 30350<br>
                            United States
                        </span>
                    </p>
                </td>
            </tr>
            
	    	<tr>
                <td colspan='5' style='padding:0 0 0 15px;'>
        	   	<p style='font-size:16px; color: #626262; line-height: 1;'>
                    <b>Nicolás Granda</b><br>
                    <span style='font-size:12px; line-height: 0.8;'>
                        Calle General Freire, 5<br>
                        Irún, Guipúzcoa 20303<br>
                        España<br>
                        <a href='https://wa.me/34600142663' style='color:#626262; text-decoration:none;'>WhatsApp +34 600 142 663</a><br>
                    </span>
                </p>
    		    </td>
    		</tr>
    		
<tr height='50px'>
    <td colspan='5' style='width:90%; height:55px; text-align:center;'>
        <a href='https://ikusa.net' style='color:#fff; text-decoration:none; background-color:#E10B76; display:inline-block; width:27%; padding:15px 0; font-size:10px'>
            Design
        </a>
        <a href='https://ikusa.net' style='color:#fff; text-decoration:none; background-color:#10C3F3; display:inline-block; width:27%; padding:15px 0; font-size:10px'>
            Web Site
        </a>
        <a href='https://ikusa.net' style='color:#fff; text-decoration:none; background-color:#3ED53E; display:inline-block; width:27%; padding:15px 0; font-size:10px'>
            Marketing
        </a>
    </td>
</tr>

    	<tr align='center' height='30'>
    	    <td colspan='5' style='text-align:center; width:25%;padding:15px;'>
        		<a href='https://facebook.com/ikusa.creativestudio'><img src='https://ikusa.net/assets/img/rrss/facebook.png' width='35px' height='auto'></a>
        		<a href='https://instragram.com/ikusa.creativestudio'><img src='https://ikusa.net/assets/img/rrss/instagram.png' width='35px' height='auto'></a>
        	    <a href='https://linkedin.com/company/ikusacreativestudio/?viewAsMember=true'><img src='https://ikusa.net/assets/img/rrss/linkedIn.png' width='35px' height='auto'></a>
        		<a href='https://api.whatsapp.com/send?phone=+34600142663'><img src='https://ikusa.net/assets/img/rrss/youtube.png' width='35px' height='auto'></a>
            </td>
        </tr> 
        
            <tr>
    		    <td colspan='5' style='padding:15px;'>
    				<p style='font-size:12; color: #626262;'>
    				<b>Información básica sobre protección de datos</b> <br>
    
    				<b>Ikusa LLC</b>, como responsable del diseño,
    				le informa que sus datos son recabados con la finalidad de: 
    				Gestión de los datos de contacto para las comunicaciones de la empresa.
    				La base jurídica para el tratamiento es el interés legítimo del responsable.
    				Sus datos no se cederán a terceros salvo obligación legal.
    				Cualquier persona tiene derecho a solicitar el acceso, rectificación, supresión, 
    				limitación del tratamiento, oposición o derecho a la portabilidad de sus datos personales,
    				escribiéndonos a la dirección de nuestras oficinas, o enviando un correo electrónico a 
    				<a href='mailto:contact@ikusa.net'>contact@ikusa.net</a>, 
    				indicando el derecho que desea ejercer. Puede obtener información adicional en el apartado de 
    				PROTECCION DE DATOS de nuestra página web: <a href='https://ikusa.net'>https://ikusa.net</a>
    				</p>
    			</td>
           </tr>
        
        </tbody>
    
        </table>
    </td></tr>
    
    <tr><td style='height:30px;'></td></tr>
</table>
</body>
</html>";


$body = $head_message.$body_message.$foot_message;
?>