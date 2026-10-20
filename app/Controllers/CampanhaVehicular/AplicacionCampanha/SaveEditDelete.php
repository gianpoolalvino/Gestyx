<?php

namespace App\Controllers\CampanhaVehicular\AplicacionCampanha;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{

    public function SaveAplicarCampanha()
    {
        date_default_timezone_set("America/Lima");
        $CampanhaModel=New CampanhaModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();

        $filtroEvento=[
            'vin'=>$_POST["vinCampanha"],
            'ideventoActual'=>4,
            'idcampanha'=>$_POST["selectCampanha"]
        ];

        $updateEvento=[
            'ideventoActual'=>4,
            'idcampanha'=>1,
            'eventoActual'=>'Campaña',
            'idestadoEvento'=>2,
            'fechaFin'=>date("Y-m-d"),
            'horaFin'=>date("H:i:s"),
            'idusuariofinaliza'=>session("idusuario"),
        ];
        $store=$eventoModel->UpdateEvento($filtroEvento,$updateEvento);

        $filtroCmp=[
            'idcampanhaVin'=>$_POST["idvinCampanha"]
        ];

        $updateCmp=[
            'idestadoCampanha'=>$_POST["selectEstado"],
            'comentarios'=>$_POST["comentarioCampanha"],
            'finalizado'=>1,
            'fechaFinaliza'=>date("Y-m-d"),
            'horaFinaliza'=>date("H:i:s")
        ];
        $updag=$CampanhaModel->UpdateVehiculo($filtroCmp,$updateCmp);


        $filtVinUp=[
            'vin'=>$_POST["vinCampanha"]
        ];

        $updVin=[
            'campanhaRealizada'=>1
        ];

        $upd=$vinModel->UpdateVin($filtVinUp,$updVin);

        if($updag){
            $dato=[
                'status'=>'success',
                'title'=>'Grabado Exitoso',
                'message'=>'La Campaña se aplico correctamente al Vin'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'Ocurrio un error al aplicar la campaña'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveCampanhaVehiculo()
    {
        date_default_timezone_set("America/Lima");
        $CampanhaModel=New CampanhaModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();

        if(isset($_POST["checkMarcCmp"]) && $_POST["checkMarcCmp"]=='1'){
            $eventoActual=[
                'fechaRegistroSistemaInicio'=>date("Y-m-d"),
                'fechaInicio'=>date("Y-m-d"),
                'vin'=>$_POST["vinCampanha"],
                'horaInicio'=>date("H:i:s"),
                'ideventoAnterior'=>4,
                'eventoAnterior'=>'Campaña',
                'ideventoActual'=>4,
                'idcampanha'=>1,
                'eventoActual'=>'Campaña',
                'idestadoEvento'=>2,
                'fechaFin'=>date("Y-m-d"),
                'horaFin'=>date("H:i:s"),
                'idusuario'=>session("idusuario"),
                'idusuariofinaliza'=>session("idusuario"),
            ];
            $store=$eventoModel->StorageEvento($eventoActual);

            $filtroDp=[
                'idestadoCampanha'=>1,
                'vin'=>$_POST["vinCampanha"],
                'idcampanha'=>1,
                'idusuario'=>session("idusuario"),
                'comentarios'=>$_POST["comentarioCampanha"],
                'fechaInicio'=>date("Y-m-d"),
                'horaInicio'=>date("H:i:s"),
                'finalizado'=>1,
                'fechaFinaliza'=>date("Y-m-d"),
                'horaFinaliza'=>date("H:i:s")
            ];
            $idcampanhaVin=$CampanhaModel->StorageVehiculo($filtroDp);


            $filtVinUp=[
                'vin'=>$_POST["vinCampanha"]
            ];

            $updVin=[
                'campanhaRealizada'=>1
            ];

            $upd=$vinModel->UpdateVin($filtVinUp,$updVin);

            if($idcampanhaVin!=''){
                $dato=[
                    'status'=>'success',
                    'title'=>'Grabado Exitoso',
                    'message'=>'La Campaña se vinculo correctamente al Vin'
                ];
                echo json_encode($dato);
                exit();
            }else{
                $dato=[
                    'status'=>'danger',
                    'title'=>'Error en proceso',
                    'message'=>'Ocurrio un error y el vin no se logro asociar a la campaña'
                ];
                echo json_encode($dato);
                exit();
            }
        }

        $filtroDp=[
            'idcampanha'=>$_POST["selectCampanha"],
            'vin'=>$_POST["vinCampanha"]
        ];

        $exist=$CampanhaModel->ViewVinCampanha($filtroDp);
        if($exist){
            $dato=[
                'status'=>'warning',
                'title'=>'Ya se realizo',
                'message'=>'Esta campaña ya fue realizada al Vehiculo'
            ];
            echo json_encode($dato);
            exit();
        }

        $filtroDp+=[
            'idestadoCampanha'=>$_POST["selectEstado"],
            'idusuario'=>session("idusuario"),
            'fechaInicio'=>$_POST["fechaAplicacion"],
            'horaInicio'=>date("H:i:s")
        ];

        $filtroCmp=[
            'idcampanha'=>$_POST["selectCampanha"],
            'vin'=>$_POST["vinCampanha"]
        ];

        $cont=$eventoModel->SearchCampanhaEvento($filtroCmp);
        $contador=$cont[0]["contador"];


        if($_POST["selectEstado"]!=3){
            $filtroDp+=[
                'finalizado'=>1,
                'fechaFinaliza'=>date("Y-m-d"),
                'horaFinaliza'=>date("H:i:s")
            ];
            if($contador==0){
                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>date("Y-m-d"),
                    'fechaInicio'=>date("Y-m-d"),
                    'vin'=>$_POST["vinCampanha"],
                    'horaInicio'=>date("H:i:s"),
                    'ideventoAnterior'=>4,
                    'eventoAnterior'=>'Campaña',
                    'ideventoActual'=>4,
                    'idcampanha'=>$_POST["selectCampanha"],
                    'eventoActual'=>'Campaña',
                    'idestadoEvento'=>2,
                    'fechaFin'=>date("Y-m-d"),
                    'horaFin'=>date("H:i:s"),
                    'idusuario'=>session("idusuario"),
                    'idusuariofinaliza'=>session("idusuario"),
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
            }
            $filtVinUp=[
                'vin'=>$_POST["vinCampanha"]
            ];
            $updVin=[
                'campanhaRealizada'=>1
            ];
            $upd=$vinModel->UpdateVin($filtVinUp,$updVin);
        }else{
            $eventoActual=[
                'fechaRegistroSistemaInicio'=>date("Y-m-d"),
                'fechaInicio'=>date("Y-m-d"),
                'vin'=>$_POST["vinCampanha"],
                'horaInicio'=>date("H:i:s"),
                'ideventoAnterior'=>4,
                'eventoAnterior'=>'Campaña',
                'ideventoActual'=>4,
                'idcampanha'=>$_POST["selectCampanha"],
                'eventoActual'=>'Campaña',
                'idestadoEvento'=>1,
                'idusuario'=>session("idusuario"),
            ];
            $store=$eventoModel->StorageEvento($eventoActual);
        }

        $idcampanhaVin=$CampanhaModel->StorageVehiculo($filtroDp);

        if($idcampanhaVin!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Grabado Exitoso',
                'message'=>'La Campaña se vinculo correctamente al Vin'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en proceso',
                'message'=>'Ocurrio un error y el vin no se logro asociar a la campaña'
            ];
            echo json_encode($dato);
            exit();
        }

    }
    public function SaveCampanha()
    {
        $CampanhaModel=New CampanhaModel();
        $filtroDp=[
            'codigo'=>$_POST["codigoCampanha"]
        ];

        $view=$CampanhaModel->ViewCampanha($filtroDp);

        if($view) {
            $dato = [
                'status' => 'warning',
                'title' => 'Duplicidad detectada',
                'message' => 'Ya existe una campaña con el codigo ingresado'
            ];
            echo json_encode($dato);
            exit();
        }

        $campanha=[
            'codigo'=>$_POST["codigoCampanha"],
            'nombre'=>$_POST["nombreCampanha"],
            'estadoCampanha'=>1
        ];

        $idcampanha=$CampanhaModel->StorageCampanha($campanha);

        if($idcampanha!=''){
            $dato = [
                'status' => 'success',
                'title' => 'Campaña Almacenada',
                'message' => 'Se genero correctamente la campaña'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato = [
                'status' => 'danger',
                'title' => 'Error de Proceso',
                'message' => 'Ocurrio un error y no se logro almacenar la data'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}