<?php
// app/views/Pages/Show.php

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

if (
    ($language ?? '') === 'es' &&
    ($slug ?? '') === 'seo-donostia'
) {
    include __DIR__ . '/../schemas/professional-service.schema.php';
}
?>


<div>

    <?php if (!empty($content['hero_path'])): ?>

        <?php if (($content['hero_type'] ?? '') === 'component'): ?>

            <?php
            $heroFile = __DIR__ . '/../components/' . $content['hero_path'];

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

    <?php foreach ($components as $component): ?>

        <?php
        $componentFile = __DIR__ . '/../components/' . $component;

        if (is_file($componentFile)) {
            include $componentFile;
        }
        ?>

    <?php endforeach; ?>


    <?php include __DIR__ . '/../components/FAQ.php'; ?>
    

</main>