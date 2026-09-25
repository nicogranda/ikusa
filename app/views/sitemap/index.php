<?php
// Función para obtener enlaces de una página
function getLinks($url, $baseUrl) {
    $links = [];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout para evitar bloqueos
    $html = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Error de cURL: ' . curl_error($ch);
        return $links;
    }
    
    curl_close($ch);

    if (!$html) {
        return $links;
    }

    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $anchors = $dom->getElementsByTagName('a');
    foreach ($anchors as $anchor) {
        $href = $anchor->getAttribute('href');
        $href = filter_var($href, FILTER_SANITIZE_URL);

        if (!filter_var($href, FILTER_VALIDATE_URL)) {
            $href = rtrim($baseUrl, '/') . '/' . ltrim($href, '/');
        }

        if (strpos($href, $baseUrl) === 0 && !in_array($href, $links)) {
            $links[] = $href;
        }
    }

    return $links;
}

// Función para rastrear todas las URLs
function crawl($url, &$crawled, $baseUrl) {
    if (in_array($url, $crawled)) {
        return;
    }

    $crawled[] = $url;
    $links = getLinks($url, $baseUrl);

    foreach ($links as $link) {
        crawl($link, $crawled, $baseUrl);
    }
}

// Función para generar el XML del sitemap
function generateSitemap($urls) {
    $xml = new DOMDocument('1.0', 'UTF-8');
    $xml->formatOutput = true;

    $urlset = $xml->createElement('urlset');
    $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $urlset->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

    $comment = $xml->createComment(' created with Free Online Sitemap Generator www.ikusa.net/sitemap ');
    $urlset->appendChild($comment);

    foreach ($urls as $url) {
        $urlElement = $xml->createElement('url');
        
        $loc = $xml->createElement('loc', htmlspecialchars($url));
        $urlElement->appendChild($loc);

        $lastmod = $xml->createElement('lastmod', date('c')); // Date format: ISO 8601
        $urlElement->appendChild($lastmod);

        $priority = $xml->createElement('priority', '0.80'); // Default priority
        $urlElement->appendChild($priority);

        $urlset->appendChild($urlElement);
    }

    $xml->appendChild($urlset);

    return $xml->saveXML();
}

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $startUrl = filter_var($_POST['url'], FILTER_SANITIZE_URL);

    if (filter_var($startUrl, FILTER_VALIDATE_URL)) {
        $crawled = [];
        crawl($startUrl, $crawled, $startUrl);

        $sitemap = generateSitemap($crawled);

        // Limpiar el buffer de salida
        ob_clean();
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="sitemap.xml"');
        echo $sitemap;
        exit;
    } else {
        $error = "URL no válida.";
    }
}
?>

<main>
    <form method="post" action="">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" required class="search_bar">
        <input type="submit" value="Generar Sitemap">
    </form>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>
</main>
