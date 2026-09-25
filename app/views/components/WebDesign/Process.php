
<?php
/**
 * WebDesign/process.php
 *
 * Componente reutilizable:
 * Proceso de diseño y desarrollo web.
 *
 * Sin dependencias de marca.
 * Sin JavaScript.
 * CSS encapsulado.
 */

$processPhases = [
    [
        'label' => 'FASE 01',
        'title' => 'Investigación y diseño',
        'description' => 'Definimos la estrategia, la identidad visual y la experiencia de usuario de tu proyecto.',
        'steps' => [
            [
                'title' => 'Investigación de palabras clave',
                'description' => 'Analizamos cómo buscan tus potenciales clientes, estudiamos tu competencia y definimos la arquitectura SEO de tu web.',
                'icon' => 'fa-magnifying-glass'
            ],
            [
                'title' => 'Identidad visual y paleta de colores',
                'description' => 'Estudiamos tu marca y definimos los colores, las tipografías y los elementos visuales que representarán tu negocio.',
                'icon' => 'fa-palette'
            ],
            [
                'title' => 'Diseño de la web en Figma',
                'description' => 'Diseñamos las páginas, la navegación y las interfaces, priorizando la experiencia de usuario y la conversión.',
                'icon' => 'fa-pen-ruler'
            ]
        ]
    ],
    [
        'label' => 'FASE 02',
        'title' => 'Validación y desarrollo',
        'description' => 'Convertimos el diseño aprobado en una página web funcional, rápida y preparada para crecer.',
        'steps' => [
            [
                'title' => 'Validación del diseño',
                'description' => 'Te presentamos la propuesta visual, recogemos tus comentarios y realizamos los ajustes antes de comenzar a programar.',
                'icon' => 'fa-comments'
            ],
            [
                'title' => 'Entorno de desarrollo seguro',
                'description' => 'Preparamos un entorno de pruebas independiente para desarrollar y revisar tu web sin afectar a tu página actual.',
                'icon' => 'fa-shield-halved'
            ],
            [
                'title' => 'Desarrollo modular por dominios',
                'description' => 'Desarrollamos las funcionalidades de tu web mediante una arquitectura modular, utilizando la tecnología más adecuada para tu proyecto.',
                'icon' => 'fa-code'
            ]
        ]
    ],
    [
        'label' => 'FASE 03',
        'title' => 'Revisión y lanzamiento',
        'description' => 'Preparamos los contenidos, comprobamos el funcionamiento y dejamos tu página lista para su publicación.',
        'steps' => [
            [
                'title' => 'Páginas legales y privacidad',
                'description' => 'Integramos las páginas legales y los mecanismos de privacidad y consentimiento aplicables a tu proyecto, con los textos facilitados o validados por el responsable legal.',
                'icon' => 'fa-file-shield'
            ],
            [
                'title' => 'Estructura de datos y vistas',
                'description' => 'Organizamos los contenidos, las bases de datos y las vistas para facilitar la gestión de la información y el crecimiento de tu web.',
                'icon' => 'fa-database'
            ],
            [
                'title' => 'Revisión final y lanzamiento',
                'description' => 'Comprobamos la navegación, los formularios, la visualización en móviles, el rendimiento y el SEO técnico. Revisamos contigo el resultado y publicamos tu web.',
                'icon' => 'fa-rocket'
            ]
        ]
    ]
];

$processStepNumber = 0;
?>

