
<head>

<style>
        /* Estilos para el modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(128, 128, 128, 0.8); /* Fondo gris con opacidad */
    padding-top: 60px;
}

.modal-content {
    background-color: gray;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 800px; /* Opcional: Limitar el ancho máximo del modal */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.scraper-gallery-item {
    margin-bottom: 20px;
}

.scraper-gallery-item a {
    text-decoration: none;
    color: blue;
    cursor: pointer;
}
</style>
</head>

    <?php
    function getDomainFromUrl($url) {
        $url = preg_replace('/^https?:\/\//', '', $url);
        $url = preg_replace('/^www\./', '', $url);
        $domainParts = explode('/', $url);
        $domain = array_shift($domainParts);
        return $domain;
    }

    function makeAbsoluteUrl($relativeUrl, $baseUrl) {
        if (preg_match('/^(https?:\/\/)/i', $relativeUrl)) {
            return $relativeUrl;
        }

        $parsedBaseUrl = parse_url($baseUrl);
        $baseUrl = $parsedBaseUrl['scheme'] . '://' . $parsedBaseUrl['host'];

        $relativeUrl = ltrim($relativeUrl, '/');
        if (strpos($relativeUrl, '/') === 0) {
            return $baseUrl . $relativeUrl;
        }

        return $baseUrl . '/' . $relativeUrl;
    }

    function getImageSizeAndWeight($url) {
        $size = @getimagesize($url);
        if ($size) {
            $dimensions = $size[0] . 'x' . $size[1];
            $isLandscape = $size[0] > $size[1];
        } else {
            $dimensions = 'Desconocido';
            $isLandscape = false;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $weight = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($ch);
        $weight = $weight !== -1 ? round($weight / 1024, 2) . ' KB' : 'Desconocido';

        return ['dimensions' => $dimensions, 'weight' => $weight, 'isLandscape' => $isLandscape];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url = filter_var($_POST["url"], FILTER_VALIDATE_URL);

        if ($url === false) {
            echo "<p>URL no válida.</p>";
        } else {
            if (strpos($url, 'https://') === false) {
                echo "<p>La URL no usa HTTPS. La seguridad es importante para el posicionamiento SEO.</p>";
            }

            $domain = getDomainFromUrl($url);
            echo "<p>Dominio: " . htmlspecialchars($domain) . "</p>";

            $html = @file_get_contents($url);
            if ($html === false) {
                echo "<p>No se pudo obtener el contenido de la página.</p>";
            } else {
                $dom = new DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

                // Obtener las imágenes
                $images = $dom->getElementsByTagName("img");

                // Mostrar la galería de imágenes con alt, title, dimensiones y peso
                echo "<div class='info-section'>";
                echo "<h2>Galería de Imágenes:</h2>";
                echo "<div class='scraper-gallery'>";

                foreach ($images as $image) {
                    $src = $image->getAttribute('src');
                    $src = makeAbsoluteUrl($src, $url);
                    $alt = $image->getAttribute('alt');
                    $title = $image->getAttribute('title');

                    $imageInfo = getImageSizeAndWeight($src);
                    $dimensions = $imageInfo['dimensions'];
                    $weight = $imageInfo['weight'];
                    $isLandscape = $imageInfo['isLandscape'];
                    $class = $isLandscape ? 'landscape' : 'portrait';

                    echo "<div class='scraper-gallery-item $class'>";
                    echo "<a href='#' class='image-link' data-src='" . htmlspecialchars($src) . "'>Ver Imagen</a>";
                    echo "<p><strong>Alt:</strong> " . htmlspecialchars($alt) . "</p>";
                    echo "<p><strong>Title:</strong> " . htmlspecialchars($title) . "</p>";
                    echo "<p><strong>Dimensiones:</strong> $dimensions</p>";
                    echo "<p><strong>Peso:</strong> $weight</p>";
                    echo "</div>";
                }
                
                echo "</div>";
                echo "</div>";
            }
        }
    }
    ?>

    <!-- El modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="" style="width: 100%;">
            <p id="modalAlt"></p>
            <p id="modalTitle"></p>
        </div>
    </div>

    <script>
        // Obtener elementos del modal
        var modal = document.getElementById("imageModal");
        var span = document.getElementsByClassName("close")[0];
        var modalImage = document.getElementById("modalImage");
        var modalAlt = document.getElementById("modalAlt");
        var modalTitle = document.getElementById("modalTitle");

        // Manejar clic en los enlaces de imagen
        document.querySelectorAll('.image-link').forEach(function(link) {
            link.onclick = function(event) {
                event.preventDefault();
                var src = this.getAttribute('data-src');
                modalImage.src = src;
                modalAlt.textContent = 'Alt: ' + this.getAttribute('alt');
                modalTitle.textContent = 'Title: ' + this.getAttribute('title');
                modal.style.display = "block";
            };
        });

        // Cerrar el modal cuando se hace clic en la X
        span.onclick = function() {
            modal.style.display = "none";
        };

        // Cerrar el modal cuando se hace clic fuera del contenido del modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>

