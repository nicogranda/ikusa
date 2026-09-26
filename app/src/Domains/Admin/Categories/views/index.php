<main class="container py-4">
    <h1>Categorías</h1>
    <p><a href="index.php?page=categories&action=create">Crear categoría</a></p>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                <form method="post" action="index.php?page=categories&action=delete&id=<?= (int) $category['id'] ?>" style="display:inline">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
