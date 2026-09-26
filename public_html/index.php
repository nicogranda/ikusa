<?php
// index.php
// La URL pública de assets depende del document root, no del dominio.
$publicDir = realpath(__DIR__);
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
$assetPrefix = '';

if ($publicDir && $documentRoot && str_starts_with($publicDir, $documentRoot . DIRECTORY_SEPARATOR)) {
    $assetPrefix = str_replace(DIRECTORY_SEPARATOR, '/', substr($publicDir, strlen($documentRoot)));
} elseif ($publicDir !== $documentRoot) {
    $scriptDirectory = dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $assetPrefix = $scriptDirectory === '/' || $scriptDirectory === '.' ? '' : rtrim($scriptDirectory, '/');
}

$routePrefix = preg_replace('~/public_html$~', '', $assetPrefix);

function route_url(string $path): string
{
    global $routePrefix;
    return $routePrefix . '/' . ltrim($path, '/');
}

function asset_url(string $path): string
{
    global $assetPrefix;
    return $assetPrefix . '/assets/' . ltrim(preg_replace('~^/?assets/~', '', $path), '/');
}

// Compatibilidad con las vistas antiguas que aún imprimen /assets/.
// El filtro solo actúa sobre HTML y deja intactas las respuestas de archivos.
ob_start(static function (string $output) use ($assetPrefix, $routePrefix): string {
    if ($assetPrefix === '') {
        return $output;
    }

    foreach (headers_list() as $header) {
        if (stripos($header, 'Content-Type:') === 0
            && stripos($header, 'text/html') === false
            && stripos($header, 'application/xhtml+xml') === false) {
            return $output;
        }
    }

    $output = preg_replace('~(?<![A-Za-z0-9._-])/assets/~', $assetPrefix . '/assets/', $output);
    $output = str_replace('https://ikusa.net/assets/', $assetPrefix . '/assets/', $output);
    if ($routePrefix !== '') {
        $output = preg_replace_callback(
            '~(?<![A-Za-z0-9._-])/(es|en|eu)(?=/|\\b)~',
            static fn(array $match): string => $routePrefix . '/' . $match[1],
            $output
        );
    }
    return $output;
});

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once __DIR__ . '/../app/src/Shared/Model.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
require_once '../app/config/env.php'; 

// require '../app/config/settings.php';
require '../app/config/assets.php';
require '../app/config/connection.php';

/*
|--------------------------------------------------------------------------
| DESCARGA PÚBLICA DE FACTURA
|--------------------------------------------------------------------------
*/

if (
    isset($_GET['invoice'], $_GET['client']) &&
    ctype_digit((string) $_GET['invoice']) &&
    $_GET['client'] !== ''
) {

    require_once __DIR__ . '/../app/views/admin/sales/invoices/rocket_invoice_view.php';
    exit;
}



// Determina la página a cargar
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$blocked = ['download.aspx', 'wp-login.php'];

if (in_array($page, $blocked)) {
    http_response_code(404);
    exit;
}

use App\Controllers\RFQ\RFQsController;

$lang = $_GET['lang'] ?? 'es';
$page = $_GET['page'] ?? 'home';

$landingFile = __DIR__ . "/../app/views/landings/" . str_replace('-', '_', $page) . ".php";

$isLanding = file_exists($landingFile);

// ==================================================
// SISTEMA NUEVO (pages / page_translations)
// Se resuelve AQUÍ, temprano, antes del <head>,
// para que $seoData use estos metadatos si la página existe.
// ==================================================
require_once '../app/src/Domains/Pages/Page.php';
require_once '../app/src/Domains/Pages/PageTranslation.php';
require_once '../app/src/Domains/Pages/PageController.php';

$pageController = new \App\Domains\Pages\PageController($mysqli);
$newSystemTranslation = $pageController->resolve($lang, $page);

// Recupera metadatos de la tabla seo; las traducciones nuevas tienen prioridad.
require __DIR__ . '/../app/config/seo.php';

// URL canónica para las etiquetas del head, sin consultar el SEO antiguo.
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$currentUrl = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/');

$seoData = array_merge([
    'title' => '',
    'description' => '',
    'keywords' => '',
    'og_title' => '',
    'og_description' => '',
    'og_image' => '',
    'twitter_title' => '',
    'twitter_description' => '',
    'twitter_image' => ''
], $seoData ?? []);

// Si la página existe en el sistema nuevo, sus metadatos ganan sobre seo.php
if ($newSystemTranslation) {
    $seoData = array_merge($seoData, [
        'title'               => $newSystemTranslation['title'],
        'description'         => $newSystemTranslation['meta_description'],
        'keywords'            => $newSystemTranslation['keywords'] ?? '',
        'og_title'            => $newSystemTranslation['og_title'] ?? '',
        'og_description'      => $newSystemTranslation['og_description'] ?? '',
        'og_image'            => $newSystemTranslation['og_image'] ?? '',
        'twitter_title'       => $newSystemTranslation['twitter_title'] ?? '',
        'twitter_description' => $newSystemTranslation['twitter_description'] ?? '',
        'twitter_image'       => $newSystemTranslation['twitter_image'] ?? '',
    ]);
}

if($page == 'branding-proposal' OR $page == "admin" OR $page == "chat") { }
else {
    echo '<!DOCTYPE html><html lang="' . htmlspecialchars($lang) . '">';
    include '../app/views/partials/schema.php';
    include '../app/views/partials/head.php';
    include '../app/views/partials/header.php';
}

error_log("PAGE VALUE: " . $page);


