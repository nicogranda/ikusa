<?php
/**
 * Component: GeographicSplit.php
 *
 * Split geográfico reutilizable.
 * DATA → VIEW → STYLE
 *
 * Desktop:
 * 01 texto | imagen
 * 02 imagen | texto
 * 03 texto | imagen
 *
 * Mobile:
 * siempre texto → imagen
 */


/* =========================================================
   DATA
========================================================= */

$geographicSplits = [

    [
        'eyebrow' => 'SEO LOCAL · DONOSTIA',

        'title' => 'Agencia SEO en Donostia para empresas de Gipuzkoa',

        'content' => [
            'En Ikusa trabajamos el posicionamiento SEO de empresas de Donostia-San Sebastián y Gipuzkoa que quieren mejorar su visibilidad en Google y atraer clientes a través de búsquedas con intención real.',

            'Nuestra estrategia combina SEO técnico, SEO local, optimización de contenidos y Google Maps para mejorar la presencia de cada negocio tanto en los resultados orgánicos como en las búsquedas locales.',
        ],

        'image' => '/assets/img/landings/seo-donostia/san-sebastian.jpg',

        'image_alt' => 'Donostia-San Sebastián y bahía de La Concha',

        'location' => 'Donostia-San Sebastián',
    ],


   [
    'eyebrow' => 'AGENCIA SEO EN GIPUZKOA',

    'title' => '¿Por qué el SEO en San Sebastián es diferente?',

    'content' => [
        'Como agencia SEO en Gipuzkoa, conocemos las particularidades del posicionamiento en San Sebastián y su entorno. El mercado local de Donostia y Gipuzkoa tiene características propias que influyen directamente en cómo buscan los usuarios y cómo compiten las empresas en Google.',

        'El castellano y el euskera forman parte del entorno digital de Gipuzkoa. Analizar cómo busca realmente el público permite identificar oportunidades en ambos idiomas y construir una estrategia de contenidos adaptada al mercado local.',

        'Google Maps también tiene un papel especialmente importante para negocios que atienden a clientes en una ubicación o área concreta. Trabajamos la presencia local para aumentar la relevancia del negocio en búsquedas relacionadas con sus servicios, Donostia (San Sebastián), Gipuzkoa y las zonas donde realmente opera.',

        'La competencia tampoco es únicamente por sector. Dependiendo del negocio, pueden existir búsquedas específicas relacionadas con zonas como Gros, Amara, Centro o Parte Vieja. Por eso analizamos las consultas reales antes de decidir qué términos y ubicaciones merece la pena trabajar.',

        'En Ikusa no aplicamos una estrategia SEO idéntica a todos los negocios. Partimos del análisis de la web, la competencia y los datos reales de búsqueda para definir las oportunidades de posicionamiento en Donostia (San Sebastián) y Gipuzkoa.',
    ],

        'image' => '/assets/img/landings/seo-donostia/euskotren.jpg',

        'image_alt' => 'Hondarribia en Gipuzkoa',

        'location' => 'Gipuzkoa',
    ],


    [
        'eyebrow' => 'POSICIONAMIENTO WEB',

        'title' => 'Posicionamiento web en Donostia y Gipuzkoa orientado a captar clientes',

        'content' => [
            'El objetivo no es simplemente aumentar posiciones en Google. Trabajamos para que tu empresa aparezca cuando potenciales clientes buscan los servicios que ofreces y convertir esa visibilidad en visitas, consultas y oportunidades comerciales.',

            'Analizamos qué búsquedas ya están generando impresiones para tu web, qué páginas está mostrando Google y qué oportunidades existen para mejorar progresivamente su posicionamiento.',
        ],

        'image' => '/assets/img/landings/seo-donostia/gipuzkoa.jpg',

        'image_alt' => 'Pasaia en Gipuzkoa',

        'location' => 'Pasaia · Gipuzkoa',
    ],

];

?>


<!-- =======================================================
     VIEW
======================================================== -->

<section class="geo-splits">

    <?php foreach ($geographicSplits as $index => $split): ?>

        <article class="geo-split<?= $index % 2 !== 0 ? ' geo-split--reverse' : '' ?>">

            <!-- TEXT -->

            <div class="geo-split__content">

                <div class="geo-split__inner">

                    <?php if (!empty($split['eyebrow'])): ?>

                        <div class="geo-split__eyebrow">

                            <span class="geo-split__eyebrow-line"></span>

                            <span>
                                <?= htmlspecialchars($split['eyebrow']) ?>
                            </span>

                        </div>

                    <?php endif; ?>


                    <h2 class="geo-split__title">
                        <?= htmlspecialchars($split['title']) ?>
                    </h2>


                    <div class="geo-split__text">

                        <?php foreach ($split['content'] as $paragraph): ?>

                            <p>
                                <?= htmlspecialchars($paragraph) ?>
                            </p>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>


            <!-- IMAGE -->

            <div class="geo-split__visual">

                <img
                    src="<?= htmlspecialchars($split['image']) ?>"
                    alt="<?= htmlspecialchars($split['image_alt']) ?>"
                    loading="lazy"
                    width="1200"
                    height="900"
                >

                <?php if (!empty($split['location'])): ?>

                    <div class="geo-split__location">

                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>

                        <span>
                            <?= htmlspecialchars($split['location']) ?>
                        </span>

                    </div>

                <?php endif; ?>

            </div>

        </article>

    <?php endforeach; ?>

