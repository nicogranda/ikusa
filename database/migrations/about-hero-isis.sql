-- Aplicar sobre la base local, después de importar las tablas de About.
START TRANSACTION;

UPDATE page_translations
SET hero_type = 'component',
    hero_path = 'About/Hero.php',
    hero_image = 'img/about/hero-cafe.png',
    hero_image_alt = CASE language
        WHEN 'es' THEN 'Taza de café con arte latte'
        ELSE 'Cup of coffee with latte art'
    END,
    hero_eyebrow = CASE language
        WHEN 'es' THEN 'Agencia de marketing digital'
        ELSE 'Digital marketing agency'
    END,
    h1 = CASE language
        WHEN 'es' THEN 'Somos Ikusa'
        ELSE 'We are Ikusa'
    END,
    excerpt = CASE language
        WHEN 'es' THEN 'Las buenas ideas empiezan con una conversación. Escuchamos tu negocio, entendemos tus objetivos y convertimos esa conversación en estrategia, diseño, tecnología y resultados.'
        ELSE 'Good ideas start with a conversation. We listen to your business, understand your goals and turn that conversation into strategy, design, technology and results.'
    END,
    hero_cta_text = CASE language
        WHEN 'es' THEN 'Hablemos de tu proyecto'
        ELSE 'Tell us about your project'
    END,
    components = 'About/FeatureGrid.php,team.php,About/Places.php,About/CTA.php'
WHERE page_id = 3 AND language IN ('es', 'en');

UPDATE component_translations AS t
JOIN components AS c ON c.id = t.component_id
SET t.subtitle = CASE t.language
    WHEN 'es' THEN 'Publicidad y Marketing'
    WHEN 'en' THEN 'Advertising and Marketing'
    ELSE t.subtitle
END
WHERE c.name = 'team'
  AND t.title = 'Isis Marcial'
  AND t.language IN ('es', 'en');

COMMIT;
