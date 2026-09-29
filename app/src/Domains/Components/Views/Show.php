<?php
/** @var string $name */
/** @var array<int,array<string,mixed>> $items */
$escape = static fn ($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$asset = static function ($path): string {
    $path = (string) ($path ?? '');
    if ($path === '' || str_contains($path, '..') || !preg_match('~^(?:assets/)?img/[a-zA-Z0-9_./-]+\.(?:png|jpe?g|webp|avif)$~i', $path)) {
        return '';
    }
    return function_exists('asset_url')
        ? asset_url($path)
        : '/assets/' . preg_replace('~^assets/~', '', $path);
};
$isTeam = $name === 'team';
?>
<section <?= $isTeam ? 'id="team"' : '' ?> class="ik-components<?= $isTeam ? ' ik-components--team' : '' ?>" aria-label="<?= $escape($name) ?>">
<?php if ($isTeam): ?>
    <?php foreach ($items as $item): ?>
        <?php if ($item['type'] !== 'heading') continue; ?>
        <?php $lines = preg_split('/\R/u', trim((string) ($item['title'] ?? '')), 2); ?>
        <div class="ik-components__team-heading">
            <div>
                <?php if (!empty($item['subtitle'])): ?><p class="ik-components__eyebrow"><?= $escape($item['subtitle']) ?></p><?php endif; ?>
                <h2><?= $escape($lines[0] ?? '') ?><?php if (!empty($lines[1])): ?><br><span><?= $escape($lines[1]) ?></span><?php endif; ?></h2>
            </div>
            <?php if (!empty($item['text'])): ?><p><?= nl2br($escape($item['text'])) ?></p><?php endif; ?>
        </div>
    <?php endforeach; ?>
    <div class="ik-components__team-grid">
    <?php foreach ($items as $item): ?>
        <?php if ($item['type'] === 'heading') continue; ?>
        <?php $src = $asset($item['image'] ?? ''); ?>
        <article class="ik-components__team-card">
            <div class="ik-components__team-photo">
                <?php if ($src !== ''): ?><img src="<?= $escape($src) ?>" alt="<?= $escape($item['image_alt'] ?: $item['title']) ?>" loading="lazy" decoding="async"><?php endif; ?>
            </div>
            <div class="ik-components__team-body">
                <?php if (!empty($item['title'])): ?><h3><?= $escape($item['title']) ?></h3><?php endif; ?>
                <?php if (!empty($item['subtitle'])): ?><p class="ik-components__team-role"><?= $escape($item['subtitle']) ?></p><?php endif; ?>
                <?php if (!empty($item['text'])): ?><p class="ik-components__team-description"><?= nl2br($escape($item['text'])) ?></p><?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>
    </div>
<?php else: ?>
    <?php foreach ($items as $item): ?>
        <?php $type = in_array($item['type'], ['heading', 'split', 'card'], true) ? $item['type'] : 'card'; ?>
        <?php if ($type === 'heading'): ?>
            <header class="ik-components__heading">
                <?php if (!empty($item['subtitle'])): ?><p class="ik-components__eyebrow"><?= $escape($item['subtitle']) ?></p><?php endif; ?>
                <h2><?= $escape($item['title']) ?></h2>
                <?php if (!empty($item['text'])): ?><p><?= nl2br($escape($item['text'])) ?></p><?php endif; ?>
            </header>
        <?php else: ?>
            <?php $src = $asset($item['image'] ?? ''); ?>
            <article class="ik-components__item ik-components__item--<?= $escape($type) ?>">
                <?php if ($src !== ''): ?><div class="ik-components__media"><img src="<?= $escape($src) ?>" alt="<?= $escape($item['image_alt'] ?: $item['title']) ?>" loading="lazy" decoding="async"></div><?php endif; ?>
                <div class="ik-components__body">
                    <?php if (!empty($item['subtitle'])): ?><p class="ik-components__eyebrow"><?= $escape($item['subtitle']) ?></p><?php endif; ?>
                    <?php if (!empty($item['title'])): ?><h3><?= $escape($item['title']) ?></h3><?php endif; ?>
                    <?php if (!empty($item['text'])): ?><p><?= nl2br($escape($item['text'])) ?></p><?php endif; ?>
                </div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
</section>
