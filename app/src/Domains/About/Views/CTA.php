<?php
$cta = $cards[0] ?? null;
if ($cta):
    $src = $imageUrl($cta['image'] ?? '');
    $lang = $language === 'en' ? 'en' : 'es';
    $contactUrl = function_exists('route_url') ? route_url($lang === 'es' ? 'es/contacto' : 'en/contact') : '/' . $lang . '/contacto';
?>
<section class="about-block about-cta" aria-labelledby="about-cta-title">
    <div class="about-cta__content">
        <?php if (!empty($cta['subtitle'])): ?><p class="about-block__eyebrow"><?= $escape($cta['subtitle']) ?></p><?php endif; ?>
        <h2 id="about-cta-title"><?= $escape($cta['title']) ?></h2>
        <?php if (!empty($cta['text'])): ?><p><?= nl2br($escape($cta['text'])) ?></p><?php endif; ?>
        <a href="<?= $escape($contactUrl) ?>"><?= $lang === 'es' ? 'Hablemos de tu proyecto' : 'Tell us about your project' ?> <span aria-hidden="true">→</span></a>
    </div>
    <?php if ($src): ?><div class="about-cta__media"><img src="<?= $escape($src) ?>" alt="<?= $escape($cta['image_alt'] ?: $cta['title']) ?>" loading="lazy" decoding="async"></div><?php endif; ?>
</section>
<?php endif; ?>
