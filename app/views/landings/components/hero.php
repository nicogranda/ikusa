<?php /** @var array $h */ ?>
<section class="l-hero">
    <div class="l-hero__bg-text" aria-hidden="true"><?= htmlspecialchars($h['bg_text']) ?></div>
    <p class="l-hero__tag"><?= htmlspecialchars($h['tag']) ?></p>
    <h1 class="l-hero__h1"><?= $h['h1'] ?></h1>
    <p class="l-hero__sub"><?= htmlspecialchars($h['sub']) ?></p>
    <div class="l-hero__actions">
        <a href="<?= htmlspecialchars($h['cta_href']) ?>" class="l-btn-primary"><?= htmlspecialchars($h['cta_text']) ?></a>
        <a href="<?= htmlspecialchars($h['ghost_href']) ?>" class="l-btn-ghost"><?= htmlspecialchars($h['ghost_text']) ?> →</a>
    </div>
    <div class="l-hero__scroll" aria-hidden="true">Descubrir más</div>
</section>
