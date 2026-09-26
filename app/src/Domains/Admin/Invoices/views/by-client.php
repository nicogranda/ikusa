<?php
$periodLabel = $month === null ? (string) $year : sprintf('%02d/%d', $month, $year);
$money = static fn (int $cents): string => number_format($cents / 100, 2, ',', '.') . ' €';
?>
<main class="container py-4">
    <h1>Facturas por cliente</h1>
    <p><a href="index.php?page=invoices&amp;action=index">Volver a facturas</a></p>

    <form method="get" action="index.php" class="d-flex flex-wrap gap-2 align-items-end mb-4">
        <input type="hidden" name="page" value="invoices">
        <input type="hidden" name="action" value="by-client">
        <label>Año <input type="number" name="year" min="2000" max="2100" value="<?= $year ?>" class="form-control" required></label>
        <label>Mes
            <select name="month" class="form-select">
                <option value="">Todo el año</option>
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>" <?= $month === $m ? 'selected' : '' ?>><?= sprintf('%02d', $m) ?></option>
                <?php endfor; ?>
            </select>
        </label>
        <label>Cliente
            <select name="client_id" class="form-select">
                <option value="">Todos los clientes (A–Z)</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= (int) $client['id'] ?>" <?= $selectedClientId === (int) $client['id'] ? 'selected' : '' ?>><?= htmlspecialchars((string) $client['name'], ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit" class="btn btn-primary">Ver facturas</button>
    </form>

    <p><strong>Total del período <?= htmlspecialchars($periodLabel, ENT_QUOTES, 'UTF-8') ?> (todos):</strong> <?= $money($periodTotalCents) ?></p>
    <?php if ($selectedClientId !== null): ?>
        <p><strong>Total del cliente en el período:</strong> <?= $money($selectedTotalCents) ?></p>
    <?php endif; ?>
    <p><strong>Total anual <?= $year ?> del reporte de facturas:</strong> <?= $money($annualTotalCents) ?></p>
    <?php if ($month === null && $periodTotalCents !== $annualTotalCents): ?>
        <p class="alert alert-warning">Los importes del período y del reporte anual difieren en <?= $money(abs($periodTotalCents - $annualTotalCents)) ?>. Revisa los datos de las facturas.</p>
    <?php endif; ?>

    <?php if (!$groups): ?><p>No hay facturas para esta selección.</p><?php endif; ?>
    <?php foreach ($groups as $group): ?>
        <section class="mb-4">
            <h2><?= htmlspecialchars((string) $group['name'], ENT_QUOTES, 'UTF-8') ?></h2>
            <div class="table-responsive"><table class="table table-striped">
                <thead><tr><th>Factura</th><th>Cotización</th><th>Fecha</th><th class="text-end">Importe</th></tr></thead>
                <tbody>
                    <?php foreach ($group['invoices'] as $invoice): ?>
                        <tr>
                            <td><a href="index.php?page=invoices&amp;action=show&amp;id=<?= (int) $invoice['id'] ?>"><?= (int) $invoice['id'] ?></a></td>
                            <td><a href="index.php?page=quotes&amp;action=show&amp;id=<?= (int) $invoice['quote_id'] ?>"><?= (int) $invoice['quote_id'] ?></a></td>
                            <td><?= htmlspecialchars(substr((string) $invoice['created_at'], 0, 10), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-end"><?= $money($invoice['amount_cents']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot><tr><th colspan="3">Total <?= htmlspecialchars((string) $group['name'], ENT_QUOTES, 'UTF-8') ?></th><th class="text-end"><?= $money($group['total_cents']) ?></th></tr></tfoot>
            </table></div>
        </section>
    <?php endforeach; ?>
</main>
