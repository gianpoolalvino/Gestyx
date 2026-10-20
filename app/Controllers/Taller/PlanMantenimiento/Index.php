<?php

namespace App\Controllers\Taller\PlanMantenimiento;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\PlanMantenimientoModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(19,35,''));


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
        $marcaModel=new MarcaModel();
        $dato = [
            'idgrupoModulo' => 19,
            'idmodulo' => 35,
            'selectMarca'=>$marcaModel->SelectMarca()

        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/PlanMantenimiento/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/PlanMantenimiento/Index/Scripts");
    }

    public function DetailIndex()
    {
        $planMantenimiento=New PlanMantenimientoModel();

        $idmarca=$_POST["idmarca"];
        $idmodelo=$_POST["idmodelo"];

        $filtro=[
            'idmarca'=>$idmarca,
            'idmodelo'=>$idmodelo
        ];
        $planman=$planMantenimiento->ViewPlanFam($filtro);
        $idplanMan=$planman[0]["idplanMantenimientoFamilia"];

        $filterView=[
            'idplanMantenimientoFamilia'=>$idplanMan
        ];

        $dato=[
            'viewPlan'=>$planman,
            'detailView'=>$planMantenimiento->DetailViewPlanFam($filterView),
            'viewPlanFull'=>$planMantenimiento->ViewPlanMantenimientoFull($filterView)
        ];

        $result=[
            'info'=>view("Taller/PlanMantenimiento/DetailIndex/Index",$dato).view("Taller/PlanMantenimiento/DetailIndex/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($result);
        exit();
    }
}