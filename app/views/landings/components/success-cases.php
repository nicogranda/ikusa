<?php

if (
    !isset($successCases) ||
    !is_array($successCases) ||
    empty($successCases)
){
    return;
}

?>

<section class="success-cases">

    <div class="success-header">

        <h2>Casos de éxito</h2>

        <p>
            Cada empresa tiene objetivos diferentes. Estas son algunas de las
            marcas con las que hemos trabajado desarrollando estrategias de
            posicionamiento web, SEO Local y marketing digital.
        </p>

    </div>

    <div class="success-grid">

        <?php foreach($successCases as $case): ?>

            <article class="success-card">

                <img
                    src="<?= htmlspecialchars($case["image"]) ?>"
                    alt="<?= htmlspecialchars($case["company"]) ?>"
                    loading="lazy"
                >

                <div class="success-content">

                    <span class="sector">
                        <?= htmlspecialchars($case["sector"]) ?>
                    </span>

                    <h3>
                        <?= htmlspecialchars($case["company"]) ?>
                    </h3>

                    <h4>
                        <?= htmlspecialchars($case["title"]) ?>
                    </h4>

                    <p>
                        <?= htmlspecialchars($case["description"]) ?>
                    </p>

                    <?php if(!empty($case["url"]) && $case["url"] != "#"): ?>

                        <a
                            href="<?= htmlspecialchars($case["url"]) ?>"
                            target="_blank"
                            rel="noopener"
                        >
                            Ver proyecto →
                        </a>

                    <?php endif; ?>

                </div>

            </article>

        <?php endforeach; ?>

    </div>

</section>

<style>

.success-cases{

    max-width:1200px;

    margin:90px auto;

    padding:0 20px;

}

.success-header{

    text-align:center;

    max-width:760px;

    margin:auto auto 55px;

}

.success-header h2{

    font-size:2rem;

    color:var(--color-primary);

    margin-bottom:20px;

}

.success-header p{

    color:#666;

    line-height:1.8;

}

.success-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:30px;

}

.success-card{

    background:#fff;

    border-radius:16px;

    overflow:hidden;

    box-shadow:0 8px 28px rgba(0,0,0,.06);

    transition:.25s;

}

.success-card:hover{

    transform:translateY(-6px);

    box-shadow:0 16px 45px rgba(0,0,0,.10);

}

.success-card img{

    width:100%;

    height:220px;

    object-fit:cover;

}

.success-content{

    padding:25px;

}

.success-content .sector{

    display:inline-block;

    color:var(--color-primary);

    font-size:.85rem;

    font-weight:600;

    margin-bottom:12px;

    text-transform:uppercase;

    letter-spacing:.5px;

}

.success-content h3{

    margin:0;

    font-size:1.45rem;

}

.success-content h4{

    margin:10px 0 15px;

    font-size:1rem;

    color:#444;

}

.success-content p{

    color:#666;

    line-height:1.8;

    margin-bottom:20px;

}

.success-content a{

    color:var(--color-primary);

    font-weight:600;

    text-decoration:none;

}

.success-content a:hover{

    text-decoration:underline;

}

@media(max-width:900px){

    .success-grid{

        grid-template-columns:1fr;

    }

}

</style>