<section class="web-design-process" id="proceso-diseno-web">

    <div class="web-design-process__container">

        <!-- ENCABEZADO -->

        <div class="web-design-process__intro">

            <span class="web-design-process__eyebrow">
                NUESTRO PROCESO
            </span>

            <h2 class="web-design-process__title">
                Cómo diseñamos y desarrollamos tu página web
            </h2>

            <p class="web-design-process__lead">
                Desde la investigación de palabras clave hasta
                el lanzamiento de tu página web. Un proceso
                orientado a SEO, experiencia de usuario y conversión.
            </p>

        </div>

        <!-- FASES -->

        <div class="web-design-process__phases">

            <?php foreach ($processPhases as $phase): ?>

                <div class="web-design-process__phase">

                    <!-- INFORMACIÓN DE LA FASE -->

                    <div class="web-design-process__phase-info">

                        <span class="web-design-process__phase-label">
                            <?= htmlspecialchars($phase['label']) ?>
                        </span>

                        <h3 class="web-design-process__phase-title">
                            <?= htmlspecialchars($phase['title']) ?>
                        </h3>

                        <p class="web-design-process__phase-description">
                            <?= htmlspecialchars($phase['description']) ?>
                        </p>

                    </div>

                    <!-- TIMELINE -->

                    <div class="web-design-process__timeline">

                        <?php foreach ($phase['steps'] as $step):

                            $processStepNumber++;

                        ?>

                            <div class="web-design-process__step">

                                <span class="web-design-process__number">
                                    <?= str_pad(
                                        (string)$processStepNumber,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) ?>
                                </span>

                                <span class="web-design-process__icon">
                                    <i
                                        class="fa-solid <?= htmlspecialchars($step['icon']) ?>"
                                        aria-hidden="true"
                                    ></i>
                                </span>

                                <div class="web-design-process__step-content">

                                    <h4 class="web-design-process__step-title">
                                        <?= htmlspecialchars($step['title']) ?>
                                    </h4>

                                    <p class="web-design-process__step-description">
                                        <?= htmlspecialchars($step['description']) ?>
                                    </p>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<style>
/* =========================================================
   WEB DESIGN PROCESS
   Componente independiente y reutilizable
========================================================= */

