<?php if (!empty($features)): ?>
<section class="about-section" id="<?= htmlspecialchars($features['id'] ?? '') ?>">
  <div class="about-container">
    <span class="about-eyebrow"><?= htmlspecialchars($features['eyebrow'] ?? '') ?></span>
    <h2><?= htmlspecialchars($features['title'] ?? '') ?><br><span><?= htmlspecialchars($features['highlight'] ?? '') ?></span></h2>
    <p class="about-lead"><?= htmlspecialchars($features['text'] ?? '') ?></p>
    <div class="feature-grid">
      <?php foreach (($features['items'] ?? []) as $item): ?>
      <article class="feature-card">
        <i class="<?= htmlspecialchars($item['icon'] ?? '') ?>"></i>
        <h3><?= htmlspecialchars($item['title'] ?? '') ?></h3>
        <p><?= htmlspecialchars($item['text'] ?? '') ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
