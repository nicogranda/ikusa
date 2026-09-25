<?php

if(empty($results)){
    echo "<p>No hay resultados SERP.</p>";
    return;
}

$stopwords = [
"de","la","que","el","en","y","a","los","del","se","las","por",
"un","para","con","no","una","su","al","lo","como","más","pero",
"sus","le","ya","o","este","sí","porque","esta","entre","cuando"
];

function limpiarTexto($html){

    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    foreach($xpath->query('//script|//style|//noscript') as $node){
        $node->parentNode->removeChild($node);
    }

    $text = $dom->textContent;

    $text = mb_strtolower($text,'UTF-8');

    $text = preg_replace('/[^a-záéíóúñü\s]/u',' ',$text);

    $text = preg_replace('/\s+/',' ',$text);

    return trim($text);
}

function contarPalabras($texto,$stopwords){

    $words = explode(" ",$texto);

    $freq = [];

    foreach($words as $w){

        if(strlen($w) < 3) continue;

        if(in_array($w,$stopwords)) continue;

        if(!isset($freq[$w])) $freq[$w]=0;

        $freq[$w]++;
    }

    arsort($freq);

    return array_slice($freq,0,30,true);
}

/* obtener 3 competidores válidos */

$competitors = [];

foreach($results as $r){

    if(count($competitors) >= 3) break;

    $url = $r['link'];

    $html = @file_get_contents($url);

    if(!$html) continue;

    $texto = limpiarTexto($html);

    if(strlen($texto) < 500) continue;

    $keywords = contarPalabras($texto,$stopwords);

    $competitors[] = [
        "url"=>$url,
        "keywords"=>$keywords
    ];
}

if(count($competitors) < 3){
    echo "<p>No se pudieron analizar 3 competidores.</p>";
    return;
}

/* combinar keywords */

$tabla_keywords = [];

foreach($competitors as $i => $comp){

    foreach($comp['keywords'] as $word=>$freq){

        if(!isset($tabla_keywords[$word])){

            $tabla_keywords[$word]=[
                "c1"=>0,
                "c2"=>0,
                "c3"=>0,
                "total"=>0
            ];
        }

        $col="c".($i+1);

        $tabla_keywords[$word][$col]=$freq;

        $tabla_keywords[$word]["total"] += $freq;
    }
}

/* ordenar */

uasort($tabla_keywords,function($a,$b){
    return $b["total"] <=> $a["total"];
});

?>

<style>

.seo_box{
margin-top:30px;
}

.seo_urls{
margin-bottom:15px;
font-size:14px;
}

.seo_urls div{
margin-bottom:4px;
}

.seo_table{
width:100%;
border-collapse:collapse;
font-size:14px;
}

.seo_table th{
background:#111827;
color:white;
padding:10px;
text-align:left;
}

.seo_table td{
padding:8px;
border-bottom:1px solid #eee;
}

.seo_table tr:nth-child(even){
background:#f9fafb;
}

.seo_table tr:hover{
background:#eef2ff;
}

</style>

<div class="seo_box">

<h2>Comparativa SEO de Competidores</h2>

<div class="seo_urls">

<div><b>Competidor 1:</b> <?php echo $competitors[0]['url']; ?></div>
<div><b>Competidor 2:</b> <?php echo $competitors[1]['url']; ?></div>
<div><b>Competidor 3:</b> <?php echo $competitors[2]['url']; ?></div>

</div>

<table class="seo_table">

<tr>
<th>Keyword</th>
<th>Competidor 1</th>
<th>Competidor 2</th>
<th>Competidor 3</th>
<th>Total</th>
</tr>

<?php

foreach($tabla_keywords as $keyword=>$row){

echo "<tr>";

echo "<td>".$keyword."</td>";

echo "<td>".$row['c1']."</td>";

echo "<td>".$row['c2']."</td>";

echo "<td>".$row['c3']."</td>";

echo "<td>".$row['total']."</td>";

echo "</tr>";

}

?>

</table>

</div>