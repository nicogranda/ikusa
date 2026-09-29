<?php if ($heading): ?>
<section class="about-block about-features" aria-labelledby="about-features-title">
    <div class="about-block__inner">
        <?php if (!empty($heading['subtitle'])): ?><p class="about-block__eyebrow"><?= $escape($heading['subtitle']) ?></p><?php endif; ?>
        <?php $titleLines = preg_split('/\R/u', (string) ($heading['title'] ?? ''), 2); ?>
        <h2 id="about-features-title" class="about-block__title"><?= $escape($titleLines[0] ?? '') ?><?php if (!empty($titleLines[1])): ?><br><span><?= $escape($titleLines[1]) ?></span><?php endif; ?></h2>
        <?php if (!empty($heading['text'])): ?><p class="about-features__intro"><?= nl2br($escape($heading['text'])) ?></p><?php endif; ?>
        <div class="about-features__grid">
            <?php foreach ($cards as $index => $card): ?>
            <article class="about-features__card">
                <?php if ($index === 0): ?>
                <svg class="about-features__icon" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="22" cy="26" r="15" stroke="currentColor" stroke-width="2.5"/><circle cx="22" cy="26" r="8" stroke="currentColor" stroke-width="2.5"/><path d="m22 26 18-18M32 8h8v8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <?php elseif ($index === 1): ?>
                <svg class="about-features__icon" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="m9 34 2-8L32 5a4 4 0 0 1 6 6L17 32l-8 2Zm3-8 5 6M29 8l7 7M7 40h33" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <?php else: ?>
                <svg class="about-features__icon" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="m16 13-11 11 11 11m16-22 11 11-11 11M28 8l-8 32" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <?php endif; ?>
                <h3><?= $escape($card['title']) ?></h3>
                <?php if (!empty($card['text'])): ?><p><?= nl2br($escape($card['text'])) ?></p><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
