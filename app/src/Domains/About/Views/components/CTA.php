<?php if (!empty($cta)): ?>
<section class="about-cta">
  <div class="about-cta__content">
    <span class="about-eyebrow about-eyebrow--light"><?= htmlspecialchars($cta['eyebrow'] ?? '') ?></span>
    <h2><?= htmlspecialchars($cta['title'] ?? '') ?></h2>
    <p><?= htmlspecialchars($cta['text'] ?? '') ?></p>
    <?php if (!empty($cta['button'])): ?><a class="about-btn about-btn--light" href="<?= htmlspecialchars($cta['button']['url']) ?>"><?= htmlspecialchars($cta['button']['label']) ?> →</a><?php endif; ?>
  </div>
  <?php if (!empty($cta['image'])): ?><div class="about-cta__image"><?php if (!empty($cta['image_tile'])): ?><div class="about-atlas about-atlas--<?= htmlspecialchars($cta['image_tile']) ?>" role="img" aria-label="<?= htmlspecialchars($cta['image_alt'] ?? '') ?>"></div><?php else: ?><img src="<?= htmlspecialchars($cta['image']) ?>" alt="<?= htmlspecialchars($cta['image_alt'] ?? '') ?>" loading="lazy"><?php endif; ?></div><?php endif; ?>
</section>
<?php endif; ?>
