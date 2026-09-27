<?php
// La ruta carga head y header antes de incluir esta vista.
?>
<link rel="stylesheet" href="<?= htmlspecialchars(asset_url('css/about.css')) ?>">
<main class="about-page">
    <?php $hero = $about['hero']; include __DIR__ . '/components/Hero.php'; ?>
    <?php $features = $about['intro']; include __DIR__ . '/components/FeatureGrid.php'; ?>
    <?php $team = $about['team']; include __DIR__ . '/components/Team.php'; ?>
    <?php $places = $about['places']; include __DIR__ . '/components/Places.php'; ?>
    <?php $cta = $about['cta']; include __DIR__ . '/components/CTA.php'; ?>
</main>
