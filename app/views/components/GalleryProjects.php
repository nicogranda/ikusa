<?php
/** Grid reutilizable: recibe proyectos publicados y filtrados desde el controlador. */
if (empty($projects)) return;
$projectEscape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
// El catálogo enlaza a las canónicas; los servicios conservan su contexto de navegación.
$projectQuery = ($projectOrigin ?? 'proyectos') === 'proyectos' ? '' : '?from=' . rawurlencode($projectOrigin);
$projectRoute = static fn (string $path): string => function_exists('route_url') ? route_url($path) : '/' . $path;
?>
<section class="projects-gallery" aria-labelledby="projects-gallery-title">
    <div class="projects-gallery__inner">
        <div class="projects-gallery__heading">
            <p>Nuestros proyectos</p>
            <h2 id="projects-gallery-title">Diseño, desarrollo y marketing en cada proyecto</h2>
        </div>
        <div class="projects-gallery__grid">
            <?php foreach ($projects as $project): ?>
                <a class="project-card" href="<?= $projectEscape($projectRoute(rawurlencode($lang) . '/proyectos/' . rawurlencode($project['slug'])) . $projectQuery) ?>">
                    <?php if (!empty($project['hero_image'])): ?>
                        <div class="project-card__image">
                            <img src="<?= $projectEscape($project['hero_image']) ?>" alt="<?= $projectEscape($project['hero_image_alt'] ?: $project['project_name']) ?>" loading="lazy" decoding="async">
                        </div>
                    <?php endif; ?>
                    <div class="project-card__content">
                        <h3><?= $projectEscape($project['project_name']) ?></h3>
                        <?php if (!empty($project['excerpt'])): ?>
                            <p><?= $projectEscape($project['excerpt']) ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<style>
.projects-gallery{padding:56px 0;background:#fff;color:#202020;font-family:var(--font-primary,'Montserrat',Arial,sans-serif)}
.projects-gallery__inner{width:min(100% - 48px,1200px);margin:auto}
.projects-gallery__heading{margin:0 0 28px;text-align:center}
.projects-gallery__heading>p{color:var(--color-brand,#F15A24);font-size:12px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;margin:0 0 16px}
.projects-gallery__heading h2{font-family:inherit;font-weight:300;font-size:clamp(26px,3vw,36px);line-height:1.25;margin:0}
.projects-gallery__grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}
.projects-gallery a.project-card{display:flex;flex-direction:column;min-width:0;border:1px solid #e5e5e5;border-radius:6px;padding:16px;background:#fff;color:inherit;text-decoration:none;transition:border-color .2s ease}
.projects-gallery a.project-card:hover{border-color:var(--color-brand,#F15A24)}
.projects-gallery a.project-card:focus-visible{outline:3px solid var(--color-brand,#F15A24);outline-offset:4px}
.project-card__image{aspect-ratio:16/9;overflow:hidden;border-radius:4px;background:#f5f5f5}
.project-card__image img{width:100%;height:100%;display:block;object-fit:cover;object-position:top}
.project-card__content h3{font-family:inherit;font-size:21px;font-weight:300;line-height:1.3;margin:16px 0 12px}
.project-card__content p{font-size:13px;line-height:1.7;color:#555;margin:0}
@media(max-width:900px){.projects-gallery__grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:600px){.projects-gallery{padding:40px 0}.projects-gallery__inner{width:calc(100% - 32px)}.projects-gallery__grid{grid-template-columns:1fr}}
</style>
