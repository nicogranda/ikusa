 <?php
        
        /**
         * =========================================================
         * COMPONENT DATA
         * =========================================================
         */
        
        $featureBlocks = [
        
            [
                "icon" => "fa-solid fa-users",
                "title" => "Un compromiso que pocas agencias se atreven a hacer",
                "text" => "Si ya trabajamos con un negocio de tu sector en tu zona, no aceptamos otro competidor. Así de simple. Toda nuestra capacidad trabaja para ti, no para tu competencia."
            ],
        
            [
                "icon" => "fa-solid fa-location-dot",
                "title" => "Por qué el SEO local en Donostia es diferente",
                "text" => "El mercado bilingüe, la competencia por zonas, la estacionalidad real y el peso de Google Maps hacen que posicionarse en Donostia requiera estrategia local, no recetas genéricas."
            ],
        
            [
                "icon" => "fa-solid fa-bullseye",
                "title" => "Qué hacemos para posicionarte",
                "text" => "Auditoría SEO, investigación de palabras clave local, optimización on-page y técnica, Google Business Profile y construcción de autoridad local."
            ],
        
            [
                "icon" => "fa-solid fa-chart-column",
                "title" => "Resultados que se traducen en negocio",
                "text" => "No buscamos visitas, buscamos clientes. SEO con enfoque comercial, seguimiento mensual y transparencia total en cada paso del proceso."
            ]
        
        ];
?>
<?php if (!empty($featureBlocks)) : ?>

<section class="feature-blocks">

    <div class="feature-blocks__grid">

        <?php foreach ($featureBlocks as $item) : ?>

            <article class="feature-block">

                <div class="feature-block__icon">
                    <i class="<?= $item['icon']; ?>"></i>
                </div>

                <span class="feature-block__title">
                    <?= $item['title']; ?>
                </span>

                <p class="feature-block__text">
                    <?= $item['text']; ?>
                </p>

            </article>

        <?php endforeach; ?>

    </div>

</section>

<?php endif; ?>

<style>
    .feature-blocks{
        padding:80px 0;
    }
    
    .feature-blocks__grid{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:50px;
    }
    
    .feature-block{
        display:flex;
        flex-direction:column;
        gap:20px;
    }
    
    .feature-block__icon{
        font-size: 34px;
        color: var(--color-primary);
    }
    
    .feature-block__title{
        font-size: 16px;
        line-height:1.3;
        font-weight:700;
        color:#111827;
    }
    
    .feature-block__text{
        font-size:14px;
        line-height:1.8;
        color:#4B5563;
    }
    
    @media (max-width: 992px){
        .feature-blocks__grid{
            grid-template-columns:repeat(2,1fr);
        }
    }
    
    @media (max-width: 768px){
        .feature-blocks{
            padding:50px 0;
        }
    
        .feature-blocks__grid{
            grid-template-columns:1fr;
            gap:40px;
        }
    }
</style>