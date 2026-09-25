<?php

if(!isset($_POST['url']) || empty($_POST['url'])){
    echo "<p>Introduce una URL.</p>";
    return;
}

$url = $_POST['url'];

$html = @file_get_contents($url);

if(!$html){
    echo "<p>No se pudo acceder a la URL.</p>";
    return;
}

$dom = new DOMDocument();
@$dom->loadHTML($html);

/* eliminar scripts y estilos */
$tags = $dom->getElementsByTagName('script');
for ($i = $tags->length - 1; $i >= 0; $i--) {
    $tags->item($i)->parentNode->removeChild($tags->item($i));
}

$tags = $dom->getElementsByTagName('style');
for ($i = $tags->length - 1; $i >= 0; $i--) {
    $tags->item($i)->parentNode->removeChild($tags->item($i));
}

/* obtener texto */
$text = $dom->textContent;

/* limpiar texto */
$text = strtolower($text);
$text = preg_replace('/[^a-záéíóúñü\s]/u',' ',$text);
$text = preg_replace('/\s+/',' ',$text);

/* stopwords español */
$stopwords = [
"de","la","que","el","en","y","a","los","del","se","las","por","un","para",
"con","no","una","su","al","lo","como","más","pero","sus","le","ya","o",
"este","sí","porque","esta","entre","cuando","muy","sin","sobre","también",
"me","hasta","hay","donde","quien","desde","todo","nos","durante","todos",
"uno","les","ni","contra","otros","ese","eso","ante","ellos","e","esto",
"mí","antes","algunos","qué","unos","yo","otro","otras","otra","él"
];

/* separar palabras */
$words = explode(" ",$text);

$filtered = [];

foreach($words as $w){

    if(strlen($w) < 4) continue;

    if(in_array($w,$stopwords)) continue;

    $filtered[] = $w;
}

/* frecuencia palabras */
$freq = array_count_values($filtered);
arsort($freq);

/* bigramas */
$bigrams = [];
$count = count($filtered);

for($i=0;$i<$count-1;$i++){

    $bigram = $filtered[$i]." ".$filtered[$i+1];

    if(!isset($bigrams[$bigram])) $bigrams[$bigram]=0;

    $bigrams[$bigram]++;
}

arsort($bigrams);

/* trigramas */

$trigrams = [];

for($i=0;$i<$count-2;$i++){

    $tri = $filtered[$i]." ".$filtered[$i+1]." ".$filtered[$i+2];

    if(!isset($trigrams[$tri])) $trigrams[$tri]=0;

    $trigrams[$tri]++;
}

arsort($trigrams);

?>

<div class="tables_keywords">

    <div class="table_block">
        <h3>Top palabras</h3>

        <table>
            <tr>
                <th>Keyword</th>
                <th>Frecuencia</th>
            </tr>

            <?php
            $i=0;
            foreach($freq as $k=>$v){

                echo "<tr>
                        <td>$k</td>
                        <td>$v</td>
                      </tr>";

                $i++;
                if($i>=20) break;
            }
            ?>

        </table>
    </div>


    <div class="table_block">
        <h3>Bigramas</h3>

        <table>
            <tr>
                <th>Keyword</th>
                <th>Frecuencia</th>
            </tr>

            <?php

            $i=0;

            foreach($bigrams as $k=>$v){

                echo "<tr>
                        <td>$k</td>
                        <td>$v</td>
                      </tr>";

                $i++;
                if($i>=20) break;
            }

            ?>

        </table>
    </div>


    <div class="table_block">
        <h3>Trigramas</h3>

        <table>
            <tr>
                <th>Keyword</th>
                <th>Frecuencia</th>
            </tr>

            <?php

            $i=0;

            foreach($trigrams as $k=>$v){

                echo "<tr>
                        <td>$k</td>
                        <td>$v</td>
                      </tr>";

                $i++;
                if($i>=20) break;
            }

            ?>

        </table>
    </div>

</div>

<style>
    .tables_keywords{
    display:flex;
    gap:20px;
    align-items:flex-start;
    flex-wrap:wrap;
}

.tables_keywords .table_block{
    flex:1;
    min-width:280px;
}

.tables_keywords table{
    width:100%;
    border-collapse:collapse;
}

.tables_keywords th,
.tables_keywords td{
    border:1px solid #ccc;
    padding:6px 8px;
    font-size:14px;
}

.tables_keywords th{
    background:#0f172a;
    color:white;
}
</style>