<?php if (!empty($projects)): ?>

<section class="projects-gallery">
    <div class="projects-gallery__grid">

        <?php foreach ($projects as $project): ?>

            <a
                class="project-card"
                href="/<?= htmlspecialchars($lang) ?>/proyectos/<?= htmlspecialchars($project['slug']) ?>"
            >

                <?php if (!empty($project['hero_image'])): ?>
                    <div class="project-card__image">
                        <img
                            src="<?= htmlspecialchars($project['hero_image']) ?>"
                            alt="<?= htmlspecialchars(
                                !empty($project['hero_image_alt'])
                                    ? $project['hero_image_alt']
                                    : (!empty($project['h1']) ? $project['h1'] : $project['title'])
                            ) ?>"
                            loading="lazy"
                        >
                    </div>
                <?php endif; ?>

                <div class="project-card__content">

                    <h2 class="project-card__title">
                        <?= htmlspecialchars(
                            !empty($project['h1'])
                                ? $project['h1']
                                : $project['title']
                        ) ?>
                    </h2>

                    <?php if (!empty($project['excerpt'])): ?>
                        <p class="project-card__excerpt">
                            <?= htmlspecialchars($project['excerpt']) ?>
                        </p>
                    <?php endif; ?>

                    <span class="project-card__more">
                        Ver proyecto <span aria-hidden="true">→</span>
                    </span>

                </div>

            </a>

        <?php endforeach; ?>

    </div>
</section>

<?php endif; ?>

<style>
    .projects-gallery{
    width:100%;
    padding:60px 0;
}

.projects-gallery__grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:30px;
}

.project-card{
    display:flex;
    flex-direction:column;
    background:#fff;
    border:1px solid rgba(0,0,0,.08);
    border-radius:16px;
    overflow:hidden;
    text-decoration:none;
    color:inherit;
    transition:transform .25s ease,box-shadow .25s ease;
}

.project-card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 45px rgba(0,0,0,.10);
}

.project-card__image{
    width:100%;
    aspect-ratio:16/10;
    overflow:hidden;
    background:#f5f5f5;
}

.project-card__image img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:transform .4s ease;
}

.project-card:hover .project-card__image img{
    transform:scale(1.03);
}

.project-card__content{
    display:flex;
    flex-direction:column;
    flex:1;
    padding:24px;
}

.project-card__title{
    margin:0 0 12px;
    font-family:var(--font-brand);
    font-size:1.55rem;
    line-height:1.15;
}

.project-card__excerpt{
    margin:0 0 22px;
    font-family:var(--font-text);
    font-size:.95rem;
    line-height:1.6;
    color:#666;
}

.project-card__more{
    margin-top:auto;
    display:flex;
    align-items:center;
    gap:8px;
    font-family:var(--font-text);
    font-size:.85rem;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.project-card__more span{
    transition:transform .2s ease;
}

.project-card:hover .project-card__more span{
    transform:translateX(5px);
}

@media(max-width:900px){
    .projects-gallery__grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:600px){
    .projects-gallery{
        padding:40px 0;
    }

    .projects-gallery__grid{
        grid-template-columns:1fr;
        gap:22px;
    }

    .project-card__content{
        padding:20px;
    }
}
</style>