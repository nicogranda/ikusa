<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = filter_var($_POST["url"], FILTER_VALIDATE_URL);

    if ($url === false) {
        echo "<p>URL no válida.</p>";
    } else {
        // Obtener el contenido de la página
        $html = @file_get_contents($url);

        if ($html === false) {
            echo "<p>No se pudo obtener el contenido de la página.</p>";
        } else {
            // Cargar el contenido HTML en DOMDocument
            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            // Inicializar variables para los metadatos
            $ogTitle = "";
            $ogDescription = "";
            $ogImage = "";
            $twitterTitle = "";
            $twitterDescription = "";
            $twitterImage = "";

            // Obtener los metadatos Open Graph y Twitter
            $metas = $dom->getElementsByTagName("meta");

            foreach ($metas as $meta) {
                $property = $meta->getAttribute("property");
                $name = $meta->getAttribute("name");
                $content = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');

                // Open Graph
                if ($property === "og:title") $ogTitle = $content;
                if ($property === "og:description") $ogDescription = $content;
                if ($property === "og:image") $ogImage = $content;

                // Twitter
                if ($name === "twitter:title") $twitterTitle = $content;
                if ($name === "twitter:description") $twitterDescription = $content;
                if ($name === "twitter:image") $twitterImage = $content;
            }

            // Obtener los enlaces
            $links = $dom->getElementsByTagName('a');

            // Redes sociales comunes
            $socialNetworks = [
                'facebook' => 'facebook',
                'twitter' => 'twitter',
                'instagram' => 'instagram',
                'linkedin' => 'linkedin',
                'youtube' => 'youtube',
                'pinterest' => 'pinterest'
            ];

            $socialLinks = [];

            foreach ($links as $link) {
                $href = strtolower($link->getAttribute('href'));

                foreach ($socialNetworks as $network => $keyword) {
                    if (strpos($href, $keyword) !== false) {
                        $socialLinks[$network] = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
                    }
                }
            }

            // Mostrar los resultados
            echo "<div class='info-section'>";
            echo "<h2>Metadatos de Open Graph:</h2>";
            echo "<div class='info-item'><strong>OG Título:</strong> " . ($ogTitle ?: "<span class='no-found'>No encontrado</span>") . "</div>";
            echo "<div class='info-item'><strong>OG Descripción:</strong> " . ($ogDescription ?: "<span class='no-found'>No encontrado</span>") . "</div>";
            echo "<div class='info-item'><strong>OG Imagen:</strong> " . ($ogImage ?: "<span class='no-found'>No encontrado</span>") . "</div>";

            echo "<h2>Metadatos de Twitter:</h2>";
            echo "<div class='info-item'><strong>Twitter Título:</strong> " . ($twitterTitle ?: "<span class='no-found'>No encontrado</span>") . "</div>";
            echo "<div class='info-item'><strong>Twitter Descripción:</strong> " . ($twitterDescription ?: "<span class='no-found'>No encontrado</span>") . "</div>";
            echo "<div class='info-item'><strong>Twitter Imagen:</strong> " . ($twitterImage ?: "<span class='no-found'>No encontrado</span>") . "</div>";

            echo "<h2>Redes Sociales:</h2>";
            foreach ($socialNetworks as $network => $keyword) {
                $label = ucfirst($network);
                $iconClass = 'fab fa-' . $network;
                $url = isset($socialLinks[$network]) 
                    ? "<a href='" . $socialLinks[$network] . "' target='_blank'><i class='$iconClass'></i> " . $label . "</a>: ". $socialLinks[$network]
                    : "<span class='no-found'<i class='$iconClass'></i> " . $label .": No encontrado</span>";
                echo "<div class='info-item'>$url</div>";
            }

            echo "</div>";
        }
    }
}
?>
