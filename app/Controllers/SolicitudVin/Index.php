<?php

namespace App\Controllers\SolicitudVin;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\SolicitudVinModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;

class Index extends BaseController
{
    public function Index()
    {
        $solicitudModel = new SolicitudVinModel();
        $usuario=New UsuarioModel();
        $filtroUs=[
            'idusuario'=>(int)session('idusuario')
        ];

        $usd=$usuario->ViewUsuario($filtroUs);

        $idevento = 1;
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $fechaAnterior = date("Y-m-d", strtotime($hoy . ' -15 days'));

        $filtro=[
            'fechaSolicitud>='=>$fechaAnterior,
            'fechaSolicitud<='=>$hoy,
            'idestadoSolicitud'=>1,
        ];

        if($usd[0]['gestorSolicitudVehiculo']!=1){
            $filtro+=[
                'idusuario'=>(int)session('idusuario')
            ];
        }

        $filtroTotal=[
            'sv.fechaSolicitud>='=>$fechaAnterior,
            'sv.fechaSolicitud<='=>$hoy
        ];

        if($usd[0]['gestorSolicitudVehiculo']!=1){
            $filtroTotal+=[
                'sv.idusuario'=>(int)session('idusuario')
            ];
        }

        $detail = $solicitudModel->DetailIndex($filtro);
        $totales=$solicitudModel->TotalSolicitudes($filtroTotal);
        //   $co=$vehiculosModel->CountRegistro('','');

        $dato = [
            'idgrupoModulo' => 26,
            'idmodulo' => '',
            'totales'=>$totales,
            'detailIndex' => $detail,
            'finish' => 0,
            'count' => 0,
            'countReg' => 0
        ];
        echo view("Layouts/Head", $dato);
        echo view("SolicitudVin/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("SolicitudVin/Index/Scripts");
    }

    public function DetailIndex()
    {
        $solicitudModel = new SolicitudVinModel();
        $usuario=New UsuarioModel();

        $filtroU=[
            'idusuario'=>(int)session('idusuario')
        ];

        $usd=$usuario->ViewUserConfig($filtroU);

        $filtro=[
            'fechaSolicitud>='=>$_POST["fechaInicio"],
            'fechaSolicitud<='=>$_POST["fechaFin"],
        ];

        if($usd[0]['gestorSolicitudVehiculo']!=1){
            $filtro+=[
                'idusuario'=>(int)session('idusuario')
            ];
        }

        if($_POST["idestadoSolicitud"]!=''){
            $filtro+=[
                'idestadoSolicitud'=>$_POST["idestadoSolicitud"]
            ];
        }

        $filtroTotal=[
            'sv.fechaSolicitud>='=>$_POST["fechaInicio"],
            'sv.fechaSolicitud<='=>$_POST["fechaFin"]
        ];

        if($usd[0]['gestorSolicitudVehiculo']!=1){
            $filtroTotal+=[
                'sv.idusuario'=>(int)session('idusuario')
            ];
        }
        $totales=$solicitudModel->TotalSolicitudes($filtroTotal);

        $dato=[
            'detail'=>$solicitudModel->DetailIndex($filtro),
        ];
        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/DetailIndex/Index",$dato).view("SolicitudVin/DetailIndex/Scripts"),
            'total'=>$totales[0]["total"],
            'recibidas'=>$totales[0]["recibida"],
            'vistas'=>$totales[0]["vista"],
            'realizadas'=>$totales[0]["realizada"],
            'rechazadas'=>$totales[0]["rechazada"],
        ];

        echo json_encode($send);
        exit();
    }
}