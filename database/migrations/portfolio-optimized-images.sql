-- Upgrade previously deployed PNG mockups to optimized JPEGs.
SET NAMES utf8mb4;
START TRANSACTION;
UPDATE page_translations SET hero_image = '/assets/img/projects/laexcocteleria/mockup.jpg' WHERE hero_image = '/assets/img/projects/laexcocteleria/mockup.png';
UPDATE page_translations SET hero_image = '/assets/img/projects/borjas-design/mockup.jpg' WHERE hero_image = '/assets/img/projects/borjas-design/mockup.png';
UPDATE page_translations SET hero_image = '/assets/img/projects/petit-cafe/mockup.jpg' WHERE hero_image = '/assets/img/projects/petit-cafe/mockup.png';
COMMIT;
