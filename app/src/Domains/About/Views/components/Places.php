<?php if (!empty($places['items'])): ?>
<section class="about-section">
  <div class="about-container">
    <span class="about-eyebrow"><?= htmlspecialchars($places['eyebrow'] ?? '') ?></span>
    <div class="about-heading-split">
      <h2><?= htmlspecialchars($places['title'] ?? '') ?><br><span><?= htmlspecialchars($places['highlight'] ?? '') ?></span></h2>
      <p><?= htmlspecialchars($places['text'] ?? '') ?></p>
    </div>
    <div class="places-grid">
      <?php foreach ($places['items'] as $place): ?>
      <article class="place-card">
        <?php if (!empty($place['image'])): ?><img src="<?= htmlspecialchars($place['image']) ?>" alt="<?= htmlspecialchars($place['alt']) ?>" loading="lazy"><?php endif; ?>
        <h3><?= htmlspecialchars($place['city']) ?></h3>
        <p><?= htmlspecialchars($place['country']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
