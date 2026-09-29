<?php
// Hero de la página Nosotros. Recibe $content y $language de PageController.
$heroTitle = (string) ($content['h1'] ?? 'Somos Ikusa');
$heroEyebrow = (string) ($content['hero_eyebrow'] ?? '');
$heroDescription = (string) ($content['excerpt'] ?? '');
$heroImage = (string) ($content['hero_image'] ?? 'img/about/hero-cafe.png');
$heroAlt = (string) ($content['hero_image_alt'] ?? 'Taza de café con arte latte');
$heroCta = (string) ($content['hero_cta_text'] ?? ($language === 'en' ? 'Tell us about your project' : 'Hablemos de tu proyecto'));
$heroCtaUrl = $language === 'en' ? 'en/contact-us' : 'es/contacto';
$heroUrl = function_exists('asset_url') ? asset_url($heroImage) : '/assets/' . ltrim(preg_replace('~^assets/~', '', $heroImage), '/');
$contactUrl = function_exists('route_url') ? route_url($heroCtaUrl) : '/' . $heroCtaUrl;
$h = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<section class="about-hero" aria-labelledby="about-hero-title">
    <div class="about-hero__inner">
        <div class="about-hero__copy">
            <?php if ($heroEyebrow !== ''): ?><p class="about-hero__eyebrow"><?= $h($heroEyebrow) ?></p><?php endif; ?>
            <h1 id="about-hero-title"><?= $h($heroTitle) ?></h1>
            <?php if ($heroDescription !== ''): ?><p class="about-hero__description"><?= $h($heroDescription) ?></p><?php endif; ?>
            <p class="about-hero__services"><?= $language === 'en' ? 'STRATEGY · DESIGN · WEB DEVELOPMENT · SEO · DIGITAL MARKETING' : 'ESTRATEGIA · DISEÑO · DESARROLLO WEB · SEO · MARKETING DIGITAL' ?></p>
            <div class="about-hero__actions">
                <a class="about-hero__button" href="<?= $h($contactUrl) ?>"><?= $h($heroCta) ?> <span aria-hidden="true">→</span></a>
                <a class="about-hero__more" href="#team"><?= $language === 'en' ? 'Meet us' : 'Conoce más' ?> ↓</a>
            </div>
        </div>
        <div class="about-hero__media">
            <img src="<?= $h($heroUrl) ?>" alt="<?= $h($heroAlt) ?>" width="1289" height="1220" fetchpriority="high" decoding="async">
        </div>
    </div>
</section>
<style>
.about-hero{background:radial-gradient(circle at 68% 43%,#df5149 0,#bf272e 48%,#9d1e29 100%);color:#fff;overflow:hidden;font-family:var(--font-text,inherit)}
.about-hero *{box-sizing:border-box}
.about-hero__inner{width:min(1200px,calc(100% - 2.5rem));min-height:clamp(430px,49vw,650px);margin:auto;display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);align-items:center;gap:2rem;padding:clamp(4rem,7vw,7rem) 0}
.about-hero__copy{position:relative;z-index:1}
.about-hero__eyebrow,.about-hero__services{font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
.about-hero__eyebrow{margin:0 0 1rem}
.about-hero h1{font-family:var(--font-brand,inherit);font-size:clamp(3.2rem,6vw,6rem);line-height:1;letter-spacing:-.04em;color:#fff;margin:0 0 1.2rem}
.about-hero__description{font-size:clamp(1.1rem,1.7vw,1.45rem);line-height:1.46;max-width:39ch;margin:0 0 1.7rem}
.about-hero__services{line-height:1.6;margin:0 0 1.8rem;opacity:.9}
.about-hero__actions{display:flex;flex-wrap:wrap;align-items:center;gap:1.4rem}
.about-hero__button{display:inline-flex;align-items:center;gap:1rem;background:#fff;color:#222;text-decoration:none;border-radius:3px;padding:.9rem 1.2rem;font-weight:700}
.about-hero__button:hover{background:#f6eeee;color:#222}
.about-hero__more,.about-hero__more:visited{color:#fff;text-decoration:none;font-weight:600}
.about-hero__media{min-width:0;align-self:end;display:flex;align-items:center;justify-content:center}
.about-hero__media img{display:block;width:min(100%,620px);height:auto;max-height:560px;object-fit:contain;filter:drop-shadow(0 20px 25px rgba(50,0,0,.24))}
@media(max-width:750px){.about-hero__inner{grid-template-columns:1fr;padding:5rem 0 0;gap:0}.about-hero__media img{width:min(90%,430px);max-height:350px}.about-hero__services{font-size:.68rem}.about-hero__description{max-width:50ch}}
</style>
