<?php
$siteName = 'Ikusa';
$siteUrl  = 'https://ikusa.net';
// Opcional, solo si tienes buscador interno funcional:
// $siteSearchUrlTemplate = 'https://ikusa.net/search?q={search_term_string}';

require __DIR__ . '/schemas/website.schema.php';
?>
<div class='desk'>
    <div class='cubo'>
        <?php include __DIR__ . '/components/cube/index.php'; ?>
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

<?php include  __DIR__ . '/components/services/services.php';?>

<?php include  __DIR__ . '/components/benefits/benefits.php';?>


<img src="<?= htmlspecialchars(asset_url('img/heros/desarrollo_web.jpg'), ENT_QUOTES, 'UTF-8') ?>" style='width:100%;' alt='Diseño Web Profesional' title='Diseño Web Profesional'>
<?php include  __DIR__ . '/components/fases/fases.php';?>

<?php
$zonas = [
    ['nombre' => 'Irún', 'url' => '/es/marketing-digital-irun', 'desc' => 'Marketing digital y SEO'],
    ['nombre' => 'Donostia / San Sebastián', 'url' => '/es/seo-donostia', 'desc' => 'SEO y posicionamiento'],
    ['nombre' => 'Gipuzkoa', 'url' => '/es/marketing-digital-gipuzkoa', 'desc' => 'Cobertura de toda la provincia'],
    ['nombre' => 'Resto de España', 'url' => '/agencia-de-marketing', 'desc' => 'Servicio 100% remoto'],
];
?>

<section class="zonas-trabajo">
    <p class="zonas-trabajo__label principal">Zonas donde trabajamos</p>
    <div class="zonas-trabajo__grid">
        <?php foreach ($zonas as $zona): ?>
            <a href="<?php echo $zona['url']; ?>" class="zonas-trabajo__card">
                <span class="zonas-trabajo__nombre"><?php echo $zona['nombre']; ?></span>
                <span class="zonas-trabajo__desc"><?php echo $zona['desc']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<style>
.zonas-trabajo__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
.zonas-trabajo__card { display: block; padding: 1rem 1.1rem; border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; text-decoration: none; }
.zonas-trabajo__nombre { display: block; font-weight: 600; margin-bottom: 2px; }
.zonas-trabajo__desc { display: block; font-size: 13px; opacity: 0.7; }
</style>

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