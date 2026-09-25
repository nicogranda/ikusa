<form action="" method="POST" class="container-form">
    <input type="hidden" name="quote_id" value="<?php echo $_GET['id']; ?>">

    <label for="category_id">Category:</label>
    <select name="category_id" id="category_id" onchange="loadProducts(this.value)">
        <?php foreach($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
    
    <label for="product_id">Producto:</label>
    <select name="product_id" id="product_id" onchange="loadProductDetails(this.value)">
        <option value="">Selecciona un producto</option>
    </select>

<label for="quantity">Cantidad:</label>
<input type="number" name="quantity" id="quantity" value="1" required>

<label for="unit_value">Valor Unitario (€):</label>
<input type="number" name="unit_value" id="unit_value" step="0.01" required>

<label for="discount">Descuento:</label>
<input type="number" name="discount" id="discount" step="0.01">

<label for="vat_rate">Tasa de IVA:</label>
<input type="number" name="vat_rate" id="vat_rate" step="0.01" required>

    <label for="note">Nota:</label>
    <textarea name="note" id="note"></textarea>

    <button type="submit" name="action" value="create">Agregar Detalle</button>
</form>

<script>
function loadProducts(categoryId) {
    const productSelect = document.getElementById('product_id');
    productSelect.innerHTML = '<option value="">Cargando...</option>';

    fetch(`getProductsByCategory.php?category_id=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            productSelect.innerHTML = '<option value="">Selecciona un producto</option>';
            data.forEach(product => {
                productSelect.innerHTML += `<option value="${product.id}">${product.name}</option>`;
            });
        })
        .catch(() => {
            productSelect.innerHTML = '<option value="">Error al cargar productos</option>';
        });
}

function loadProductDetails(productId) {
    if (!productId) return;

    fetch(`getProductDetails.php?product_id=${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('unit_value').value = data.unit_value || 0;
            // document.getElementById('quantity').value = data.quantity || 1;
            // document.getElementById('discount').value = data.discount || 0;
            document.getElementById('vat_rate').value = data.vat_rate || 0;
        })
        .catch(() => {
            alert('Error al cargar los detalles del producto');
        });
}
</script>

<style>
.container-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 700px;
    margin: 0 auto;
}

.form-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.form-group {
    display: flex;
    flex-direction: column;
    flex: 1 1 200px; /* Crece y se ajusta */
}

.full-width {
    flex: 1 1 100%;
}

input, select, textarea, button {
    padding: 8px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: orangered;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #e04e1c;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }
}
</style>
