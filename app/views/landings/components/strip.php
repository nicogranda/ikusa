<?php /** @var array $items */ $doubled = array_merge($items, $items); ?>
<div class="l-strip" aria-hidden="true">
    <div class="l-strip__inner">
        <?php foreach ($doubled as $item): ?>
            <span><?= htmlspecialchars($item) ?></span><span class="l-strip__dot">✦</span>
        <?php endforeach; ?>
    </div>
</div>
