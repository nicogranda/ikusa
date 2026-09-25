<?php include __DIR__ . "/BenefitsController.php"; ?>
<?php include __DIR__ . "/benefitsHero.php"; ?>

<link rel="stylesheet" href="/assets/css/benefits.css">

<section class="benefits-section">

    <div class="container">

        <div class="benefits-grid">

            <?php foreach ($benefits as $item): ?>
                <article class="benefit-card">

                    <div class="benefit-icon">
                        <i class="fa-solid <?= $item['icon'] ?>"></i>
                    </div>

                    <h3><?= htmlspecialchars($item['title']) ?></h3>

                    <p><?= htmlspecialchars($item['text']) ?></p>

                </article>
            <?php endforeach; ?>

        </div>

        <div class="benefits-cta">

            <div class="cta-content">

                <div class="cta-icon">
                    <i class="fa-regular fa-comment-dots"></i>
                </div>

                <div>
                    <h3>¿Tienes un proyecto en mente?</h3>
                    <p>Hablemos y te ayudamos a hacerlo realidad.</p>
                </div>

            </div>

            <div class="cta-buttons">
                <a href="/es/contacto" class="btn btn-primary">Solicitar propuesta</a>
                <a href="#" class="btn btn-secondary">Ver portfolio</a>
            </div>

        </div>

    </div>

</section>