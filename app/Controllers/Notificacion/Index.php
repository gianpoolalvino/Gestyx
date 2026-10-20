<?php

namespace App\Controllers\Notificacion;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\NotificacionModel;


class Index extends BaseController
{
    public function NotificacionInferior()
    {
        $notificacionModel=New NotificacionModel();
        $dato=[
            'detail'=>$notificacionModel->DetailNotificacion()
        ];
        echo view("Notificacion/Index/Index",$dato);
        echo view("Notificacion/Index/Scripts");
    }

    public function DetailNotificacionInferior()
    {
        $notificacionModel=New NotificacionModel();

        $dato=[
            'detail'=>$notificacionModel->DetailNotificacion()
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Notificacion/DetailIndex/Index",$dato).view("Notificacion/DetailIndex/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}