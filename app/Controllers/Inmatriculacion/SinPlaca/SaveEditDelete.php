<?php

namespace App\Controllers\Inmatriculacion\SinPlaca;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SendERP($vin='',$placa='')
    {
        $vinModel=new VinModel();
        $vn=$vinModel->VinInfo($vin);
        $marca=$vn[0]["marca"];

        date_default_timezone_set('America/Lima');
        $fechaHoy=date("Y/m/d");
        $url='';
        if(session("database")=='logistica_peru'){
            if($marca=='CHEVROLET'){
                $url="http://190.223.25.10:8093/api/Tarjeta";
            }else if($marca=='ISUZU'){
                $url="http://190.223.25.10:8093/api/Tarjeta";
            }else{
                $url = "http://190.223.25.10:8070/api/Tarjeta";
            }
        }
        $cotiCab = [
            "TIPO"=>2,
            "SERIE"=>$vin,
            "U_SYP_NROPLC"=>$placa,
        ];
        $ch = curl_init();

// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cotiCab));  // Convertir los datos a JSON y enviarlos

// Establecer el encabezado Content-Type para JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic emlxRGpyMjNabWRjUHVzVlFDT1k3djN6YUt1eFJod2o5MFdjUWk4d29kYz06K0M1UnYwcTRZcHdoNjJvRkc0bjZ5dz09",
            'Content-Type: application/json',  // Indicar que estamos enviando JSON
            'Accept: application/json'         // Indicar que esperamos recibir JSON como respuesta
        ]);
// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        curl_close($ch);
// Decodificar la respuesta JSON
        $result=json_decode($response);
        var_dump($marca);
        return 'success';
    }
    public function SavePlaca()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $inmatriculacionModel=New InmatriculacionModel();
        $vinModel=New VinModel();

        $filtroDupli=[
            'comentarios'=>$_POST["placa"]
        ];
        //verificar Duplicados
        $count=$inmatriculacionModel->DuplicateTituloPlaca($filtroDupli);
        $contador=$count[0]["contador"];

        if($contador>0){
            $dato=[
                'status'=>'danger',
                'title'=>'Placa Duplicada',
                'message'=>'La Placa ya fue ingresada en el sistema '.$_POST["placa"]
            ];
            echo json_encode($dato);
            exit();
        }

        $filtroupd=[
            'ideventoActual'=>14,
            'vin'=>$_POST["vinExpe"]
        ];

        $evento=[
            'idestadoEvento'=>2,
            'fechaFin'=>$_POST["fechaPlaca"],
            'horaFin'=>$hora,
            'idusuariofinaliza'=>session("idusuario"),
            'comentarios'=>$_POST["placa"],
            'comentarioAdicional'=>$_POST["comentarioAdv"],
            'fechaRegistroSistemaFin'=>$hoy
        ];
        $idinmatriculacion=$inmatriculacionModel->UpdateTitulo($filtroupd,$evento);

        $filtroVin=[
            'vin'=>$_POST["vinExpe"]
        ];
        $updateVin=[
            'idtipoPlaca'=>2,
            'placa'=>$_POST["placa"]
        ];
        $updatevn=$vinModel->UpdateVin($filtroVin,$updateVin);

        if($updatevn){
            $database=session("database");

            if($database=='logistica_peru'){
                $this->SendERP($_POST["vinExpe"],$_POST["placa"]);
            }

            $dato=[
                'status'=>'success',
                'title'=>'Titulo Ingresado',
                'message'=>'Se ingreso correctamente el titulo '.$_POST["placa"]
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