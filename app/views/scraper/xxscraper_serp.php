<?php
/**
 * SEO Auditor Dashboard estilo "Projects"
 * Requiere:
 * - PHP 7.4+
 * - cURL habilitado
 *
 * IMPORTANTE:
 * Lo que muestras en la imagen NO lo da SERPAPI directamente.
 * SERPAPI sirve para rankings/SERP.
 *
 * Para sacar:
 * - Health score
 * - URLs crawled
 * - Internal URLs having errors
 *
 * Debes hacer TU crawler o usar otra API.
 *
 * Este código mezcla:
 * 1) Tus proyectos
 * 2) Crawl real básico del sitio
 * 3) Calcula score simple
 */

// ===============================
// CONFIG
// ===============================
$projects = [
    [
        "name" => "Maletachic",
        "url"  => "https://maletachic.com/"
    ],
    [
        "name" => "Ikusa",
        "url"  => "https://ikusa.net/"
    ],
    [
        "name" => "Borjasdesign",
        "url"  => "https://borjasdesign.com/"
    ],
    [
        "name" => "Petitcafe",
        "url"  => "https://petitcafe.es/"
    ]
];

// ===============================
// FUNCIONES
// ===============================

function getHttpStatus($url)
{
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY         => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    curl_exec($ch);

    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return $status ?: 0;
}

function getHtml($url)
{
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT      => "Mozilla/5.0 SEO Auditor Bot"
    ]);

    $html = curl_exec($ch);
    curl_close($ch);

    return $html;
}

function getInternalLinks($baseUrl, $limit = 100)
{
    $html = getHtml($baseUrl);

    if (!$html) return [];

    preg_match_all('/href=["\'](.*?)["\']/i', $html, $matches);

    $links = [];

    $host = parse_url($baseUrl, PHP_URL_HOST);

    foreach ($matches[1] as $link) {

        if (strpos($link, 'mailto:') === 0) continue;
        if (strpos($link, 'tel:') === 0) continue;
        if (strpos($link, '#') === 0) continue;

        if (strpos($link, 'http') !== 0) {
            $link = rtrim($baseUrl, '/') . '/' . ltrim($link, '/');
        }

        $linkHost = parse_url($link, PHP_URL_HOST);

        if ($linkHost === $host) {
            $links[] = strtok($link, '#');
        }
    }

    $links = array_unique($links);

    return array_slice($links, 0, $limit);
}

function analyzeProject($url)
{
    $links = getInternalLinks($url, 200);

    $errors = 0;

    foreach ($links as $link) {
        $status = getHttpStatus($link);

        if ($status >= 400 || $status == 0) {
            $errors++;
        }
    }

    $total = count($links);

    $health = $total > 0
        ? max(1, round((($total - $errors) / $total) * 100))
        : 1;

    return [
        "urls_crawled" => $total,
        "errors"       => $errors,
        "health"       => $health
    ];
}

// ===============================
// HTML
// ===============================
?>

<style>
body{
    font-family:Arial;
    background:#f6f7fb;
    margin:40px;
}
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
}
th,td{
    padding:14px;
    border-bottom:1px solid #eee;
    text-align:left;
    font-size:14px;
}
th{
    background:#111827;
    color:#fff;
}
.status{
    color:green;
    font-weight:bold;
}
.btn{
    background:#2563eb;
    color:#fff;
    padding:8px 14px;
    border-radius:6px;
    text-decoration:none;
}
.score-good{color:green;font-weight:bold;}
.score-mid{color:#d97706;font-weight:bold;}
.score-bad{color:red;font-weight:bold;}
small{color:#666;}
</style>

<h2>SEO Projects Dashboard</h2>

<table>
<tr>
    <th>Project</th>
    <th>Last Crawl</th>
    <th>Status</th>
    <th>Health Score</th>
    <th>URLs Crawled</th>
    <th>Internal URLs Errors</th>
    <th>Scheduled</th>
    <th>Plan</th>
</tr>

<?php foreach($projects as $p): ?>

<?php
$data = analyzeProject($p['url']);

$scoreClass = "score-good";

if($data['health'] < 80) $scoreClass = "score-mid";
if($data['health'] < 50) $scoreClass = "score-bad";
?>

<tr>
    <td>
        <strong><?= $p['name']; ?></strong><br>
        <small><?= $p['url']; ?></small>
    </td>

    <td>
        <?= date("d M"); ?><br>
        <small><?= date("h:i A"); ?></small>
    </td>

    <td class="status">Completed</td>

    <td class="<?= $scoreClass; ?>">
        <?= $data['health']; ?>%
    </td>

    <td><?= $data['urls_crawled']; ?></td>

    <td><?= $data['errors']; ?></td>

    <td>Today 11 PM</td>

    <td>
        <a href="#" class="btn">Start</a><br>
        <small>Basic</small>
    </td>
</tr>

<?php endforeach; ?>

</table>