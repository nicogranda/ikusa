<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descubre cómo se aplica el marketing en Donostia, destacando su gastronomía, turismo, sostenibilidad y eventos culturales.">
    <meta name="keywords" content="marketing, Donostia, San Sebastián, turismo, gastronomía, sostenibilidad, eventos">
    <title>Marketing en Donostia</title>
</head>
<section class="hero">
    <div class='desk'>
        <?php //include '../app/views/components/cube/index.html';?>
        <img src='images/heros/marketing-donosti.png' alt="<?php echo $_GET['page'];?>" title="<?php echo $_GET['page'];?>" width='100%;'>
        <article class="hero-banner-text">
            <!--<h1 class='hero-banner-title'>Diseño Web Donostia</h1>-->
            <!--<div class='hero-banner-container'>Páginas web únicas y estrategias de marketing digital para liderar tu sector online</div>-->
        </article>
    </div>
</section>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';
$formattedPage = ucwords(str_replace('-', ' ', $page));

?>

<h1 class='principal'><?php echo $formattedPage;?></h1>

<div class="content">
    <h1 class="principal"></h1>
    <p>El marketing en Donostia (San Sebastián), como en muchas ciudades, se adapta a las características y particularidades locales. Esta ciudad, conocida por su gastronomía, turismo y cultura, tiene un enfoque distintivo en varios aspectos clave:</p>
    
    <h2 class="sub-title">1. Marketing turístico</h2>
    <ul>
        <li><strong>Enfoque en la gastronomía:</strong> Estrategias que destacan restaurantes, bares, y eventos como el Basque Culinary Center y San Sebastián Gastronomika.</li>
        <li><strong>Promoción del turismo cultural:</strong> Eventos como el Festival Internacional de Cine, la Semana Grande y el Jazzaldia.</li>
        <li><strong>Paisaje y estilo de vida:</strong> Atracciones como la Playa de La Concha y el Monte Igueldo.</li>
    </ul>

    <h2 class="sub-title">2. Marketing local y sostenible</h2>
    <ul>
        <li><strong>Valorización del comercio local:</strong> Campañas para pequeños negocios, mercados como el Mercado de San Martín y productos de kilómetro cero.</li>
        <li><strong>Sostenibilidad:</strong> Estrategias alineadas con iniciativas ecológicas y de turismo sostenible.</li>
    </ul>

    <h2 class="sub-title">3. Marketing digital</h2>
    <ul>
        <li><strong>Uso de redes sociales:</strong> Promoción con fotos y videos que destacan paisajes, eventos y gastronomía.</li>
        <li><strong>Colaboración con influencers:</strong> Relevancia de creadores de contenido en viajes y gastronomía.</li>
    </ul>

    <h2 class="sub-title">4. Eventos y festivales</h2>
    <p>El marketing aprovecha la rica agenda de eventos para promover negocios locales como hoteles, restaurantes y más.</p>

    <h2 class="sub-title">5. Enfoque en mercados internacionales</h2>
    <p>Donostia se proyecta como un destino de lujo, adaptando mensajes para atraer a turistas con alto poder adquisitivo.</p>

    <h2 class="sub-title">6. Marketing comunitario</h2>
    <p>Se fomenta la participación activa de la comunidad local para reforzar el orgullo y la identidad de Donostia.</p>
</div>

<section class="principal-service">
    <article class="article-graphic">
        <h2>Diseño Gráfico</h2>
        <p>Diseñamos para formatos on-line y off-line. ¿Qué necesitas?</p>
        <ul>
            <li><h3>Branding</h3></li>
            <li><h3>Brochure</h3></li>
            <li><h3>Merchandising</h3></li>
            <li><h3>Multimedias</h3></li>
        </ul>
    </article>
    <article class="article-website">
        <h2 class="sub-principal">Web Site</h2>
        <p>Diseñamos y programamos desde cero la web que tu empresa necesita para triunfar. ¿Qué necesitas?</p>
        <ul>
            <li><h3>Páginas web</h3></li>
            <li><h3>Tiendas online</h3></li>
        </ul>
    </article>
    <article class="article-marketing">
        <h2>Marketing Digital</h2>
        <p>Te proponemos estrategias de marketing digital para dar con tu cliente, convertirlo y fidelizarlo:</p>
        <ul>
            <li><h3>SEO</h3></li>
            <li><h3>SEM</h3></li>
        </ul>
    </article>
</section>
