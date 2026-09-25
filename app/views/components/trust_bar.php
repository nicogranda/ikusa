<?php

                $trustItems = [
                    [
                        "icon"  => "fa-regular fa-calendar",
                        "label" => "+5 años de experiencia"
                    ],
                    [
                        "icon"  => "fa-solid fa-location-dot",
                        "label" => "Con base en Gipuzkoa"
                    ],
                   [
    "icon"  => "fa-regular fa-star",
    "label" => "Un cliente por sector"
],
                    [
                        "icon"  => "fa-solid fa-chart-line",
                        "label" => "Resultados medibles"
                    ]
                ];
?>
<?php if (!empty($trustItems)) : ?>
<div class="trust-bar">
    <div class="container">
        <ul class="trust-bar__list">
            <?php foreach ($trustItems as $item) : ?>
                <li class="trust-bar__item">
                    <i class="<?= $item['icon']; ?>"></i>
                    <span><?= $item['label']; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>

<style>
    .trust-bar {
        /*background-color: #F9FAFB;*/
        border-top: 1px solid #E5E7EB;
        border-bottom: 1px solid #E5E7EB;
        padding: 14px 0;
    }

    .trust-bar__list {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 40px;
        list-style: none;
        margin: 0;
        padding: 0;
        
    }

    .trust-bar__item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 500;
        color: #374151;
        white-space: nowrap;
    }

    .trust-bar__item i {
        font-size: 14px;
        color: var(--color-primary, #111827);
    }

    @media (max-width: 991px) {
        .trust-bar__list {
            gap: 20px;
            justify-content: flex-start;
            overflow-x: auto;
            flex-wrap: nowrap;
            padding: 0 16px;
            scrollbar-width: none;
            color: #ffff;
        }

    .trust-bar__item {
          color: #ffff;
    }
        .trust-bar__list::-webkit-scrollbar {
            display: none;
        }
    }
</style>