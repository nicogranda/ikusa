<?php

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/Model.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/Product.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Categories/Category.php';

use App\Models\Admin\Product;
use App\Models\Admin\Category;

class ProductsController
{
    private $product;
    private $category;
    private $mysqli;

    public function __construct()
    {
        global $mysqli;
        $this->mysqli = $mysqli;
        $this->category = new Category();
        $this->product = new Product();
    }

public function create()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --- Validar y limpiar datos base ---
        $name = trim($_POST['name'] ?? '');
        $sku = trim($_POST['sku'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $unit = trim($_POST['unit'] ?? '');
        $category_id = trim($_POST['category_id'] ?? '');

        if (empty($name) || empty($sku) || empty($unit) || empty($category_id)) {
            echo "El nombre, SKU, unidad y categoría son obligatorios.";
            return;
        }

        // --- Preparar datos para guardar el producto principal ---
        $productData = [
            'name' => $name,
            'sku' => $sku,
            'description' => $description,
            'unit' => $unit,
            'category_id' => $category_id
        ];

        // Guardar producto principal
        $productId = $this->product->create($productData);

        if (!$productId) {
            echo "Error al guardar el producto principal.";
            return;
        }

// --- Obtener variantes desde POST ---
$variants = $_POST['variants'] ?? [];
// var_dump($_POST['variants']);
// exit;


if (!empty($variants)) {
    // echo "Entramos al if de variantes<br>";
    
    $variantModel = new \App\Libraries\Admin\Model();
    $variantModel->setTable('product_variants');
    
    $attributeModel = new \App\Libraries\Admin\Model();
    $attributeModel->setTable('variant_attributes');

    foreach ($variants as $vIndex => $variant) {
        // Limpiar datos de la variante
        $cleanVariant = [
            'product_id' => $productId,
            'sku'        => trim($variant['sku'] ?? ''),
            'price'      => floatval($variant['price'] ?? 0),
            'stock'      => intval($variant['stock'] ?? 0),
            'weight'     => floatval($variant['weight'] ?? 0),
            'image_url'  => trim($variant['image_url'] ?? ''),
            'is_active'  => isset($variant['is_active']) ? intval($variant['is_active']) : 1,
        ];

        // Insertar la variante en la tabla product_variants
        $variantId = $variantModel->create($cleanVariant);
        echo "Guardada variante ID={$variantId}, SKU={$cleanVariant['sku']}<br>";

        // Procesar atributos de la variante
        $attributes = $variant['attributes'] ?? [];
        foreach ($attributes as $attrIndex => $attr) {
            $atributo       = trim($attr['atributo'] ?? '');
            $atributo_valor = trim($attr['atributo_valor'] ?? '');

            if ($atributo && $atributo_valor) {
                $attributeModel->create([
                    'variant_id'     => $variantId,
                    'atributo'       => $atributo,
                    'atributo_valor' => $atributo_valor
                ]);
                echo "Guardado atributo: {$atributo} = {$atributo_valor}<br>";
            }
        }
    }
}



        // --- Redirigir al listado de productos ---
        header('Location: /admin/index.php?page=products&action=index');
        exit;

    } else {
        // Mostrar formulario de creación
        $categories = $this->category->getAll();
        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/views/create.php';
    }
}


    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file'];

            // --- Directorio de destino en public_html/uploads ---
            $uploadDir = realpath(dirname(__DIR__, 5) . '/public_html/uploads');

            if ($uploadDir === false) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'No se encontró el directorio de subida.']);
                exit;
            }

            // Sanitiza nombre y agrega uniqid
            $name = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $newName = $name . '_' . uniqid('', true) . '.' . $ext;

            $destination = $uploadDir . DIRECTORY_SEPARATOR . $newName;

            // --- Crear carpeta si no existe ---
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // --- Mover archivo ---
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $publicUrl = '/uploads/' . $newName; // URL pública accesible desde navegador

                echo json_encode([
                    'success' => true,
                    'file' => $newName,
                    'url' => $publicUrl
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Error al mover el archivo.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'No se recibió ningún archivo.']);
        }

        exit; // Evita cargar vistas
    }
   public function index()
{
    // Obtener el valor de búsqueda (si existe)
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Configuración de paginación
    $productsPerPage = 10;
    $currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1;
    $offset = ($currentPage - 1) * $productsPerPage;

    // Si hay búsqueda, usamos searchByName(); sino, getAllPaginated()
    if (!empty($search)) {
        $products = $this->product->searchByName($search);
    } else {
        $products = $this->product->getAllPaginated($productsPerPage, $offset);
    }

    // Obtener total de registros (filtrados si hay búsqueda)
    $totalProducts = $this->product->getTotal($search);
  $totalPages = ceil($totalProducts / $productsPerPage);

    // Agregar variantes y atributos para cada producto
    // foreach ($products as &$product) {
    //     $product['variants'] = $this->variantModel->getByColumn('product_id', $product['id']);
    //     foreach ($product['variants'] as &$variant) {
    //         $variant['attributes'] = $this->attributeModel->getByColumn('variant_id', $variant['id']);
    //     }
    // }
    // unset($variant);
    //unset($product);

   $categories = $this->category->getAll();
       
    // Pasar datos a la vista
    include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/views/index.php';
}

// 🔍 SEARCH: para manejar búsquedas por POST (formulario o AJAX)
public function search()
{
    // Capturar el texto de búsqueda
    $search = isset($_POST['search']) ? trim($_POST['search']) : '';

    // Configuración de paginación
    $productsPerPage = 10;
    $currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage'] : 1;
    $offset = ($currentPage - 1) * $productsPerPage;

    if (!empty($search)) {
        $products = $this->product->searchByName($search);
    } else {
        $products = $this->product->getAllPaginated($productsPerPage, $offset);
    }

    // Obtener total de productos (filtrados si hay búsqueda)
    $totalProducts = $this->product->getTotal($search);
    $totalPages = ceil($totalProducts / $productsPerPage);

    // Agregar nombre de categoría y variantes con atributos
    foreach ($products as &$product) {
        $category = $this->category->getById($product['category_id']);
        $product['category_name'] = $category ? $category['name'] : 'Sin categoría';

        $product['variants'] = $this->variantModel->getByColumn('product_id', $product['id']);
        foreach ($product['variants'] as &$variant) {
            $variant['attributes'] = $this->attributeModel->getByColumn('variant_id', $variant['id']);
        }
    }
    unset($variant);
    unset($product);

    // Cargar vista
    include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/views/index.php';
}

public function delete($id)
{
     $id = intval($id); // Asegurar que sea un número
  
     $productId = $this->product->delete($id);

    // Redirigir al listado de productos
    header('Location: /admin/index.php?page=products&action=index');
    exit;
}

}


