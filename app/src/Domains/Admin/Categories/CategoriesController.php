<?php

class CategoriesController
{
    private mysqli $mysqli;

    public function __construct(?mysqli $mysqli = null)
    {
        $this->mysqli = $mysqli ?? $GLOBALS['mysqli'];
    }

    public function index(): void
    {
        $categories = $this->mysqli->query('SELECT id, name FROM categories ORDER BY name')->fetch_all(MYSQLI_ASSOC);
        require __DIR__ . '/views/index.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim((string) ($_POST['name'] ?? ''));
            if ($name !== '') {
                $stmt = $this->mysqli->prepare('INSERT INTO categories (name) VALUES (?)');
                $stmt->bind_param('s', $name);
                $stmt->execute();
                header('Location: index.php?page=categories&action=index');
                exit;
            }
        }
        require __DIR__ . '/views/create.php';
    }

    public function delete(int $id): void
    {
        $stmt = $this->mysqli->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        header('Location: index.php?page=categories&action=index');
        exit;
    }

    public function upload(): void
    {
        http_response_code(404);
        echo 'Esta sección no tiene carga de archivos.';
    }
}
