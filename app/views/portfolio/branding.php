<style>

@media all and (min-width: 320px) {
  .grid-gallery {
    grid-template-columns: repeat(1, 1fr);
  }
}

@media all and (min-width: 768px) {
  .grid-gallery {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media all and (min-width: 1024px) {
  .grid-gallery {
    grid-template-columns: repeat(6, 1fr);
  }
}

.grid-gallery__item:nth-child(11n+1) {
  grid-column: span 1;
}

.grid-gallery__item:nth-child(11n+4) {
  grid-column: span 2;
  grid-row: span 1;
}

.grid-gallery__item:nth-child(11n+6) {
  grid-column: span 3;
  grid-row: span 1;
}

.grid-gallery__item:nth-child(11n+7) {
  grid-column: span 1;
  grid-row: span 2;
}

.grid-gallery__item:nth-child(11n+8) {
  grid-column: span 2;
  grid-row: span 2;
}

.grid-gallery__item:nth-child(11n+9) {
  grid-row: span 3;
}

.grid-gallery__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

    </style>

<div class='gallery'>   
    <div class='products'>   
    <?php 
        $dir = "images/portfolio/cards"; // Ruta a la carpeta de imágenes
        $images = array(); // Array para almacenar los archivos de imagen

        // Abrimos el directorio
        $direc = @opendir($dir) or die("Permiso denegado");

        // Recorremos los archivos dentro del directorio
        while ($file = readdir($direc)) {
            if ($file != "." && $file != "..") {
                // Almacenamos solo los archivos de imagen en el array
                $images[] = $dir . "/" . $file;
            }
        }

        // Cerramos el directorio
        closedir($direc);

        // Usamos foreach para recorrer el array de imágenes
        foreach ($images as $image) {
            echo "<a class='grid-gallery__item' href='#'>
                    <img class='grid-gallery__image' src='" . $image . "' alt='" . pathinfo($image, PATHINFO_FILENAME) . "' />
                  </a>";
        }
    ?>
    </div>
</div>

    <h1 class='principal'>Cards</h1>  	
    <p class="introduces">
Esta es nuestra reciente colección de tarjetas de visita, carnets, tarjetas de agradecimiento y gift cards, diseñadas en un formato estándar de 8.5 cm x 5.5 cm. Cada diseño combina creatividad y funcionalidad para destacar tu marca con un estilo único y profesional.
    </p>
 
