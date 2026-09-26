<!-- Formulario -->
<!-- Formulario -->
<section class="container-form">
    <form name="form1" method="post" action="index.php?page=quotes&action=create" accept-charset="UTF-8" onsubmit="return validateForm();" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" name="name" id="name" placeholder="Name" class="input-field">
            <span id="nameError" class="error-message" style="display:none;">Please fill in the Name field</span>
        </div>

        <div class="form-group">
            <input type="text" name="unit" id="unit" placeholder="Unit" class="input-field">
            <span id="unitError" class="error-message">Please fill in the Unit field</span>
        </div>

        <div class="form-group">
            <input type="number" name="unit_value" id="unitValue" placeholder="Unit Value" class="input-field">
            <span id="unitValueError" class="error-message">Please fill in the Unit Value field</span>
        </div>

        <div class="form-group">
            <input type="text" name="category_id" id="categoryId" placeholder="Category ID" class="input-field">
            <span id="categoryError" class="error-message">Please fill in the Category ID field</span>
        </div>

        <div class="form-group">
            <input type="number" name="vat_rate" id="vatRate" placeholder="VAT Rate" class="input-field">
            <span id="vatRateError" class="error-message">Please fill in the VAT Rate field</span>
        </div>



        <div class="form-group">
            <label>Installation:</label>
            <div class="radio-group">
                <input type="radio" name="installation" value="Yes"> Yes
                <input type="radio" name="installation" value="No"> No
            </div>
        </div>

        <div class="form-group">
            <label>Shipment:</label>
            <div class="radio-group">
                <input type="radio" name="shipment" value="Yes" onclick="toggleShipment(true)"> Yes
                <input type="radio" name="shipment" value="No" onclick="toggleShipment(false)"> No
            </div>
        </div>

        <div id="shipmentFields" style="display:none;">
            <div class="form-group">
                <input type="number" name="width" id="width" placeholder="Width" class="input-field">
            </div>
            <div class="form-group">
                <input type="number" name="height" id="height" placeholder="Height" class="input-field">
            </div>
            <div class="form-group">
                <input type="number" name="long" id="long" placeholder="Long" class="input-field">
            </div>
            <div class="form-group">
                <input type="number" name="weight" id="weight" placeholder="Weight" class="input-field">
            </div>
        </div>

               <div class="form-group" style="display:none;">
            <input type="datetime-local" name="created_at" id="createdAt" class="input-field">
        </div>

        <div class="form-group" style="display:none;">
            <input type="datetime-local" name="updated_at" id="updatedAt" class="input-field">
        </div>

        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo" accept="image/*" class="input-field" onchange="updatePhotoPath()">
            <input type="text" name="photo_path" id="photoPath" placeholder="Image Path" class="input-field" readonly>
        </div>

        <input type="submit" value="Submit" class='button-primary'>
    </form>
</section>
<form action="save_dimension.php" method="POST" enctype="multipart/form-data">
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Dimension Type</th>
                <th>Width</th>
                <th>Height</th>
                <th>Length</th>
                <th>Weight</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="dimension_type" required>
                        <option value="volume">Volume</option>
                        <option value="area">Area</option>
                    </select>
                </td>
                <td><input type="number" name="width" step="0.01" placeholder="Width" required></td>
                <td><input type="number" name="height" step="0.01" placeholder="Height" required></td>
                <td><input type="number" name="length" step="0.01" placeholder="Length"></td>
                <td><input type="number" name="weight" step="0.01" placeholder="Weight"></td>
                <td>
                    <input type="file" name="photo" accept="image/*">
                    <input type="text" name="photo_path" placeholder="Image Path" readonly>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 10px; text-align: center;">
        <button type="submit" style="padding: 8px 16px; background: var(--color-primary, #F15A24); color: #fff; border: none; border-radius: 5px; cursor: pointer;">Guardar</button>
    </div>
</form>


<script>
    function toggleShipment(show) {
        document.getElementById('shipmentFields').style.display = show ? 'block' : 'none';
    }
</script>




<script>

function validateForm() {
    let isValid = true;

    // Obtener elementos
    const alias = document.getElementById('alias');
    const businessName = document.getElementById('businessName');
    const email = document.getElementById('email');
    const itemError = document.getElementById('itemError');
    const aliasError = document.getElementById('brandError');
    const businessError = document.getElementById('businessError');
    const emailError = document.getElementById('emailError');

    // Validar campos vacíos
    if (alias.value.trim() === '') {
        aliasError.style.display = 'block';
        isValid = false;
    } else {
        aliasError.style.display = 'none';
    }

    if (businessName.value.trim() === '') {
        businessError.style.display = 'block';
        isValid = false;
    } else {
        businessError.style.display = 'none';
    }

    if (email.value.trim() === '') {
        emailError.style.display = 'block';
        isValid = false;
    } else {
        emailError.style.display = 'none';
    }

    // Validar formato de email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value.trim())) {
        emailError.style.display = 'block';
        isValid = false;
    } else {
        emailError.style.display = 'none';
    }

    // Validar los ítems seleccionados
    const selectedItems = document.querySelectorAll('#selectedItems input[name*="product_name"]');
    if (selectedItems.length === 0) {
        itemError.style.display = 'block';
        isValid = false;
    } else {
        itemError.style.display = 'none';
    }

    return isValid;
}


</script>
<style>


    /*Form*/
     .form-group {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 500px;
        margin-bottom: 15px;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .error-message {
        color: red;
        font-size: 12px;
        display: none;
    }
    
    .radio-group {
        display: flex;
        gap: 10px;
    }
</style>

