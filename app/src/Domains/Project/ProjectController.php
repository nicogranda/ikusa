<?php
namespace Domains\Project;

// Activar todos los errores y warnings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Opcional: log de errores en un archivo
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log'); // Se creará php-error.log en la misma carpeta que index.php


class ProjectController {
    protected $projectModel;

    public function __construct() {
        $this->projectModel = new Project();
    }

    // Listar todos los proyectos
    public function index() {
        $projects = $this->projectModel->all();
        require_once __DIR__ . '/../../../views/projects/index.php';
    }

    // Mostrar un proyecto individual por slug
    public function show($slug) {
        $project = $this->projectModel->findBySlug($slug);
        if (!$project) {
            http_response_code(404);
            echo "Proyecto no encontrado";
            exit;
        }
        require_once __DIR__ . '/../../../views/projects/show.php';
    }

    // Crear proyecto desde un array (ej. POST)
    public function store($data) {
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Project::generateSlug($data['title']);
        }
        return $this->projectModel->create($data);
    }
}