<?php if (!empty($team['members'])): ?>
<section class="about-section about-section--soft">
  <div class="about-container">
    <span class="about-eyebrow"><?= htmlspecialchars($team['eyebrow'] ?? '') ?></span>
    <div class="about-heading-split">
      <h2><?= htmlspecialchars($team['title'] ?? '') ?><br><span><?= htmlspecialchars($team['highlight'] ?? '') ?></span></h2>
      <p><?= htmlspecialchars($team['text'] ?? '') ?></p>
    </div>
    <div class="team-grid">
      <?php foreach ($team['members'] as $member): ?>
      <article class="team-card">
        <?php if (!empty($member['image'])): ?><div class="team-card__image"><img src="<?= htmlspecialchars($member['image']) ?>" alt="<?= htmlspecialchars($member['alt']) ?>" loading="lazy"></div><?php endif; ?>
        <h3><?= htmlspecialchars($member['name']) ?></h3>
        <span class="team-card__role"><?= htmlspecialchars($member['role']) ?></span>
        <p><?= htmlspecialchars($member['text']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
