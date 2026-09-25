<?php

if(empty($_POST['keywords'])){
    echo "<p>Introduce una keyword.</p>";
    return;
}

$keyword = trim($_POST['keywords']);
$api_key = ($_ENV['SERP_API_KEY'] ?? '');

// Parámetros SERP
$params = [
    "q" => $keyword,
    "api_key" => $api_key,
    "num" => 10,
    "hl" => $_POST['lang'] ?? "es",
    "gl" => $_POST['country'] ?? "es"
];

// Agregar ciudad si existe
if(!empty($_POST['city'])){
    $params['location'] = $_POST['city'] . ", " . ($_POST['country'] ?? "España");
}

$url = "https://serpapi.com/search.json?" . http_build_query($params);

// cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if(!$response){
    echo "<p>Error consultando SERP: $err</p>";
    return;
}

$data = json_decode($response,true);

if(empty($data['organic_results'])){
    echo "<p>No hay resultados.</p>";
    echo "<pre>"; print_r($data); echo "</pre>"; // útil para depuración
    return;
}

// TOP 10
$results = array_slice($data['organic_results'], 0, 10);

echo "<h3>TOP 10 SERP para: <strong>$keyword</strong>";
if(!empty($_POST['city'])){
    echo " en <strong>" . htmlspecialchars($_POST['city']) . "</strong>";
}
echo "</h3>";

echo "<table class='serp_table'>";
echo "<tr>
        <th>#</th>
        <th>Título</th>
        <th>URL</th>
        <th>Snippet</th>
      </tr>";

$pos = 1;

foreach($results as $r){
    $title = $r['title'] ?? '';
    $link = $r['link'] ?? '';
    $snippet = $r['snippet'] ?? '';
    $thumbnail = $r['thumbnail'] ?? '';

    echo "<tr>";

    echo "<td>$pos</td>";

    echo "<td>";
    if($thumbnail){
        echo "<img src='$thumbnail' style='width:80px;margin-right:8px;vertical-align:middle;'>";
    }
    echo "<a href='$link' target='_blank'>$title</a></td>";

    echo "<td>$link</td>";
    echo "<td>$snippet</td>";

    echo "</tr>";

    $pos++;
}

echo "</table>";
?>

<style>
.serp_table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.serp_table th,
.serp_table td{
    border:1px solid #ccc;
    padding:10px;
    font-size:14px;
    text-align:left;
}

.serp_table th{
    background:#0f172a;
    color:white;
}

.serp_table tr:nth-child(even){
    background:#f5f5f5;
}

.serp_table a{
    color:#2563eb;
    text-decoration:none;
}

.serp_table a:hover{
    text-decoration:underline;
}
</style>