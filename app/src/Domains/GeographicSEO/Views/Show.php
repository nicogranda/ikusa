<?php

/** @var array $geoSeo */

$municipalities = $geoSeo['municipalities'] ?? [];
$firstSlug = array_key_first($municipalities);

/*
|--------------------------------------------------------------------------
| ASSETS DEL DOMAIN
|--------------------------------------------------------------------------
*/

$cssFile = __DIR__ . '/../Assets/css/geographic-seo.css';
$jsFile  = __DIR__ . '/../Assets/js/geographic-seo.js';

/*
|--------------------------------------------------------------------------
| MAPA SVG
|--------------------------------------------------------------------------
|
| El SVG se carga INLINE.
| De esta forma CSS y JavaScript pueden acceder directamente
| al municipio de Donostia dentro del SVG.
|
*/

$svgFile = __DIR__ . '/../Assets/img/gipuzkoa-interactive-municipios.svg';

?>

<?php if (is_file($cssFile)): ?>

<style>
<?php include $cssFile; ?>
</style>

<?php endif; ?>


<section
    class="geo-seo"
    data-geo-seo
>

    <!-- ============================================================
         CABECERA
    ============================================================= -->

    <div class="geo-seo__head">

        <p class="geo-seo__eyebrow">
            SEO LOCAL · GIPUZKOA
        </p>

        <h2>
            Posicionamiento SEO en Gipuzkoa
        </h2>

        <p>
            Selecciona un municipio para conocer las oportunidades
            de posicionamiento orgánico y SEO local.
        </p>

    </div>


    <!-- ============================================================
         MAPA + INFORMACIÓN
    ============================================================= -->

    <div class="geo-seo__layout">


        <!-- ========================================================
             MAPA DE GIPUZKOA
        ========================================================= -->

        <div
            class="geo-seo__map"
            data-geo-map
        >

            <?php if (is_file($svgFile)): ?>

                <?php

                /*
                 * Insertamos físicamente el SVG dentro del HTML.
                 *
                 * NO usamos <img>.
                 *
                 * Esto permite hacer:
                 *
                 * document.querySelector(
                 *     '#donostia-san-sebastian'
                 * );
                 */

                echo file_get_contents($svgFile);

                ?>

            <?php else: ?>

                <div class="geo-seo__map-error">

                    <p>
                        No se encontró el mapa SVG de Gipuzkoa.
                    </p>

                    <?php if (ini_get('display_errors')): ?>

                        <small>
                            Archivo buscado:
                            <?= htmlspecialchars(
                                $svgFile,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </small>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- ========================================================
             INFORMACIÓN DE MUNICIPIOS
        ========================================================= -->

        <div
            class="geo-seo__details"
            data-geo-details
        >


            <!-- ====================================================
                 DONOSTIA
            ===================================================== -->

            <article
                class="geo-seo__municipality"
                data-municipality="donostia"
                data-ine="20069"
                hidden
            >

                <h3>
                    SEO en Donostia
                </h3>


                <!-- TURISMO -->

                <div class="geo-seo__sector">

                    <h4>
                        Turismo y alojamiento
                    </h4>

                    <p>
                        Estrategias SEO para hoteles,
                        apartamentos, alojamientos turísticos
                        y empresas del sector.
                    </p>

                </div>


                <!-- GASTRONOMÍA -->

                <div class="geo-seo__sector">

                    <h4>
                        Restaurantes y gastronomía
                    </h4>

                    <p>
                        Posicionamiento local para restaurantes,
                        bares y negocios gastronómicos de Donostia.
                    </p>

                </div>


                <!-- SERVICIOS PROFESIONALES -->

                <div class="geo-seo__sector">

                    <h4>
                        Servicios profesionales
                    </h4>

                    <p>
                        Visibilidad orgánica para despachos,
                        consultoras y empresas de servicios.
                    </p>

                </div>


            </article>


        </div>

    </div>

</section>


<?php if (is_file($jsFile)): ?>

<script>
<?php include $jsFile; ?>
</script>

<?php endif; ?>