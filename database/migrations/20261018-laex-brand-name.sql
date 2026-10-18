-- Unify the LAEX brand spelling in the Spanish project copy.
SET NAMES utf8mb4;
UPDATE page_translations
SET h1 = REPLACE(h1, 'La Ex Coctelería', 'LAEX Coctelería'),
    hero_image_alt = REPLACE(hero_image_alt, 'La Ex Coctelería', 'LAEX Coctelería'),
    excerpt = REPLACE(excerpt, 'La Ex Coctelería', 'LAEX Coctelería'),
    meta_description = REPLACE(meta_description, 'La Ex Coctelería', 'LAEX Coctelería')
WHERE language = 'es' AND slug = 'la-ex-cocteleria';
