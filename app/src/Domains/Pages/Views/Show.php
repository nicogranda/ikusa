<?php
// app/src/Domains/Pages/Views/Show.php

/**
 * Partial de contenido.
 *
 * Variables recibidas desde PageController::render():
 *
 * $content
 * $canonical
 * $allTranslations
 * $language
 * $slug
 * $components
 * $projects
 */

$faqs = $content['faqs'] ?? [];

$viewsPath = __DIR__ . '/../../../../views';


/*
|--------------------------------------------------------------------------
| SCHEMA SEO DONOSTIA
|--------------------------------------------------------------------------
*/

if (
    ($language ?? '') === 'es' &&
    ($slug ?? '') === 'seo-donostia'
) {
    include $viewsPath . '/schemas/professional-service.schema.php';
}

?>


<div>

    <?php if (!empty($content['hero_path'])): ?>

        <?php if (($content['hero_type'] ?? '') === 'component'): ?>

            <?php

            $heroFile = $viewsPath
                . '/components/'
                . $content['hero_path'];

            if (is_file($heroFile)) {
                include $heroFile;
            }

            ?>

        <?php else: ?>

            <article class="hero-banner-text">

                <h1 class="hero-banner-title">
                    <?= $content['h1'] ?? '' ?>
                </h1>

                <?php if (!empty($content['excerpt'])): ?>

                    <p class="hero-banner-container">
                        <?= $content['excerpt'] ?>
                    </p>

                <?php endif; ?>

            </article>

        <?php endif; ?>

    <?php else: ?>

        <h1 class="principal">
            <?= $content['h1'] ?? '' ?>
        </h1>

        <?php if (!empty($content['excerpt'])): ?>

            <p class="hero-banner-container">
                <?= $content['excerpt'] ?>
            </p>

        <?php endif; ?>

    <?php endif; ?>

</div>


<main class="page-<?= htmlspecialchars($content['slug'] ?? '') ?>">


    <?php
    /*
    |--------------------------------------------------------------------------
    | COMPONENTS DE LA PÁGINA
    |--------------------------------------------------------------------------
    */

    foreach ($components as $component):

        $componentFile = $viewsPath
            . '/components/'
            . $component;

        if (is_file($componentFile)) {
            include $componentFile;
        }

    endforeach;
    ?>


<?php
/*
|--------------------------------------------------------------------------
| GEOGRAPHIC SEO
|--------------------------------------------------------------------------
*/

if (
    ($language ?? '') === 'es' &&
    ($slug ?? '') === 'seo-donostia'
) {

    $geographicSeoControllerFile =
        __DIR__ . '/../../GeographicSEO/GeographicSeoController.php';

    if (is_file($geographicSeoControllerFile)) {

        require_once $geographicSeoControllerFile;

        $geographicSeoController =
            new \App\Domains\GeographicSEO\GeographicSeoController();

        $geographicSeoController->show();
    }
}
?>


    <?php
    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */

    include $viewsPath . '/components/FAQ.php';
    ?>


</main>