switch ($page) {

    case 'home':
        if ($newSystemTranslation
            && (trim((string) ($newSystemTranslation['content'] ?? '')) !== ''
                || trim((string) ($newSystemTranslation['components'] ?? '')) !== '')) {
            $pageController->render($lang, $page);
        } else {
            include __DIR__ . '/../app/views/home.php';
        }
        break;
    
  
        
    case 'services':
        $controller = new \App\Domains\Services\ServicesController();
        $action     = $_GET['action'] ?? 'index';
    
        if ($action === 'index') {
            $controller->index();
        } else {
            $controller->show($action);
        }
    break;
    
    case 'seo-company':
        include '../app/views/services/seo-company.php';
        break; 

    case 'about':
        include '../app/views/about.php';
        break;
        
    case 'contact':
        require_once '../app/controllers/RFQ/RFQsController.php';
        
        $controller = new \App\Controllers\RFQ\RFQsController();
            // $controller = new RFQsController();
        
            $action = $_GET['action'] ?? 'index';
        
            switch ($action) {
    
                case 'create':
                    $controller->create();
                    break;
    
                case 'success':
                    $controller->success();
                    break;
    
                case 'suppliers':
                    $controller->suppliers();
                    break;
    
                case 'send':
                    $controller->send();
                    break;
    
                case 'show':
                    $id = $_GET['id'] ?? null;
                    $controller->show($id);
                    break;
    
                case 'print':
                    $id = $_GET['id'] ?? null;
                    $controller->print($id);
                    break;
    
                case 'mail':
                    $id = $_GET['id'] ?? null;
                    $controller->mail($id);
                    break;
            }
        
        break;
        
    case 'logos':
        include '../app/views/portfolio/logotypes.php';
        break;   

    case 'cards':
        include '../app/views/portfolio/cards.php';
        break;  
        
    case 'brochures':
        include '../app/views/portfolio/brochure.php';
        break;      
        
    case 'merchandising':
        include '../app/views/portfolio/merchandising.php';
        break; 
        
    case 'webs':
        include '../app/views/portfolio/webs.php';
        break;  

    case 'development':
        include '../app/views/portfolio/development.php';
        break;      
        

    case 'website-terms':
        include '../app/views/legals/website-terms.php';
        break;   
        
    case 'branding-proposal':
        include '../app/views/legals/branding-proposal.php';
        break;  
        
    case 'seo-positioning':
        include '../app/views/legals/seo-positioning.php';
        break;  
        
        
    case 'lead':

        require_once '../app/src/Domains/Leads/SEOLeadController.php';
    
        $controller = new \App\Domains\Leads\SEOLeadController();
    
        $action = $_GET['action'] ?? 'create';
    
        switch ($action) {
    
            case 'create':
                $controller->create();
                break;
    
            case 'store':
                $controller->store();
                break;
    
            case 'success':
                $controller->success();
                break;
    
            default:
                $controller->create();
                break;
        }
    
        break;          
        
    case 'admin':
        require_once "../app/controllers/admin/AuthsController.php";
        $controller = new AuthsController();
        $action = $_GET['action'] ?? 'auth';
        if ($action === 'auth') {
            $controller->auth();
        }
    break;
    
    case 'E-mail':
        // require_once "../app/views/auth/login.php";
        require_once "../app/controllers/admin/EmailsController.php";
        $controller = new MailController();
     
        if ($_GET['action'] === 'create') {
          $controller->create();
        }
        break;    
        
    case 'scraper':
        include '../app/views/scraper/index.php';
        break;  
        
    case 'sitemap':
        include '../app/views/sitemap/index.php';
        break;      
    
    // Blog  
    case 'seo':
        include '../app/views/SEO/index.php';
        break;  
    
 
    case 'branding-proposal':
        include '../app/views/blogs/branding.php';
        break;
        
    case 'marketing-donostia':
        include '../app/views/blogs/marketing-donostia.php';
        break;     

    case 'email-corporativo-en-GMail':
        include '../app/views/blogs/configurar-email-corporativo-en-gmail-androide.php';
        break;     
        
    case 'messaging':
        ob_end_clean();
        require_once '../app/Domains/Messaging/MessagingRepository.php';
        require_once '../app/Domains/Messaging/MessagingController.php';
    
        $controller = new \App\Domains\Messaging\MessagingController($mysqli);
    
        $action = $_GET['action'] ?? '';
    
        if ($action === 'lookup') {
            $controller->lookup();
        }
        exit;
        

    case 'webhook':
        ob_end_clean();
        require_once '../app/src/Domains/SocialInbox/WebhookController.php';

        $controller = new \App\Domains\SocialInbox\WebhookController($mysqli);

        $action = $_GET['action'] ?? '';

        if ($action === 'instagram') {
            $controller->instagram();
        } elseif ($action === 'messenger') {
            $controller->messenger();
        }
        exit;    
        
    case 'chat':
        require_once "../app/controllers/ChatController.php";
        $chatController = new ChatController();
    
        if (isset($_GET['action']) && $_GET['action'] === 'send') {
            $chatController->send();
        } else {
            include '../app/views/chat.php';
        }
        break;
    
     
        default:

            if ($newSystemTranslation) {
                $pageController->render($lang, $page);
            } elseif ($isLanding) {
                include $landingFile;
            } else {
                http_response_code(404);
                include __DIR__ . '/../app/views/404.php';
            }

            break;
    
    }

      if( $page == "chat") { }
      
    else {
     
        // Cargar categorías para el footer
        require_once __DIR__ . '/../app/libraries/admin/Model.php';
        require_once __DIR__ . '/../app/models/admin/Category.php';
        
        $categoryModel = new \App\Models\Admin\Category();
        $categories = $categoryModel->getAll();
        
        include '../app/views/partials/footer.php';
    
    }

ob_end_flush();
?>
