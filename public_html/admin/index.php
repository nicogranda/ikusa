<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/auth.php';
// El panel usa inclusiones relativas al directorio public_html.
chdir(__DIR__ . '/..');

// Carga variables de entorno
require dirname(__DIR__, 2) . '/app/config/env.php';

$baseUrl = $_ENV['APP_URL'] ?? '';

include dirname(__DIR__, 2) . '/app/src/Domains/Admin/Shared/views/partials/head.php';
// require __DIR__ . '/../../app/config/assets.php';
require dirname(__DIR__, 2) . '/app/config/connection.php';


// Determina la página a cargar
$route = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = $_GET['action'] ?? 'index';

include dirname(__DIR__, 2) . '/app/src/Domains/Admin/Shared/views/partials/nav.php';
    
// Carga la vista correspondiente o muestra un 404 si la página no existe
switch ($route) {
    
    case 'home':
        echo '<main class="container py-4"><h1>Panel de administración</h1></main>';
        break;
        
    case 'users':
        include '../app/views/users.php';
        break;
        
    case 'logout':
        //include 'app/views/users/logout.php';
       include dirname(__DIR__, 2) . '/app/src/Domains/Admin/Auth/views/logout.php';
        break;    
        
    case 'order':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Orders/OrdersController.php";
        $controller = new OrdersController($mysqli);
    
        if ($action === 'create') {
            $controller->create(); // Llama al método que maneja GET y POST
        }
        
        if ($action === 'index') {
            $controller->index(); // Llama al método que maneja GET y POST
        }

        if ($action === 'search') {
            $controller->search(); // Pasar el ID al método
        }
        
        if ($action === 'mail') {
          $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
           $controller->mail($id); // Ver el POST[mail] abajo 6/2/2025
        }
        
        if ($action === 'show') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->show($id); // Pasar el ID al método
        }
        
        if ($action === 'delete' && isset($_GET['id'])) {
            $controller->delete($_GET['id']); // Pasa el id de la orden
        }

        break;

    case 'categories':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Categories/CategoriesController.php";
        $controller = new CategoriesController();
    
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
    
        switch($action) {
            case 'create':
                $controller->create(); // GET y POST
                break;
            case 'upload':
                $controller->upload(); // solo para Dropzone
                break;
            case 'delete':
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                if ($id > 0) {
                    $controller->delete($id);
                } else {
                    echo "ID inválido";
                }
                break;
    
            case 'index':
            default:
                $controller->index();
                break;
            }
            break;
        
    case 'products':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Products/ProductsController.php";
        $controller = new ProductsController($mysqli);

        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        switch($action) {
            case 'create':
                $controller->create(); // GET y POST
                break;
            case 'upload':
                $controller->upload(); // solo para Dropzone
                break;
                
            case 'edit':
                if (!isset($_GET['id'])) {
                    die('ID requerido');
                }
            
                $controller->edit((int) $_GET['id']);
                break;
  
            case 'update':
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            
                if ($id <= 0) {
                    die('ID de producto inválido');
                }
            
                $controller->update($id);
                break;

    
            case 'delete':
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                if ($id > 0) {
                    $controller->delete($id);
                } else {
                    echo "ID inválido";
                }
                break;

            case 'index':
            default:
                $controller->index();
                break;
        }
        break;

    case 'clients':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Clients/ClientsController.php";
        $controller = new \App\Domains\Clients\ClientsController($mysqli);
    
        $action = $_GET['action'] ?? 'index';
    
        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'search':
                $controller->search();
                break;
            case 'create':
                $controller->create();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'update':
                $controller->update();
                break;
        }
        break;

    case 'providers':
        require_once dirname(__DIR__, 2) . '/app/src/Domains/Admin/Providers/ProvidersController.php';
        (new ProvidersController($mysqli))->index();
        break;

    case 'quotes':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Quotes/QuotesController.php";
        $controller = new QuotesController($mysqli);
        
        if ($action === 'index') {
            $controller->index(); // Llama al método que maneja GET y POST
        }
        
        if ($action === 'create') {
           $controller->create(); // Ver el POST[mail] abajo 6/2/2025
        }
      
        if ($action === 'search') {
            $controller->search(); // Llama al método que maneja GET y POST
        }
      
        if ($action === 'show') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->show($id); // Pasar el ID al método
        }
        
        if ($action === 'update') {
            $id = isset($_POST['operation_id']) ? (int) $_POST['operation_id'] : 0;
            $data = $_POST;
            $controller->update($id, $data);
        }

        if ($action === 'delete') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->delete($id); // Pasar el ID al método
        }
        
        if ($action === 'print') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            header("Location: /admin/fpdf/quote.php?id=".$id);
        }
        
        if ($action === 'mail') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $controller->mail($id);
        }

    break;

    case 'quote_details':
       require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/QuoteDetails/QuotesDetailsController.php";
       $controller = new QuotesDetailsController($mysqli);
        
        //
        if ($action === 'create') {
           $id = isset($_POST['operation_id']) ? (int) $_POST['operation_id'] : 0;
           $data = $_POST;
           $controller->create($data); // Llama al método que maneja GET y POST
        }
        //
        if ($action === 'delete') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
           $controller->delete($id); // Pasar el ID al método
        }
    break;
    
    case 'requests':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Requests/RequestsController.php";
        $controller = new RFQsController();
        
        if ($action === 'index') {
          $controller->index(); // Llama al método que maneja GET y POST
              
        }
      
        if ($action === 'create') {
            $controller->create(); // Llama al método que maneja GET y POST
        }
        
        
        if ($action === 'search') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->search(); // Llama al método que maneja GET y POST
        }
      
        if ($action === 'show') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->show($id); // Pasar el ID al método
        }

        if ($action === 'update') {
            $id = isset($_POST['operation_id']) ? (int) $_POST['operation_id'] : 0;
            $data = $_POST;
            $controller->update($id, $data);
        }
        
        if ($action === 'print') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->print($id); // Pasar el ID al método
        }
        
        if ($action === 'mail') {
          $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
           $controller->mail($id); // Ver el POST[mail] abajo 6/2/2025
        }
        
        if ($action === 'delete') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->delete($id); // Pasar el ID al método
        }
        
    break;

    case 'supplies':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Supplies/SuppliesController.php";
        $controller = new SuppliesController();

        if ($action === 'index') {
           $controller->index(); // Llama al método que maneja GET y POST
        }
        
        if ($action === 'search') {
           $controller->search(); // Llama al método que maneja GET y POST
        }
        
        if ($action === 'read') {
           $controller->read(); // Llama al método que maneja GET y POST
        }


    break;
       
    case 'deliveries':
        include 'app/views/sales/deliveries.php';
        break;

    case 'invoices':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Invoices/InvoicesController.php";
        $controller = new InvoicesController($mysqli);

        if ($action === 'by-client') {
            $controller->byClient();
            break;
        }
    
        if ($action === 'create') {
            $controller->create(); // Llama al método que maneja GET y POST
        }
        
        if ($action === 'index') {
            $controller->index(); // Llama al método que maneja GET y POST
        }

        if ($action === 'search') {
            $controller->search(); // Pasar el ID al método
        }
        
        if ($action === 'mail') {
          $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
           $controller->mail($id); // Ver el POST[mail] abajo 6/2/2025
        }
        
        if ($action === 'show') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Asegurarse de que sea un número entero
            $controller->show($id); // Pasar el ID al método
        }
        
        if ($action === 'print') {
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        
            ob_end_clean();
        
            $controller->pdf($id);
            exit;
        }
        
        if ($action === 'delete' && isset($_GET['id'])) {
            $controller->delete($_GET['id']); // Pasa el id de la orden
        }

        break;    

