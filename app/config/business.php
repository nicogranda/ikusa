<?php
// app/config/business.php
// Datos globales de la empresa — usados por app/views/schemas/*.schema.php
// y por app/Domains/Pages/PageController.php para resolver placeholders en `content`.
// Depende de $lang (definido antes de incluir este archivo)
// EN -> entidad legal Ikusa LLC (Atlanta, GA)
// ES/EU -> operación local (Irún, Gipuzkoa)

$orgName  = 'Ikusa';
$orgUrl   = 'https://ikusa.net';
$orgLogo  = $orgUrl . '/assets/img/ikusa-logo.svg';
$orgEmail = 'contact@ikusa.net';

if (($lang ?? 'es') === 'en') {

    // Ikusa LLC — Atlanta, GA
    $orgLegalName     = 'Ikusa LLC';
    $orgPhone         = '+14709837444';
    $orgStreetAddress = '8735 Dunwoody Place, Ste R';
    $orgLocality      = 'Atlanta';
    $orgRegion        = 'GA';
    $orgPostalCode    = '30350';
    $orgCountry       = 'US';

} else {

    // Ikusa — Irún, Gipuzkoa
    $orgLegalName     = 'Ikusa';
    $orgPhone         = '+34600142663';
    $orgStreetAddress = 'Calle General Freire, 5';
    $orgLocality      = 'Irún';
    $orgRegion        = 'Gipuzkoa';
    $orgPostalCode    = '';
    $orgCountry       = 'ES';
}

$orgRegistration = 'Georgia Secretary of State - Control Number 21243562';
$orgTaxId        = 'EIN 87-2680481';

$orgLegalAddress = '8735 Dunwoody Place, Ste R, Atlanta, Georgia 30350, United States';

$orgSameAs = [
    'https://www.instagram.com/ikusa.creativestudio',
    'https://www.linkedin.com/company/ikusacreativestudio',
];