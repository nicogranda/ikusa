# Componentes de contenido para Ikusa

Rama de integración: añadir `team.php` a `page_translations.components` de la página About (en cada idioma que se quiera mostrar). El widget lee `name=team` y el idioma de `PageController`. No hay cambios automáticos en la página ni en la base de producción.

## En localhost

1. Importar `database/components.sql` en la base de pruebas.
2. Insertar los bloques `team` y sus traducciones `es` y `en`. Ejemplo abajo.
3. Guardar las fotos en `public_html/assets/img/team/` y escribir rutas como `img/team/nico.png` en `components.image`.
4. Agregar `team.php` al campo `components` de las traducciones de About, separado por coma de los componentes existentes.
5. Abrir About en ambos idiomas y verificar fotos, orden y textos.

```sql
INSERT INTO components (name, type, image, sort_order)
VALUES ('team', 'heading', NULL, 0);
SET @heading_id = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, text)
VALUES
(@heading_id, 'es', 'Una agencia sin fronteras', NULL, 'De Puerto Ordaz a Donostia'),
(@heading_id, 'en', 'An agency without borders', NULL, 'From Puerto Ordaz to Donostia');

INSERT INTO components (name, type, image, sort_order)
VALUES ('team', 'split', 'img/team/nico.png', 1);
SET @nico_id = LAST_INSERT_ID();
INSERT INTO component_translations (component_id, language, title, subtitle, text, image_alt)
VALUES
(@nico_id, 'es', 'Nicolás Granda', 'Desarrollo web', 'Convierte ideas en productos digitales rápidos y funcionales, preparados para posicionar.', 'Retrato de Nicolás Granda'),
(@nico_id, 'en', 'Nicolás Granda', 'Web development', 'Turns ideas into fast, functional digital products built to rank.', 'Portrait of Nicolás Granda');
```

Agregar las otras dos personas siguiendo el segundo INSERT. `sort_order` establece el orden. `heading`, `split` y `card` son los tipos disponibles. La traducción de cada bloque es obligatoria para que aparezca en ese idioma.

El CSS se lee desde `app/src/Domains/Components/Assets/css/style.css` por `app/views/components/team.php`; no hace falta enlazar el directorio privado como URL pública.
