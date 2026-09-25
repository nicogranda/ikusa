<?php
// models/BusinessType.php

// Inicialización de la variable para almacenar los resultados
$business_types = [];

// Asegúrate de que la consulta esté funcionando correctamente
$business_typesSQL = $mysqli->query("SELECT * FROM business_types ORDER BY name");

// Verifica si la consulta fue exitosa
if ($business_typesSQL) {
    // Itera sobre los resultados
    while ($row = $business_typesSQL->fetch_assoc()) {
        $business_types[] = $row;
    }
} else {
    // Si hay un error con la consulta, muestra un mensaje de error
    echo "Error en la consulta SQL: " . $mysqli->error;
}

// Si quieres ver los datos que se han recuperado
//var_dump($business_types); // Esto te ayudará a verificar los resultados

?>