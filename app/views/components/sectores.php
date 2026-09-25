<?php

$sectores = [
    ['icono'=>'fa-solid fa-utensils','label'=>'Restaurantes','descripcion'=>'SEO local para restaurantes, cafeterías y negocios gastronómicos que quieren atraer clientes desde Google y Maps.'],
    ['icono'=>'fa-solid fa-kit-medical','label'=>'Clínicas','descripcion'=>'Estrategias de posicionamiento para clínicas, centros médicos, estética y negocios del sector salud.'],
    ['icono'=>'fa-solid fa-scale-balanced','label'=>'Abogados','descripcion'=>'Visibilidad para despachos y profesionales que necesitan aparecer cuando un cliente busca asesoramiento legal.'],
    ['icono'=>'fa-solid fa-cart-shopping','label'=>'Tiendas Online','descripcion'=>'SEO para ecommerce orientado a mejorar categorías, productos y búsquedas con intención de compra.'],
    ['icono'=>'fa-solid fa-wrench','label'=>'Reformas','descripcion'=>'Posicionamiento local para reformas, construcción y profesionales que trabajan por zonas geográficas.'],
    ['icono'=>'fa-solid fa-hotel','label'=>'Hoteles','descripcion'=>'Estrategias SEO para alojamientos que quieren aumentar su visibilidad y reducir la dependencia de intermediarios.'],
    ['icono'=>'fa-solid fa-plane','label'=>'Turismo','descripcion'=>'Posicionamiento para empresas turísticas, experiencias y servicios que compiten por búsquedas locales.'],
    ['icono'=>'fa-solid fa-store','label'=>'Servicios Locales','descripcion'=>'SEO y Google Maps para negocios que necesitan captar clientes en Donostia, Gipuzkoa y su área de servicio.'],
];

?>

<section class="sectores">

    <div class="sectores__container">

        <div class="sectores__heading">

            <span class="sectores__eyebrow">
                SECTORES
            </span>

            <h2>
                Sectores con los que trabajamos
            </h2>

            <p>
                No todas las empresas compiten igual en Google.
                Adaptamos la estrategia SEO al mercado, al tipo de cliente
                y a la forma en que se busca cada servicio.
            </p>

        </div>


        <div class="sectores__grid">

            <?php foreach ($sectores as $sector): ?>

                <article class="sectores__card">

                    <div class="sectores__icon">
                        <i
                            class="<?= htmlspecialchars($sector['icono']) ?>"
                            aria-hidden="true"
                        ></i>
                    </div>

                    <h3>
                        <?= htmlspecialchars($sector['label']) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($sector['descripcion']) ?>
                    </p>

                </article>

            <?php endforeach; ?>

        </div>


        <div class="sectores__cta">

            <div>
                <span>¿NO VES TU SECTOR?</span>

                <h3>
                    Cuéntanos a qué se dedica tu empresa.
                </h3>

                <p>
                    Analizamos tu mercado, las búsquedas de tus clientes
                    y las oportunidades reales de posicionamiento.
                </p>
            </div>

            <a href="/es/contacto">
                Cuéntanos tu proyecto
                <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>

    </div>

</section>


<style>

.sectores{
    --brand:var(--color-brand,#F15A24);
    --dark:#0B0F19;
    padding:90px 20px;
    background:#fff;
}

.sectores__container{
    max-width:1280px;
    margin:auto;
}


/* HEADER DEL COMPONENTE
   NO usamos <header> para evitar conflicto con el header global */

.sectores__heading{
    position:static !important;
    inset:auto !important;
    transform:none !important;
    width:100%;
    max-width:760px;
    margin:0 auto 55px;
    padding:0;
    text-align:center;
}

.sectores__eyebrow{
    display:block;
    margin-bottom:14px;
    font-size:12px;
    font-weight:600;
    letter-spacing:.16em;
    color:var(--brand);
}

.sectores__heading h2{
    position:static !important;
    transform:none !important;
    width:auto !important;
    max-width:none !important;
    margin:0 0 18px !important;
    padding:0 !important;

    font-size:clamp(36px,4vw,52px);
    font-weight:500;
    line-height:1.08;
    letter-spacing:-.04em;
    text-align:center;
    color:var(--dark);
}

.sectores__heading p{
    max-width:650px;
    margin:auto;
    font-size:16px;
    line-height:1.7;
    color:#666;
}


/* GRID */

.sectores__grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    border-top:1px solid #e5e5e5;
    border-left:1px solid #e5e5e5;
}

.sectores__card{
    min-height:260px;
    padding:30px;
    border-right:1px solid #e5e5e5;
    border-bottom:1px solid #e5e5e5;
}

.sectores__icon{
    display:flex;
    align-items:center;
    justify-content:center;
    width:54px;
    height:54px;
    margin-bottom:40px;
    border:1px solid #ddd;
    border-radius:50%;
}

.sectores__icon i{
    font-size:20px;
    color:var(--dark);
}

.sectores__card h3{
    margin:0 0 10px;
    font-size:20px;
    font-weight:600;
    color:var(--dark);
}

.sectores__card p{
    margin:0;
    font-size:15px;
    line-height:1.6;
    color:#555;
}


/* CTA */

.sectores__cta{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:40px;

    margin-top:30px;
    padding:36px 40px;

    background:var(--dark);
    border-radius:16px;
    color:#fff;
}

.sectores__cta > div{
    max-width:700px;
}

.sectores__cta span{
    display:block;
    margin-bottom:8px;
    font-size:11px;
    font-weight:600;
    letter-spacing:.15em;
    color:var(--brand);
}

.sectores__cta h3{
    margin:0 0 8px;
    font-size:26px;
    font-weight:500;
    color:#fff;
}

.sectores__cta p{
    margin:0;
    line-height:1.6;
    color:#bbb;
}

.sectores__cta a{
    display:inline-flex;
    align-items:center;
    gap:10px;
    flex-shrink:0;

    padding:14px 22px;

    background:var(--brand);
    border-radius:999px;

    color:#fff;
    font-weight:600;
    text-decoration:none;
}


/* TABLET */

@media(max-width:900px){

    .sectores__grid{
        grid-template-columns:repeat(2,1fr);
    }

    .sectores__cta{
        align-items:flex-start;
        flex-direction:column;
    }

}


/* MOBILE */

@media(max-width:600px){

    .sectores{
        padding:65px 18px;
    }

    .sectores__heading{
        margin-bottom:38px;
        text-align:left;
    }

    .sectores__heading h2{
        font-size:34px;
        text-align:left;
    }

    .sectores__heading p{
        margin:0;
        text-align:left;
    }

    .sectores__grid{
        grid-template-columns:1fr;
    }

    .sectores__card{
        min-height:0;
        padding:25px;
    }

    .sectores__icon{
        margin-bottom:25px;
    }

    .sectores__cta{
        padding:28px 24px;
    }

    .sectores__cta a{
        width:100%;
        justify-content:center;
    }

}

</style>