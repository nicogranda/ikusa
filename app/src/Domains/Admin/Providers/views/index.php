<main class="container py-4">
    <h1>Proveedores</h1>
    <?php if (!$providers): ?>
        <p>No hay proveedores registrados.</p>
    <?php else: ?>
        <div class="table-responsive"><table class="table table-striped"><thead><tr>
            <?php foreach (array_keys($providers[0]) as $column): ?>
                <th><?= htmlspecialchars($column, ENT_QUOTES, 'UTF-8') ?></th>
            <?php endforeach; ?>
        </tr></thead><tbody>
            <?php foreach ($providers as $provider): ?><tr>
                <?php foreach ($provider as $value): ?>
                    <td><?= htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                <?php endforeach; ?>
            </tr><?php endforeach; ?>
        </tbody></table></div>
    <?php endif; ?>
</main>
