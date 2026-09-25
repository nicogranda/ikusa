<?php

// Fetch categories with IDs 3, 4, 5, and 6 (First section)
$categories_require = [];
$products_require = [];

// Get required categories
$categoryQuery = $mysqli->query("SELECT * FROM categories WHERE id IN (2, 3, 4, 5, 6) ORDER BY id");
while ($categoryRow = $categoryQuery->fetch_assoc()) {
    $categories_require[$categoryRow['id']] = $categoryRow['name'];
}

// Get products within the specified categories
$productQuery = $mysqli->query("SELECT * FROM products WHERE category_id IN (2, 3, 4, 5, 6) ORDER BY id");
while ($productRow = $productQuery->fetch_assoc()) {
    $products_require[$productRow['category_id']][] = $productRow;
}

// Fetch all categories and products (Second section)
$categories_briefing = [];
$products_briefing = [];

// Get all categories
$categoryQueryBriefing = $mysqli->query("SELECT * FROM categories  WHERE id IN (1) ORDER BY id");
while ($categoryRow = $categoryQueryBriefing->fetch_assoc()) {
    $categories_briefing[] = $categoryRow;
}

// Get all products
$productQueryBriefing = $mysqli->query("SELECT * FROM products WHERE category_id IN (1) ORDER BY id");
while ($productRow = $productQueryBriefing->fetch_assoc()) {
    $products_briefing[] = $productRow;
}
?>