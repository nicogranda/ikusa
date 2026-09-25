<?php /** @var array $sv */ ?>
<section class="l-services" id="servicios">
    <div class="l-label"><?= htmlspecialchars($sv['label']) ?></div>
    <div class="l-services__grid">
        <?php foreach ($sv['cards'] as $card): ?>
        <div class="l-service-card fade-up">
            <div class="l-service-card__num"><?= htmlspecialchars($card['num']) ?></div>
            <h2 class="l-service-card__name"><?= htmlspecialchars($card['name']) ?></h2>
            <p class="l-service-card__desc"><?= htmlspecialchars($card['desc']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>
