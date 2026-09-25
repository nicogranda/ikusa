<style>
.fa-square {
    font-style: normal; /* Evita que se muestre inclinado */
    /*margin-right: 8px;  Espaciado */
    color: var(--color-primary, #F15A24); /* Color naranja */
    width: 50px;
    height:50px;
}

.grid-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1rem;
  grid-auto-flow: dense;
  width: 80%;
  margin: 0 auto;
}

.grid-gallery__item {
  display: flex;
  justify-content: center;
  align-items: center;
  /* background: #f5f5f5; Fondo para imágenes con transparencias */
}

.grid-gallery__image {
  width: 100%;
  height: auto; /* Mantiene la proporción */
  object-fit: contain; /* Muestra la imagen completa sin recortar */
  /*border-radius: 15px;  Esquinas redondeadas */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra alrededor de la imagen */
  transition: box-shadow 0.3s ease; /* Efecto de transición suave al pasar el ratón */
}

/* Efecto al pasar el ratón (hover) */
.grid-gallery__image:hover {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Sombra más intensa cuando pasa el ratón */
}

/* Ajuste de tamaño según la orientación */
.grid-gallery__item[data-orientation="horizontal"] {
  grid-column: span 2;
}

.grid-gallery__item[data-orientation="vertical"] {
  grid-row: span 1; /* Se redujo la altura */
}

.grid-gallery__item[data-orientation="large"] {
  grid-column: span 2;
  grid-row: span 2;
}
</style>
</head>

<?php 
    $dir = "images/portfolio/brochures";
    $images = [];

    if ($handle = @opendir($dir)) {
        while ($file = readdir($handle)) {
            // Excluir directorios y solo agregar archivos
            if ($file != "." && $file != ".." && is_file("$dir/$file")) {
                $images[] = [
                    "filename" => pathinfo($file, PATHINFO_FILENAME),
                    "route" => "$dir/$file"
                ];
            }
        }
        closedir($handle);
    }

    // Ordenar alfabéticamente por el nombre del archivo
    usort($images, function($a, $b) {
        return strcmp($a['filename'], $b['filename']);
    });
?>


<div class="gallery">   
    <div class="grid-gallery">
        <?php foreach ($images as $image): ?>
            <div class="grid-gallery__item">
                <img class="grid-gallery__image" 
                     src="<?= $image['route'] ?>" 
                     alt="<?= $image['filename'] ?>" 
                     title="<?= $image['filename'] ?>"
                     data-reverse="<?= (file_exists($dir . '/reverso/' . pathinfo($image['route'], PATHINFO_FILENAME) . '.' . pathinfo($image['route'], PATHINFO_EXTENSION))) ? $dir . '/reverso/' . pathinfo($image['route'], PATHINFO_FILENAME) . '.' . pathinfo($image['route'], PATHINFO_EXTENSION) : '' ?>" />
            </div>
        <?php endforeach; ?>
    </div>
</div>



    <h1 class='principal'>Brochure</h1>  	
       <div class="introduces" style="display:flex;gap:15px;color: var(--color-primary);">
            <h2 class="secondary"><i class="fa-solid fa-square-full" style="color: #F15A24;"></i> Flyers</h2>
            <h2 class="secondary"><i class="fa-solid fa-square-full" style="color: #F15A24;"></i> Dípticos</h2>
            <h2 class="secondary"><i class="fa-solid fa-square-full" style="color: #F15A24;"></i> Trípticos</h2>
            <h2 class="secondary"><i class="fa-solid fa-square-full" style="color: #F15A24;"></i> Afiches</h2>
        </div>
    <p class="introduces" style="padding: 0 0 20px 0;">
     

Nuestra reciente colección brochure, carnets, tarjetas de agradecimiento y gift cards, diseñadas en un formato estándar de 8.5 cm x 5.5 cm. Cada diseño combina creatividad y funcionalidad para destacar tu marca con un estilo único y profesional.
    </p>
    
<?php include "../app/views/components/services.php";?>    
<script>   
    document.querySelectorAll(".grid-gallery__image").forEach(img => {
  img.onload = function () {
    let parent = img.parentElement;
    if (img.naturalWidth > img.naturalHeight) {
      parent.setAttribute("data-orientation", "horizontal");
    } else if (img.naturalHeight > img.naturalWidth) {
      parent.setAttribute("data-orientation", "vertical");
    } else {
      parent.setAttribute("data-orientation", "large");
    }
  };
});

document.querySelectorAll(".grid-gallery__image").forEach(img => {
  // Guardar la ruta original al cargar la imagen
  const originalSrc = img.getAttribute('src');
  
  // Solo añadir el evento si hay reverso
  const reverseSrc = img.getAttribute('data-reverse');
  if (reverseSrc) {
    // Función para cambiar a la imagen de reverso
    img.addEventListener('mouseover', function() {
      img.setAttribute('src', reverseSrc); // Cambiar la imagen al reverso
    });

    // Función para volver a la imagen original cuando el ratón sale
    img.addEventListener('mouseleave', function() {
      img.setAttribute('src', originalSrc); // Volver a la imagen original
    });
  }
});




</script>

