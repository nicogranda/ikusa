<?php if ($heading): ?>
<section class="about-block about-places" aria-labelledby="about-places-title">
    <div class="about-block__inner">
        <div class="about-places__heading">
            <div>
                <?php if (!empty($heading['subtitle'])): ?><p class="about-block__eyebrow"><?= $escape($heading['subtitle']) ?></p><?php endif; ?>
                <?php $titleLines = preg_split('/\R/u', (string) ($heading['title'] ?? ''), 2); ?>
                <h2 id="about-places-title" class="about-block__title"><?= $escape($titleLines[0] ?? '') ?><?php if (!empty($titleLines[1])): ?><br><span><?= $escape($titleLines[1]) ?></span><?php endif; ?></h2>
            </div>
            <?php if (!empty($heading['text'])): ?><p class="about-places__intro"><?= nl2br($escape($heading['text'])) ?></p><?php endif; ?>
        </div>
        <div class="about-places__grid">
            <?php foreach ($cards as $card): ?>
            <?php $src = $imageUrl($card['image'] ?? ''); ?>
            <article class="about-places__card">
                <?php if ($src): ?><img src="<?= $escape($src) ?>" alt="<?= $escape($card['image_alt'] ?: $card['title']) ?>" loading="lazy" decoding="async"><?php endif; ?>
                <h3><?= $escape($card['title']) ?></h3>
                <?php if (!empty($card['subtitle'])): ?><p><?= $escape($card['subtitle']) ?></p><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
