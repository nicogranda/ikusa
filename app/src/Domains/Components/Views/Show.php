<?php
/** @var string $name */
/** @var string $language */
/** @var array $items */
$escape = static fn (?string $value): string => htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$allowedTypes = ['heading', 'split', 'card'];
?>
<section class="ik-components ik-components--<?= $escape($name) ?>" aria-label="<?= $escape($name) ?>">
    <?php foreach ($items as $item):
        $type = in_array($item['type'], $allowedTypes, true) ? $item['type'] : 'card';
        $image = (string) ($item['image'] ?? '');
        // Las rutas guardadas son relativas a la raíz pública: img/team/nico.png.
        $imageUrl = $image !== '' && preg_match('~^(?:img|assets/img)/[a-zA-Z0-9_./-]+\.(?:png|jpe?g|webp|avif)$~i', $image) && !str_contains($image, '..')
            ? (function_exists('asset_url') ? asset_url($image) : '/assets/' . preg_replace('~^assets/~', '', $image)) : '';
        $title = (string) ($item['title'] ?? '');
        $subtitle = (string) ($item['subtitle'] ?? '');
        $description = (string) ($item['text'] ?? '');
    ?>
    <?php if ($type === 'heading'): ?>
        <header class="ik-components__heading">
            <?php if ($subtitle !== ''): ?><p class="ik-components__eyebrow"><?= $escape($subtitle) ?></p><?php endif; ?>
            <?php if ($title !== ''): ?><h2><?= $escape($title) ?></h2><?php endif; ?>
            <?php if ($description !== ''): ?><p><?= nl2br($escape($description)) ?></p><?php endif; ?>
        </header>
    <?php else: ?>
        <article class="ik-components__item ik-components__item--<?= $escape($type) ?>">
            <?php if ($imageUrl !== ''): ?>
                <div class="ik-components__media">
                    <img src="<?= $escape($imageUrl) ?>" alt="<?= $escape((string) ($item['image_alt'] ?: $title)) ?>" loading="lazy" decoding="async">
                </div>
            <?php endif; ?>
            <div class="ik-components__body">
                <?php if ($subtitle !== ''): ?><p class="ik-components__eyebrow"><?= $escape($subtitle) ?></p><?php endif; ?>
                <?php if ($title !== ''): ?><h3><?= $escape($title) ?></h3><?php endif; ?>
                <?php if ($description !== ''): ?><p><?= nl2br($escape($description)) ?></p><?php endif; ?>
            </div>
        </article>
    <?php endif; ?>
    <?php endforeach; ?>
</section>
