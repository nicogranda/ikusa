<?php
require ("../../app/config/connection.php");

$category_id = intval($_GET['category_id'] ?? 0);
$result = [];

if ($category_id > 0) {
    $stmt = $mysqli->prepare("SELECT id, name FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $query = $stmt->get_result();

    while ($row = $query->fetch_assoc()) {
        $result[] = $row;
    }

    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($result);
?>
