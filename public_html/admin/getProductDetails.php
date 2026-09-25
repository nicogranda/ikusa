<?php
require ("../../app/config/connection.php");

$product_id = intval($_GET['product_id'] ?? 0);
$result = [];

if ($product_id > 0) {
    $stmt = $mysqli->prepare("SELECT unit_value, vat_rate FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $query = $stmt->get_result();

    if ($row = $query->fetch_assoc()) {
        $result = $row;
    }

    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($result);
?>
