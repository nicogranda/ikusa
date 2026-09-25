<?php
// $config ya viene cargado desde index.php vía el bootstrap
$api_key = $config['apis']['serp'] ?? null;

if (empty($api_key)) {
    echo "<p style='color:red;'>API key de SerpAPI no configurada.</p>";
    return;
}

$keyword = trim($_POST['keywords'] ?? '');

if (empty($keyword)) {
    echo "<p style='color:red;'>Introduce una keyword para ver la competencia.</p>";
    return;
}

$url = "https://serpapi.com/search.json?q=" . urlencode($keyword) . "&api_key=" . urlencode($api_key);
$response = @file_get_contents($url);

if (!$response) {
    echo "<p style='color:red;'>Error al conectar con SerpAPI.</p>";
    return;
}

$data = json_decode($response, true);

if (empty($data['organic_results'])) {
    echo "<p>No se encontraron resultados para <strong>" . htmlspecialchars($keyword) . "</strong>.</p>";
    return;
}

$top3 = array_slice($data['organic_results'], 0, 3);

echo "<ul style='list-style:none;padding:0;'>";
foreach ($top3 as $result) {
    echo "<li style='margin-bottom:20px;border-bottom:1px solid #ddd;padding-bottom:15px;'>";
    if (isset($result['thumbnail'])) {
        echo "<img src='" . htmlspecialchars($result['thumbnail']) . "' style='width:120px;float:left;margin-right:15px;'>";
    }
    echo "<a href='" . htmlspecialchars($result['link']) . "' target='_blank'>
            <h3>" . htmlspecialchars($result['title']) . "</h3>
          </a>";
    echo "<p>" . htmlspecialchars($result['snippet'] ?? '') . "</p>";
    echo "<div style='clear:both'></div>";
    echo "</li>";
}
echo "</ul>";