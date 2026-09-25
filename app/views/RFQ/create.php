<?php
// ==================================================
// I18N — ES / EN
// Más adelante esto se moverá a un Model/Controller
// (ej. Domains/Contact o un helper de traducciones compartido)
// ==================================================

$i18n = [
    'es' => [
        'title'                 => 'Solicita tu presupuesto',
        'identification'        => 'Identificación/Log Up',
        'placeholder_brand'     => 'Nombre de la marca',
        'placeholder_business'  => 'Nombre de Persona Jurídica ó Persona Física',
        'placeholder_email'     => 'E-mail',
        'error_brand'           => 'Por favor completa el campo Marca',
        'error_business'        => 'Por favor completa el campo Nombre/Empresa',
        'error_email'           => 'Por favor introduce un E-mail válido',
        'briefing_title'        => 'Briefing: ¿Qué recursos tienes?',
        'asset_column'          => 'Activo de Marketing',
        'yes'                   => 'Sí',
        'no'                    => 'No',
        'products_title'        => 'Indica que Productos/Servicios requieres',
        'no_products'           => 'No hay productos disponibles en esta categoría.',
        'domain_title'          => 'Dominio web',
        'domain_copy'           => 'Si necesitas registrar un dominio nuevo para tu proyecto web, indícanos el nombre tentativo.',
        'placeholder_domain'    => 'Ejemplo: miempresa.com',
        'error_product'         => 'Por favor selecciona al menos un producto',
        'captcha_error'         => 'Confirma que no eres un robot',
        'submit'                => 'Enviar',
        'js_alert_briefing'     => 'Por favor selecciona Sí o No para cada elemento del briefing.',
        'action_url'            => 'index.php?page=contact&action=create&lang=es',
    ],
    'en' => [
        'title'                 => 'Request a quote',
        'identification'        => 'Identification/Sign Up',
        'placeholder_brand'     => 'Brand name',
        'placeholder_business'  => 'Legal entity or individual name',
        'placeholder_email'     => 'E-mail',
        'error_brand'           => 'Please fill in the Brand field',
        'error_business'        => 'Please fill in the Business/Name field',
        'error_email'           => 'Please fill in a valid E-mail',
        'briefing_title'        => 'Briefing: What resources do you have?',
        'asset_column'          => 'Marketing Asset',
        'yes'                   => 'Yes',
        'no'                    => 'No',
        'products_title'        => 'Select the Products/Services you need',
        'no_products'           => 'No products available in this category.',
        'domain_title'          => 'Web Domain',
        'domain_copy'           => 'If you need to register a new domain for your web project, let us know the tentative name.',
        'placeholder_domain'    => 'Example: mycompany.com',
        'error_product'         => 'Please select at least one product',
        'captcha_error'         => 'Please confirm you are not a robot',
        'submit'                => 'Submit',
        'js_alert_briefing'     => 'Please select Yes or No for each briefing item.',
        'action_url'            => 'index.php?page=contact&action=create&lang=en',
    ],
];

