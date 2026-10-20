<?php

namespace App\Controllers\Inmatriculacion\TramitesRunt;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController = new Tokens();

        $access = json_decode($tokenController->AccessRolUser(7, 87, ''));


        if ($access->status == 'error') {
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head", $dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $inmatriculacionModel = new InmatriculacionModel();
        $idevento = 1;
        $limit = 10;
        $start = 0;
        $finish = 10;
      //  $detail = $inmatriculacionModel->DetailIndexSinPlaca('', '',2, $limit, $start);

        $dato = [
            'idgrupoModulo' => 7,
            'idmodulo' => 87,
            'detailIndex' => '',
            'finish' => $start,
            'count' => 0,
            'countReg' => 0
        ];
        echo view("Layouts/Head", $dato);
        echo view("Inmatriculacion/TramitesRunt/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inmatriculacion/TramitesRunt/Index/Scripts");

    }
}