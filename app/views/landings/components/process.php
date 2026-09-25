<?php /** @var array $pr */ ?>
<section class="l-process" id="proceso">
    <div class="l-label"><?= htmlspecialchars($pr['label']) ?></div>
    <h2 class="l-process__h2"><?= htmlspecialchars($pr['h2']) ?></h2>
    <div class="l-process__steps">
        <?php foreach ($pr['steps'] as $step): ?>
        <div class="l-step fade-up">
            <h3 class="l-step__h3"><?= htmlspecialchars($step['title']) ?></h3>
            <p class="l-step__p"><?= htmlspecialchars($step['desc']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>
