<?php
/**
 * Componente reutilizable "fases" — autodetecta tipo e idioma.
 * Se incluye añadiendo "fases/view.php" a la columna `components`
 * de page_translations. No requiere pasar nada manualmente:
 * usa $language y $slug, ya disponibles en el scope de Show.php.
 *
 * Override manual opcional: si una página necesita forzar un tipo
 * distinto al que detectaría por el slug, puede definir $fase_tipo
 * ANTES del include (aunque vía columna `components` no aplica).
 */

$lang_actual = isset($language) ? $language : (isset($translation['language']) ? $translation['language'] : 'es');
$page_actual = isset($slug) ? $slug : (isset($translation['slug']) ? $translation['slug'] : '');

require_once __DIR__ . '/data.php';

// --- Autodetección del tipo de fase según el slug de la página ---
if (!isset($fase_tipo)) {
    if (stripos($page_actual, 'seo') !== false || stripos($page_actual, 'donostia') !== false) {
        $fase_tipo = 'seo';
    } elseif (stripos($page_actual, 'diseno-grafico') !== false || stripos($page_actual, 'graphic-design') !== false) {
        $fase_tipo = 'diseno-grafico';
    } else {
        $fase_tipo = 'web'; // home, páginas de diseño web, y cualquier otra por defecto
    }
}

// Si el tipo/idioma resultante no existe en los datos, cae a 'es' (evita romper la página).
$fase_lang  = isset($FASES_DATA[$fase_tipo][$lang_actual]) ? $lang_actual : 'es';
$fase_info  = $FASES_DATA[$fase_tipo][$fase_lang] ?? null;
?>

<?php if ($fase_info): ?>
<section class="fases-wrap">

    <p class="fases-eyebrow"><?= htmlspecialchars($fase_info['eyebrow']) ?></p>
    <h2 class="fases-title"><?= htmlspecialchars($fase_info['titulo']) ?></h2>
    <p class="fases-sub"><?= htmlspecialchars($fase_info['subtitulo']) ?></p>

    <?php foreach ($fase_info['pasos'] as $fase): ?>
    <div class="fase-row">
        <div class="fase-left">
            <div class="fase-num"><?= htmlspecialchars($fase['numero']) ?></div>
            <div class="fase-line"></div>
        </div>
        <div class="fase-content">
            <div class="fase-header">
                <i class="ti <?= htmlspecialchars($fase['icono']) ?> fase-icon" aria-hidden="true"></i>
                <p class="fase-name"><?= htmlspecialchars($fase['titulo']) ?></p>
            </div>
            <p class="fase-desc"><?= htmlspecialchars($fase['desc']) ?></p>
        </div>
    </div>
    <?php endforeach; ?>

</section>

<style>
    .fases-wrap {
        max-width: 780px;
        margin: 48px auto;
        padding: 56px 48px;
        border-radius: 12px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .fases-eyebrow {
        font-size: 12px;
        letter-spacing: 0.12em;
        color: var(--color-brand, #F15A24);
        font-weight: 500;
        text-transform: uppercase;
        margin-bottom: 12px;
    }
    .fases-title {
        font-size: 30px;
        font-weight: 500;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    .fases-sub {
        font-size: 14px;
        margin-bottom: 48px;
        max-width: 520px;
        line-height: 1.6;
    }
    .fase-row {
        display: grid;
        grid-template-columns: 56px 1fr;
        gap: 0 20px;
    }
    .fase-left {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .fase-num {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: orangered;
        border: 0.5px solid orangered;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        flex-shrink: 0;
    }
    .fase-line {
        width: 0.5px;
        flex: 1;
        background: rgba(0, 0, 0, 0.1);
        margin: 4px 0;
        min-height: 32px;
    }
    .fase-row:last-child .fase-line { display: none; }
    .fase-content { padding: 10px 0 40px; }
    .fase-row:last-child .fase-content { padding-bottom: 0; }
    .fase-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .fase-icon {
        font-size: 17px;
        color: var(--color-brand, #F15A24);
    }
    .fase-name {
        font-size: 16px;
        font-weight: 500;
    }
    .fase-desc {
        font-size: 13px;
        line-height: 1.65;
        max-width: 560px;
    }
</style>
<?php endif; ?>
