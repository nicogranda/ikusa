<head>
    <meta charset="UTF-8">
    <title>Scraper Auditoría Web para SEO</title>
    <meta name="robots" content="index,follow">
    <!--<meta name="description" content="Scraper web para extraer datos de sitios web de forma automática. Su función principal es navegar en una página web, identificar y extraer información específica.">-->
    <link rel="stylesheet" href="css/scraper.css" type="text/css" charset="utf-8" />

    <style>
        /* Estilos para tabs horizontales */
        .tabs{
            display:flex;
        }

        .tabs button{
            background: var(--color-primary);
            color:white;
            border:none;
            padding:10px 18px;
            cursor:pointer;
            border-radius:6px;
            font-size:14px;
            transition:0.2s;
        }

        .tabs button:hover{
            background:#0f172a;
        }

        .tabs .reset{
            background:#b91c1c;
        }

        .tabs .reset:hover{
            background:#7f1d1d;
        }

        .search_bar{
            width:100%;
            max-width:500px;
            padding:10px;
            font-size:16px;
            margin-bottom:10px;
        }

        .principal{margin-bottom:0;}
        .sub-principal{margin-top:0;margin-bottom:15px;}
        .introduces{margin-bottom:15px;line-height:1.5;}
    </style>
</head>

<body>

<h1 class="principal">Scraper Web</h1>
<h2 class="sub-principal">Auditoría Web</h2>

<p class="introduces">
Un scraper o scraper web es un programa o script que se utiliza para extraer datos de sitios web de forma automática. 
Su función principal es navegar en una página web, identificar y extraer información específica 
(como texto, imágenes, enlaces o datos de tablas) y almacenarla en una estructura de datos como una base de datos o archivo, facilitando su análisis o uso posterior.
</p>

<form method="post">

    <input type="text"
           id="url"
           name="url"
           value="<?php echo isset($_POST['url']) ? htmlspecialchars($_POST['url']) : ''; ?>"
           placeholder="URL"
           required
           class="search_bar">

    <input type="text"
           name="keywords"
           placeholder="Keyword principal (opcional)"
           value="<?php echo $_POST['keywords'] ?? ''; ?>"
           class="search_bar">

    <select name="country" class="search_bar">
        <option value="es">España</option>
        <option value="us">USA</option>
        <option value="mx">México</option>
        <option value="co">Colombia</option>
    </select>

    <select name="lang" class="search_bar">
        <option value="es">Español</option>
        <option value="en">English</option>
    </select>

    <input type="text"
           name="city"
           placeholder="Ciudad (opcional)"
           value="<?php echo $_POST['city'] ?? ''; ?>"
           class="search_bar">

    <div class="tabs">
        <button type="submit" name="summary">Summary</button>
        <button type="submit" name="heads">Headers</button>
        <button type="submit" name="images">Images</button>
        <button type="submit" name="links">Links</button>
        <button type="submit" name="rrss">RRSS</button>
        <button type="submit" name="keyword">Keywords</button>
        <button type="submit" name="serp">SERP</button>
        <button type="submit" name="competencia">Competencia</button>
        <button type="submit" name="audit">Auditoría SEO</button>
        <button type="submit" name="reset" class="reset">Reset</button>
    </div>

</form>

<?php
if (isset($_POST['summary'])) {
    include 'scraper_summary.php';
}

if (isset($_POST['images'])) {
    include 'scraper_img.php';
}

if (isset($_POST['heads'])) {
    include 'scraper_heads.php';
}

if (isset($_POST['links'])) {
    include 'scraper_links.php';
}

if (isset($_POST['rrss'])) {
    include 'scraper_rrss.php';
}

if (isset($_POST['keyword'])) {
include 'scraper_keywords.php';
}

if (isset($_POST['serp'])) {
    include 'scraper_serp.php';
}

if (isset($_POST['audit'])) {
    include 'keywords.php';
}

if (isset($_POST['competencia'])) {
    include 'competencia.php';
}


if (isset($_POST['reset'])) {
    // Redirige al mismo archivo para reiniciar el formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

