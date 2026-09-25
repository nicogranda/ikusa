<?php 
    $dir = "assets/img/portfolio/cards";
    $images = [];

    if ($handle = @opendir($dir)) {
        while ($file = readdir($handle)) {
            if ($file != "." && $file != ".." && is_file("$dir/$file")) {
                $images[] = [
                    "filename" => pathinfo($file, PATHINFO_FILENAME),
                    "route"    => '/' . $dir . '/' . rawurlencode($file),
                    "reverse"  => file_exists("$dir/reverso/$file") ? '/' . $dir . '/reverso/' . rawurlencode($file) : ''
                ];
            }
        }
        closedir($handle);
    }

    usort($images, fn($a, $b) => strcmp($a['filename'], $b['filename']));
?>

<style>
.grid-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 1rem;
  grid-auto-flow: dense;
  width: 80%;
  margin: 0 auto;
}
.grid-gallery__item {
  display: flex;
  justify-content: center;
  align-items: center;
}
.grid-gallery__image {
  width: 100%;
  height: auto;
  object-fit: contain;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  transition: box-shadow 0.3s ease;
}
.grid-gallery__image:hover {
  box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}
.grid-gallery__item[data-orientation="horizontal"] { grid-column: span 2; }
.grid-gallery__item[data-orientation="vertical"]   { grid-row: span 1; }
.grid-gallery__item[data-orientation="large"]      { grid-column: span 2; grid-row: span 2; }
</style>

<h1 class='principal'>Cards</h1>

<div class="introduces" style="display:flex;gap:15px;color:var(--color-primary);">
    <h2 class="secondary"><i class="fa-solid fa-square-full" style="color:#F15A24;"></i> Tarjetas de Visitas</h2>
    <h2 class="secondary"><i class="fa-solid fa-square-full" style="color:#F15A24;"></i> Tarjetas de Agradecimiento</h2>
    <h2 class="secondary"><i class="fa-solid fa-square-full" style="color:#F15A24;"></i> Gift Cards</h2>
    <h2 class="secondary"><i class="fa-solid fa-square-full" style="color:#F15A24;"></i> Carnets/Fichas</h2>
</div>

<p class="introduces" style="padding:0 0 20px 0;">
    Nuestra reciente colección de tarjetas de visita, carnets, tarjetas de agradecimiento y gift cards, diseñadas en un formato estándar de 8.5 cm x 5.5 cm. Cada diseño combina creatividad y funcionalidad para destacar tu marca con un estilo único y profesional.
</p>

<div class="gallery">
    <div class="grid-gallery">
        <?php foreach ($images as $image): ?>
            <div class="grid-gallery__item">
                <img class="grid-gallery__image"
                     src="<?= $image['route'] ?>"
                     alt="<?= htmlspecialchars($image['filename']) ?>"
                     title="<?= htmlspecialchars($image['filename']) ?>"
                     data-reverse="<?= $image['reverse'] ?>" />
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "../app/views/components/services/services.php"; ?>

<script>
document.querySelectorAll(".grid-gallery__image").forEach(img => {
    img.addEventListener('load', function () {
        const parent = img.parentElement;
        if (img.naturalWidth > img.naturalHeight) {
            parent.setAttribute("data-orientation", "horizontal");
        } else if (img.naturalHeight > img.naturalWidth) {
            parent.setAttribute("data-orientation", "vertical");
        } else {
            parent.setAttribute("data-orientation", "large");
        }
    });

    const originalSrc = img.getAttribute('src');
    const reverseSrc  = img.getAttribute('data-reverse');

    if (reverseSrc) {
        img.addEventListener('mouseover',  () => img.setAttribute('src', reverseSrc));
        img.addEventListener('mouseleave', () => img.setAttribute('src', originalSrc));
    }
});
</script>