<?php
// app/Domains/Pages/PageController.php

namespace App\Domains\Pages;

require_once __DIR__ . '/Page.php';
require_once __DIR__ . '/PageTranslation.php';

class PageController
{
    private Page $pageModel;
    private PageTranslation $translationModel;
    private ?array $resolvedTranslation = null;

    public function __construct(\mysqli $db)
    {
        $this->pageModel = new Page($db);
        $this->translationModel = new PageTranslation($db);
    }

    /**
     * Resuelve la traducción sin renderizar.
     *
     * Se llama antes del <head> para que $seoData
     * tenga disponibles los datos correctos.
     */
    public function resolve(string $language, string $slug): ?array
    {
        $this->resolvedTranslation = $this->translationModel->findBySlug(
            $language,
            $slug
        );

        return $this->resolvedTranslation;
    }

    /**
     * Renderiza el contenido de la página.
     *
     * $content es la variable que exponemos a las vistas.
     * Internamente PageTranslation continúa siendo el modelo
     * encargado de resolver el contenido por idioma.
     */
    public function render(string $language, string $slug): bool
    {
        $content = $this->resolvedTranslation
            ?? $this->translationModel->findBySlug($language, $slug);

        if (!$content) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Compatibilidad temporal
        |--------------------------------------------------------------------------
        |
        | Los componentes antiguos todavía pueden utilizar $translation.
        | Los componentes nuevos deben utilizar $content.
        |
        | Cuando terminemos la migración eliminamos esta línea.
        |
        */

        $translation = $content;

        /*
        |--------------------------------------------------------------------------
        | Datos globales de empresa
        |--------------------------------------------------------------------------
        */

        $lang = $language;

        require __DIR__ . '/../../config/business.php';

        /*
        |--------------------------------------------------------------------------
        | Placeholders
        |--------------------------------------------------------------------------
        */

        $replacements = [
            '{{brand_name}}'            => $orgName,
            '{{brand_url}}'             => $orgUrl,
            '{{legal_name}}'            => $orgLegalName,
            '{{contact_phone}}'         => $orgPhone,
            '{{contact_email}}'         => $orgEmail,
            '{{company_registration}}'  => $orgRegistration,
            '{{company_tax_id}}'        => $orgTaxId,
            '{{company_legal_address}}' => $orgLegalAddress,
        ];

        $content['content'] = strtr(
            $content['content'] ?? '',
            $replacements
        );

        /*
        |--------------------------------------------------------------------------
        | Compatibilidad después de procesar contenido
        |--------------------------------------------------------------------------
        |
        | Actualizamos el alias para que los componentes antiguos reciban
        | también el contenido con placeholders ya resueltos.
        |
        */

        $translation = $content;

        /*
        |--------------------------------------------------------------------------
        | SEO / idiomas
        |--------------------------------------------------------------------------
        */

        $canonical = $this->translationModel->resolveCanonical($content);

        $allTranslations = $this->translationModel->findByPageId(
            (int) $content['page_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Componentes
        |--------------------------------------------------------------------------
        */

        $components = array_filter(
            array_map(
                'trim',
                explode(',', $content['components'] ?? '')
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Proyectos
        |--------------------------------------------------------------------------
        |
        | GalleryProjects.php puede utilizarse desde cualquier landing.
        | Cuando está presente buscamos dinámicamente la página "proyectos"
        | y cargamos sus hijos.
        |
        */

        $projects = [];

        if (in_array('GalleryProjects.php', $components, true)) {

            $projectsPage = $this->translationModel->findBySlug(
                $language,
                'proyectos'
            );

            if ($projectsPage) {

                $projects = $this->pageModel->getChildren(
                    (int) $projectsPage['page_id'],
                    $language
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        include __DIR__ . '/../../views/Pages/Show.php';

        return true;
    }

    /**
     * Admin: crea página + primera traducción.
     */
    public function create(array $input): array
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');

        $pageId = $this->pageModel->create(
            $input['type'] ?? 'landing',
            $input['status'] ?? 'draft'
        );

        $input['page_id'] = $pageId;

        $translationId = $this->translationModel->create($input);

        $response = [
            'success'        => true,
            'page_id'        => $pageId,
            'translation_id' => $translationId,
        ];

        echo json_encode($response);
        exit;
    }

    /**
     * Admin: actualiza una traducción existente.
     */
    public function update(int $translationId, array $input): void
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');

        $ok = $this->translationModel->update(
            $translationId,
            $input
        );

        echo json_encode([
            'success' => $ok
        ]);

        exit;
    }

    /**
     * Admin: elimina página.
     */
    public function delete(int $pageId): void
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');

        $ok = $this->pageModel->delete($pageId);

        echo json_encode([
            'success' => $ok
        ]);

        exit;
    }

    /**
     * Admin: lista páginas.
     */
    public function list(?string $type = null): void
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');

        echo json_encode(
            $this->pageModel->all($type)
        );

        exit;
    }
}