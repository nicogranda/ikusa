<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Guía paso a paso para configurar un email corporativo dentro de GMail con capturas de pantalla detalladas.">
    <meta name="keywords" content="email corporativo, GMail, configuración email, correo IMAP, pasos configuración email">
    <meta name="author" content="Nicolás Granda Bauza">
    <meta property="og:title" content="Configura tu Email Corporativo en GMail">
    <meta property="og:description" content="Aprende a configurar un correo corporativo en GMail siguiendo esta guía completa con imágenes.">
    <meta property="og:image" content="https://ikusa.net/images/og/website.png">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.ikusa.net">
    <title>Configura tu Email Corporativo en GMail</title>
    <style>
        .gallery {
            width: 80%;
            margin: 0 auto;
            padding: 20px 0;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        .products img {
            width: 100%;
            display: block;
        }

        .product-item {
            text-align: center;
        }

        .step-text {
            display: flex;
            align-items: flex-start;
            margin-top: 10px;
            font-family: Montserrat, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .step-circle {
            background-color: orangered;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            margin-right: 10px;
            flex-shrink: 0;
        }

        @media only screen and (max-width: 800px) {
            .products {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

    <h1 class="principal">Email corporativo dentro de GMail</h1>
    <h2 style="text-align: center;"> Androide</h2>
    <div class="gallery">   
        <div class="products">
            <?php 
            $step = [
                1 => "Ubica el icono de GMail",
                2 => "Haz clic en el avatar de tu cuenta regular en GMail",
                3 => "Haz clic en Añadir otra cuenta",
                4 => "Selecciona: Otro servicio",
                5 => "Escribe tu email Corporativo",
                6 => "Dale a siguiente",
                7 => "Selecciona: Personal (IMAP)",
                8 => "Escribe la clave",
                9 => "Dale a siguiente",
                10 => "Dale a siguiente",
                11 => "Dale a siguiente",
                12 => "Dale a siguiente",
                13 => "Verifica y si es necesario modifica tu nombre y dale a siguiente",
                14 => "Verifica que ya es una opción dentro de tus emails"
            ];

            $dir = "images/email-corporativo/";
            $images = [];

            if ($direc = @opendir($dir)) {
                while ($file = readdir($direc)) {
                    if ($file != "." && $file != ".." && $file != ".DS_Store") {
                        $images[] = $file;
                    }
                }
                closedir($direc);
            } else {
                die("Permiso denegado");
            }

            sort($images);
            $i = 0;

            foreach ($images as $file) {
                $i++;
                $ruta = $dir . $file;
                echo "<div class='product-item'>";
                echo "<img src='" . htmlspecialchars($ruta) . "' alt='" . htmlspecialchars($file) . "' />";
                if (isset($step[$i])) {
                    echo "<p class='step-text'>";
                    echo "<span class='step-circle'>$i</span> " . htmlspecialchars($step[$i]);
                    echo "</p>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

