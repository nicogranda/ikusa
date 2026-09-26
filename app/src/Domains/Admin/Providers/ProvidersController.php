<?php

class ProvidersController
{
    public function __construct(private mysqli $mysqli)
    {
    }

    public function index(): void
    {
        $providers = $this->mysqli->query('SELECT * FROM providers ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
        require __DIR__ . '/views/index.php';
    }
}
