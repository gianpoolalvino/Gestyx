<?php

namespace App\Controllers\Inmatriculacion\TramitesRunt;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $inmatriculacionModel=New InmatriculacionModel();

        $storage=[
            'idestadoTramite'=>4,
            'idusuarioTramite'=>session('idusuario')
        ];
        $deletTramite=$inmatriculacionModel->DestroyTramite($storage);
        $idtramite=$inmatriculacionModel->StorageTramite($storage);

        $dato=[
            'tipoTramite'=>$inmatriculacionModel->SelectTipoTramite(),
            'tipoVehiculo'=>$inmatriculacionModel->SelectTipoVehiculo(),
            'idtramite'=>$idtramite
        ];


        $send=[
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>view("Inmatriculacion/TramitesRunt/Create/Index",$dato).view("Inmatriculacion/TramitesRunt/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function OrganismoPlaca()
    {
        $inmatriculacionModel=New InmatriculacionModel();

        $filtro=[
            'idtramite'=>$_POST["idtramite"]
        ];

        $dato=[
            'idtramite'=>$_POST["idtramite"],
            'viewTramite'=>$inmatriculacionModel->ViewTramite($filtro),
            'tipoTramite'=>$inmatriculacionModel->SelectTipoTramite(),
            'tipoVehiculo'=>$inmatriculacionModel->SelectTipoVehiculo(),
        ];

        $send=[
            'status'=>'',
            'title'=>'',
            'message'=>'',
            'info'=>view("Inmatriculacion/TramitesRunt/Create/OrganismoPlacaTramite",$dato).view("Inmatriculacion/TramitesRunt/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function LineaCombustible()
    {
        $inmatriculacionModel=New InmatriculacionModel();

        $filtro=[
            'idtramite'=>$_POST["idtramite"]
        ];

        $dato=[
            'idtramite'=>$_POST["idtramite"],
            'tipoCarroceria'=>$inmatriculacionModel->SelectTipoCarroceria(),
            'viewTramite'=>$inmatriculacionModel->ViewTramite($filtro),
            'tipoCombustible'=>$inmatriculacionModel->SelectTipoCombustible(),
        ];

        $send=[
            'status'=>'',
            'title'=>'',
            'message'=>'',
            'info'=>view("Inmatriculacion/TramitesRunt/Create/LineaCombustibleModelo",$dato).view("Inmatriculacion/TramitesRunt/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function CapacidadBlindaje()
    {
        $inmatriculacionModel=New InmatriculacionModel();

        $filtro=[
            'idtramite'=>$_POST["idtramite"]
        ];

        $dato=[
            'idtramite'=>$_POST["idtramite"],
            'viewTramite'=>$inmatriculacionModel->ViewTramite($filtro),
            'tipoCombustible'=>$inmatriculacionModel->SelectTipoCombustible(),
        ];

        $send=[
            'status'=>'',
            'title'=>'',
            'message'=>'',
            'info'=>view("Inmatriculacion/TramitesRunt/Create/CapacidadBlindajeVin",$dato).view("Inmatriculacion/TramitesRunt/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}