<?php
/** Regression checks for the 18 October crawl exports; no database required. */
function verifyCrawl(bool $ok, string $message): void {
    if (!$ok) throw new RuntimeException($message);
}
$slugs = ['la-ex-cocteleria', 'porlamar', 'avalon-estetic', 'borjas-design', 'petit-cafe', 'maleta-chic'];
$projects = array_map(static fn ($slug) => ['slug' => $slug, 'project_name' => $slug], $slugs);
$lang = 'es';
foreach (['proyectos', 'marketing-digital-gipuzkoa'] as $projectOrigin) {
    ob_start();
    include __DIR__ . '/../app/views/components/GalleryProjects.php';
    $html = ob_get_clean();
    foreach ($slugs as $slug) {
        $suffix = $projectOrigin === 'proyectos' ? '' : '?from=' . $projectOrigin;
        verifyCrawl(str_contains($html, 'href="/es/proyectos/' . $slug . $suffix . '"'), 'Enlace incorrecto: ' . $slug);
    }
}
foreach (['porlamar', 'avalon-estetic', 'la-ex-cocteleria'] as $slug) {
    $evidenceGallery = require __DIR__ . '/../app/data/project-evidence/' . $slug . '.php';
    $data = $evidenceGallery;
    ob_start();
    include __DIR__ . '/../app/views/components/EvidenceGallery.php';
    $html = ob_get_clean();
    foreach ($data['items'] as $item) {
        verifyCrawl(!str_contains($item['title'], '«') && !str_contains($item['title'], '»'), 'Keyword con comillas');
        verifyCrawl(str_contains($html, 'class="evidence-gallery__isotype"'), 'Falta isotipo');
        $file = __DIR__ . '/../public_html' . $data['image_base'] . $item['image'];
        verifyCrawl(filesize($file) < 100000, 'Captura demasiado pesada: ' . $file);
        verifyCrawl(getimagesize($file)[2] === IMAGETYPE_WEBP, 'WebP inválido');
        verifyCrawl(str_contains($html, 'src="' . $data['image_base'] . $item['image'] . '"'), 'Recorte no utilizado');
        verifyCrawl(!str_contains($html, 'href="' . $data['image_base'] . $item['image'] . '"'), 'Captura enlazada');
        verifyCrawl(!str_contains($html, 'Abrir captura') && !str_contains($html, 'abrir captura'), 'CTA de ampliación publicado');
    }
}
echo "OK: seis canónicas enlazadas, navegación contextual y siete recortes WebP <100 kB sin enlaces de ampliación.\n";
