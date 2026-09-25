<?php
namespace App\Controllers\RFQ;
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once '../app/libraries/admin/Model.php';
require_once '../app/models/admin/Quote.php';
require_once '../app/models/admin/Client.php';
require_once '../app/models/admin/QuoteDetail.php';
require_once '../app/models/admin/Product.php';
require_once '../app/models/admin/OperationData.php'; // Agregar esta línea
require_once '../app/models/admin/Invoice.php';
require_once '../app/models/admin/Category.php';

use App\Models\Admin\OperationData; // Si usas namespaces, agrégalo aquí

use App\Models\Admin\Quote;
use App\Models\Admin\Client;
use App\Models\Admin\QuoteDetail;
use App\Models\Admin\Product;
use App\Models\Admin\Invoice;
use App\Models\Admin\Category;

class RFQsController
{
    private $mysqli;

    private Quote $operation;
    private Client $business;
    private QuoteDetail $operation_details;
    private Product $product;
    private OperationData $operationData;
    private Invoice $invoice;
    private Category $category;
  

public function __construct()
{
    global $mysqli;

    $this->mysqli = $mysqli;

    $this->operation = new Quote();
    $this->business = new Client();
    $this->operation_details = new QuoteDetail();
    $this->product = new Product();

    $this->operationData = new OperationData(
        $this->operation,
        $this->business,
        $this->operation_details,
        $this->product
    );

    $this->invoice = new Invoice();
    $this->category = new Category();
}

public function create()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // ===========================
        // VALIDAR RECAPTCHA
        // ===========================
        $captcha = $_POST['g-recaptcha-response'] ?? '';
        $secret = $_ENV['GOOGLE_RECAPTCHA_SECRET_KEY'] ?? '';

        $response = file_get_contents(
            'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret) . 
            '&response=' . urlencode($captcha) . 
            '&remoteip=' . ($_SERVER['REMOTE_ADDR'] ?? '')
        );

        $result = json_decode($response, true);

        if (empty($result['success'])) {
            die('Error: no se pudo validar reCAPTCHA');
        }

