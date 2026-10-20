<?php

namespace App\Controllers\ModuloElectronico\FacturaElectronica;
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
            'idmodulo'=>53,
        ];

        echo view("Layouts/Head",$dato);
        echo view("ModuloElectronico/FacturaElectronica/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ModuloElectronico/FacturaElectronica/Index/Scripts",$dato);
    }

    public function DetailIndex()
    {
        $tokensPrincipal=New Tokens();

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


// Define los datos a enviar en la solicitud POST
        $data = [
            'issueDateRange' => [
                'startDate' => $_POST["fechaInicio"].'T00:00:00-05:00',
                'endDate' => $_POST["fechaFin"].'T23:59:59-05:00'
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
                foreach($details as $di){
                    $numeroFactura=$di->identification;
                    $documentoProveedor=$di->issuer->identification;
                    $erp=$this->ApiFacturaErp($numeroFactura,$documentoProveedor);
                    $rp=json_decode($erp);
                    $dtl[]=[
                        'nroOc'=>$rp->nroOc,
                        'uuid'=>$di->uuid,
                        'usuarioOc'=>$rp->nombreUsuarioOc,
                        'numeroFactura'=>$rp->numeroFactura,
                        'prefix'=>$di->prefix,
                        'identification'=>$di->identification,
                        'creationDate'=>$di->creationDate,
                        'issueDate'=>$di->issueDate,
                        'documentoProveedor'=>$di->issuer->identification,
                        'nombreProveedor'=>$di->issuer->name,
                        'events'=>$di->events,
                        'total'=>$di->totals->payableAmount
                    ];
                }
                $result=[
                    'detailIndex'=>$dtl
                ];
                $send=[
                    'status'=>'success',
                    'info'=>view("ModuloElectronico/FacturaElectronica/DetailIndex/Index",$result).view("ModuloElectronico/FacturaElectronica/DetailIndex/Scripts")
                ];
                echo json_encode($send);
                exit();
            }
        }
// Cierra la sesión cURL
        curl_close($ch);
    }

    private function ApiFacturaErp($numeroFactura='',$docProveedor='')
    {
        // URL del endpoint
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        // $compani=100025;
        $url = 'http://localhost/temporalSincroniza/FacturasOrdenesMatch.php';
        //  $url='https://recepcion.ptesa.com.co/api/fer/companies/'.$compani.'/billingdocuments/searches';
// Inicializa una sesión cURL
        $ch = curl_init($url);
// Establece los encabezados
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
            'numeroFactura' => $numeroFactura,
            'docProveedor' => $docProveedor,
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
                    return json_encode([
                        'nroOc'=>$json->detail->nroOc,
                        'nombreUsuarioOc'=>$json->detail->nombreUsuarioOc,
                        'numeroFactura'=>$json->detail->numeroFactura
                    ]);
                }else if($json->status=='noExist'){
                    return json_encode([
                        'nroOc'=>'No Existe',
                        'nombreUsuarioOc'=>'No Existe',
                        'numeroFactura'=>'No Existe'
                    ]);
                }

            }else{
                return $httpCode . PHP_EOL;
            }
        }
// Cierra la sesión cURL
        curl_close($ch);
    }
}