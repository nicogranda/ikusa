<main class="container py-4">
    <h1>Editar cobro</h1>
    <form method="post" action="index.php?page=collections&amp;action=update&amp;id=<?= (int) $collection['id'] ?>">
        <label>Importe <input type="number" name="amount" min="0.01" step="0.01" value="<?= htmlspecialchars((string) ($collection['amount'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required></label>
        <label>Método de pago <input type="text" name="payment_method" value="<?= htmlspecialchars((string) ($collection['payment_method'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required></label>
        <label>Banco <input type="text" name="bank_name" value="<?= htmlspecialchars((string) ($collection['bank_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></label>
        <label>Número de transacción <input type="text" name="transaction_number" value="<?= htmlspecialchars((string) ($collection['transaction_number'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></label>
        <label>Fecha <input type="date" name="payment_date" value="<?= htmlspecialchars((string) ($collection['payment_date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></label>
        <button type="submit">Guardar</button>
    </form>
</main>
