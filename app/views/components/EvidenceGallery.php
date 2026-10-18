<?php
/**
 * Galería compartida: añadir EvidenceGallery.php a components.
 * Acepta $evidenceGallery o carga app/data/project-evidence/{reference|slug}.php.
 * Datos y campos opcionales documentados en app/data/project-evidence/README.md.
 */
if (!isset($evidenceGallery)) {
    $evidenceReferences = array_unique(array_filter([
        $content['reference'] ?? $translation['reference'] ?? '',
        $content['slug'] ?? $translation['slug'] ?? '',
    ]));
    foreach ($evidenceReferences as $evidenceReference) {
        if (!preg_match('/^[a-z0-9-]+$/D', $evidenceReference)) continue;
        $evidenceDataFile = __DIR__ . '/../../data/project-evidence/' . $evidenceReference . '.php';
        if (is_file($evidenceDataFile)) {
            $evidenceGallery = require $evidenceDataFile;
            break;
        }
    }
}
if (empty($evidenceGallery['items'])) return;
$evidenceEscape = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$evidenceId = uniqid('evidence-gallery-');
$evidenceDate = static function (string $value) use ($evidenceEscape): string {
    $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    if (!$date || $date->format('Y-m-d') !== $value) return $evidenceEscape($value);
    return '<time datetime="' . $evidenceEscape($value) . '">' . $date->format('d/m/Y') . '</time>';
};
?>
<section class="evidence-gallery" aria-labelledby="<?= $evidenceId ?>">
    <div class="evidence-gallery__container">
        <?php if (!empty($evidenceGallery['label'])): ?>
            <p class="evidence-gallery__label"><?= $evidenceEscape($evidenceGallery['label']) ?></p>
        <?php endif; ?>
        <h2 id="<?= $evidenceId ?>"><?= $evidenceEscape($evidenceGallery['title']) ?></h2>
        <?php if (!empty($evidenceGallery['description'])): ?>
            <p class="evidence-gallery__intro"><?= $evidenceEscape($evidenceGallery['description']) ?></p>
        <?php endif; ?>
        <div class="evidence-gallery__grid">
            <?php foreach ($evidenceGallery['items'] as $evidenceItem):
                $evidenceImage = !empty($evidenceItem['image']) ? ($evidenceGallery['image_base'] ?? '') . $evidenceItem['image'] : '';
                $evidenceObservedAt = $evidenceItem['observed_at'] ?? '';
                $evidenceUpdatedAt = $evidenceItem['updated_at'] ?? $evidenceGallery['updated_at'] ?? '';
            ?>
                <figure class="evidence-gallery__card">
                    <?php if ($evidenceImage): ?>
                    <div class="evidence-gallery__image">
                        <img src="<?= $evidenceEscape($evidenceImage) ?>" alt="<?= $evidenceEscape($evidenceItem['text']) ?>" loading="lazy" decoding="async">
                    </div>
                    <?php endif; ?>
                    <figcaption>
                        <h3><img class="evidence-gallery__isotype" src="<?= $evidenceEscape(function_exists('asset_url') ? asset_url('img/favicon.png') : '/assets/img/favicon.png') ?>" width="20" height="20" alt="" aria-hidden="true"> <span><?= $evidenceEscape($evidenceItem['title']) ?></span></h3>
                        <p><?= $evidenceEscape($evidenceItem['text']) ?></p>
                        <dl class="evidence-gallery__facts">
                            <?php if (!empty($evidenceItem['query'])): ?>
                                <div><dt>Consulta trabajada</dt><dd><?= $evidenceEscape($evidenceItem['query']) ?></dd></div>
                            <?php endif; ?>
                            <?php if ($evidenceObservedAt !== ''): ?>
                                <div><dt>Fecha de observación</dt><dd><?= $evidenceDate($evidenceObservedAt) ?></dd></div>
                            <?php endif; ?>
                            <?php if (!empty($evidenceItem['period'])): ?>
                                <div><dt>Periodo analizado</dt><dd><?= $evidenceEscape($evidenceItem['period']) ?></dd></div>
                            <?php endif; ?>
                            <?php if (!empty($evidenceItem['result_types'])): ?>
                                <div><dt>Tipo de resultado</dt><dd><?= $evidenceEscape(implode(' · ', $evidenceItem['result_types'])) ?></dd></div>
                            <?php endif; ?>
                            <?php if (isset($evidenceItem['observed_position']) && $evidenceObservedAt !== ''): ?>
                                <div><dt>Posición observada en la captura</dt><dd><?= $evidenceEscape((string) $evidenceItem['observed_position']) ?> (observación del <?= $evidenceDate($evidenceObservedAt) ?>; no es una posición actual permanente)</dd></div>
                            <?php endif; ?>
                            <?php if (isset($evidenceItem['search_console_average_position']) && !empty($evidenceItem['period']) && !empty($evidenceItem['source_url'])): ?>
                                <div><dt>Posición media de Search Console</dt><dd><?= $evidenceEscape((string) $evidenceItem['search_console_average_position']) ?> (<?= $evidenceEscape($evidenceItem['period']) ?>; media del periodo, no posición puntual)</dd></div>
                            <?php endif; ?>
                            <?php foreach ($evidenceItem['metrics'] ?? [] as $evidenceMetric):
                                // Una métrica requiere periodo y fuente para publicarse.
                                if (!isset($evidenceMetric['value']) || empty($evidenceMetric['label']) || empty($evidenceMetric['period']) || empty($evidenceMetric['source_url']) || !in_array($evidenceMetric['kind'] ?? '', ['visibility', 'business'], true)) continue;
                            ?>
                                <div><dt><?= $evidenceMetric['kind'] === 'business' ? 'Resultado de negocio' : 'Métrica de visibilidad' ?>: <?= $evidenceEscape($evidenceMetric['label']) ?></dt><dd><?= $evidenceEscape((string) $evidenceMetric['value']) ?> · <?= $evidenceEscape($evidenceMetric['period']) ?> · <a href="<?= $evidenceEscape($evidenceMetric['source_url']) ?>" target="_blank" rel="noopener noreferrer">Fuente</a></dd></div>
                            <?php endforeach; ?>
                            <?php if (!empty($evidenceItem['evolution']) && !empty($evidenceItem['period']) && !empty($evidenceItem['source_url']) && in_array($evidenceItem['evolution_kind'] ?? '', ['visibility', 'business'], true)): ?>
                                <div><dt>Evolución documentada de <?= $evidenceItem['evolution_kind'] === 'business' ? 'negocio' : 'visibilidad' ?></dt><dd><?= $evidenceEscape($evidenceItem['evolution']) ?> (<?= $evidenceEscape($evidenceItem['period']) ?>)</dd></div>
                            <?php endif; ?>
                            <?php if (!empty($evidenceItem['source_url'])): ?>
                                <div><dt>Fuente</dt><dd><a href="<?= $evidenceEscape($evidenceItem['source_url']) ?>" target="_blank" rel="noopener noreferrer"><?= $evidenceEscape($evidenceItem['source_label'] ?? 'Consultar fuente') ?></a></dd></div>
                            <?php endif; ?>
                            <?php if ($evidenceUpdatedAt !== ''): ?>
                                <div><dt>Evidencia actualizada</dt><dd><?= $evidenceDate($evidenceUpdatedAt) ?></dd></div>
                            <?php endif; ?>
                        </dl>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($evidenceGallery['note'])): ?>
            <p class="evidence-gallery__note"><?= $evidenceEscape($evidenceGallery['note']) ?></p>
        <?php endif; ?>
    </div>
