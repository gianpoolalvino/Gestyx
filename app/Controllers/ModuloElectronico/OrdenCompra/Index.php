<?php

namespace App\Controllers\ModuloElectronico\OrdenCompra;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\GeneralesModel;
use App\Models\IngresoModel;
use App\Models\InventarioModel;


class Index extends BaseController
{
    public function Index()
    {
        $generalModel=New GeneralesModel();
        $ingresoModel=New IngresoModel();


        $limit=10;
        $start=0;
        $finish=10;
        $dato=[
            'idgrupoModulo'=>23,
            'idmodulo'=>52,
        ];

        echo view("Layouts/Head",$dato);
        echo view("ModuloElectronico/OrdenCompra/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ModuloElectronico/OrdenCompra/Index/Scripts",$dato);
    }

    public function DetailIndex()
    {
        set_time_limit(0);
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $fechaInicio=isset($_POST["fechaInicio"])?$_POST["fechaInicio"]:$hoy;
        $fechaFin=isset($_POST["fechaFin"])?$_POST["fechaFin"]:$hoy;
        // $compani=100025;
        $url = 'http://localhost/temporalSincroniza/OrdenesCompraDms.php';
        $ch = curl_init($url);
        $headers = [
            'Authorization: Bearer b=tQ1GB6f4BA2NG6byKs4WkDZxqdboTEgUp!2AfAq/FT/eqbX9g6rpBmDhQtspc7',
            'Content-Type: application/json',
        ];
        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Define los datos a enviar en la solicitud POST
        $data = [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'tipoOc'=>$_POST["tipoOc"]
        ];
        // Convierte los datos a formato JSON
        $jsonData = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // Ejecuta la solicitud cURL
        $response = curl_exec($ch);
        // Verifica si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime el código de estado HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $codehtml=$httpCode . PHP_EOL;
            // Imprime la respuesta del servidor
            if($codehtml=='200'){
                $json=json_decode($response);
                if($json->status=='success'){
                    $res=$this->ConsultaFacturasWebService($fechaInicio,$fechaFin);
                    $result=[
                        'detailIndex'=>$json->detail,
                    ];
                    if(json_decode($res)->status=='success'){
                        $result+=[
                            'detailIndexWebService'=>json_decode($res)->details
                        ];
                    }
                    $send=[
                        'status'=>'success',
                        'info'=>view("ModuloElectronico/OrdenCompra/DetailIndex/Index",$result).view("ModuloElectronico/OrdenCompra/DetailIndex/Scripts")
                    ];
                    echo json_encode($send);
                    exit();
                }
            }
        }
        curl_close($ch);
    }

    public function ConsultaFacturasWebService($fechaInicio='',$fechaFin='')
    {
        $tokensPrincipal=New Tokens();
        set_time_limit(0);
        $token = $tokensPrincipal->GenerarTokenPtesa();
        $url = 'https://habilitacionfer.ptesa.com.co/api/fer/companies/242/billing-documents/searches';
        // $url='https://recepcion.ptesa.com.co/api/fer/companies/'.$compani.'/billingdocuments/searches';
        // Inicializa una sesión cURL
        $ch = curl_init($url);
// Establece los encabezados
        $headers = [
            'Authorization: Bearer '.$token,
            'Content-Type: application/json',
        ];
        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $timestamp = strtotime($fechaInicio);
        // Sumar 40 días a la marca de tiempo
        $nuevaFechaTimestamp = strtotime('-40 days', $timestamp);
        // Convertir la nueva marca de tiempo a una fecha legible
        $fechaIn = date('Y-m-d', $nuevaFechaTimestamp);

        // Define los datos a enviar en la solicitud POST
        $data = [
            'issueDateRange' => [
                'startDate' => $fechaIn.'T00:00:00-05:00',
                'endDate' => $fechaFin.'T23:59:59-05:00'
            ],
        ];

// Convierte los datos a formato JSON
        $jsonData = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// Ejecuta la solicitud cURL
        $response = curl_exec($ch);
// Verifica si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime el código de estado HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $httpCode . PHP_EOL;
            $dtl=[];
            if($httpCode=='200'){
                $json=json_decode($response);
                $details=$json->documents;
                $result=[
                    'status'=>'success',
                    'details'=>$details
                ];
                return json_encode($result);
                exit();
            }else{
                $result=[
                    'status'=>'danger',
                ];
                return json_encode($result);
                exit();
            }
        }
// Cierra la sesión cURL
        curl_close($ch);
    }
}