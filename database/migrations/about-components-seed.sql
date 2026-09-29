-- Ejecutar una sola vez en la base de pruebas, después de crear components y component_translations.
-- Las imágenes se colocan en public_html/assets/img/about/.
START TRANSACTION;

INSERT INTO components (name, type, sort_order) VALUES ('about-features', 'heading', 0);
SET @features_heading = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, text) VALUES
(@features_heading, 'es', CONCAT('No hacemos webs.', CHAR(10), 'Construimos herramientas', CHAR(10), 'para hacer crecer negocios.'), 'Más que una agencia', 'En Ikusa combinamos estrategia, creatividad y desarrollo para crear marcas y experiencias digitales pensadas para ser encontradas, entendidas y elegidas.'),
(@features_heading, 'en', CONCAT('We build more than websites.', CHAR(10), 'We build tools', CHAR(10), 'that grow businesses.'), 'More than an agency', 'At Ikusa, we combine strategy, creativity and development to build brands and digital experiences designed to be found, understood and chosen.');

INSERT INTO components (name, type, sort_order) VALUES ('about-features', 'card', 1);
SET @strategy = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, text) VALUES
(@strategy, 'es', 'Estrategia', 'Primero entendemos tu negocio. Después decidimos qué construir.'),
(@strategy, 'en', 'Strategy', 'First we understand your business. Then we decide what to build.');

INSERT INTO components (name, type, sort_order) VALUES ('about-features', 'card', 2);
SET @design = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, text) VALUES
(@design, 'es', 'Diseño', 'Creamos una identidad y una experiencia coherentes con tu marca y tu público.'),
(@design, 'en', 'Design', 'We create an identity and experience consistent with your brand and audience.');

INSERT INTO components (name, type, sort_order) VALUES ('about-features', 'card', 3);
SET @technology = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, text) VALUES
(@technology, 'es', 'Tecnología + SEO', 'Desarrollamos pensando desde el principio en rendimiento, posicionamiento y conversión.'),
(@technology, 'en', 'Technology + SEO', 'We build with performance, search visibility and conversion in mind from day one.');

INSERT INTO components (name, type, sort_order) VALUES ('about-places', 'heading', 0);
SET @places_heading = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, text) VALUES
(@places_heading, 'es', CONCAT('Una mirada internacional.', CHAR(10), 'Una manera cercana de trabajar.'), 'Conexiones sin fronteras', 'Nuestra experiencia junto a clientes en España, Venezuela y Estados Unidos nos permite entender contextos distintos y encontrar oportunidades comunes. Escuchamos de cerca, colaboramos con claridad y adaptamos cada solución al mercado al que se dirige.'),
(@places_heading, 'en', CONCAT('An international perspective.', CHAR(10), 'A personal way of working.'), 'Connections across borders', 'Our experience with clients in Spain, Venezuela and the United States helps us understand different contexts and find shared opportunities. We listen closely, collaborate clearly and adapt every solution to its market.');

INSERT INTO components (name, type, image, sort_order) VALUES ('about-places', 'card', 'img/about/atlanta.jpg', 1);
SET @atlanta = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, image_alt) VALUES
(@atlanta, 'es', 'Atlanta', 'Estados Unidos', 'Vista de la ciudad de Atlanta'),
(@atlanta, 'en', 'Atlanta', 'United States', 'View of the city of Atlanta');

INSERT INTO components (name, type, image, sort_order) VALUES ('about-places', 'card', 'img/about/donostia.jpg', 2);
SET @donostia = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, image_alt) VALUES
(@donostia, 'es', 'San Sebastián – Donostia', 'España', 'Vista de la bahía de San Sebastián'),
(@donostia, 'en', 'San Sebastián – Donostia', 'Spain', 'View of San Sebastián bay');

INSERT INTO components (name, type, image, sort_order) VALUES ('about-places', 'card', 'img/about/puerto-ordaz.jpg', 3);
SET @puerto = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, image_alt) VALUES
(@puerto, 'es', 'Puerto Ordaz', 'Venezuela', 'Vista de Puerto Ordaz'),
(@puerto, 'en', 'Puerto Ordaz', 'Venezuela', 'View of Puerto Ordaz');

INSERT INTO components (name, type, image, sort_order) VALUES ('about-cta', 'card', 'img/about/cta-cafe.jpg', 1);
SET @cta = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, text, image_alt) VALUES
(@cta, 'es', '¿Tienes un proyecto en mente?', 'Hablemos', 'Cuéntanos qué quieres conseguir. Nosotros ponemos el café y empezamos por escucharte.', 'Taza de café de Ikusa junto a un ordenador'),
(@cta, 'en', 'Have a project in mind?', 'Let’s talk', 'Tell us what you want to achieve. We’ll make the coffee and start by listening.', 'Ikusa coffee cup beside a laptop');

COMMIT;
