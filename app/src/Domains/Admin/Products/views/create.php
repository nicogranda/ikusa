<!-- Incluye Dropzone -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<main class="container-form">

<form id="productForm" method="POST" action="" enctype="multipart/form-data">
  
  <!-- IDENTIFICACIÓN DEL PRODUCTO -->
  <fieldset>
    <legend>Identificación del Producto</legend>
    <input type="hidden" name="language" value="EN">
    
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required class="input-field"><br>
    
    <!-- Categoría -->
    <label for="category_id">Categoría:</label>
    <select id="category_id" name="category_id" required class="input-field">
      <option value="">Selecciona una categoría</option>
      <?php foreach($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
      <?php endforeach; ?>
    </select><br>
    
    <!-- Unidad -->
    <label for="unit">Unidad:</label>
    <input type="text" id="unit" name="unit" value="pza" required class="input-field"><br>

    <label for="sku">SKU:</label>
    <input type="text" id="sku" name="sku" required class="input-field"><br>
    
    <label for="description">Descripción:</label>
    <textarea id="description" name="description" class="input-field"></textarea><br>
  </fieldset>

<fieldset>
  <legend>Variantes</legend>
  <div id="variantsContainer" class="variants-flex">

    <div class="variant">
      <!-- SKU de la variante -->
      <input type="text" name="variants[0][sku]" placeholder="SKU" required>

      <!-- Precio -->
      <input type="number" name="variants[0][price]" placeholder="Precio" step="0.01" required>

      <!-- Stock -->
      <input type="number" name="variants[0][stock]" placeholder="Cantidad en inventario" required>

      <!-- Peso -->
      <input type="number" name="variants[0][weight]" placeholder="Peso" step="0.01">

      <!-- Imagen -->
      <input type="text" name="variants[0][image_url]" placeholder="URL de imagen">

      <!-- Activo -->
      <select name="variants[0][is_active]">
        <option value="1" selected>Activo</option>
        <option value="0">Inactivo</option>
      </select>

      <!-- Atributos dinámicos -->
      <div class="variant-attributes">
        <div class="attribute">
          <input type="text" name="variants[0][attributes][0][atributo]" placeholder="Atributo (ej: color)" required>
          <input type="text" name="variants[0][attributes][0][atributo_valor]" placeholder="Valor (ej: Rojo)" required>
          <button type="button" class="removeAttribute"><i class="fas fa-trash"></i></button>
        </div>
      </div>

      <!-- Botón agregar atributo -->
      <button type="button" class="addAttribute">Agregar Atributo</button>

      <!-- Botón eliminar variante -->
      <button type="button" class="removeVariant"><i class="fas fa-trash"></i></button>
    </div>

  </div>

  <!-- Botón agregar variante -->
  <button type="button" id="addVariant" class="add-btn"><i class="fas fa-plus"></i> Agregar Variante</button>
</fieldset>


  <!-- DIMENSIONES -->
<!--<fieldset>-->
<!--  <legend>Dimensiones</legend>-->
<!--  <div class="dimensions-flex">-->
<!--    <input type="number" id="weight" name="weight" step="0.01" placeholder="Peso (kg)" required>-->
<!--    <input type="number" id="length" name="length" step="0.1" placeholder="Largo (cm)" required>-->
<!--    <input type="number" id="width" name="width" step="0.1" placeholder="Ancho (cm)" required>-->
<!--    <input type="number" id="height" name="height" step="0.1" placeholder="Alto (cm)" required>-->
<!--  </div>-->
<!--</fieldset>-->




  <!-- DROPZONE PARA IMÁGENES -->
  <fieldset>
    <legend>Imágenes</legend>
    <div id="dropzone" class="dropzone"></div>
  </fieldset>

  <button type="submit" class="btn-submit">Crear Producto</button>
</form>

</main>

<style>
  .variants-flex {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: center;
	align-items: center;
	align-content: space-evenly;
	gap: 10px;
}

  .variant {
    display: flex;
    gap: 10px;
    align-items: center;
  }

  .variant input {
    padding: 5px;
    width: 130px;
    /*min-width: 100px;*/
  }

  .variant button {
    background-color: #e74c3c;
    border: none;
    color: white;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    height: 36px;
  }

  .add-btn {
    background-color: #2ecc71;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    height: 36px;
  }
</style>

<style>
  .dimensions-flex {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
  }

  .dimensions-flex input {
    padding: 5px;
    width: 120px; /* tamaño uniforme */
  }
</style>

<script>
let variantIndex = 1;

document.getElementById('addVariant').addEventListener('click', () => {
  const container = document.getElementById('variantsContainer');
  const div = document.createElement('div');
  div.classList.add('variant');
  div.innerHTML = `
    <input type="text" name="variants[${variantIndex}][color]" placeholder="Color" required>
    <input type="text" name="variants[${variantIndex}][size]" placeholder="Talla" required>
    <input type="number" name="variants[${variantIndex}][price]" placeholder="Precio" step="0.01" required>
    <input type="number" name="variants[${variantIndex}][stock]" placeholder="Cantidad en inventario" required>
    <button type="button" class="removeVariant"><i class="fas fa-trash"></i></button>
  `;
  // Insertar antes del botón "Agregar" para que este siempre quede al final
  container.insertBefore(div, document.getElementById('addVariant'));
  variantIndex++;
});

document.getElementById('variantsContainer').addEventListener('click', e => {
  if(e.target.closest('.removeVariant')) {
    e.target.closest('.variant').remove();
  }
});
</script>
<script>
document.getElementById('variantsContainer').addEventListener('click', e => {
  if(e.target.classList.contains('removeVariant')) {
    e.target.parentElement.remove();
  }
});

</script>
<script>
    Dropzone.autoDiscover = false;

const myDropzone = new Dropzone("#dropzone", {
  url: "index.php?page=products&action=upload",
  paramName: "file",
  maxFilesize: 5, // MB
  acceptedFiles: "image/*",
  addRemoveLinks: true,
  dictRemoveFile: "Eliminar",
  init: function() {
    this.on("thumbnail", function(file) {
      // Reducir tamaño (puede variar según navegador)
      const reader = new FileReader();
      reader.onload = function(event) {
        const img = new Image();
        img.src = event.target.result;
        img.onload = () => {
          const canvas = document.createElement("canvas");
          const ctx = canvas.getContext("2d");
          const maxDim = 1024;
          let width = img.width;
          let height = img.height;

          if(width > height) {
            if(width > maxDim) { height *= maxDim / width; width = maxDim; }
          } else {
            if(height > maxDim) { width *= maxDim / height; height = maxDim; }
          }

          canvas.width = width;
          canvas.height = height;
          ctx.drawImage(img, 0, 0, width, height);
          canvas.toBlob(blob => {
            file.upload = { blob };
          }, "image/jpeg", 0.8);
        };
      };
      reader.readAsDataURL(file);
    });
  },
  renameFile: function(file) {
    const ext = file.name.split('.').pop();
    const shortName = Math.random().toString(36).substring(2,10);
    return `${shortName}.${ext}`;
  }
});

</script>