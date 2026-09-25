<?php
if (isset($_POST['links']) || isset($_POST['reset'])) {
    if (isset($_POST['reset'])) {
        // Redirige al mismo archivo para reiniciar el formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $url = filter_var($_POST["url"], FILTER_VALIDATE_URL);

    if ($url === false) {
        echo "<p>URL no válida.</p>";
    } else {
        if (strpos($url, 'https://') === false) {
            echo "<p>La URL no usa HTTPS. La seguridad es importante para el posicionamiento SEO.</p>";
        }

        $domain = getDomainFromUrl($url);
        echo "<p>Dominio: " . htmlspecialchars($domain) . "</p>";

        $html = file_get_contents($url);
        if ($html === false) {
            echo "<p>No se pudo obtener el contenido de la página.</p>";
        } else {
            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            // Obtención de enlaces
            $links = $dom->getElementsByTagName('a');
            $linkCount = $links->length;

            // Mostrar enlaces en una tabla
            echo "<div class='info-section'>";
            echo "<h2>Enlaces:</h2>";
            echo "<table class='links-table'>";
            echo "<thead><tr><th>Link</th><th>Title</th></tr></thead>";
            echo "<tbody>";
            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                $text = htmlspecialchars($link->textContent);
                $href = htmlspecialchars($href);
                echo "<tr>";
                echo "<td><span class='link-text'>$href</span></td>";
                echo "<td><span class='link-text'>$text</span></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
    }
}

function getDomainFromUrl($url) {
    $url = preg_replace('/^https?:\/\//', '', $url);
    $url = preg_replace('/^www\./', '', $url);
    $domainParts = explode('/', $url);
    $domain = array_shift($domainParts);
    return $domain;
}
?>
