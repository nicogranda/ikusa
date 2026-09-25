<head>

<?php
$seoData = $seoData ?? [];

$title = $seoData['title'] ?? '';
$description = $seoData['description'] ?? '';
$keywords = $seoData['keywords'] ?? '';

$og_title = $seoData['og_title'] ?? '';
$og_description = $seoData['og_description'] ?? '';
$og_image = $seoData['og_image'] ?? '';

$twitter_title = $seoData['twitter_title'] ?? '';
$twitter_description = $seoData['twitter_description'] ?? '';
$twitter_image = $seoData['twitter_image'] ?? '';

$schema = $schema ?? '{}';
$currentUrl = $currentUrl ?? '';
$site['url'] = $site['url'] ?? '';
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>

<meta name="description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="keywords" content="<?= htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8'); ?>">

<link rel="canonical" href="<?= htmlspecialchars($currentUrl, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Ikusa">
<meta property="og:url" content="<?= htmlspecialchars($currentUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:title" content="<?= htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?= htmlspecialchars($og_description, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image" content="<?= htmlspecialchars($site['url'] . '/' . $og_image, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($twitter_title, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($twitter_description, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($site['url'] . '/' . $twitter_image, ENT_QUOTES, 'UTF-8'); ?>">

<!-- Cookie consent (debe cargar antes que cualquier script gated de abajo) -->
<link rel="stylesheet" href="/assets/css/cookie-consent.css">
<script src="/assets/js/cookie-consent.js"></script>

<link rel="stylesheet" href="/assets/css/styles.css">

<?php if (!empty($schema)): ?>
<!-- Schema JSON-LD -->
<script type="application/ld+json">
<?= $schema ?>
</script>
<?php endif; ?>



<!-- Google tag (gtag.js) 〞 bloqueado hasta consentimiento de analytics -->
<script type="text/plain" data-cookie-category="analytics"
        data-cookie-src="https://www.googletagmanager.com/gtag/js?id=G-KM1RP8K6TE" async></script>
<script type="text/plain" data-cookie-category="analytics">
window.dataLayer = window.dataLayer || [];

function gtag(){
    dataLayer.push(arguments);
}

gtag('js', new Date());

gtag('config', 'G-KM1RP8K6TE');
</script>

<!-- Ahrefs Analytics 〞 bloqueado hasta consentimiento de analytics -->
<script type="text/plain" data-cookie-category="analytics">
var ahrefs_analytics_script = document.createElement('script');
ahrefs_analytics_script.async = true;
ahrefs_analytics_script.src = 'https://analytics.ahrefs.com/analytics.js';
ahrefs_analytics_script.setAttribute('data-key', 'DIcP1rZNgssMJwOSBznW1Q');
document.head.appendChild(ahrefs_analytics_script);
</script>

<meta name="ahrefs-site-verification" content="845c4ac3030976b3652a2c8b0e64b92a522f5897a0fd059bde36aa9dced18f31">

<!-- reCAPTCHA (necesario para formularios; no requiere consentimiento de marketing/analytics) -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


<?php
// --- Detecci車n de p芍gina para tracking ---
$isGraciasPage = (
    isset($_GET['page']) &&
    $_GET['page'] === 'contact' &&
    isset($_GET['action']) &&
    $_GET['action'] === 'success'
);

$rfqConfirmado = $isGraciasPage && !empty($_SESSION['rfq_sent']);

$metaPixelId = $_ENV['META_PIXEL_ID'] ?? '';

$landingSlugs = ['diseno-grafico', 'desarrollo-web', 'marketing-digital', 'seo-company', 'seo-donostia', 'marketing-digital-irun', 'agencia-de-marketing'];
$isLandingPage = false;
foreach ($landingSlugs as $slug) {
    if (strpos($currentUrl, $slug) !== false) {
        $isLandingPage = true;
        break;
    }
}
?>

<?php if (($isLandingPage || $rfqConfirmado) && !empty($metaPixelId)): ?>
<!-- Meta Pixel Code 〞 bloqueado hasta consentimiento de marketing -->
<script type="text/plain" data-cookie-category="marketing">
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?= htmlspecialchars($metaPixelId, ENT_QUOTES, 'UTF-8'); ?>');
<?php if ($isLandingPage): ?>
fbq('track', 'PageView');
<?php endif; ?>
<?php if ($rfqConfirmado): ?>
fbq('track', 'Lead');
<?php endif; ?>
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=<?= htmlspecialchars($metaPixelId, ENT_QUOTES, 'UTF-8'); ?>&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<?php endif; ?>

<?php if ($rfqConfirmado): ?>
<script type="text/plain" data-cookie-category="analytics">
console.log("Lead enviado");

gtag('event', 'generate_lead', {
    'event_category': 'RFQ',
    'event_label': 'formulario_completo_con_email_confirmado'
});
</script>
<?php unset($_SESSION['rfq_sent']); ?>
<?php endif; ?>

</head>