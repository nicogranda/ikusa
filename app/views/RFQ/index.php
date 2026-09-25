<head>
    <meta charset="UTF-8">
    
    <title>Cotización de servicios y productos Publicitarios | Ikusa</title>
    
    <meta name="description" content="Diseño Gráfico, Community Manager, Desarrollo Web y posicionamiento SEO en Donostia San Sebastián.Cotización de servicios y productos Publicitarios ">
      
    <meta name="keywords" content="diseño web, posicionamiento web Donostia, posicionamiento web san sebastian, seo san sebastian, seo donostia, diseño web donostia,  diseño web y seo, marketing digital donostia, marketing digital san sebastian, diseño gráfico, community manager ">

    <link rel="canonical" href="https://ikusa.net/quote">

    <style>

.error-message {
    color: red;
    display: none;
}

.table-header-request {
    display: flex;
    align-items: center;
}

.request-option {
    width: 20%;
    text-align: center;
}

.briefing {
    font-family: Arial, sans-serif;
}

.table-container-request {
    width: 100%;
    /*border: 1px solid #ddd;*/
}

.table-header-request, .table-row {
    display: flex;
    align-items: center;
    padding: 10px;
    /*border-bottom: 1px solid #ddd;*/
}

.table-header-request {
    background-color: #f5f5f5;
    font-weight: bold;
}

.request-product-title, .request-product-name {
    width: 60%;
}

.request-option {
    width: 20%;
    text-align: center;
}

.request-option input[type="radio"] {
    margin: 0;
    vertical-align: middle;
}

/* Ajustes de márgenes para h3 */
.briefing h3 {
    margin-top: 20px;
    font-size: 1.1em;
    color: #333;
}


    </style>

</head>

<section style="margin: 0 auto; width:30%;">
    <h1 class="principal">¿Cuánto cuesta una agencia de marketing digital?</h1>
    
    <article style="text-align:left;">
        <h2>¿Cuánto cuesta el servicio de un Community Manager?</h2>
        <h2>¿Cuánto cuesta el servicio de SEO?</h2>
        <h2>¿Cuánto cuesta hacer un pagina web?</h2>
        <h2>¿Cuánto cobra un community manager?</h2>
    </article>
    
<form name="form1" method="post" action="index.php?page=Email" accept-charset="UTF-8" onsubmit="return validateForm();">
    <div class="visual"></div>
    <input type="text" name="brand" id="brand" placeholder="Nombre de tu marca" class="client-data">
    <span id="brandError" class="error-message">Please fill in the Brand field</span>

    <input type="text" name="client" id="client" placeholder="Nombre y Apellidos o Razón Social" class="client-data">
    <span id="clientError" class="error-message">Please fill in the Business/Name field</span>

    <input type="email" name="email" id="email" placeholder="tu E-mail" class="client-data">
    <span id="emailError" class="error-message">Please fill in a valid E-mail</span>

    <input type="hidden" name="business_type_id" id="business_type_id">



<select name="business_type" id="business_type" onchange="business_type_add();" class="client-data">
    <option value="Choose">Dinos que comercializas o promueves</option>
    <?php foreach ($business_types as $business_type): ?>
        <option value="<?php echo htmlspecialchars($business_type['id']); ?>">
            <?php echo htmlspecialchars($business_type['name']); ?>
        </option>
    <?php endforeach; ?>
</select>

<span id="businessTypeError" class="error-message">Please select a Business Type</span>

   <h2>Available Products/Services</h2>

<!-- Bucle para mostrar las categorías -->
<?php foreach ($categories_require as $categoryId => $categoryName): ?>
    <div class="category">
        <input type="checkbox" id="category_<?php echo $categoryId; ?>" class="category-checkbox">
        <label for="category_<?php echo $categoryId; ?>"><?php echo htmlspecialchars($categoryName); ?></label>
        
        <div class="products" id="products_<?php echo $categoryId; ?>" style="display: none;">
            <!-- Verificar si hay productos para esta categoría -->
            <?php if (isset($products_require[$categoryId])): ?>
                <?php foreach ($products_require[$categoryId] as $product): ?>
                    <div class="line">
                        <label class="product-checkbox">
                            <!-- Formulario para seleccionar productos con ID único y cantidad -->
                            <input 
                                type="checkbox" 
                                name="products[<?php echo $product['id']; ?>][id]" 
                                value="<?php echo $product['id']; ?>" 
                                class="product-selection">
                            <?php echo htmlspecialchars($product['name']); ?>
                            
                            <!-- Campo de cantidad (se puede ocultar si no se necesita) -->
                            <input 
                                type="number" 
                                name="products[<?php echo $product['id']; ?>][quantity]" 
                                value="1" 
                                min="1" 
                                class="product-quantity">
                            
                            <!-- Valor unitario, si es necesario mostrarlo -->
                            <input 
                                type="hidden" 
                                name="products[<?php echo $product['id']; ?>][unit_value]" 
                                value="<?php echo $product['unit_value']; ?>"
                                class="product-unit-value">
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>


    <span id="productError" class="error-message">Please select at least one product</span>