</section>


<style>

/* =========================================================
   GEOGRAPHIC SPLITS
========================================================= */

.geo-splits{
    --geo-brand:var(--color-brand,#F15A24);
    --geo-dark:#0B0F19;
    --geo-text:#4b4b4b;
    --geo-muted:#858585;
    width:100%;
    background:#fff;
}


/* =========================================================
   SPLIT
========================================================= */

.geo-split{
    display:grid;
    grid-template-columns:1fr 1fr;
    min-height:680px;
    background:#fff;
}


/* =========================================================
   CONTENT
========================================================= */

.geo-split__content{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:6rem clamp(2rem,6vw,7rem);
    order:1;
}

.geo-split__inner{
    width:100%;
    max-width:650px;
}


/* EYEBROW */

.geo-split__eyebrow{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:1.5rem;

    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.72rem;
    font-weight:600;
    letter-spacing:.16em;
    text-transform:uppercase;
    color:var(--geo-muted);
}

.geo-split__eyebrow-line{
    display:block;
    width:32px;
    height:2px;
    background:var(--geo-brand);
}


/* TITLE */

.geo-split__title{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:clamp(2rem,3.2vw,3.4rem);
    font-weight:500;
    line-height:1.08;
    letter-spacing:-.035em;
    color:var(--geo-dark);
    margin:0 0 2rem;
}


/* TEXT */

.geo-split__text{
    max-width:620px;
}

.geo-split__text p{
    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:1rem;
    line-height:1.8;
    color:var(--geo-text);
    margin:0 0 1.25rem;
}

.geo-split__text p:last-child{
    margin-bottom:0;
}


/* =========================================================
   IMAGE
========================================================= */

.geo-split__visual{
    position:relative;
    overflow:hidden;
    min-height:680px;
    order:2;
}

.geo-split__visual img{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:transform .8s ease;
}

.geo-split:hover .geo-split__visual img{
    transform:scale(1.025);
}


/* LOCATION */

.geo-split__location{
    position:absolute;
    left:30px;
    bottom:30px;

    display:inline-flex;
    align-items:center;
    gap:9px;

    background:rgba(11,15,25,.82);
    backdrop-filter:blur(8px);
    -webkit-backdrop-filter:blur(8px);

    color:#fff;

    font-family:var(--font-primary,'Montserrat',sans-serif);
    font-size:.78rem;
    font-weight:500;
    letter-spacing:.04em;

    padding:.7rem 1rem;
    border-radius:999px;
}

.geo-split__location i{
    color:#fff;
    font-size:.8rem;
}


/* =========================================================
   ALTERNATE DESKTOP
========================================================= */

.geo-split--reverse .geo-split__content{
    order:2;
}

.geo-split--reverse .geo-split__visual{
    order:1;
}


/* =========================================================
   SEPARATION
========================================================= */

.geo-split + .geo-split{
    border-top:1px solid #eee;
}


/* =========================================================
   TABLET
========================================================= */

@media(max-width:991px){

    .geo-split{
        min-height:0;
    }

    .geo-split__content{
        padding:4.5rem 2.5rem;
    }

    .geo-split__visual{
        min-height:600px;
    }

    .geo-split__title{
        font-size:clamp(1.9rem,4vw,2.7rem);
    }

}


/* =========================================================
   MOBILE
   SIEMPRE TEXTO → FOTO
========================================================= */

@media(max-width:767px){

    .geo-split{
        display:flex;
        flex-direction:column;
        min-height:0;
    }

    .geo-split__content,
    .geo-split--reverse .geo-split__content{
        order:1;
        padding:4rem 22px 3rem;
    }

    .geo-split__visual,
    .geo-split--reverse .geo-split__visual{
        order:2;
        min-height:420px;
    }

    .geo-split__title{
        font-size:clamp(2rem,9vw,2.7rem);
        line-height:1.08;
        margin-bottom:1.5rem;
    }

    .geo-split__text p{
        font-size:.96rem;
        line-height:1.75;
    }

    .geo-split__location{
        left:20px;
        bottom:20px;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media(max-width:480px){

    .geo-split__content,
    .geo-split--reverse .geo-split__content{
        padding:3.5rem 20px 2.5rem;
    }

    .geo-split__visual,
    .geo-split--reverse .geo-split__visual{
        min-height:340px;
    }

}

</style>