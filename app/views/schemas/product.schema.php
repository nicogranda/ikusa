<?php
// Requiere: $productName, $productDescription, $productImage, $productUrl, $productPrice, $productCurrency, $productBrand
// Opcional: $productAvailability ('InStock'|'OutOfStock'), $productSku
if (!isset($productName, $productDescription, $productImage, $productUrl, $productPrice, $productCurrency, $productBrand)) {
    throw new \RuntimeException('product.schema.php requiere datos básicos del producto, incluida $productBrand');
}

$productSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $productName,
    'description' => $productDescription,
    'image' => $productImage,
    'sku' => $productSku ?? null,
    'brand' => ['@type' => 'Brand', 'name' => $productBrand],
    'offers' => [
        '@type' => 'Offer',
        'url' => $productUrl,
        'priceCurrency' => $productCurrency,
        'price' => $productPrice,
        'availability' => 'https://schema.org/' . ($productAvailability ?? 'InStock')
    ]
];
?>
<script type="application/ld+json"><?= json_encode(array_filter($productSchema), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
