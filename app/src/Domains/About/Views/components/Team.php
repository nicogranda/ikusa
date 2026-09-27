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
        <?php if (!empty($member['image'])): ?><div class="team-card__image"><?php if (!empty($member['image_tile'])): ?><div class="about-atlas about-atlas--<?= htmlspecialchars($member['image_tile']) ?>" role="img" aria-label="<?= htmlspecialchars($member['alt']) ?>"></div><?php else: ?><img src="<?= htmlspecialchars($member['image']) ?>" alt="<?= htmlspecialchars($member['alt']) ?>" loading="lazy"><?php endif; ?></div><?php endif; ?>
        <h3><?= htmlspecialchars($member['name']) ?></h3>
        <?php if (!empty($member['image_note'])): ?><small class="team-card__note"><?= htmlspecialchars($member['image_note']) ?></small><?php endif; ?>
        <span class="team-card__role"><?= htmlspecialchars($member['role']) ?></span>
        <p><?= htmlspecialchars($member['text']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
