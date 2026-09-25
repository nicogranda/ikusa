<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2) . '/public_html');
$dotenv->safeLoad();


if (!function_exists('env')) {
    function env(string $key)
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return null;
    }
}


$config = [];


// ==========================================
// WEBSITE
// ==========================================

$config['site_name']   = env('APP_NAME');
$config['url']         = env('APP_URL');
$config['lang']        = env('APP_LANG');
$config['description'] = env('APP_DESCRIPTION');


// ==========================================
// LEGAL COMPANY
// ==========================================

$config['company'] = [];

$config['company']['name'] = env('LEGAL_COMPANY_NAME');

$config['company']['country'] = env('LEGAL_COUNTRY');

$config['company']['address'] = env('LEGAL_ADDRESS');

$config['company']['city'] = env('LEGAL_CITY');

$config['company']['state'] = env('LEGAL_STATE');

$config['company']['zip'] = env('LEGAL_ZIP');

$config['company']['tax_id'] = env('LEGAL_TAX_ID');

$config['company']['registration'] = env('LEGAL_REGISTRATION');


// ==========================================
// BRANDING
// ==========================================

$config['branding'] = [];

$config['branding']['logo'] = env('APP_LOGO');


// ==========================================
// SOCIAL MEDIA
// ==========================================

$config['social'] = [];

$config['social']['instagram'] = env('SOCIAL_INSTAGRAM');

$config['social']['linkedin'] = env('SOCIAL_LINKEDIN');

$config['social']['facebook'] = env('SOCIAL_FACEBOOK');

$config['social']['youtube'] = env('SOCIAL_YOUTUBE');

$config['social']['tiktok'] = env('SOCIAL_TIKTOK');

$config['social']['x'] = env('SOCIAL_X');


// ==========================================
// CONTACT SPAIN
// ==========================================

$config['contact'] = [];

$config['contact']['email'] = env('CONTACT_EMAIL');

$config['contact']['address'] = env('APP_ADDRESS');

$config['contact']['city'] = env('APP_CITY');

$config['contact']['state'] = env('APP_STATE');

$config['contact']['zip'] = env('APP_ZIP');

$config['contact']['country'] = env('APP_COUNTRY');

$config['contact']['phone'] = env('APP_PHONE');


// ==========================================
// SERVICES
// ==========================================

$config['services'] = [];

$config['services']['1'] = env('SERVICE_1');
$config['services']['2'] = env('SERVICE_2');
$config['services']['3'] = env('SERVICE_3');
$config['services']['4'] = env('SERVICE_4');
$config['services']['5'] = env('SERVICE_5');
$config['services']['6'] = env('SERVICE_6');

// ==========================================
// APIS
// ==========================================

$config['apis'] = [];

$config['apis']['openai'] = env('API_KEY_OPEN_AI');