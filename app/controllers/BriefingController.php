<?php
// controllers/BriefingController.php
require_once('models/Client.php');
require_once('models/Briefing.php');


class BriefingController {
    private $mysqli;
    private $clientModel;
    private $briefingModel;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
        $this->clientModel = new Client($this->mysqli);
        $this->briefingModel = new Briefing($this->mysqli);
    }

    public function storeBriefing($post_data) {
        $product_data = Product::processPostData($post_data);
        extract($product_data);

        $brand = $post_data['brand'] ?? '';
        $client = $post_data['client'] ?? '';
        $email = $post_data['email'] ?? '';
        $business_type_id = $post_data['business_type_id'] ?? '';

        // Verificar si el cliente ya existe
        $clients = $this->clientModel->findByBrand($brand);
        $client_id = null;
        while ($row = $clients->fetch_assoc()) {
            $client_id = $row['id'];
        }

        if (!isset($client_id)) {
            // Crear nuevo cliente
            $client_id = $this->clientModel->create($client, $brand, $email, $business_type_id);
        }

        // Verificar si el briefing ya existe
        if ($this->briefingModel->exists($client_id)) {
            // Actualizar briefing existente
            $this->briefingModel->update($client_id, $logotype, $color_palette, $fonts, $photos, $slogan);
        } else {
            // Crear nuevo briefing
            $this->briefingModel->create($client_id, $logotype, $color_palette, $fonts, $photos, $slogan);
        }
    }
}
?>