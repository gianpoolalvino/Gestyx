<?php

namespace App\Controllers\Inmatriculacion\SinExpediente;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveExpediente()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $inmatriculacionModel=New InmatriculacionModel();

        $filtroCiudad=[
            'nombre'=>$_POST["ciudadMatricula"]
        ];

        $ciudadPlaca=$inmatriculacionModel->CiudadPlacaId($filtroCiudad);
        $tipoCiudadPlaca="";
        if(!$ciudadPlaca){
            $tipoCiudadPlaca='MUNICIPIO';
            $storageCiudad=[
                'nombre'=>$_POST["ciudadMatricula"],
                'idtipoCiudadPlaca'=>2
            ];
            $inmatriculacionModel->StorageCiudadPlaca($storageCiudad);
        }else{
            if($ciudadPlaca[0]["idtipoCiudadPlaca"]==1){
                $tipoCiudadPlaca='CIUDAD';
            }else{
                $tipoCiudadPlaca='MUNICIPIO';
            }
        }

        $vinModel=New VinModel();
        $evento=[
            'vin'=>$_POST["vinExpe"],
            'ideventoActual'=>11,
            'fechaInicio'=>$_POST["fechaExpediente"],
            'horaInicio'=>$hora,
            'fechaFin'=>$_POST["fechaExpediente"],
            'horaFin'=>$hora,
            'eventoActual'=>'Expediente',
            'eventoAnterior'=>'Sin Expediente',
            'ideventoAnterior'=>11,
            'idestadoEvento'=>2,
            'idusuario'=>session("idusuario"),
            'idusuariofinaliza'=>session("idusuario"),
            'comentarios'=>$_POST["expediente"],
            'comentarioAdicional'=>$_POST["comentarioAdv"],
            'fechaRegistroSistemaInicio'=>$hoy,
            'fechaRegistroSistemaFin'=>$hoy,
            'ciudadPlaca'=>$_POST["ciudadMatricula"]
        ];

        $idinmatriculacion=$inmatriculacionModel->StorageExpediente($evento);
        if($idinmatriculacion!=''){

            $filtVin=[
                'vin'=>$_POST["vinExpe"],
            ];

            $updateVin=[
                'ciudadPlaca'=>$_POST["ciudadMatricula"],
                'tipoCiudadPlaca'=>$tipoCiudadPlaca,
                'fechaEnvioManifiesto'=>$hoy
            ];

            $resulVin=$vinModel->UpdateVin($filtVin,$updateVin);

            $eventoTitu=[
                'vin'=>$_POST["vinExpe"],
                'ideventoActual'=>12,
                'fechaInicio'=>$_POST["fechaExpediente"],
                'horaInicio'=>$hora,
                'idusuario'=>session("idusuario"),
                'eventoActual'=>'Titulo',
                'idestadoEvento'=>1,
                'eventoAnterior'=>'Expediente',
                'ideventoAnterior'=>11,
                'fechaRegistroSistemaInicio'=>$hoy
            ];
            $idExpd=$inmatriculacionModel->StorageExpediente($eventoTitu);
            $dato=[
                'status'=>'success',
                'title'=>'Exepediente Ingresado',
                'message'=>'Se ingreso correctamente el expediente'
            ];

            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Expediente Errado',
                'message'=>'Ocurrio un error en la Base de Datos'
            ];

            echo json_encode($dato);
            exit();
        }
    }
}