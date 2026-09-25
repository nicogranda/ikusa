<?php

namespace App\Domains\GeographicSEO;

/*
|--------------------------------------------------------------------------
| DEPENDENCIES
|--------------------------------------------------------------------------
|
| El Domain puede ser cargado directamente desde Pages/Views/Show.php,
| por lo que cargamos explícitamente su Model.
|
*/

require_once __DIR__ . '/GeographicSeoModel.php';


final class GeographicSeoController
{
    private GeographicSeoModel $model;


    public function __construct()
    {
        $this->model = new GeographicSeoModel();
    }


    public function show(): void
    {
        $geoSeo = $this->model->getGipuzkoaData();

        require __DIR__ . '/Views/Show.php';
    }
}