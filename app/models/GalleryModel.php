<head>
<style type="text/css">	

    .products {
        display: flex; /* Utilizar Flexbox para el contenedor */
        flex-wrap: wrap; /* Permitir que los elementos se envuelvan si es necesario */
        justify-content: center; /* Centrar horizontalmente */
        align-items: center; /* Centrar verticalmente (si es necesario) */
        width: 80%;
        margin: 0 auto; /* Centrar el contenedor dentro del elemento padre */
    }
    
    .products img {
        width: 27%;
        padding: 20px;
    }


    #filler {
        width: 27%;
        height: auto;
        background-color: orangered;
    }
   

@media only screen and (max-width: 800px) {
    
	.products {
		display: block;
		width: 100%;
        padding: 0 20 5 0;
       
	}

    .products img {
		position: relative;
		display: inline-block;
		width: 100%;
		padding: 20px 0 10px 0;
		
    }

} 
   </style>
</head>


<div class='products'>   
<?php 
    $t = 0;
    $dir = "images/gallery/";
    
    // Verificar si el directorio existe
    if (is_dir($dir)) {
        $direc = opendir($dir);

        // Asegurarse de que el directorio se abre correctamente
        if ($direc) {
            // Leer el directorio
            while (($file = readdir($direc)) !== false) {
                // Ignorar los directorios "." y ".."
                if ($file != "." && $file != "..") {
                    $ruta = $dir . $file;
                    $t++;
                    echo "<img src='" . $ruta . "' alt='" . htmlspecialchars($file) . "' title='" . htmlspecialchars($file) . "'/>";
                }
            }

            // Cerrar el directorio después de usarlo
            closedir($direc);
        } else {
            echo "<p>Error: No se pudo abrir el directorio.</p>";
        }
    } else {
        echo "<p>Error: El directorio no existe.</p>";
    }
?>
</div>
