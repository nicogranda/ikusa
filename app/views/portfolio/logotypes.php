<head>
<!--<title>Crear Logotipos en Donostia | Ikusa </title>-->

<!--<meta name="description" content="Bienvenidos a nuestro logofolio, donde el diseño minimalista y los colores planos crean identidades visuales elegantes y funcionales. -->
<!--    Destacamos en bordados, serigrafía y más, con un enfoque en la Promesa Única de Venta de cada marca.">-->
    	
<meta name="keywords"
    content="Logos, Branding, Identidad Visual, Identidad Corporativa, Donostia, San Sebastian, Puerto Ordaz, Atlanta"/>
		
<meta property="og:title" content="Logo"/>

<meta property="og:description" content="Bienvenidos a nuestro logofolio, donde el diseño minimalista y los colores planos crean identidades visuales elegantes y funcionales. 
    Destacamos en bordados, serigrafía y más, con un enfoque en la Promesa Única de Venta de cada marca."/>

<meta property="og:image" content="https://ikusa.net/assets/img/og/logofolio.png" />

<meta name="robots" content="index,follow">

<link rel="canonical" href="<?php echo $currentUrl; ?>" />

     <style type="text/css">
     
        .gallery {
            width: 80%;
            margin: 0 auto;
            margin-top: 70px;
            padding-top: 50px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 20px;
            margin: 0 auto;
        }

        .products img {
            width: 100%;
        }

        .shadow-basic {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }
        
        
    @media only screen and (max-width: 800px) {
        .products {
            grid-template-columns: 1fr;
        }
    }

    </style>
</head>

 
<div class='gallery'>   
    <div class='products'>   
    
    <?php 
        $t=0;
        $dir="assets/img/portfolio/logos";
        $direc=@opendir($dir) or die("permiso denegado");
        while ($file = readdir($direc)) {
            if ($file != "." && $file != "..") {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $route = "/assets/img/portfolio/logos/" . $file;
                // echo "<img src='/assets/img/ . "' alt='" . $filename . "' title='" . $filename . "' />";
                echo "<img src='" . $route . "' alt='" . $filename . "' title='" . $filename . "' />";              
            }
        }
    ?>
    </div>
</div>
    <h1 class='principal'>Logos</h1>  	
    <p class="introduces">
    Bienvenidos a nuestro logofolio,  con tendencia al diseño minimalista. La simplicidad no sólo es elegante, sino que también es funcional, especialmente en productos publicitarios como bordados, serigrafía y sellos. Cada diseño que presentamos aquí está pensado para destacar, no solo en apariencia, sino también en aplicación.
En una identidad visual, realizamos un exhaustivo estudio de marketing (marketing research) que nos permite comprender el impacto que los colores y las tipografias (fonts) tienen en la percepción de una marca. Esta investigación nos guía en la creación de una identidad visual que resuene con los valores de nuestros clientes y su público objetivo.
Nos enfocamos en cómo estas fuentes pueden asociarse con el eslogan de la marca, convirtiéndolo en la Promesa Única de Venta (Unique Selling Proposition). El elemento visual debe contar una historia y conectar emocionalmente con los consumidores.
    </p>
    <?php include "../app/views/components/services/services.php";?>