// Fallback a 'es' si $lang no llega o no existe en el array
$lang = isset($lang) && isset($i18n[$lang]) ? $lang : 'es';
$t    = $i18n[$lang];
?>
<main class="container">
<section class="container-form">
    <h1 class="principal"><?= htmlspecialchars($t['title']); ?></h1>

    <form
        name="RFQs"
        method="post"
        action="<?= htmlspecialchars($t['action_url']); ?>"
        accept-charset="UTF-8"
        onsubmit="return validateForm();"
    >
        <article class="client-id">
            <h2 style='font-size: 24px; padding: 20px 0;'><?= htmlspecialchars($t['identification']); ?></h2>

            <input type="text" name="alias" id="alias" placeholder="<?= htmlspecialchars($t['placeholder_brand']); ?>" class="client-data">
            <span id="brandError" class="error-message"><?= htmlspecialchars($t['error_brand']); ?></span>

            <input type="text" name="business_name" id="client" placeholder="<?= htmlspecialchars($t['placeholder_business']); ?>" class="client-data">
            <span id="clientError" class="error-message"><?= htmlspecialchars($t['error_business']); ?></span>

            <input type="email" name="email" id="email" placeholder="<?= htmlspecialchars($t['placeholder_email']); ?>" class="client-data">
            <span id="emailError" class="error-message"><?= htmlspecialchars($t['error_email']); ?></span>

            <input type="hidden" name="business_type_id" id="business_type_id">
        </article>


        <article class="client-briefing">

            <h2 style='font-size:24px; padding:20px 0;'>
                <?= htmlspecialchars($t['briefing_title']); ?>
            </h2>

            <div class="table-container-request">

                <div class="table-header-request">
                    <span class="request-product-title"><?= htmlspecialchars($t['asset_column']); ?></span>
                    <span class="request-option">
                        <button type="button" class="select-all" data-value="yes">
                            <?= htmlspecialchars($t['yes']); ?>
                        </button>
                    </span>
                    <span class="request-option">
                        <button type="button" class="select-all" data-value="no">
                            <?= htmlspecialchars($t['no']); ?>
                        </button>
                    </span>
                </div>


                <?php foreach ($briefingProducts as $product): ?>

                    <div class="table-row">

                        <span class="request-product-name">
                            <?= htmlspecialchars($product['name']); ?>
                        </span>


                        <label class="request-option">

                            <input
                                type="radio"
                                name="briefing[<?= $product['id']; ?>]"
                                value="yes"
                                class="briefing-radio yes-radio"
                            >

                        </label>


                        <label class="request-option">

                            <input
                                type="radio"
                                name="briefing[<?= $product['id']; ?>]"
                                value="no"
                                class="briefing-radio no-radio"
                            >

                        </label>

                    </div>

                <?php endforeach; ?>

            </div>

        </article>

        <article>
           <h2 style='font-size: 24px; padding: 20px 0;'><?= htmlspecialchars($t['products_title']); ?></h2>
        <!-- Bucle para mostrar las categorías -->
        <?php foreach ($categories as $category): ?>
            <?php if ($category['id'] == 1) continue; // Omitir la categoría con id 1 ?>
            <div class="category">
                <label for="category_<?php echo $category['id']; ?>">
    <input
        type="checkbox"
        id="category_<?php echo $category['id']; ?>"
        class="category-checkbox"
        data-category-name="<?= htmlspecialchars($category['name']); ?>">
    <?php echo htmlspecialchars($category['name']); ?>
</label>



            <?php
                // Obtener el ID de la categoría actual
                $categoryId = $category['id'];
                ?>

                <div class="products" id="products_<?php echo $categoryId; ?>" style="display: none;">
                    <!-- Verificar si hay productos para esta categoría -->
                    <?php if (isset($productsByCategory[$categoryId])): ?>
                        <?php foreach ($productsByCategory[$categoryId] as $product): ?>
                            <div class="line">
                               <label class="product-checkbox">
                                    <input
                                        type="checkbox"
                                        name="item[<?php echo $product['id']; ?>][product_id]"
                                        value="<?php echo $product['id']; ?>"
                                        class="product-selection">
                                    <span class="product-name"><?php echo htmlspecialchars($product['name']); ?></span>

                                    <input type="hidden" name="item[<?php echo $product['id']; ?>][quantity]" value="1" min="1" class="product-quantity">
                                    <input type="hidden" name="item[<?php echo $product['id']; ?>][unit_value]" value="<?php echo $product['unit_value']; ?>" class="product-unit-value">
                                    <input type="hidden" name="item[<?php echo $product['id']; ?>][discount]" value="0.00" class="product-unit-value">
                                    <input type="hidden" name="item[<?php echo $product['id']; ?>][vat_rate]" value="0.00" class="product-unit-value">
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p><?= htmlspecialchars($t['no_products']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div id="domain-request" class="domain-request" style="display:none;">

            <h2 style='font-size:24px; padding:20px 0;'>
                <?= htmlspecialchars($t['domain_title']); ?>
            </h2>

            <p>
                <?= htmlspecialchars($t['domain_copy']); ?>
            </p>

            <input
                type="text"
                name="domain_name"
                id="domain_name"
                placeholder="<?= htmlspecialchars($t['placeholder_domain']); ?>"
                class="client-data"
            >

        </div>

            <span id="productError" class="error-message"><?= htmlspecialchars($t['error_product']); ?></span>

            <!-- RECAPTCHA -->
        <div class="captcha-container" style="margin:20px 0;">
            <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($_ENV['GOOGLE_RECAPTCHA_SITE_KEY'] ?? '') ?>"></div>
            <span id="captchaError" class="error-message" style="display:none;"><?= htmlspecialchars($t['captcha_error']); ?></span>
        </div>

        <input type="submit" value="<?= htmlspecialchars($t['submit']); ?>" class='button-send'>

    </form>

</section>

</main>
<script>

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
    document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');

    // Validación de Brand
    var brand = document.getElementById('alias').value.trim();
    if (brand === "") {
        document.getElementById('brandError').style.display = 'block';
        isValid = false;
    }

    // Validación de Business/Name
    var client = document.getElementById('client').value.trim();
    if (client === "") {
        document.getElementById('clientError').style.display = 'block';
        isValid = false;
    }

    // Validación de Email
    var email = document.getElementById('email').value.trim();
    if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) {
        document.getElementById('emailError').style.display = 'block';
        isValid = false;
    }

    // Validación de productos seleccionados
    var productCheckboxes = document.querySelectorAll('.product-selection:checked');
    if (productCheckboxes.length === 0) {
        document.getElementById('productError').style.display = 'block';
        isValid = false;
    }

    // Validación de briefing (al menos un radio seleccionado)
    var radioGroups = new Set();
    var radios = document.querySelectorAll('.briefing input[type="radio"]');
    radios.forEach(radio => radioGroups.add(radio.name));

    for (let group of radioGroups) {
        if (!document.querySelector(`input[name="${group}"]:checked`)) {
            alert('<?= addslashes($t['js_alert_briefing']); ?>');
            isValid = false;
            break;
        }
    }

    return isValid;
}

