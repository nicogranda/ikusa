# Tres componentes de la página About

Los archivos de entrada son `About/FeatureGrid.php`, `About/Places.php` y `About/CTA.php`. `Pages/Views/Show.php` ya los incluye desde el campo `page_translations.components`. El Domain About consulta `components` y `component_translations` mediante `ComponentModel` y el idioma de la página.

## En localhost

1. Copiar `app/src/Domains/About/` y `app/views/components/About/` desde esta rama. Conservar el Domain Components usado por Team.
2. Ejecutar una sola vez `database/migrations/about-components-seed.sql` en la base de pruebas, después de crear las dos tablas generales.
3. Para colocar las cuatro secciones en el orden del diseño, ejecutar:

```sql
UPDATE page_translations
SET components = 'About/FeatureGrid.php,team.php,About/Places.php,About/CTA.php'
WHERE page_id = 3 AND language IN ('es', 'en');
```

Esto reemplaza la lista anterior solo para About en español e inglés; guardar su valor previo antes si contiene otros componentes que quieras conservar. El hero sigue gestionándose por `hero_type` y `hero_path`.

4. Subir estas imágenes reales a `public_html/assets/img/about/`: `atlanta.jpg`, `donostia.jpg`, `puerto-ordaz.jpg`, `cta-cafe.jpg`. Los nombres de archivo deben corresponder a las rutas de `components.image`.
5. Comprobar `/es/nosotros` y `/en/about-us`, también en móvil.

El CSS está en `app/src/Domains/About/Assets/css/style.css` y lo carga el componente; no se requiere acceso HTTP directo a esa carpeta.
