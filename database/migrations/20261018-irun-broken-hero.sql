-- Replace missing placeholder social/hero images with an existing neutral image.
SET NAMES utf8mb4;
UPDATE page_translations
SET og_image = REPLACE(og_image, '/assets/img/heros/PENDIENTE-marketing-digital-irun.jpeg', '/assets/img/heros/ikusa-digital-workspace.webp'),
    twitter_image = REPLACE(twitter_image, '/assets/img/heros/PENDIENTE-marketing-digital-irun.jpeg', '/assets/img/heros/ikusa-digital-workspace.webp')
WHERE language = 'es' AND slug = 'marketing-digital-irun';

UPDATE page_translations
SET og_image = REPLACE(og_image, '/assets/img/heros/seo-irun.jpeg', '/assets/img/heros/ikusa-digital-workspace.webp'),
    twitter_image = REPLACE(twitter_image, '/assets/img/heros/seo-irun.jpeg', '/assets/img/heros/ikusa-digital-workspace.webp')
WHERE language = 'es' AND slug = 'seo-irun';
