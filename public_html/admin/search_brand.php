<?php 
    $brand = $_GET["alias"];
    require('../app/config/connection.php');

    $email = '';
    $business_type = '';
    $client = '';

    // Obtener información del cliente
    $clients = $mysqli->query("SELECT * FROM clients WHERE alias='$brand'");
    while ($row = $clients->fetch_assoc()) {
        $client_id = $row["id"]; 
        $email = $row["email"]; 
        $client = $row["name"]; 
        $business_type = $row["business_type"];
    }

    // Obtener información del briefing
    $briefings = $mysqli->query("SELECT * FROM briefings WHERE client_id='$client_id'");
    while ($row = $briefings->fetch_assoc()) {
        $briefing_id = $row['id'];
        $logotype = $row['logotype'];
        $color_palette = $row['color_palette'];
        $fonts = $row['fonts'];
        $photos = $row['photos'];
        $rrss = $row['rrss'];
        $slogan = $row['slogan'];
    }
?>

<!-- Valores ocultos de la base de datos -->
<input type='hidden' name='email' id='email' value='<?php echo $email;?>'>
<input type='hidden' name='client' id='client' value='<?php echo $client;?>'>
<!--<input type='hidden' name='business_type' id='business_type' value='<?php //echo $business_type;?>'>-->

<!-- Valores para cada parte del briefing -->
<input type='hidden' name='logotype' id='logotype' value='<?php echo $logotype;?>'>
<input type='hidden' name='color_palette' id='color_palette' value='<?php echo $color_palette;?>'>
<input type='hidden' name='fonts' id='fonts' value='<?php echo $fonts;?>'>
<input type='hidden' name='photos' id='photos' value='<?php echo $photos;?>'>
<input type='hidden' name='slogan' id='slogan' value='<?php echo $slogan;?>'>
<input type='hidden' name='rrss' id='rrss' value='<?php echo $rrss;?>'>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
    // Asegurarse de que la ventana padre está disponible
    if (window.opener && window.opener.document) {
        // Copiar valores al documento de la ventana principal
        window.opener.document.getElementById('email').value = document.getElementById('email').value;
        window.opener.document.getElementById('client').value = document.getElementById('client').value;
        window.opener.document.getElementById('business_type').value = document.getElementById('business_type').value;

        var briefingElement = window.opener.document.getElementsByClassName('briefing')[0];
        briefingElement.style.display = 'block';

        // Función para marcar el radio "Yes" o "No" basado en el valor (0 o 1)
        function setRadioValue(inputIdYes, inputIdNo, value) {
            if (value === '1' || value === 1) {
                window.opener.document.getElementById(inputIdYes).checked = true;
            } else if (value === '0' || value === 0) {
                window.opener.document.getElementById(inputIdNo).checked = true;
            }
        }

        // Marcar los radio buttons con base en los valores de la base de datos
        setRadioValue('product_1_yes', 'product_1_no', document.getElementById('logotype').value);
        setRadioValue('product_2_yes', 'product_2_no', document.getElementById('color_palette').value);
        setRadioValue('product_3_yes', 'product_3_no', document.getElementById('fonts').value);
        setRadioValue('product_4_yes', 'product_4_no', document.getElementById('photos').value);
        setRadioValue('product_23_yes', 'product_23_no', document.getElementById('slogan').value);

        // Cerrar la ventana actual una vez que los valores se hayan copiado
        window.close();
    }
});

</script>
