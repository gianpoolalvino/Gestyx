<?php

namespace App\Controllers\Inmatriculacion\PlacasRotativas;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(7,81,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $inmatriculacionModel = new InmatriculacionModel();
        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros

        $detail = $inmatriculacionModel->DetailIndexPlacaRotativa('', '','', $limit, $start);
        $countReg = $inmatriculacionModel->CountPlacaRotativa('', '','');
        // Calcular el número total de páginas
        $totalPages = ceil($countReg[0]['contador'] / $limit);

        $dato = [
            'idgrupoModulo' => 7,
            'idmodulo' => 81,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg[0]['contador'],
            'countReg' => $countReg[0]['contador'],
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
        ];
        echo view("Layouts/Head", $dato);
        echo view("Inmatriculacion/PlacasRotativas/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inmatriculacion/PlacasRotativas/Index/Scripts");
    }
}