<?php

namespace App\Controllers\Taller\PlanMantenimiento;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\PlanMantenimientoModel;
use App\Models\RepuestoModel;

class CreateViewEdit extends BaseController
{

    public function ViewMysql()
    {
        $planMantenimiento=New PlanMantenimientoModel();
        $filtro=[
            'idplanMantenimientoFamilia'=>$_POST["idplanMantenimientoFamilia"]
        ];
        $planman=$planMantenimiento->ViewPlanFam($filtro);
        $modelo=$planman[0]["modelo"];
        $marca=$planman[0]["marca"];

        $filtroCabe=[
            'modeloVersion'=>$modelo,
            'marca'=>$marca
        ];

        $repuesto=$planMantenimiento->CabeceraMasivaCargaRepuesto($filtroCabe);



        $dats=[
            'idplanMantenimientoFamilia'=>$_POST["idplanMantenimientoFamilia"],
            'modelo'=>$planman[0]["modelo"],
            'marca'=>$planman[0]["marca"]
        ];

        $cabeceras=$planMantenimiento->CabeceraMasivaPlan($filtroCabe);



        if (empty($cabeceras) && !empty($repuesto)) {
            $dats += [
                'status' => 'error',
                'title' => 'No existen planes cargados o el modelo no corresponde, tiene repuestos inexistentes en la BD',
                'repuesto' => $repuesto
            ];
        }else if(!empty($cabeceras) && !empty($repuesto)){
            $dats += [
                'status' => 'error',
                'title' => 'Tiene repuestos inexistentes en la BD',
                'repuesto' => $repuesto
            ];
        }elseif (empty($cabeceras) && empty($repuesto)) {
            $dats += [
                'status' => 'error',
                'title' => 'No existen planes cargados o el modelo no corresponde',
            ];
        } else {
            $dats += [
                'title'=>'',
                'status' => 'success'
            ];
        }

        $send=[
            'info'=>view("Taller/PlanMantenimiento/CreateMysql/Index",$dats).view("Taller/PlanMantenimiento/CreateMysql/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function ViewPlanFamilia()
    {
        $planMantenimiento=New PlanMantenimientoModel();
        $repuestoModel=New RepuestoModel();
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

        $filtromrmd=[
            'idmarcaAfectada'=>$idmarca
        ];
        $selMrc=$repuestoModel->SelectRepuesto($filtromrmd);

        $datos=[
            'viewPlan'=>$planMantenimiento->ViewPlanFam($filtro),
            'detailViewPlan'=>$planMantenimiento->DetailViewPlanFam($filterView),
            'kilometraje'=>$planMantenimiento->KilometrajeMantenimiento(),
            'idplanMantenimientoFamilia'=>$idplanMan,
            'selectRepuesto'=>$selMrc
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/PlanMantenimiento/ViewPlan/Index",$datos).view("Taller/PlanMantenimiento/ViewPlan/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }

    public function DeleteDetailFamiliaRepuesto()
    {
        $planMantenimientoModel=New PlanMantenimientoModel();
        $iddetallePlanMantenimiento=$_POST["iddetallePlanMantenimientoFam"];


        $filtro=[
            'iddetallePlanMantenimientoFamilia'=>$iddetallePlanMantenimiento
        ];

        $dato=[
            'viewDetail'=>$planMantenimientoModel->DetailViewPlanFam($filtro),
            'iddetallePlanMantenimientoFamilia'=>$iddetallePlanMantenimiento
        ];

        $resultado=[
            'info'=>view("Taller/PlanMantenimiento/DeleteDetailFamilia/Index",$dato).view("Taller/PlanMantenimiento/DeleteDetailFamilia/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($resultado);
        exit();

    }

    public function ViewDetailPlanFamilia()
    {
        $planMantenimientoModel = New PlanMantenimientoModel();
        $idplanMantenimientoFamilia=$_POST["idplanmantenimientofamilia"];

        $filtro=[
            'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
        ];

        $dato=[
            'detailViewPlan'=>$planMantenimientoModel->DetailViewPlanFam($filtro)
        ];

        $datosjson=[
            'info'=>view("Taller/PlanMantenimiento/DetailViewPlan/Index",$dato).view("Taller/PlanMantenimiento/DetailViewPlan/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($datosjson);
        exit();

    }

    public function Repuesto()
    {
        $repuestoModel=New RepuestoModel();

        $filtro=[
            'idmarcaAfectada'=>$_POST["idmarca"]
        ];
        $selMrc=$repuestoModel->SelectRepuesto($filtro);
        $selectRep='';
        $selectRep.='<option value="">Seleccione Repuesto</option>';
        foreach($selMrc as $mcc){
            $selectRep.='<option value="'.$mcc["idrepuesto"].'">'.$mcc["codigo"].' - '.$mcc["descripcion"].'</option>';
        }

        $dato=[
            'selectRepuesto'=>$selectRep,
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }

    public function ViewRepuesto()
    {
        $repuestoModel=New RepuestoModel();

        $filtro=[
            'idrepuesto'=>$_POST["idrepuesto"]
        ];

        $dato=[
            'idplanmantenimientofamilia'=>$_POST["idplanmantenimientofamilia"],
            'viewRepuesto'=>$repuestoModel->View($filtro)
        ];

        $dats=[
            'status'=>'success',
            'info'=>view("Taller/PlanMantenimiento/ViewRepuesto/Index",$dato).view("Taller/PlanMantenimiento/ViewRepuesto/Scripts")
        ];
        echo json_encode($dats);
        exit();
    }

    public function Create()
    {
        $marcaModel=New MarcaModel();

        $datos=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/PlanMantenimiento/Create/Index",$datos).view("Taller/PlanMantenimiento/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }

    public function SelectModelo()
    {
        $modeloModel=New ModeloModel();
        $filtro=[
            'idmarca'=>$_POST["idmarca"]
        ];

        $modelos=$modeloModel->SelectModelo($filtro);
        $option='';
        $option.='<option value="">Seleccione Modelo</option>';
        foreach($modelos as $mds){
            $option.='<option value="'.$mds["idmodelo"].'">'.$mds["descripcion"]." ".$mds["version"].'</option>';
        }

        $dato=[
            'selectModelo'=>$option,
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();

    }
}