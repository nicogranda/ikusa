<main class="container py-4">
    <h1>Registrar cobro</h1>
    <form method="post" action="index.php?page=collections&amp;action=create">
        <label>Cotización <input type="number" name="quote_id" min="1" value="<?= (int) ($_GET['quote_id'] ?? 0) ?>" required></label>
        <label>Importe <input type="number" name="amount" min="0.01" step="0.01" required></label>
        <label>Método de pago <input type="text" name="payment_method" required></label>
        <label>Banco <input type="text" name="bank_name"></label>
        <label>Número de transacción <input type="text" name="transaction_number"></label>
        <label>Fecha <input type="date" name="payment_date" value="<?= date('Y-m-d') ?>"></label>
        <button type="submit">Guardar</button>
    </form>
</main>
