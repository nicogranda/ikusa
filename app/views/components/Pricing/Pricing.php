<?php

/**
 * Component: Pricing/Pricing.php
 *
 * Vista genérica para SEO y diseño web.
 * Obtiene los datos del controlador.
 */

require_once dirname(__DIR__, 3)
    . '/src/Domains/Pricing/PricingController.php';

use App\Domains\Pricing\PricingController;

$pricing = PricingController::get();

$pricingLang = strtolower((string)($lang ?? 'es'));

$contactPaths = [
    'es' => '/es/contacto',
    'en' => '/en/contact',
    'eu' => '/eu/kontaktua',
];

$contactPath = $contactPaths[$pricingLang]
    ?? $contactPaths['es'];

$pricingCssUrl = '/assets/css/components/pricing.css';

/*
 * IMPORTANTE:
 * El archivo CSS debe existir en:
 * public_html/assets/css/components/pricing.css
 */
?>

<style>
<?php
readfile(__DIR__ . '/pricing.css');
?>
</style>

<section
    class="pricing-section"
    id="precios-<?= htmlspecialchars($pricing['service'], ENT_QUOTES, 'UTF-8') ?>"
>

    <div class="pricing-container">

        <div class="pricing-eyebrow">
            <span class="pricing-eyebrow-line"></span>

            <span class="pricing-eyebrow-text">
                <?= htmlspecialchars($pricing['eyebrow'], ENT_QUOTES, 'UTF-8') ?>
            </span>
        </div>

        <h2 class="pricing-title">
            <?= htmlspecialchars($pricing['title'], ENT_QUOTES, 'UTF-8') ?>
        </h2>

        <?php if (!empty($pricing['intro'])): ?>
            <p class="pricing-intro">
                <?= htmlspecialchars($pricing['intro'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <div class="pricing-grid">

            <?php foreach ($pricing['plans'] as $index => $plan): ?>

                <?php
                $number = str_pad(
                    (string)($index + 1),
                    2,
                    '0',
                    STR_PAD_LEFT
                );

                $contactUrl = $contactPath . '?' . http_build_query([
                    'servicio' => $plan['service'] ?? $pricing['service'],
                    'plan' => $plan['plan'] ?? '',
                ]);

                $featured = !empty($plan['featured']);
                ?>

                <article class="pricing-card<?= $featured ? ' pricing-card-featured' : '' ?>">

                    <?php if (!empty($plan['badge'])): ?>
                        <span class="pricing-badge">
                            <?= htmlspecialchars($plan['badge'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    <?php endif; ?>

                    <span class="pricing-num">
                        <?= $number ?>
                    </span>

                    <h3 class="pricing-card-title">
                        <?= htmlspecialchars($plan['title'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>

                    <p class="pricing-card-description">
                        <?= htmlspecialchars($plan['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <div class="pricing-price">

                        <span class="pricing-amount">
                            <?= htmlspecialchars($plan['amount'], ENT_QUOTES, 'UTF-8') ?>
                        </span>

                        <?php if (!empty($plan['currency'])): ?>
                            <span class="pricing-currency">
                                <?= htmlspecialchars($plan['currency'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($plan['period'])): ?>
                            <span class="pricing-period">
                                <?= htmlspecialchars($plan['period'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        <?php endif; ?>

                    </div>

                    <?php if (!empty($plan['features'])): ?>
                        <ul class="pricing-features">

                            <?php foreach ($plan['features'] as $feature): ?>
                                <li>
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                    <span>
                                        <?= htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    <?php endif; ?>

                    <?php if (!empty($plan['note'])): ?>
                        <p class="pricing-card-note">
                            <?= htmlspecialchars($plan['note'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    <?php endif; ?>

                    <a
                        class="pricing-btn<?= $featured ? ' pricing-btn-solid' : '' ?>"
                        href="<?= htmlspecialchars($contactUrl, ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <?= htmlspecialchars(
                            $plan['button'] ?? 'Solicitar información',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </a>

                </article>

            <?php endforeach; ?>

        </div>

        <?php if (!empty($pricing['infrastructure'])): ?>

            <?php $infrastructure = $pricing['infrastructure']; ?>

            <div class="pricing-infrastructure">

                <div class="pricing-infrastructure__intro">

                    <span class="pricing-infrastructure__eyebrow">
                        <?= htmlspecialchars($infrastructure['eyebrow'], ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <h3>
                        <?= htmlspecialchars($infrastructure['title'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($infrastructure['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                </div>

                <div class="pricing-infrastructure__grid">

                    <?php foreach ($infrastructure['items'] as $item): ?>

                        <article class="pricing-infrastructure__item">

                            <i
                                class="fa-solid <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>"
                                aria-hidden="true"
                            ></i>

                            <h4>
                                <?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h4>

                            <p>
                                <?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <span>
                                <?= htmlspecialchars($item['note'], ENT_QUOTES, 'UTF-8') ?>
                            </span>

                        </article>

                    <?php endforeach; ?>

                </div>

                <?php if (!empty($infrastructure['footer'])): ?>
                    <p class="pricing-infrastructure__note">
                        <?= htmlspecialchars($infrastructure['footer'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

</section>