case 'collection':
case 'collections':
    require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Collections/CollectionController.php";
    $controller = new CollectionController($mysqli);

    $action = $_GET['action'] ?? 'index';

    switch ($action) {
        case 'process':
            $controller->process();
            break;
        case 'create':
            $controller->create();
            break;
        case 'show':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $controller->show($id);
            break;
        case 'update':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $controller->update($id);
            break;
        case 'delete':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $controller->delete($id);
            break;
        case 'print':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $controller->print($id);
            break;
        case 'index':
        default:
            $controller->index();
            break;
    }
    break;


    case 'messaging':
        ob_end_clean();
        require_once dirname(__DIR__, 2) . '/app/src/Domains/Admin/Messaging/MessagingRepository.php';
        require_once dirname(__DIR__, 2) . '/app/src/Domains/Admin/Messaging/MessagingController.php';
    
        $controller = new \App\Domains\Messaging\MessagingController($mysqli);
    
        $action = $_GET['action'] ?? '';
    
        if ($action === 'lookup') {
            $controller->lookup();
        }
        exit;

    case 'E-mail':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Email/EmailsController.php";
        $controller = new MailController();
        

        if ($action === 'create') {
            $controller->create(); // Llama al método que maneja GET y POST
        }
        break;  
              
    
    case 'carnets':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Quotes/QuotesController.php";
        $controller = new QuotesController($mysqli);
        
        if ($action === 'print') {
            //header("Location: /admin/TCPDF/examples/example_001.php");
            header("Location: /admin/TCPDF/examples/carnets.php");
        }              
        break;  
           
    case 'keywords':
        require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Keywords/KeywordsController.php";
        $controller = new KeywordsController();
        $action = $_GET['action'] ?? 'index';
        if ($action === 'suggest') {
            $controller->suggest();
        } else {
            $controller->index();
        }
        break;

case 'irs':
    require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Irs/IrsFilingRepository.php";
    require_once dirname(__DIR__, 2) . "/app/src/Domains/Admin/Irs/IrsController.php";

    $controller = new \App\Domains\Irs\IrsController($mysqli);

    switch ($_GET['action'] ?? 'index') {

        case 'index':
            $controller->index();
            break;

        case 'create':
            $controller->create();
            break;

        case 'store':
            $controller->store();
            break;

        case 'show':
            $controller->show();
            break;

        case 'update':
            $controller->update();
            break;

        case 'mark-filed':
            $controller->markFiled();
            break;

        case 'pdf':
            ob_end_clean();
            $controller->pdf();
            break;

        case '1120-proforma':
            ob_end_clean();
            $controller->proforma1120();
            break;
    }

    break;
        
    default:
        include dirname(__DIR__, 2) . '/app/src/Domains/Admin/Shared/views/404.php';
        break;
}



//include 'app/views/partials/footer.php';

ob_end_flush(); // envía contenido al navegador
?>
</body>
</html>
