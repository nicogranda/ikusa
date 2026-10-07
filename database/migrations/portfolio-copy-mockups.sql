-- Portfolio copy and supplied mockups; preserves existing slugs.
SET NAMES utf8mb4;
START TRANSACTION;
UPDATE page_translations SET `title` = 'LaEx Coctelería | Diseño web multilingüe | IKUSA',
    `excerpt` = 'Migramos La Ex Coctelería desde otro dominio y configuramos el hosting desde cero. Diseñamos una landing page multilingüe, preparada para crecer con nuevas páginas y trabajar progresivamente el posicionamiento SEO.',
    `meta_description` = 'Migración de dominio, hosting y landing page multilingüe para La Ex Coctelería, con una estructura preparada para ampliar contenidos y trabajar el SEO.',
    `hero_eyebrow` = 'PROYECTO · DISEÑO WEB',
    `hero_image` = '/assets/img/projects/laexcocteleria/mockup.jpg',
    `hero_image_alt` = 'Proyecto web de La Ex Coctelería' WHERE language = 'es' AND slug IN ('la-ex-cocteleria', 'laex-cocteleria');

UPDATE page_translations SET `title` = 'Borjas Design | Tienda online | IKUSA',
    `excerpt` = 'Diseñamos y desarrollamos la web y la tienda online de Borjas Design. Optimizamos las imágenes, vinculamos la tienda con Instagram y configuramos una pasarela de pago para completar las compras online.',
    `meta_description` = 'Tienda online de Borjas Design: diseño y desarrollo web, optimización de imágenes, vinculación con Instagram y configuración de la pasarela de pago.',
    `hero_eyebrow` = 'PROYECTO · ECOMMERCE',
    `hero_image` = '/assets/img/projects/borjas-design/mockup.jpg',
    `hero_image_alt` = 'Proyecto de tienda online de Borjas Design' WHERE language = 'es' AND slug IN ('borjas-design');

UPDATE page_translations SET `title` = 'Petit Café | Identidad gráfica, web y SEO | IKUSA',
    `excerpt` = 'Diseñamos el concepto gráfico y la identidad visual de Petit Café. Creamos su página web y trabajamos el posicionamiento SEO para dar visibilidad a la marca en buscadores.',
    `meta_description` = 'Concepto e identidad gráfica, diseño y desarrollo de la página web y posicionamiento SEO para Petit Café. Descubre el proyecto de IKUSA.',
    `hero_eyebrow` = 'PROYECTO · IDENTIDAD, WEB Y SEO',
    `hero_image` = '/assets/img/projects/petit-cafe/mockup.jpg',
    `hero_image_alt` = 'Proyecto web de Petit Café' WHERE language = 'es' AND slug IN ('petit-cafe');

COMMIT;
