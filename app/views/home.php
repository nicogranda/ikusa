<?php
$siteName = 'Ikusa';
$siteUrl  = 'https://ikusa.net';
// Opcional, solo si tienes buscador interno funcional:
// $siteSearchUrlTemplate = 'https://ikusa.net/search?q={search_term_string}';

require __DIR__ . '/schemas/website.schema.php';
?>
<div class='desk'>
    <div class='cubo'>
        <?php
        $cubeRenderHeading = false;
        include __DIR__ . '/components/cube/index.php';
        unset($cubeRenderHeading);
        ?>
    </div>
    <article class="hero-banner-text">
        <h1 class='hero-banner-title'>Agencia de Diseño Gráfico,<br>Desarrollo Web<br> y Marketing Digital</h1>
        <p class='hero-banner-container'>Estrategias de marketing para liderar tu sector</p>
    </article>
</div>

<section class="container">
    <article class="article-text">
        <h2 class="principal">Tu agencia de diseño web, SEO y marketing digital</h2>
        <p>
            Somos una agencia de diseño web y marketing digital con más de 20 años de experiencia
            ayudando a empresas de todos los tamaños y sectores a tener páginas web útiles,
            bien posicionadas y que generen negocio. Estarás en buenas manos.
        </p>
    </article>
</section>

<?php include __DIR__ . '/components/clients.php'; ?>

<?php include  __DIR__ . '/components/services/services.php';?>

<?php include  __DIR__ . '/components/benefits/benefits.php';?>


<?php include  __DIR__ . '/components/fases/fases.php';?>

<?php include __DIR__ . '/components/google_reviews.php'; ?>

<script>
function updateCartButton() {
    const cartButton = document.getElementById('viewCart');
    if (!cartButton) return;
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    const totalItems = Object.values(cart).reduce((acc, item) => acc + item.quantity, 0);
    cartButton.textContent = `${totalItems}`;
}
document.addEventListener('DOMContentLoaded', updateCartButton);
</script>
