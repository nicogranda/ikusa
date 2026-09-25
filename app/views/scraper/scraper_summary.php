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
            $title = "";
            $description = "";
            $keywords = "";
            $canonical = "";
            $author = "";
            $publisher = "";
            $robotsTag = "";
            $language = "";

            // Obtener los metadatos
            $metas = $dom->getElementsByTagName("meta");

            foreach ($metas as $meta) {
                if ($meta->getAttribute("name") === "description") {
                    $description = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');
                }
                if ($meta->getAttribute("name") === "keywords") {
                    $keywords = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');
                }
                if ($meta->getAttribute("name") === "canonical") {
                    $canonical = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');
                }
                if ($meta->getAttribute("name") === "author") {
                    $author = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');
                }
                if ($meta->getAttribute("name") === "publisher") {
                    $publisher = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');
                }
                if ($meta->getAttribute("name") === "robots") {
                    $robotsTag = htmlspecialchars($meta->getAttribute("content"), ENT_QUOTES, 'UTF-8');
                }
            }

            // Obtener el idioma desde el atributo lang en la etiqueta html
            $htmlLang = $dom->getElementsByTagName("html")->item(0);
            if ($htmlLang) {
                $language = $htmlLang->getAttribute("lang");
            }

            // Obtener el título de la página
            $titleTag = $dom->getElementsByTagName("title")->item(0);
            if ($titleTag) {
                $title = htmlspecialchars($titleTag->textContent, ENT_QUOTES, 'UTF-8');
            }

            // Mostrar los resultados en una tabla
            echo "<div class='info-section'>";
            echo "<h2>Metadatos de la Página:</h2>";
            echo "<table class='metadata-table'>";
            echo "<tr><td><strong>Título:</strong></td><td>" . ($title ? $title : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Descripción:</strong></td><td>" . ($description ? $description : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Keywords:</strong></td><td>" . ($keywords ? $keywords : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Canonical:</strong></td><td>" . ($canonical ? $canonical : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Autor:</strong></td><td>" . ($author ? $author : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Editor:</strong></td><td>" . ($publisher ? $publisher : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Robots Tag:</strong></td><td>" . ($robotsTag ? $robotsTag : "No encontrado") . "</td></tr>";
            echo "<tr><td><strong>Idioma:</strong></td><td>" . ($language ? $language : "No encontrado") . "</td></tr>";
            echo "</table>";
            echo "</div>";
        }
    }
}
?>