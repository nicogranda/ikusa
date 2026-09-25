<style>
.rrss-footer a,
.rrss-footer i {
    color: white !important;
}
.rrss-footer i {
    font-size: 20px;
    padding: 5px;
}
.rrss-footer {
    display: flex;
    gap: 16px;
    align-items: center;
}
.rrss-footer a {
    font-size: 1.4rem;
    transition: opacity 0.2s ease;
    text-decoration: none;
}
.rrss-footer a:hover {
    opacity: 0.7;
}
</style>

<?php
// Dirección dinámica según idioma de la URL ($lang ya viene definido en index.php)
// EN -> entidad legal Ikusa LLC (Atlanta, GA)
// ES/EU -> operación local (Irún, Gipuzkoa)

$footerLang = $lang ?? 'es';

if ($footerLang === 'en') {
    $footerContact = [
        'address' => '8735 Dunwoody Place, Ste R',
        'city'    => 'Atlanta',
        'state'   => 'GA',
        'zip'     => '30350',
        'country' => 'United States',
        'phone'   => $config['contact']['phone'], // mismo teléfono; cambia aquí si tienes uno US dedicado
    ];
} else {
    $footerContact = [
        'address' => $config['contact']['address'],
        'city'    => $config['contact']['city'],
        'state'   => $config['contact']['state'],
        'zip'     => $config['contact']['zip'],
        'country' => $config['contact']['country'],
        'phone'   => $config['contact']['phone'],
    ];
}

function formatPhoneDisplay($phone) {
    // Limpia espacios/guiones por si el .env trae algo raro
    $digits = preg_replace('/\D/', '', $phone);

    // Detecta número US (código de país de 1 dígito: 1 + 10 dígitos = 11 total)
    if (strlen($digits) === 11 && $digits[0] === '1') {
        return '+1 (' . substr($digits, 1, 3) . ') ' . substr($digits, 4, 3) . '-' . substr($digits, 7, 4);
    }

    // Fallback: asume prefijo de país de 2 dígitos (34 = España), agrupa el resto en bloques de 3
    $countryCode = substr($digits, 0, 2);
    $rest = substr($digits, 2);
    $grouped = trim(chunk_split($rest, 3, ' '));

    return '+' . $countryCode . ' ' . $grouped;
}
?>

<footer>   
<section class='info'>
<article class="information"> 
<span class="info-title">Contáctanos<br></span>
<span class="info-address">
<?php echo $footerContact['address']; ?><br>
<?php echo $footerContact['city'] . ', ' . $footerContact['state'] . ', ' . $footerContact['zip']; ?><br>
<?php echo $footerContact['country']; ?><br><br>

<a href="tel:+<?php echo preg_replace('/\D/', '', $footerContact['phone']); ?>" style="color:white; text-decoration: none;">
<?php echo formatPhoneDisplay($footerContact['phone']); ?>
</a><br><br>
</span>      
</article>

<article class="information">

            <span class="info-title">Legal</span>
<ul  class='list-items'>
                <li><a href='/es/legal/aviso-legal'>Aviso Legal</a></li>
                <li><a href='/es/legal/politica-de-cookies'>Política de Cookies</a></li>
                <li><a href="#" data-cookie-settings>Cookies</a></li>
                <li><a href='/es/legal/politica-de-proteccion-de-datos'>Protección de Datos</a></li> 
                
                <br>
                <li><a href='/es/legal/propuesta-de-branding'>Propuesta de Branding</a></li>
                <li><a href='/es/legal/condiciones-para-sitio-web'>Desarrollo de Sitio Web</a></li>
              
                
                
</ul>
</article>

        <article class="information">
            <span class="info-title">Servicios</span>
            <ul class='list-items'>
            
                <li><a href="<?php echo '/es/diseno-grafico';?>"><h3 class='info-service'>Diseño Gráfico</h3></a></li>
                <li><a href="<?php echo '/es/desarrollo-web';?>"><h3 class='info-service'>Desarrollo-web</h3></a></li>
                  <li><a href="<?php echo '/es/agencia-de-marketing';?>"><h3 class='info-service'>Agencia de Marketing</h3></a></li>
                <li><a href="<?php echo '/es/marketing-digital';?>"><h3 class='info-service'>Marketing Digital</h3></a></li>
                <li><a href="<?php echo '/es/agencia-marketing-industrial';?>"><h3 class='info-service'>Marketing Industrial</h3></a></li>
                <br>
              

                
                <li><a href="<?php echo '/es/marketing-digital-gipuzkoa';?>"><h3 class='info-service'>Marketing Digital en Gipuzkoa</h3></a></li>
                
                <li><a href="<?php echo '/es/diseno-web-donostia';?>"><h3 class='info-service'>Diseño Web en Donostia</h3></a></li>
                <li><a href="<?php echo '/es/seo-donostia';?>"><h3 class='info-service'>Seo en Donostia</h3></a></li>
                
                <li><a href="<?php echo '/es/marketing-digital-irun';?>"><h3 class='info-service'>Marketing Digital en Irún</h3></a></li>                
                <li><a href="<?php echo '/es/seo-irun';?>"><h3 class='info-service'>Seo en Irún</h3></a></li>

                <li>------</li>
                <li><a href="<?php echo '/en/seo-company';?>"><h3 class='info-service'>SEO company</h3></a></li>

            </ul>  
</article>



<div class="information">
            <span class="info-title">About</span>
           
            <p class='business-type'>Creative Studio</p>

            <section class="rrss-footer">
               
                <a href="https://facebook.com/<?= $config['social']['facebook'] ?>" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://instagram.com/<?= $config['social']['instagram'] ?>" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://youtube.com/<?= $config['social']['youtube'] ?>" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://tiktok.com/@<?= $config['social']['tiktok'] ?>" target="_blank">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://linkedin.com/company/<?= $config['social']['linkedin'] ?>" target="_blank">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="https://x.com/<?= $config['social']['x'] ?>" target="_blank">
                    <i class="fab fa-x-twitter"></i>
                </a>
            </section>
            
</div>
</section>
<div id='copyright'>&copy;<?php echo date('Y');?></div>
<div class='brand'>Ikusa LLC&reg;</div><br>
<?php include "../app/views/components/WebDevelopment.php";?>

</footer>
<!-- enlace de gestión de cookies (footer) -->

<!-- justo antes de </body>, en el layout principal -->
<link rel="stylesheet" href="/assets/css/cookie-consent.css">
<script src="/assets/js/cookie-consent.js"></script>
<script>
  CookieConsent.init({
    lang: 'es',
    policyUrl: '/es/legal/politica-de-cookies',
    onConsentChange: function (consent) {
      if (consent.analytics) {
        // aquí cargarías/activarías GA4 u otro script de analítica
      }
      if (consent.marketing) {
        // aquí cargarías/activarías Meta Pixel, Google Ads, etc.
      }
    }
  });
</script>

<script>
    // Header (por ejemplo)
const header = document.querySelector('header');
console.log('Header height:', header.getBoundingClientRect().height);

// Footer
const footer = document.querySelector('footer');
console.log('Footer height:', footer.getBoundingClientRect().height);

</script>
</body>
</html>