        // ===========================
        // CONTINÚA EL PROCESO NORMAL
        // ===========================
        $business = [
            'alias'       => $_POST['alias'],
            'name'        => $_POST['business_name'],
            'email'       => $_POST['email'],
            'domain'      => trim($_POST['domain_name'] ?? ''),
            'business_type' => "",
            'phone'       => "",
            'country'     => "",
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $bid = [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'approval' => 0,
        ];

        // Verificar si la marca ya existe
        $businessModel = $this->business->getByAlias($business['alias']);
        
        if ($businessModel) {
        
            $bid['business_id'] = $businessModel['id'];
        
            // Si se ha indicado un dominio y la marca no tiene uno guardado,
            // lo actualizamos.
            $this->addDomain(
                $businessModel['id'],
                $business['domain']
            );
        
        } else {
        
        
            if (!$this->business->create($business)) {
                die('Error al crear la marca');
            }
        
            $bid['business_id'] = $this->mysqli->insert_id;
        
            // Guardar dominio si se indicó
            $this->addDomain(
                $bid['business_id'],
                $business['domain']
            );
        }

        // Insertar la operación
        if (!$this->operation->create($bid)) {
            die('Error al crear Quote');
        }

        $operationId = $this->mysqli->insert_id;

        // Filtrar y preparar los ítems
        $items = array_filter($_POST['item'], function ($item) {
            return !empty($item['product_id']);
        });

        foreach ($items as $index => $item) {
            $items[$index] = array_merge(['quote_id' => $operationId], $item);
        }

        // Insertar detalles de operación
        $this->operation_details->store($items);

        // Enviar correo
        $this->mail($operationId);

        //  header('Location: /es/gracias/');
        // exit();
    } else {
        // Mostrar formulario
        $lang = $_GET['lang'] ?? 'es';  
        
        $products = $this->product->getAll();
        $categories = $this->category->getAll();

        // Agrupar productos por categoría
        $productsByCategory = array_reduce($products, function ($result, $product) {
            $result[$product['category_id']][] = $product;
            return $result;
        }, []);

        // Filtrar productos de categoría 1
        $filteredProducts = array_filter($products, fn($product) => $product['category_id'] == 1);
        
        $productTranslations = [
        
            // Traffic
            'Traffic' => 'Tráfico',
        
            // Tax
            'Tax' => 'Gestoría / Impuestos',
        
            // Marketing
            'Marketing' => 'Marketing',
        
            'Hourly Service Package' => 'Bolsa de horas',
        
            'Online Store' => 'Tienda online',
        
            'E-commerce' => 'Comercio electrónico',
        
            'SEO' => 'Posicionamiento SEO',
        
            'Web Design' => 'Diseño Web',
        
            'Website Maintenance' => 'Mantenimiento Web',
        
            'Web Development' => 'Desarrollo Web',
        
            'Hosting' => 'Alojamiento Web',
        
            'Domain' => 'Dominio',
        
        
            // Multimedia
            'Multimedia' => 'Multimedia',
        
            'Reel' => 'Reel',
        
            'Story' => 'Historia / Story',
        
            'Post' => 'Publicación Social',
        
        
            // Merchandising
            'Merchandising' => 'Merchandising',
        
            'Certificate' => 'Certificado',
        
            'Passport' => 'Pasaporte',
        
            'Medical Appointment Card' => 'Tarjeta de cita médica',
        
            'Banderole' => 'Banderola',
        
            'Gift Card' => 'Tarjeta regalo',
        
        
            // Graphic Design
            'Graphic Design' => 'Diseño Gráfico',
        
            'Printed Vinyl' => 'Vinilo impreso',
        
            'Cut Vinyl' => 'Vinilo de corte',
        
            'Billboard' => 'Valla publicitaria',
        
            'Storefront Sign' => 'Rótulo de fachada',
        
            'Banner' => 'Banner',
        
            'Business Card' => 'Tarjeta de visita',
        
            'Brochure' => 'Folleto',
        
        
            // Social Media
            'Social Media' => 'Redes Sociales',
        
        ];
        $briefingProducts = [
            [
                'id' => 1,
                'name' => 'Photos/Videos'
            ],
            [
                'id' => 2,
                'name' => 'Eslogan'
            ],
            [
                'id' => 3,
                'name' => 'Paletas de colores'
            ],
            [
                'id' => 4,
                'name' => 'Tipografías'
            ],
            [
                'id' => 5,
                'name' => 'Logotipo'
            ]
        ];

        include '../app/views/RFQ/create.php';
    }
}

   
    
    public function show($id)
    {

        //Get and Calculate
        $operation = $this->operationData->getOperationData($id);
      
        
      
        $requireModel = $this->require->getByItemId('quote_id', $operation['id']); 
            //var_dump($requireModel);
            
        if (!empty($requireModel) && is_array($requireModel)) {
                $firstItem = $requireModel[0]; // Tomar el primer resultado
                $operation['required'] = $firstItem['id'] ?? null;
            } else {
                $operation['required'] = null;
            }
        
        //Show
        include '../../app/views/admin/sales/quotes/show.php';

    }
    
     public function update($operationId, $data)
        {
         //var_dump($data);
            $alias = $data['operation']['\'alias\'']; // Mostrará: Cadena Panamericana
           
            $business = $this->business->getByAlias($alias);
            $businessId = $business['id'];
             $quoteModel = $this->operation; // Instancia del modelo Quote (tabla 'quotes')
            $OperationUpdated = $quoteModel->updateOperationByBusinessId($operationId, $businessId);
         
            // Se espera que $data sea un array con los datos de las cotizaciones y sus detalles
            $operationDetailData = $data['operation_detail']; // Detalles para la tabla operations_details
    
            // Crear instancias de los modelos
           
            $operationsDetailsModel = new QuoteDetail(); 

            // Llamamos al método updateOperation para actualizar ambas tablas
            $updateSuccess =$operationsDetailsModel->updateOperationDetailsByOperationId($operationId, $operationDetailData);
            header("Location: index.php?page=quotes&action=show&id=" . $operationId);
            if ($updateSuccess) {
                // Si la actualización es exitosa, redirigimos o mostramos un mensaje de éxito
                //header("Location: /path_to_success_page");
               //header("Location: index.php?page=quotes&action=show&id=" . $operationId);

                exit;
            } else {
                // Si algo falla, mostramos un mensaje de error
                echo "Error al actualizar la cotización";
            }
        }
    
     public function mail($id) {
    
        if ($id <= 0) {
        echo "ID no valido: {$id}";
        return;
        }
      
        $operation = $this->operation->getById($id);
        // var_dump($operation);
        
        if ($operation) {
            
            $business = $this->business->getById($operation['business_id']);
            
            $operation['business_name'] = $business ? $business['name'] : 'Business no encontrado';
            $operation['business_email'] = $business ? $business['email'] : 'N/A';
           // $operation['client_address'] = $business ? $business['address'] : 'N/A';
           
            $operation_details = $this->operation_details->getByItemId(
                'quote_id',
                $operation['id']
            );
            
            
            foreach ($operation_details as $key => $operation_detail) {
            
                $product = $this->product->getByItemId(
                    'id',
                    $operation_detail['product_id']
                );
            
            
                if (!empty($product)) {
            
                    $operation_details[$key]['product_name'] = $product[0]['name'];
                    $operation_details[$key]['unit'] = $product[0]['unit'];
            
                } else {
            
                    $operation_details[$key]['product_name'] = 'Product not found';
                    $operation_details[$key]['unit'] = 'N/A';
            
                }
            
            }
           // var_dump($operation_details);
            $vat = 0; $total = 0;
            
            //El config
            $mailerId = "Ikusa";
            $mailerTo = $operation['business_email'];
        
            $mailerFrom = 'contact@ikusa.net'; // Place the E-mail of Domain
            $mailerToToo = 'ikusa.ads@gmail.com';
            $mailerReplay = $mailerFrom;
            $subject = "Quote {$operation['id']}";
            
            //Credenciales para PHPMailer 
            require_once '../app/config/email.php';
            
            //Body:
             include '../app/views/RFQ/mail.php';
          
            //Send
             include '../app/libraries/inc_phpmailer.php';
             
            //Marcamos éxito y redirigimos (Post/Redirect/Get)
             //Marcamos éxito y redirigimos (Post/Redirect/Get)
             $_SESSION['rfq_sent'] = true;
             $_SESSION['rfq_mailer_to'] = $mailerTo;
             $_SESSION['rfq_mailer_from'] = $mailerFrom;

             header('Location: /es/gracias');
             exit;
             } else {
                echo "No se encontró la cotización con el ID {$id}.";
            }
      
    }
    
    public function success()
        {


            $mailerTo = $_SESSION['rfq_mailer_to'] ?? '';
            $mailerFrom = $_SESSION['rfq_mailer_from'] ?? '';
    
            include '../app/views/RFQ/notice.php';
    
            // Limpiamos para que un refresh no siga mostrando datos viejos
            unset($_SESSION['rfq_sent'], $_SESSION['rfq_mailer_to'], $_SESSION['rfq_mailer_from']);
        }
    
    public function print($id)
    {
        //Area de data, debo crear una class que haga esto y poder reusarla, aca en show y en mail.
        $operation = $this->operation->getById($id);
        
        $vat = 0; $total = 0;
        if ($operation) {
            
            $business = $this->business->getById($operation['client_id']);
            
            $operation['business_alias'] = $business ? $business['alias'] : 'Cliente no encontrado';
            $operation['business_name'] = $business ? $business['name'] : 'Cliente no encontrado';
            $operation['business_email'] = $business ? $business['email'] : 'N/A';
            $operation['business_address'] = $business ? $business['address'] : 'N/A';
            
            $operation_details = $this->operation_details->getByItemId('quote_id', $operation['id']);
        
            foreach ($operation_details as &$operation_detail) {
                $product = $this->product->getByItemId('id', $operation_detail['product_id']);
                
                    if (!empty($product) && is_array($product)) {
                        // Si getByItemId devuelve un array con un solo producto, accedemos al primer elemento
                        $product = reset($product);  
                    }
                    
                
                //var_dump($product); // Asegúrate de que aquí solo ves un producto a la vez
                 
                $operation_detail['product_name'] = $product['name'] ?? 'Product not found';
                $operation_detail['unit'] = $product['unit'] ?? 'N/A';
                
                  // Cálculo de vat_item y balance
                $vat_item = $operation_detail['quantity'] * $operation_detail['unit_value'] * (1 - $operation_detail['discount'] / 100) * ($operation_detail['vat_rate'] / 100);
                $balance = $operation_detail['quantity'] * $operation_detail['unit_value'] * (1 - $operation_detail['discount'] / 100) + $vat_item;
                $vat = $vat + $vat_item;
                $total = $total + $balance +$vat;
            }
        }
        include '../../app/views/admin/sales/quotes/print.php';
    }
    
    public function delete($id)
    {
        // Validar que $id sea numérico
        if (!is_numeric($id)) {
            throw new Exception("ID inválido.");
        }
    
        $this->mysqli->begin_transaction(); // Iniciar transacción
    
        try {
            // Obtener la cotización
            $quote1 = $this->operation->getById($id);
            if (!$quote1) {
                throw new Exception("Cotización no encontrada.");
            }
    
            // Eliminar los detalles de la cotización
            $quote_details = $this->operation_details->deleteItemsByOperationId('quote_id', $quote1['id']);
    
            // Eliminar la cotización principal
            $quote = $this->operation->delete($id);
    
            $this->mysqli->commit(); // Confirmar transacción
    
            // Redirigir después de una eliminación exitosa
            header("Location: index.php?page=quotes&action=index");
            exit;
            
        } catch (Exception $e) {
            $this->mysqli->rollback(); // Revertir cambios en caso de error
            throw new Exception("Error al eliminar la cotización: " . $e->getMessage());
        }
    }

    private function addDomain(int $businessId, string $domain): void
    {
        $domain = trim($domain);
    
        if ($domain === '') {
            return;
        }
    
        $business = $this->business->getById($businessId);
    
        if (!$business) {
            return;
        }
    
        // Solo si todavía no tiene dominio
        if (empty($business['domain'])) {
            $this->business->updateDomain($businessId, $domain);
        }
    } 
}