<?php
require_once '../app/models/admin/Categories.php';

class CategoriesController
{
    private $categoryModel;

    public function __construct($mysqli)
    {
        $this->categoryModel = new Categories($mysqli);
    }

    // Mostrar todas las categorías
    public function index()
    {
        // Obtener todas las categorías desde el modelo
        $categories = $this->categoryModel->getAllCategories();
        
        // Pasar las categorías a la vista
        require_once 'views/admin/categories/index.php'; // Cambia esta ruta según tu estructura de vistas
    }


    // Ver detalles de una categoría
    public function show($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        require_once 'views/categories/show.php'; // Cambia esta ruta según tu estructura de vistas
    }

    // Crear nueva categoría
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if ($this->categoryModel->createCategory($name)) {
                header('Location: index.php?action=index'); // Redirige a la lista de categorías
            }
        }
        require_once 'views/categories/create.php'; // Cambia esta ruta según tu estructura de vistas
    }

    // Editar categoría
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if ($this->categoryModel->updateCategory($id, $name)) {
                header('Location: index.php?action=index'); // Redirige a la lista de categorías
            }
        }

        require_once 'views/categories/edit.php'; // Cambia esta ruta según tu estructura de vistas
    }

    // Eliminar categoría
    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: index.php?action=index'); // Redirige a la lista de categorías
        }
    }
}
?>
