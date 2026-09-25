<?php
declare(strict_types=1);

$api_key = ($_ENV['SERP_API_KEY'] ?? '');
if(!$api_key){
    die("<p>Error: API Key no encontrada en .env</p>");
}

// 2️⃣ Keyword principal
if(empty($_POST['keywords'])){
    die("<p>Introduce una keyword.</p>");
}
$keyword = trim($_POST['keywords']);
$country = $_POST['country'] ?? 'es';
$lang = $_POST['lang'] ?? 'es';

// 3️⃣ Función para llamar SerpApi
function getTopUrls(string $keyword, string $api_key, int $top = 3, string $country = 'es', string $lang = 'es') {
    $params = [
        "q" => $keyword,
        "api_key" => $api_key,
        "num" => $top,
        "hl" => $lang,
        "gl" => $country
    ];
    $url = "https://serpapi.com/search.json?" . http_build_query($params);

    $response = file_get_contents($url);
    if(!$response) return [];

    $data = json_decode($response, true);
    if(empty($data['organic_results'])) return [];

    $urls = [];
    foreach(array_slice($data['organic_results'], 0, $top) as $r){
        if(isset($r['link'])) $urls[] = $r['link'];
    }
    return $urls;
}

// 4️⃣ Función para extraer texto visible de una página
function extractVisibleText(string $html): string {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Eliminar scripts y estilos
    foreach(['script','style','noscript'] as $tag){
        $tags = $dom->getElementsByTagName($tag);
        for ($i = $tags->length - 1; $i >= 0; $i--) {
            $tags->item($i)->parentNode->removeChild($tags->item($i));
        }
    }

    $text = $dom->textContent;
    $text = strtolower($text);
    $text = preg_replace('/[^a-záéíóúñü\s]/u',' ',$text);
    $text = preg_replace('/\s+/',' ',$text);
    return $text;
}

// 5️⃣ Stopwords en español
$stopwords = [
"de","la","que","el","en","y","a","los","del","se","las","por","un","para",
"con","no","una","su","al","lo","como","más","pero","sus","le","ya","o",
"este","sí","porque","esta","entre","cuando","muy","sin","sobre","también",
"me","hasta","hay","donde","quien","desde","todo","nos","durante","todos",
"uno","les","ni","contra","otros","ese","eso","ante","ellos","e","esto",
"mí","antes","algunos","qué","unos","yo","otro","otras","otra","él"
];

// 6️⃣ Obtener top 3 URLs
$topUrls = getTopUrls($keyword, $api_key, 3, $country, $lang);
if(empty($topUrls)){
    die("<p>No se encontraron resultados de SERP para '$keyword'.</p>");
}

// 7️⃣ Procesar cada URL
$competitorKeywords = [];

foreach($topUrls as $url){
    $html = @file_get_contents($url);
    if(!$html) continue;

    $text = extractVisibleText($html);
    $words = explode(" ", $text);

    // Filtrar palabras
    $filtered = [];
    foreach($words as $w){
        if(strlen($w)<4) continue;
        if(in_array($w,$stopwords)) continue;
        $filtered[] = $w;
    }

    // Frecuencia
    $freq = array_count_values($filtered);
    arsort($freq);

    // Bigrams
    $bigrams = [];
    for($i=0;$i<count($filtered)-1;$i++){
        $bigram = $filtered[$i]." ".$filtered[$i+1];
        $bigrams[$bigram] = ($bigrams[$bigram] ?? 0) + 1;
    }
    arsort($bigrams);

    // Trigrams
    $trigrams = [];
    for($i=0;$i<count($filtered)-2;$i++){
        $tri = $filtered[$i]." ".$filtered[$i+1]." ".$filtered[$i+2];
        $trigrams[$tri] = ($trigrams[$tri] ?? 0) + 1;
    }
    arsort($trigrams);

    $competitorKeywords[$url] = [
        'top_words' => array_slice($freq,0,20),
        'bigrams' => array_slice($bigrams,0,20),
        'trigrams' => array_slice($trigrams,0,20)
    ];
}

// 8️⃣ Mostrar resultados
foreach($competitorKeywords as $url => $data){
    echo "<h3>Keywords de: <a href='$url' target='_blank'>$url</a></h3>";

    echo "<strong>Top palabras:</strong><br>";
    echo "<ul>";
    foreach($data['top_words'] as $k=>$v){
        echo "<li>$k ($v)</li>";
    }
    echo "</ul>";

    echo "<strong>Bigramas:</strong><br>";
    echo "<ul>";
    foreach($data['bigrams'] as $k=>$v){
        echo "<li>$k ($v)</li>";
    }
    echo "</ul>";

    echo "<strong>Trigramas:</strong><br>";
    echo "<ul>";
    foreach($data['trigrams'] as $k=>$v){
        echo "<li>$k ($v)</li>";
    }
    echo "</ul>";

    echo "<hr>";
}
?>