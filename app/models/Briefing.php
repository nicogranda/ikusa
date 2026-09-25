<?php
// models/Briefing.php
class Briefing {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    // Método para obtener categorías
    public function getCategories() {
        $categories = [];
        $query = "SELECT * FROM categories WHERE id IN (1) ORDER BY id";
        $result = $this->mysqli->query($query);
        
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        return $categories; // Retorna las categorías
    }

    // Método para obtener productos
    public function getProducts() {
        $products = [];
        $query = "SELECT * FROM products WHERE category_id IN (1) ORDER BY id";
        $result = $this->mysqli->query($query);
        
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products; // Retorna los productos
    }
    
    public function exists($client_id) {
        $query = "SELECT * FROM briefings WHERE client_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Método de lectura para obtener todos los datos del briefing de un cliente
    public function read($client_id) {
        $query = "SELECT * FROM briefings WHERE client_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Si existe el briefing para el cliente, retornar los datos
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retorna un solo resultado como un array asociativo
        } else {
            return null; // Si no existe, retorna null
        }
    }
    
    public function create($client_id, $logotype, $color_palette, $fonts, $photos, $slogan) {
        $query = "INSERT INTO briefings (client_id, logotype, color_palette, fonts, photos, slogan, rrss) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("iiiiiii", $client_id, $logotype, $color_palette, $fonts, $photos, $slogan, $rrss);
        $stmt->execute();
    }

    public function update($client_id, $logotype, $color_palette, $fonts, $photos, $slogan) {
        $query = "UPDATE briefings SET logotype = ?, color_palette = ?, fonts = ?, photos = ?, slogan = ? 
                  WHERE client_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("iiiiii", $logotype, $color_palette, $fonts, $photos, $slogan, $client_id);
        $stmt->execute();
    }
}

?>