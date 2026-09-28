-- Ejecutar en localhost sobre los bloques ya insertados.
START TRANSACTION;

UPDATE component_translations AS t
JOIN components AS c ON c.id = t.component_id
SET
    t.title = CASE t.language
        WHEN 'es' THEN CONCAT('Talento que conecta disciplinas.', CHAR(10), 'Ideas que impulsan marcas.')
        WHEN 'en' THEN CONCAT('Talent across disciplines.', CHAR(10), 'Ideas that move brands forward.')
        ELSE t.title
    END,
    t.subtitle = CASE t.language
        WHEN 'es' THEN 'Las personas detrás de Ikusa'
        WHEN 'en' THEN 'The people behind Ikusa'
        ELSE t.subtitle
    END,
    t.text = CASE t.language
        WHEN 'es' THEN 'Estrategia, diseño y tecnología conviven en un equipo que entiende cada proyecto desde distintas perspectivas. Trabajamos con criterio, cercanía y atención al detalle para convertir objetivos en experiencias digitales valiosas.'
        WHEN 'en' THEN 'Strategy, design and technology come together in a team that sees each project from different perspectives. We work with care, clarity and attention to detail to turn goals into valuable digital experiences.'
        ELSE t.text
    END
WHERE c.name = 'team' AND c.type = 'heading' AND t.language IN ('es','en');

UPDATE component_translations AS t
JOIN components AS c ON c.id = t.component_id
SET
    t.title = CASE t.language
        WHEN 'es' THEN CONCAT('Una mirada internacional.', CHAR(10), 'Una manera cercana de trabajar.')
        WHEN 'en' THEN CONCAT('An international perspective.', CHAR(10), 'A personal way of working.')
        ELSE t.title
    END,
    t.subtitle = CASE t.language
        WHEN 'es' THEN 'Conexiones sin fronteras'
        WHEN 'en' THEN 'Connections across borders'
        ELSE t.subtitle
    END,
    t.text = CASE t.language
        WHEN 'es' THEN 'Nuestra experiencia junto a clientes en España, Venezuela y Estados Unidos nos permite entender contextos distintos y encontrar oportunidades comunes. Escuchamos de cerca, colaboramos con claridad y adaptamos cada solución al mercado al que se dirige.'
        WHEN 'en' THEN 'Our experience with clients in Spain, Venezuela and the United States helps us understand different contexts and find shared opportunities. We listen closely, collaborate clearly and adapt every solution to its market.'
        ELSE t.text
    END
WHERE c.name = 'about-places' AND c.type = 'heading' AND t.language IN ('es','en');

UPDATE components
SET image = 'img/about/places-reference.png'
WHERE name = 'about-places' AND type = 'card';

UPDATE component_translations AS t
JOIN components AS c ON c.id = t.component_id
SET
    t.title = 'Adelsis Martínez Navarro',
    t.image_alt = CASE t.language
        WHEN 'es' THEN 'Retrato de Adelsis Martínez Navarro'
        WHEN 'en' THEN 'Portrait of Adelsis Martínez Navarro'
        ELSE t.image_alt
    END
WHERE c.name = 'team'
  AND (t.title LIKE 'Adelsisa%' OR t.title LIKE 'Adelsis%');

UPDATE components
SET image = 'img/team/adelsis.png'
WHERE name = 'team' AND image = 'img/team/adelsisa.png';

COMMIT;
