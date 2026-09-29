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
            <?php foreach ($cards as $index => $card): ?>
            <?php $src = $imageUrl($card['image'] ?? ''); ?>
            <article class="about-places__card">
                <?php if ($src): ?>
                    <?php if (str_ends_with((string) $card['image'], 'places-reference.png')): ?>
                        <?php $crop = ['6 100 163 119', '176 100 162 119', '345 100 162 119'][$index] ?? '6 100 163 119'; ?>
                        <svg class="about-places__photo" role="img" aria-label="<?= $escape($card['image_alt'] ?: $card['title']) ?>" viewBox="<?= $crop ?>" preserveAspectRatio="xMidYMid slice">
                            <image href="<?= $escape($src) ?>" width="512" height="270" />
                        </svg>
                    <?php else: ?>
                        <img src="<?= $escape($src) ?>" alt="<?= $escape($card['image_alt'] ?: $card['title']) ?>" loading="lazy" decoding="async">
                    <?php endif; ?>
                <?php endif; ?>
                <h3><?= $escape($card['title']) ?></h3>
                <?php if (!empty($card['subtitle'])): ?><p><?= $escape($card['subtitle']) ?></p><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
