<?php /** @var array $w */ ?>
<section class="l-why">
    <div>
        <h2 class="l-why__h2"><?= $w['h2'] ?></h2>
        <p class="l-why__p"><?= htmlspecialchars($w['p1']) ?></p>
        <p class="l-why__p"><?= htmlspecialchars($w['p2']) ?></p>
        <a href="<?= htmlspecialchars($w['cta_href']) ?>" class="l-btn-primary"><?= htmlspecialchars($w['cta_text']) ?></a>
    </div>
    <div class="l-stats">
        <?php foreach ($w['stats'] as $stat): ?>
        <div>
            <div class="l-stat__num"><?= htmlspecialchars($stat['num']) ?></div>
            <div class="l-stat__label"><?= htmlspecialchars($stat['label']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
