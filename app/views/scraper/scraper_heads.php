<?php
if (isset($_POST['heads']) || isset($_POST['reset'])) {
    if (isset($_POST['reset'])) {
        // Redirige al mismo archivo para reiniciar el formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $url = filter_var($_POST["url"], FILTER_VALIDATE_URL);

    if ($url === false) {
        echo "<p style='color:red;'>URL no válida.</p>";
    } else {
        if (strpos($url, 'https://') === false) {
            echo "<p style='color:orange;'>La URL no usa HTTPS. La seguridad es importante para el posicionamiento SEO.</p>";
        }

        $domain = getDomainFromUrl($url);
        echo "<p><strong>Dominio:</strong> " . htmlspecialchars($domain) . "</p>";

        $html = @file_get_contents($url);
        if ($html === false) {
            echo "<p style='color:red;'>No se pudo obtener el contenido de la página.</p>";
        } else {
            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            // Obtener todos los encabezados en orden
            $xpath = new DOMXPath($dom);
            $headerTags = ['h1','h2','h3','h4','h5','h6'];
            $headers = [];

            foreach ($headerTags as $tag) {
                $nodes = $xpath->query("//{$tag}");
                foreach ($nodes as $node) {
                    $headers[] = [
                        'tag' => $tag,
                        'text' => trim($node->textContent)
                    ];
                }
            }

            if (empty($headers)) {
                echo "<p style='color:red;'>No se encontraron encabezados en esta página.</p>";
            } else {
                echo "<div class='info-section'>";
                echo "<h2>Encabezados encontrados en orden de aparición:</h2>";
                echo "<ol>";
                foreach ($headers as $header) {
                    echo "<li><strong>{$header['tag']}:</strong> " . htmlspecialchars($header['text']) . "</li>";
                }
                echo "</ol>";

                // Resumen por tipo de encabezado
                $summary = array_count_values(array_column($headers, 'tag'));
                echo "<h3>Resumen por nivel:</h3><ul>";
                foreach ($headerTags as $tag) {
                    $count = $summary[$tag] ?? 0;
                    $color = $tag === 'h1' && $count === 0 ? 'red' : 'black';
                    echo "<li style='color:{$color};'><strong>{$tag}:</strong> {$count}</li>";
                }
                echo "</ul></div>";
            }
        }
    }
}

function getDomainFromUrl($url) {
    $url = preg_replace('/^https?:\/\//', '', $url);
    $url = preg_replace('/^www\./', '', $url);
    $domainParts = explode('/', $url);
    return array_shift($domainParts);
}
?>