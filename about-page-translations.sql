-- Conserva el slug y el page_id existentes. Comprueba primero el registro:
SELECT id, page_id, language, slug, title, components
FROM page_translations
WHERE language = 'es' AND slug IN ('nosotros', 'about');

-- Ejecuta este UPDATE en la misma base de datos de localhost.
UPDATE page_translations
SET title = 'Sobre Ikusa | Estrategia, diseño, desarrollo web y SEO',
    meta_description = 'Conoce a las personas detrás de Ikusa. Combinamos estrategia, diseño, desarrollo web y SEO para ayudar a crecer a marcas y negocios.',
    og_title = 'Somos Ikusa | Agencia de Marketing Digital',
    og_description = 'Conoce al equipo de Ikusa y nuestra forma de trabajar.',
    components = 'About/Hero.php,About/FeatureGrid.php,About/Team.php,About/Places.php,About/CTA.php',
    content = 'Conoce a Ikusa: estrategia, diseño, desarrollo web, SEO y marketing digital.'
WHERE language = 'es' AND slug IN ('nosotros', 'about');

SELECT ROW_COUNT() AS registros_actualizados;