.web-design-process {

    /* VARIABLES PERSONALIZABLES */

    --process-accent: var(--color-primary, #f4511e);
    --process-text: #191b20;
    --process-muted: #62666d;
    --process-background: #ffffff;
    --process-border: #e8e8e8;
    --process-accent-soft: color-mix(
        in srgb,
        var(--process-accent) 10%,
        white
    );

    --process-font: var(
        --font-text,
        'Montserrat',
        sans-serif
    );

    /* CONTENEDOR PRINCIPAL */

    position: relative;
    display: block;
    width: 100%;
    height: auto;
    min-height: 0;

    padding: 90px 24px;
    margin: 0;

    background: var(--process-background);
    color: var(--process-text);

    font-family: var(--process-font);

    overflow: clip;
    isolation: isolate;
}

.web-design-process *,
.web-design-process *::before,
.web-design-process *::after {
    box-sizing: border-box;
}

.web-design-process__container {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
}

/* =========================================================
   ENCABEZADO
========================================================= */

.web-design-process .web-design-process__intro {

    position: static;
    display: block;

    width: 100%;
    max-width: 720px;
    height: auto;
    min-height: 0;

    margin: 0 auto 70px;
    padding: 0;

    text-align: center;

    background: transparent;
    transform: none;
}

.web-design-process .web-design-process__eyebrow {

    position: static;
    display: block;

    width: auto;
    height: auto;

    margin: 0 0 14px;
    padding: 0;

    color: var(--process-accent);
    background: transparent;

    font-family: var(--process-font);
    font-size: 11px;
    font-weight: 700;
    line-height: 1.5;
    letter-spacing: 2px;

    text-transform: uppercase;
    transform: none;
}

.web-design-process .web-design-process__title {

    position: static;
    display: block;

    width: 100%;
    max-width: 100%;
    height: auto;

    margin: 0 0 18px;
    padding: 0;

    color: var(--process-text);
    background: transparent;

    font-family: var(--process-font);
    font-size: clamp(30px, 4vw, 44px);
    font-weight: 700;
    line-height: 1.15;
    letter-spacing: -1.2px;

    text-align: center;
    text-transform: none;

    transform: none;
}

.web-design-process .web-design-process__lead {

    position: static;
    display: block;

    width: 100%;
    max-width: 100%;
    height: auto;

    margin: 0;
    padding: 0;

    color: var(--process-muted);
    background: transparent;

    font-family: var(--process-font);
    font-size: 15px;
    font-weight: 400;
    line-height: 1.8;

    text-align: center;

    transform: none;
}

/* =========================================================
   FASES
========================================================= */

.web-design-process__phases {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 0;
}

.web-design-process__phase {

    display: grid;

    grid-template-columns:
        minmax(0, 300px)
        minmax(0, 1fr);

    gap: 65px;

    width: 100%;
    min-width: 0;

    padding: 45px 0;

    border-bottom: 1px solid var(--process-border);
}

.web-design-process__phase:first-child {
    padding-top: 0;
}

.web-design-process__phase:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

/* =========================================================
   INFORMACIÓN DE FASE
========================================================= */

.web-design-process__phase-info {
    position: static;
    display: block;
    min-width: 0;
}

.web-design-process__phase-label {

    display: block;

    margin-bottom: 12px;

    color: var(--process-accent);

    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
}

.web-design-process .web-design-process__phase-title {

    position: static;

    margin: 0 0 16px;
    padding: 0;

    color: var(--process-text);
    background: transparent;

    font-family: var(--process-font);
    font-size: clamp(24px, 2.6vw, 32px);
    font-weight: 600;
    line-height: 1.2;
    letter-spacing: -.7px;

    transform: none;
}

.web-design-process .web-design-process__phase-description {

    position: static;

    margin: 0;
    padding: 0;

    color: var(--process-muted);
    background: transparent;

    font-family: var(--process-font);
    font-size: 14px;
    font-weight: 400;
    line-height: 1.8;

    transform: none;
}

/* =========================================================
   TIMELINE
========================================================= */

.web-design-process__timeline {

    position: relative;

    display: flex;
    flex-direction: column;

    gap: 32px;

    width: 100%;
    min-width: 0;
}

.web-design-process__timeline::before {

    content: "";

    position: absolute;

    top: 20px;
    bottom: 20px;
    left: 19px;

    width: 1px;

    background: var(--process-border);
}

/* =========================================================
   STEP
========================================================= */

.web-design-process__step {

    position: relative;

    display: grid;

    grid-template-columns:
        40px
        32px
        minmax(0, 1fr);

    align-items: start;

    gap: 18px;

    width: 100%;
    min-width: 0;
}

/* NÚMERO */

.web-design-process__number {

    position: relative;
    z-index: 1;

    display: flex;
    align-items: center;
    justify-content: center;

    width: 40px;
    height: 40px;

    border-radius: 50%;

    background: var(--process-accent-soft);
    color: var(--process-accent);

    font-size: 12px;
    font-weight: 700;

    transition:
        background .25s ease,
        color .25s ease;
}

.web-design-process__step:hover
.web-design-process__number {

    background: var(--process-accent);
    color: #fff;
}

/* ICONO */

.web-design-process__icon {

    display: flex;
    align-items: center;
    justify-content: center;

    width: 32px;
    height: 40px;

    color: var(--process-accent);

    font-size: 17px;
}

/* CONTENIDO */

.web-design-process__step-content {
    min-width: 0;
    padding-top: 3px;
}

.web-design-process .web-design-process__step-title {

    position: static;

    margin: 0 0 7px;
    padding: 0;

    color: var(--process-text);
    background: transparent;

    font-family: var(--process-font);
    font-size: 17px;
    font-weight: 700;
    line-height: 1.35;

    transform: none;
}

.web-design-process .web-design-process__step-description {

    position: static;

    margin: 0;
    padding: 0;

    color: var(--process-muted);
    background: transparent;

    font-family: var(--process-font);
    font-size: 14px;
    font-weight: 400;
    line-height: 1.7;

    transform: none;
}

/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .web-design-process {
        padding: 65px 20px;
    }

    .web-design-process .web-design-process__intro {
        margin-bottom: 45px;
    }

    .web-design-process__phase {

        grid-template-columns: minmax(0, 1fr);

        gap: 30px;
        padding: 38px 0;
    }

    .web-design-process__phase-info {
        max-width: 600px;
    }

}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 480px) {

    .web-design-process {
        padding: 55px 18px;
    }

    .web-design-process .web-design-process__intro {
        margin-bottom: 40px;
    }

    .web-design-process .web-design-process__title {
        font-size: 30px;
    }

    .web-design-process .web-design-process__phase-title {
        font-size: 25px;
    }

    .web-design-process__timeline {
        gap: 28px;
    }

    .web-design-process__step {

        grid-template-columns:
            34px
            minmax(0, 1fr);

        column-gap: 15px;
    }

    .web-design-process__timeline::before {
        left: 16px;
    }

    .web-design-process__number {
        width: 34px;
        height: 34px;
    }

    .web-design-process__icon {
        display: none;
    }

    .web-design-process .web-design-process__step-title {
        font-size: 16px;
    }

    .web-design-process .web-design-process__step-description {
        font-size: 13px;
    }

}
</style>