document.addEventListener('DOMContentLoaded', function(){

    const buttons = document.querySelectorAll('.select-all');


    buttons.forEach(button => {

        button.addEventListener('click', function(){

            const value = this.dataset.value;


            document
                .querySelectorAll(
                    '.briefing-radio[value="'+value+'"]'
                )
                .forEach(radio => {

                    radio.checked = true;

                });

        });

    });


});

document.addEventListener('DOMContentLoaded', function(){

    const categories = document.querySelectorAll('.category-checkbox');
    const domainBox = document.getElementById('domain-request');

    categories.forEach(category => {

        category.addEventListener('change', function(){

            const name = this.dataset.categoryName.toLowerCase();

            if(
                name.includes('desarrollo') ||
                name.includes('web') ||
                name.includes('development')
            ){
                domainBox.style.display = this.checked
                    ? 'block'
                    : 'none';
            }

        });

    });

});

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

<style>
    :root {
    --ikusa-orange: #FF2400;
    --ikusa-orange-hover: #e02000;
}

/* ==================================================
   BOTONES "SELECT ALL" (Sí / No arriba de la tabla)
   ================================================== */
.select-all {
    background-color: transparent;
    border: 2px solid var(--ikusa-orange);
    color: var(--ikusa-orange);
    padding: 6px 18px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.select-all:hover {
    background-color: var(--ikusa-orange);
    color: #fff;
}

.select-all:active {
    background-color: var(--ikusa-orange-hover);
    border-color: var(--ikusa-orange-hover);
}

/* Estado "activo" opcional, si luego quieres marcar
   cuál de los dos (Sí/No) fue el último presionado */
.select-all.is-active {
    background-color: var(--ikusa-orange);
    color: #fff;
}


/* ==================================================
   RADIOS individuales Sí/No por fila (briefing-radio)
   Estilo tipo "pill" que se pone naranja al marcar
   ================================================== */
.request-option {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.briefing-radio {
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #ccc;
    border-radius: 50%;
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease;
}

.briefing-radio:hover {
    border-color: var(--ikusa-orange);
}

.briefing-radio:checked {
    border-color: var(--ikusa-orange);
    background-color: var(--ikusa-orange);
    box-shadow: inset 0 0 0 3px #fff;
}

.briefing-radio:focus-visible {
    outline: 2px solid var(--ikusa-orange);
    outline-offset: 2px;
}
</style>