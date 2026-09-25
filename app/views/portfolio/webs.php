<style type="text/css">
        .hero img {
            width: 100%;
            max-width: 100%;
            height: auto; /* Mantiene la proporción de la imagen */
        }

        .feacture {
        	display: flex;
        	flex-direction: row;
        	flex-wrap: nowrap;
        	justify-content: space-around;
        	align-items: center;
        	align-content: stretch;
        	padding-bottom: 20px;
        }
        
        .gallery {
            width: 80%;
            margin: 0 auto;
            margin-top: 70px;
            padding-top: 50px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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


<section class="hero">
    <img src="/assets/img/heros/diseno-web-desk.png">
</section>
    <section class="web-design">
        <div class="container">
            <h1 class="principal">Diseño y Desarrollo Web</h1>
            <h2 style="color:var(--color-primary);">Aumenta tu presencia online</h2>
            <p style="text-align:left;padding: 20px 0;">Somos una <strong>agencia de diseño web y SEO</strong> con experiencia en <strong>España, Perú, Venezuela y Estados Unidos.</strong><br> 
            Ayudamos a empresas a mejorar su presencia digital con <strong>páginas web optimizadas para SEO</strong>, diseñadas para atraer más clientes.</p>
            
            <h2 style="color:var(--color-primary);">Soluciones digitales para empresas y marcas personales</h2>
            <ul>
               <ul style="list-style: none; padding: 0;">
                    <li style="text-align: left; margin: 10px 0; font-size: 1.1rem;"><i class="fas fa-check" style="color: #F15A24;"></i> <strong>Diseño web personalizado y responsive</strong></li>
                    <li style="text-align: left; margin: 10px 0; font-size: 1.1rem;"><i class="fas fa-check" style="color: #F15A24;"></i> <strong>Optimización SEO para Google</strong></li>
                    <li style="text-align: left; margin: 10px 0; font-size: 1.1rem;"><i class="fas fa-check" style="color: #F15A24;"></i> <strong>Estrategias de conversión y marketing digital</strong></li>
                </ul>
            </ul>
            
            <style>
                .check-icon {
                    color: #F15A24; /* Color anaranjado */
                }
            </style>

            
            <p style="text-align:left;">Trabajamos en mercados como <strong>Mallorca, Texas, Georgia y Venezuela</strong>, creando estrategias efectivas para conectar con tu público ideal.</p>
            

        </div>
    </section>

<style>
/* styles.css */


.web-design {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 40px 20px;
}


.btn {
    display: inline-block;
    background: var(--color-primary);
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    margin-top: 20px;
    transition: background 0.3s;
}

.btn:hover {
    background: var(--color-secondary);
}

@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    li {
        font-size: 1rem;
    }
}
</style>

<div class='gallery' style="padding: 30px 0 20px 0;"> 
    <div class='products'> 
        <?php $dir = "images/portfolio/webs"; $direc = @opendir($dir) or die("permiso denegado");
        while ($file = readdir($direc)) { if ($file != "." && $file != ".." && $file != ".DS_Store") 
        { // Elimina la extensión .png o .jpg del nombre 
        $filename = pathinfo($file, PATHINFO_FILENAME); 
        $route = $dir . "/" . $file; echo "<img src='/" . $route . "' alt='" . $filename . "' title='" . $filename . "' />"; } } ?> 
    </div> 
</div>

<?php include "../app/views/components/services.php";?>
<!--<div class="feacture"> -->
<!--<h2 class="principal">Desarrollo Web</h2>-->
<!--<h2 class="principal">E-commerce</h2>-->
<!--<h2 class="principal">APP</h2>-->

<!--</div>-->