</section>
<style>
.evidence-gallery { padding:clamp(48px,6vw,72px) 0; background:#fff; color:#202020; font-family:var(--font-primary,'Montserrat',Arial,sans-serif); }
.evidence-gallery__container { width:calc(100% - 48px); max-width:1200px; margin:auto; }
.evidence-gallery .evidence-gallery__label { margin:0 0 14px; color:var(--color-primary,#F15A24); font-size:12px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; }
.evidence-gallery h2 { margin:0 0 18px; max-width:850px; font-family:inherit; font-size:clamp(26px,2.8vw,34px); line-height:1.3; font-weight:600; letter-spacing:-.025em; }
.evidence-gallery .evidence-gallery__intro { max-width:880px; margin:0; color:#555; font-size:14px; line-height:1.8; }
.evidence-gallery__grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:24px; margin-top:28px; }
.evidence-gallery__card { margin:0; min-width:0; border:1px solid #e9e5e2; border-radius:6px; overflow:hidden; background:#fff; }
.evidence-gallery__image { display:block; position:relative; background:#f6f6f6; }
.evidence-gallery img { display:block; width:100%; height:auto; }
.evidence-gallery figcaption { padding:20px; }
.evidence-gallery .evidence-gallery__isotype { flex:0 0 20px; width:20px; height:20px; object-fit:contain; }
.evidence-gallery h3 { display:flex; align-items:center; gap:8px; margin:0 0 10px; font-family:inherit; font-size:16px; font-weight:600; line-height:1.4; }
.evidence-gallery figcaption p { margin:0; color:#555; font-size:13px; line-height:1.75; }
.evidence-gallery__facts { margin:14px 0 0; font-size:12px; line-height:1.7; color:#555; overflow-wrap:anywhere; }
.evidence-gallery__facts > div { margin-top:10px; }
.evidence-gallery__facts dt { font-weight:600; }
.evidence-gallery__facts dd { margin:0; }
.evidence-gallery .evidence-gallery__note { margin:24px 0 0; color:#626262; font-size:12px; line-height:1.8; }
@media(max-width:900px){.evidence-gallery__grid{gap:20px}}
@media(max-width:600px){.evidence-gallery__container{width:calc(100% - 40px)}.evidence-gallery__grid{grid-template-columns:1fr}}
</style>
<?php unset($evidenceGallery); ?>