<article class="briefing">
    <h2>Briefing: ¿Cuáles recursos comunicacionales tiene?</h2>
    <div class="table-container-request">
        <div class="table-header-request">
            <span class="request-product-title">Product Name</span>
            <span class="request-option">Yes</span>
            <span class="request-option">No</span>
        </div>

        <?php foreach ($categories_briefing as $category): ?>
            <?php foreach ($products_briefing as $product): ?>
                <?php if ($product['category_id'] == $category['id']): ?>
                    <div class="table-row">
                        <span class="request-product-name"><?php echo htmlspecialchars($product['name']); ?></span>
                        
                        <!-- Input para "Yes" -->
                        <label class="request-option" for="product_<?php echo $product['id']; ?>_yes">
                            <input type="radio" id="product_<?php echo $product['id']; ?>_yes" name="product_<?php echo $product['id']; ?>" value="yes" 
                            <?php echo isset($_POST['product_' . $product['id']]) && $_POST['product_' . $product['id']] === 'yes' ? 'checked' : ''; ?> class="request-option">
                        </label>

                        <!-- Input para "No" -->
                        <label class="request-option" for="product_<?php echo $product['id']; ?>_no">
                            <input type="radio" id="product_<?php echo $product['id']; ?>_no" name="product_<?php echo $product['id']; ?>" value="no" 
                            <?php echo isset($_POST['product_' . $product['id']]) && $_POST['product_' . $product['id']] === 'no' ? 'checked' : ''; ?> class="request-option">
                        </label>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </div>
</article>

    
 
        <input type="submit" value="Submit" class='button-send'>
    
</form>

</section>


<script>
function search(){
    var brand = document.getElementById('brand').value;
    window.open('search_brand.php?brand=' + brand, '_blank');
}

function business_type_add() {
    var select = document.getElementById('business_type');
    var businessTypeIdInput = document.getElementById('business_type_id');
    
    // Obtener el valor seleccionado del select
    var selectedBusinessTypeId = select.value;
    
    // Asignar el valor al campo oculto business_type_id
    businessTypeIdInput.value = selectedBusinessTypeId;
}

function validateForm() {
    var isValid = true;

    // Limpiar mensajes de error previos
    document.querySelectorAll('.error-message').forEach(function (error) {
        error.style.display = 'none';
    });

    // Validación de Brand
    var brand = document.getElementById('brand').value;
    if (brand === "") {
        document.getElementById('brandError').style.display = 'block';
        isValid = false;
    }

    // Validación de Business/Name
    var client = document.getElementById('client').value;
    if (client === "") {
        document.getElementById('clientError').style.display = 'block';
        isValid = false;
    }

    // Validación de Email
    var email = document.getElementById('email').value;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email === "" || !emailPattern.test(email)) {
        document.getElementById('emailError').style.display = 'block';
        isValid = false;
    }

    // Validación de Business Type
    var businessType = document.getElementById('business_type').value;
    if (businessType === 'Choose') {
        document.getElementById('businessTypeError').style.display = 'block';
        isValid = false;
    }

    // Validación de selección de al menos un producto
    var selectedProducts = document.querySelectorAll('.product-selection:checked');
    if (selectedProducts.length === 0) {
        document.getElementById('productError').style.display = 'block';
        isValid = false;
    }

    return isValid;
}

// Mostrar/ocultar productos
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.category-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const productsDiv = document.getElementById('products_' + this.id.split('_')[1]);

            if (this.checked) {
                productsDiv.style.display = 'block';
            } else {
                productsDiv.style.display = 'none';
            }
        });
    });
});


</script>
