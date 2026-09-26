<!-- app/views/admin/rfq/create.php -->

<main class="container">

<h2>RFQ Generate</h2>

<p>
Quote ID:
<strong><?= $quoteId ?></strong>
</p>

<hr>

<h3>Items to Quote</h3>

<table class="quote-table">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Unit</th>
        <th>Note</th>
    </tr>
    <?php foreach($items as $item): ?>
    <tr>
        <td><?= $item['product_name'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= $item['unit'] ?></td>
        <td><?= $item['note'] ?></td>
    </tr>
    <?php endforeach; ?>

</table>

<br><hr><br>

<h3>Suppliers Available</h3>

<form method="POST" action="index.php?page=rfq&action=store">

<input type="hidden" name="quote_id" value="<?= $quoteId ?>">

<?php foreach($suppliers as $row): ?>

<label style="display:block; margin-bottom:10px;">
    <input type="checkbox"
           name="suppliers[]"
           value="<?= $row['id'] ?>">

    <?= $row['name'] ?>
</label>

<?php endforeach; ?>

<br>

<button type="submit">
Generate RFQ
</button>

</form>

</main>
<style>
    .quote-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    background: #fff;
    border: 1px solid #ddd;
    overflow: hidden;
    border-radius: 8px;
}

.quote-table th {
    background: #1f2937;
    color: #fff;
    text-align: left;
    padding: 14px 12px;
    font-size: 14px;
    letter-spacing: 0.5px;
}

.quote-table td {
    padding: 12px;
    border-top: 1px solid #eee;
    font-size: 14px;
    color: #333;
}

.quote-table tr:nth-child(even) {
    background: #f9fafb;
}

.quote-table tr:hover {
    background: #f1f5f9;
    transition: background 0.2s ease;
}

.quote-table td:first-child {
    font-weight: 600;
}

.quote-table th:first-child {
    border-top-left-radius: 8px;
}

.quote-table th:last-child {
    border-top-right-radius: 8px;
}
</style>