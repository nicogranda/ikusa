<?php
// OrdersController.php (Controlador)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/Model.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Requests/Request.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Requests/RequestDetail.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Supplies/Supply.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Providers/Provider.php';
require_once dirname(__DIR__, 5) . "/app/src/Domains/Admin/Orders/Order.php";
require_once dirname(__DIR__, 5) . "/app/src/Domains/Admin/Auth/User.php";

use App\Models\Admin\RFQ;
use App\Models\Admin\RFQDetail;
use App\Models\Admin\Supply;
use App\Models\Admin\Provider;
use App\Models\Admin\Order;
use App\Models\Admin\User;

class OrdersController {

    private $order;
    private $supply;
    private $RFQ;
    private $RFQDetail;
    private $provider;
    private $user;

    public function __construct($mysqli) {
        
        global $mysqli; // Asegurar que $mysqli est谩 disponible
        $this->mysqli = $mysqli; // Asignarlo a la clase
        
        $this->require = new Order();
        $this->operation = new RFQ();
        $this->operation_detail = new RFQDetail();
        $this->product = new Supply();
        $this->business = new Provider();
        $this->user = new User();
    }

    public function index() {
        $requires = $this->require->getAll();
        unset($_SESSION['message']);

         // Obtener el valor de búsqueda
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
         // Configuración de paginación
        $operationsPerPage = 10;
        $currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1;  // Usamos 'currentPage' en lugar de 'page'
        $offset = ($currentPage - 1) * $operationsPerPage;
        
        $operations = $this->operation->getAllPaginated($operationsPerPage, $offset); 
        
        $totalOperations = $this->operation->getTotalOperations($search); 
        $totalPages = ceil($totalOperations / $operationsPerPage);
        
        
        foreach ($requires as $key => $require) {
            $operation  = $this->operation->getById($require['request_id']);
            if ($operation) {
                $business = $this->business->getById($operation['business_id']);
                $requires[$key]['business_name'] = $business ? $business['name'] : 'Business no encontrado';
                $requires[$key]['business_email'] = $business ? $business['email'] : 'N/A';
            
                $user = $this->user->getById($require['user_id']);
                $requires[$key]['user_alias'] = $user ? $user['username'] : 'User no encontrado';     
            }
           
        }
    
      include dirname(__DIR__, 5) . "/app/src/Domains/Admin/Orders/views/index.php"; //Aca va tu views.
    }


    public function create() {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
            $operation = [    
                'request_id' => $_GET['operation'],
                'user_id' => $_SESSION['user_id'],
                'created_at' => date('Y-m-d H:i:s'),     // Fecha actual para created_at
                'updated_at' => date('Y-m-d H:i:s'),     // Fecha actual para updated_at
            ];
            
            $require = $this->require->create($operation);
            
    
            if ($require) {
                header("Location: index.php?page=order&action=index");
                exit;
            } else {
                echo "Error al crear la orden: " . $this->db->error;
            }
        //}
        //include dirname(__DIR__, 5) . "/app/src/Domains/Admin/Orders/views/create.php";
    }

    public function search()
    {
        $search = isset($_POST['search']) ? trim($_POST['search']) : '';
        $operationsPerPage = 10;
        $currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1;
        $offset = ($currentPage - 1) * $operationsPerPage;
       
     
        // Calcular el número total de páginas
        $totalPages = 1;
      
          
        if ($search !== '') {
            $requires = $this->require->getById($search); 
             
    
            if (!empty($requires) && isset($requires['id'])) {
                $requires = [$requires]; // Convertirlo en array de arrays si es un solo resultado
            }
    
            if (!is_array($requires) || empty($requires)) {
                echo "No se encontró la operación con ese ID.";
                return;
            }
    
            foreach ($requires as &$operation) {
                $business = $this->business->getById($operation['provider_id'] ?? null);
                $operation['business_name'] = $business ? $business['name'] : 'Business no found';
                $operation['business_email'] = $business ? $business['email'] : 'N/A';
            }

           include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Orders/views/index.php';
        } else {
            echo "No se ha ingresado ningún ID para buscar.";
            header("Location: index.php?page=order&action=index");
        }
    }

    public function show($id)
    {
        if ($id <= 0) {
            echo "ID no valido: {$id}";
            return;
        }
    
        $order = $this->require->getById($id);
        
        $operation = $this->operation->getById($order['request_id']);
        // var_dump($operation);
        
        if ($operation) {
            
            $business = $this->business->getById($operation['provider_id']);
            
            $operation['business_name'] = $business ? $business['name'] : 'Business no encontrado';
            $operation['business_email'] = $business ? $business['email'] : 'N/A';
           // $operation['client_address'] = $business ? $business['address'] : 'N/A';
           
            $operation_details = $this->operation_detail->getByItemId('request_id', $operation['id']);
    
            foreach ($operation_details as &$operation_detail) {
            
                $product = $this->product->getByItemId('id', $operation_detail['product_id']);
            
                $operation_detail['product_name'] = $product ? $product[0]['name'] : 'Product not found';
                $operation_detail['unit'] = $product ? $product[0]['unit'] : 'N/A';
            }
             include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Orders/views/show.php';
        } else {
            echo "No se encontr贸 la cotizaci贸n con el ID {$id}.";
        }
    }
    
    public function mail($id) {
        if ($id <= 0) {
        echo "ID no valido: {$id}";
        return;
        }
        
        // igual a show
        $order = $this->require->getById($id);
        
        $operation = $this->operation->getById($order['request_id']);
        // var_dump($operation);
        
        if ($operation) {
            
            $business = $this->business->getById($operation['provider_id']);
            
            $operation['business_name'] = $business ? $business['name'] : 'Business no encontrado';
            $operation['business_email'] = $business ? $business['email'] : 'N/A';
           // $operation['client_address'] = $business ? $business['address'] : 'N/A';
           
            $operation_details = $this->operation_detail->getByItemId('request_id', $operation['id']);
    
            foreach ($operation_details as &$operation_detail) {
            
                $product = $this->product->getByItemId('id', $operation_detail['product_id']);
            
                $operation_detail['product_name'] = $product ? $product[0]['name'] : 'Product not found';
                $operation_detail['unit'] = $product ? $product[0]['unit'] : 'N/A';
            }
            
            //
            //El config
            $mailerId = "Traffic and Media";
            $mailerTo = $operation['business_email'];
        
            $mailerFrom = 'contact@ikusa.net'; // Place the E-mail of Domain
            $mailerToToo = 'ikusa.ads@gmail.com';
            $mailerReplay = $mailerFrom;
            $subject = "Order {$operation['id']}";
            
            //Credenciales para PHPMailer 
            require_once dirname(__DIR__, 5) . '/app/config/email.php';
            
            //Body:
             include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Orders/views/mail.php';
             
             //Send
             include dirname(__DIR__, 5) . '/app/libraries/inc_phpmailer.php';
             
             //Volver
             //include dirname(__DIR__, 5) . '/app/views/Email/notice.php';
              header("Location: index.php?page=order&action=show&id={$order['id']}");
             } else {
            echo "No se encontr贸 la cotizaci贸n con el ID {$id}.";
        }
        //hasta aca
      
    }
         
    public function delete($id) {
        if ($this->require->delete($id)) {
            header("Location: index.php?page=order&action=index");
            exit;
        }
    }
    
}
