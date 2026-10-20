<?php
namespace App\Controllers\ControlSalidaVehicular\ConfirmarSaldo;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlSalidaVehicular;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveLiberar()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $controlVehicular=New ControlSalidaVehicular();
        $vinModel=New VinModel();
        $eventoModel=New EventoModel();
        $vin=$_POST["vinLiberar"];

        $infoVin=$vinModel->VinInfo($vin);

        $liberarVin=[
            'liberado'=>1,
            'idusuarioLiberado'=>session("idusuario"),
            'fechaLiberado'=>$_POST["fechaLiberacion"],
            'comentariosLiberado'=>$_POST["comentarioVinLiberado"],
            'fechaRegistroLiberado'=>$hoy,
            'horaRegistroLiberado'=>$hora
        ];
        if(isset($_POST["checkValidar"]) && $_POST["checkValidar"]==1){
            $liberarVin+=[
                'liberadoObservaciones'=>1,
                'idusuarioAutorizaVinLiberado'=>$_POST["gerenteAutorizo"],
                'saldoPendienteIndicador'=>0
            ];
        }

        $filtroUpdateVin=[
            'vin'=>$vin,
        ];

        $upd=$vinModel->UpdateVin($filtroUpdateVin,$liberarVin);

        if($upd){
            $filtroEvento=[
                'vin'=>$vin,
                'ideventoActual'=>9
            ];

            $updateEvento=[
                'fechaFin'=>$hoy,
                'horaFin'=>$hora,
                'idusuario'=>session("idusuario"),
                'idusuariofinaliza'=>session("idusuario"),
                'idestadoEvento'=>2,
                'comentarios'=>$_POST["comentarioVinLiberado"],
                'saldoPendienteLiberado'=>$infoVin[0]["saldoPendiente"]
            ];

            $updateEve=$eventoModel->UpdateEvento($filtroEvento,$updateEvento);
            $dato=[
                'status'=>'success',
                'title'=>'Grabado Correo',
                'message'=>'Se almaceno correctamente la data'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Grabado',
                'message'=>'Ocurrio un error al procesar la Data'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}