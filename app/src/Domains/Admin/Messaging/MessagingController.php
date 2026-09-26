<?php

namespace App\Domains\Messaging;

class MessagingController
{
    private MessagingRepository $repository;

    public function __construct(\mysqli $mysqli)
    {
        $this->repository = new MessagingRepository($mysqli);
    }

    public function lookup(): void
    {
        header('Content-Type: application/json');

        $alias = trim($_GET['alias'] ?? '');
        $type  = trim($_GET['type']  ?? '');

        if ($alias === '' || !in_array($type, ['supplier', 'client'])) {
            echo json_encode(['success' => false, 'message' => 'Parámetros inválidos.']);
            return;
        }

        $record = match($type) {
            'supplier' => $this->repository->findSupplierByAlias($alias),
            'client'   => $this->repository->findClientByAlias($alias),
        };

        if (!$record) {
            echo json_encode(['success' => false, 'message' => "No se encontró $type con alias '$alias'."]);
            return;
        }

        echo json_encode(['success' => true, 'type' => $type, 'data' => $record]);
    }
}