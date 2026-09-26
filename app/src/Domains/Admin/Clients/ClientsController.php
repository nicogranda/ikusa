<?php

namespace App\Domains\Clients;

require_once __DIR__ . '/Clients.php';

class ClientsController
{
    private Clients $business;
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
        $this->business = new Clients($mysqli);
    }

    public function index(): void
    {
        $search = $_GET['search'] ?? '';
        $businessPerPage = 10;
        $currentPage = (int) ($_GET['currentPage'] ?? 1);
        $offset = ($currentPage - 1) * $businessPerPage;

        $businessList = $this->business->getAllPaginated($businessPerPage, $offset, $search);
        $totalBusiness = $this->business->getTotal($search);
        $totalPages = (int) ceil($totalBusiness / $businessPerPage);

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/views/index.php';
    }

    public function search(): void
    {
        header('Content-Type: application/json');

        if (!isset($_GET['alias'])) {
            echo json_encode(['success' => false, 'message' => 'Se requiere un alias']);
            return;
        }

        $client = $this->business->getByAlias($_GET['alias']);

        if ($client) {
            echo json_encode(['success' => true, 'data' => $client]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron resultados']);
        }
    }

    public function create(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $required = ['name', 'language', 'email', 'phone', 'alias', 'address',
                         'city', 'state', 'zip_code', 'country', 'tax_id',
                         'currency', 'representative', 'business_type'];

            foreach ($required as $field) {
                if (empty(trim($_POST[$field] ?? ''))) {
                    $errors[] = "El campo '$field' es obligatorio.";
                }
            }

            if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El email no es válido.';
            }

            if (empty($errors) && $this->business->existsByEmailOrTaxId($_POST['email'], $_POST['tax_id'])) {
                $errors[] = 'Ya existe un cliente con ese email o CIF/NIF.';
            }

            if (empty($errors)) {
                $data = array_map('trim', $_POST);
                $data['tax_note'] = trim($_POST['tax_note'] ?? '');
                $data['business_type'] = (int) $_POST['business_type'];

                $id = $this->business->create($data);

                header('Location: index.php?page=clients&action=index&created=' . $id);
                exit;
            }
        }

        $options = [
            'languages' => [
                'es' => 'Español',
                'en' => 'English',
                'eu' => 'Euskera',
            ],
            'currencies' => [
                'EUR' => 'Euro (€)',
                'USD' => 'Dólar estadounidense ($)',
            ],
            'countries' => [
                'España' => 'España',
                'Estados Unidos' => 'Estados Unidos',
                'Venezuela' => 'Venezuela',
            ],
            'business_types' => [
                1 => 'Restauración / Hostelería',
                2 => 'Estética / Salud',
                3 => 'Retail / E-commerce',
                4 => 'Servicios profesionales',
                5 => 'Otro',
            ],
        ];
        
        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/views/create.php';
    }
    
public function edit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id <= 0) {
            die('ID de cliente inválido');
        }

        $client = $this->business->getById($id);

        if (!$client) {
            die('Cliente no encontrado');
        }

        $errors = [];
        $options = [
            'languages' => [
                'es' => 'Español',
                'en' => 'English',
                'eu' => 'Euskera',
            ],
            'currencies' => [
                'EUR' => 'Euro (€)',
                'USD' => 'Dólar estadounidense ($)',
            ],
            'countries' => [
                'España' => 'España',
                'Estados Unidos' => 'Estados Unidos',
                'Venezuela' => 'Venezuela',
            ],
            'business_types' => [
                1 => 'Restauración / Hostelería',
                2 => 'Estética / Salud',
                3 => 'Retail / E-commerce',
                4 => 'Servicios profesionales',
                5 => 'Otro',
            ],
        ];

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/views/edit.php';
    }

    public function update(): void
    {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

        if ($id <= 0) {
            die('ID de cliente inválido');
        }

        $errors = [];
        $required = ['name', 'language', 'email', 'phone', 'alias', 'address',
                     'city', 'state', 'zip_code', 'country', 'tax_id',
                     'currency', 'representative', 'business_type'];

        foreach ($required as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $errors[] = "El campo '$field' es obligatorio.";
            }
        }

        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email no es válido.';
        }

        if (empty($errors) && $this->business->existsByEmailOrTaxIdExcludingId($_POST['email'], $_POST['tax_id'], $id)) {
            $errors[] = 'Ya existe otro cliente con ese email o CIF/NIF.';
        }

        if (empty($errors)) {
            $data = array_map('trim', $_POST);
            $data['tax_note'] = trim($_POST['tax_note'] ?? '');
            $data['business_type'] = (int) $_POST['business_type'];

            $this->business->update($id, $data);

            header('Location: index.php?page=clients&action=index&updated=' . $id);
            exit;
        }

        // Si hay errores, recarga edit() con los datos del intento fallido
        $_GET['id'] = $id;
        $client = $_POST;
        $client['id'] = $id;

        $options = [
            'languages' => ['es' => 'Español', 'en' => 'English', 'eu' => 'Euskera'],
            'currencies' => ['EUR' => 'Euro (€)', 'USD' => 'Dólar estadounidense ($)'],
            'countries' => ['España' => 'España', 'Estados Unidos' => 'Estados Unidos', 'Venezuela' => 'Venezuela'],
            'business_types' => [1 => 'Restauración / Hostelería', 2 => 'Estética / Salud', 3 => 'Retail / E-commerce', 4 => 'Servicios profesionales', 5 => 'Otro'],
        ];

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/views/edit.php';
    }
}