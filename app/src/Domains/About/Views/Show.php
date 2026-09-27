<?php
// $about y $components llegan desde AboutController.
$aboutComponents = [
    'About/Hero.php' => ['hero', 'Hero.php'],
    'About/FeatureGrid.php' => ['features', 'FeatureGrid.php'],
    'About/Team.php' => ['team', 'Team.php'],
    'About/Places.php' => ['places', 'Places.php'],
    'About/CTA.php' => ['cta', 'CTA.php'],
];
?>
<link rel="stylesheet" href="<?= htmlspecialchars(asset_url('css/about.css')) ?>">
<main class="about-page">
    <?php foreach ($components as $component): ?>
        <?php if (isset($aboutComponents[$component])): ?>
            <?php [$variable, $file] = $aboutComponents[$component]; ?>
            <?php ${$variable} = $about[$variable === 'features' ? 'intro' : $variable]; ?>
            <?php include __DIR__ . '/components/' . $file; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</main>
