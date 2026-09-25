<?php if (!empty($collections) && is_array($collections)): ?>
    <h3>Payments Made</h3>

    <table class="collection-table">
        <thead>
            <tr>
                <th class="col-index">#</th>
                <th class="col-date">Payment Date</th>
                <th class="col-bank">Bank</th>
                <th>Payment Method</th>
                <th>Transaction Number</th>
                <th class="col-amount">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($collections as $index => $payment): ?>
                <tr>
                    <td class="col-index"><?= $index + 1 ?></td>
                    <td class="col-date">
                        <?= htmlspecialchars($payment['payment_date'] ?? '-') ?>
                    </td>
                    <td class="col-bank">
                        <?= htmlspecialchars($payment['bank_name'] ?? '-') ?>
                    </td>
                    <td><?= htmlspecialchars($payment['payment_method'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($payment['transaction_number'] ?? '-') ?></td>
                    <td class="col-amount">
                        <?= number_format($payment['amount'] ?? 0, 2) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>No payments have been recorded for this quotation.</p>
<?php endif; ?>

<style>
.collection-table {
    margin: 0 auto;
    border-collapse: collapse;
    width: 90%;
    table-layout: fixed;
}

/* Column sizing */
.col-index {
    width: 5%;
    text-align: center;
    
}

.col-date {
    width: 15%;
    white-space: nowrap;
}

.col-bank {
    width: 20%;
}

.col-method {
    width: 15%;
}

.col-transaction {
    width: 25%;
}

.col-amount {
    width: 10%;
    text-align: right;
    white-space: nowrap;
}

/* Safety net */
.collection-table th,
.collection-table td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

</style>