<?php if (!empty($hero)): ?>
<section class="about-hero">
  <div class="about-container about-hero__grid">
    <div class="about-hero__content">
      <span class="about-eyebrow"><?= htmlspecialchars($hero['eyebrow'] ?? '') ?></span>
      <h1><?= htmlspecialchars($hero['title'] ?? '') ?></h1>
      <p><?= htmlspecialchars($hero['text'] ?? '') ?></p>
      <?php if (!empty($hero['tags'])): ?>
        <div class="about-hero__tags"><?= htmlspecialchars(implode(' · ', $hero['tags'])) ?></div>
      <?php endif; ?>
      <div class="about-actions">
        <?php if (!empty($hero['primary_cta'])): ?><a class="about-btn about-btn--light" href="<?= htmlspecialchars($hero['primary_cta']['url']) ?>"><?= htmlspecialchars($hero['primary_cta']['label']) ?> →</a><?php endif; ?>
        <?php if (!empty($hero['secondary_cta'])): ?><a class="about-link" href="<?= htmlspecialchars($hero['secondary_cta']['url']) ?>"><?= htmlspecialchars($hero['secondary_cta']['label']) ?> ↓</a><?php endif; ?>
      </div>
    </div>
    <?php if (!empty($hero['image'])): ?><div class="about-hero__image"><?php if (!empty($hero['image_tile'])): ?><div class="about-atlas about-atlas--<?= htmlspecialchars($hero['image_tile']) ?>" role="img" aria-label="<?= htmlspecialchars($hero['image_alt'] ?? '') ?>"></div><?php else: ?><img src="<?= htmlspecialchars($hero['image']) ?>" alt="<?= htmlspecialchars($hero['image_alt'] ?? '') ?>"><?php endif; ?></div><?php endif; ?>
  </div>
</section>
<?php endif; ?>
