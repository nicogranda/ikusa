<?php
// components/clientes-confian.php
$clientes = [
    ['nombre' => 'Avalón Estetic',      'archivo' => 'avalon_estetic.png'],
    ['nombre' => 'BB Specialty Coffee', 'archivo' => 'bbkafe.png'],
    ['nombre' => 'Porlamar',            'archivo' => 'porlamar.png'],
    ['nombre' => 'Petit Café',          'archivo' => 'petit_cafe.png'],
];
$rutaLogos = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/clients/';
?>
<section class="clientes-confian">
    <p class="clientes-confian__label">Confían en nosotros</p>
    <div class="clientes-confian__grid">
        <?php foreach ($clientes as $cliente): ?>
            <?php $existeLogo = file_exists($rutaLogos . $cliente['archivo']); ?>
            <div class="clientes-confian__item">
                <?php if ($existeLogo): ?>
                    <img src="/assets/img/clients/<?= htmlspecialchars($cliente['archivo']) ?>"
                         alt="Logo de <?= htmlspecialchars($cliente['nombre']) ?>"
                         loading="lazy">
                <?php else: ?>
                    <span class="clientes-confian__nombre"><?= htmlspecialchars($cliente['nombre']) ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<style>
    .clientes-confian { text-align: center; padding: 2rem 0; margin: 0 auto; width: 60%; }
    .clientes-confian__label { font-size: 13px; opacity: 0.6; margin-bottom: 12px; }
    .clientes-confian__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; }
    .clientes-confian__item { background: rgba(255,255,255,0.05); border-radius: 12px; padding: 1rem; display: flex; align-items: center; justify-content: center; min-height: 60px; }
    .clientes-confian__item img { max-height: 150px; max-width: 100%; filter: grayscale(100%); opacity: 0.85; }
    .clientes-confian__item img:hover { filter: none; opacity: 1; }
    .clientes-confian__nombre { font-weight: 500; font-size: 14px; }
</style>
