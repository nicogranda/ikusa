<?php
/**
 * Componente reutilizable "comparison" — autodetecta idioma igual que fases.
 * Se incluye añadiendo "comparison/view.php" a la columna `components`
 * de page_translations. Usa $language y $slug del scope de Show.php.
 *
 * Override manual opcional: definir $comparison_tipo antes del include
 * si se necesita forzar un tipo distinto al detectado (por defecto 'seo').
 */

$lang_actual = isset($language) ? $language : (isset($translation['language']) ? $translation['language'] : 'es');
$page_actual = isset($slug) ? $slug : (isset($translation['slug']) ? $translation['slug'] : '');

require_once __DIR__ . '/data.php';

if (!isset($comparison_tipo)) {
    $comparison_tipo = 'seo';
}

$comparison_lang = isset($COMPARISON_DATA[$comparison_tipo][$lang_actual]) ? $lang_actual : 'es';
$comparison_info = $COMPARISON_DATA[$comparison_tipo][$comparison_lang] ?? null;
?>

<?php if ($comparison_info): ?>
<section class="seo-comparison">
    <div class="comparison-header">
        <h2><?= htmlspecialchars($comparison_info['titulo']) ?></h2>
        <p><?= htmlspecialchars($comparison_info['subtitulo']) ?></p>
    </div>

    <div class="comparison-grid">

        <div class="comparison-row comparison-row--head">
            <div class="comparison-cell comparison-cell--aspecto">Aspecto</div>
            <div class="comparison-cell comparison-cell--competidor"><?= htmlspecialchars($comparison_info['col_competidor']) ?></div>
            <div class="comparison-cell comparison-cell--ikusa"><?= htmlspecialchars($comparison_info['col_ikusa']) ?></div>
        </div>

        <?php foreach ($comparison_info['filas'] as $i => $fila): ?>
        <div class="comparison-row">
            <div class="comparison-cell comparison-cell--aspecto">
                <span class="comparison-num"><?= $i + 1 ?></span>
                <span><?= htmlspecialchars($fila['aspecto']) ?></span>
            </div>
            <div class="comparison-cell comparison-cell--competidor">
                <?= htmlspecialchars($fila['competidor']) ?>
            </div>
            <div class="comparison-cell comparison-cell--ikusa">
                <i class="ti ti-check" aria-hidden="true"></i>
                <span><?= htmlspecialchars($fila['ikusa']) ?></span>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</section>

<style>
.seo-comparison{
    max-width:1100px;
    margin:80px auto;
    padding:0 20px;
    font-family: var(--font-primary, 'Montserrat', Helvetica, sans-serif);
}
.comparison-header{
    text-align:center;
    max-width:850px;
    margin:0 auto 45px;
}
.comparison-header h2{
    font-size:2rem;
    font-weight:500;
    color:#1a1a1a;
    margin-bottom:18px;
}
.comparison-header p{
    color:#666;
    line-height:1.8;
    font-size:1rem;
}

.comparison-grid{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 8px 30px rgba(0,0,0,.06);
}

.comparison-row{
    display:grid;
    grid-template-columns: 22% 39% 39%;
    border-bottom:1px solid #ececec;
}
.comparison-row:last-child{
    border-bottom:none;
}
.comparison-row:not(.comparison-row--head):nth-child(even){
    background:#fafafa;
}
.comparison-row:not(.comparison-row--head):hover{
    background:#fff6f2;
}

.comparison-row--head{
    background: rgba(241, 90, 36, 0.08);
}
.comparison-row--head .comparison-cell{
    font-weight:600;
    font-size:0.95rem;
    color: var(--color-brand, #F15A24);
    padding:16px 18px;
}

.comparison-cell{
    padding:20px 18px;
    line-height:1.7;
    font-size:0.95rem;
}

.comparison-cell--aspecto{
    display:flex;
    align-items:center;
    gap:12px;
    font-weight:600;
    color:#1a1a1a;
}
.comparison-num{
    width:32px;
    height:32px;
    border-radius:50%;
    background: rgba(241, 90, 36, 0.12);
    border: 0.5px solid rgba(241, 90, 36, 0.4);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    font-weight:600;
    color: var(--color-brand, #F15A24);
    flex-shrink:0;
}

.comparison-cell--competidor{
    color:#666;
    font-weight:400;
}

.comparison-cell--ikusa{
    color:#555;
    font-weight:600;
    display:flex;
    align-items:flex-start;
    gap:8px;
}
.comparison-cell--ikusa .ti-check{
    color: var(--color-brand, #F15A24);
    font-size:16px;
    margin-top:3px;
    flex-shrink:0;
}

/* Móvil: ocultamos la columna de la competencia, solo Aspecto + Ikusa, sin scroll */
@media(max-width:768px){
    .comparison-header h2{
        font-size:1.6rem;
    }
    .comparison-row{
        grid-template-columns: 38% 62%;
    }
    .comparison-cell--competidor{
        display:none;
    }
}
</style>
<?php endif; ?>
