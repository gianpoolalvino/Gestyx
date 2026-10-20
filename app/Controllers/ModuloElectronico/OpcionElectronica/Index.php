<?php

namespace App\Controllers\ModuloElectronico\OpcionElectronica;
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

    public function ViewEvento()
    {
        $tokensPrincipal=New Tokens();
        $token = $tokensPrincipal->GenerarTokenPtesa();
        $url='https://habilitacionfer.ptesa.com.co/api/fer/companies/242/billing-documents/details?uuid='.$_POST["idcpe"];
        $headers = [
            'Authorization: Bearer '.$token,
            'Content-Type: application/json',
        ];
        $ch = curl_init();

// Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

// Obtener el código de estado HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime el código de estado HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $httpCode . PHP_EOL;
            if($httpCode=='200') {
                $json = json_decode($response);
                $dato=[
                    'cpe'=>$json,
                    'idcpe'=>$_POST["idcpe"],
                    'numeroFactura'=>$_POST["numeroFactura"]
                ];
                $send=[
                    'status'=>'success',
                    'info'=>view("ModuloElectronico/OpcionElectronica/Evento/Index/Index",$dato).view("ModuloElectronico/OpcionElectronica/Evento/Index/Scripts")
                ];
                echo json_encode($send);
                exit();

            }
        }

    }

    public function UploadEvento()
    {
        $tokensPrincipal=New Tokens();
        $token = $tokensPrincipal->GenerarTokenPtesa();
        $url='https://habilitacionfer.ptesa.com.co/api/fer/companies/242/documents/events';

        $bodySend=[
            'uuid'=>$_POST["idcpe"],
            'documentTypeId'=>(int)$_POST["typeCpe"],
            'eventTypeCode'=>$_POST["evento"],
            'eventDetail'=>[
                "person"=>[
                    'identificationTypeCode'=>session("codigoDocumentoColombia"),
                    'identification'=>session("documento"),
                    'verificationDigit'=>session("codigoVerificacionDocumento"),
                    'firstName'=>session("nombresWebService"),
                    'lastName'=>session("apellidosWebService"),
                    'jobTitle'=>session("cargo"),
                    'jobDepartment'=>session("area")
                ],
            ],
            'notificationEmails'=>[
                [
                    'email'=>session("correoUsuario"),
                    'type'=>'TO'
                ]
            ]
        ];

        $eventoSeleccionado=$_POST["evento"];
        if (strpos($eventoSeleccionado, '031') !== false) {

            $mot=explode("-",$_POST["motivoReclamo"]);
            $idreclamo=$mot[0];
            $descripcionReclamo=$mot[1];
            $bodySend['eventDetail']=
                [
                    "notes"=>[
                    $_POST["observacion"]
                ]
            ];
            $bodySend['eventDetail']['rejectionReason'] = [
                'code' => $idreclamo,
                'name' => $descripcionReclamo,
            ];
        }


        // Inicializa cURL
        $ch = curl_init($url);

        // Configura los encabezados
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Cambia esto en producción
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Cambia esto en producción

        // Convierte el cuerpo a JSON
        $jsonData = json_encode($bodySend);


        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // Ejecuta la solicitud cURL
        $response = curl_exec($ch);
        // Verifica si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime el código de estado HTTP y el contenido de la respuesta
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode == 200) {
                $json = json_decode($response, true); // Añadido true para obtener un array asociativo

                if($json["status"]=='OK'){
                    $send=[
                        'status'=>'success',
                        'title'=>'Evento Grabado',
                        'message'=>'El Evento se almaceno correctamente'
                    ];

                    echo json_encode($send);
                    exit();
                }
            }else{
                echo 'HTTP Code: ' . $httpCode . PHP_EOL;
                echo 'Response: ' . $response; // Muestra la respuesta completa del servidor
            }
        }
        // Cierra la conexión cURL
        curl_close($ch);
    }

    public function ViewDownload()
    {
        $dato=[
            'idcpe'=>$_POST["idcpe"],
            'numeroFactura'=>$_POST["numeroFactura"]
        ];
        $send=[
            'status'=>'success',
            'info'=>view("ModuloElectronico/OpcionElectronica/Download/Index/Index",$dato).view("ModuloElectronico/OpcionElectronica/Download/Index/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function Download()
    {
        $tokensPrincipal=New Tokens();

        $token = $tokensPrincipal->GenerarTokenPtesa();
        $url = 'https://habilitacionfer.ptesa.com.co/api/fer/companies/242/billing-documents/files?fileTypeId=2&uuid='.$_GET["idcpe"].'&fileTypeId='.$_GET["idtipoArchivo"];
        // $url='https://recepcion.ptesa.com.co/api/fer/companies/'.$compani.'/billingdocuments/searches';
        // Inicializa una sesión cURL
// Establece los encabezados
        $headers = [
            'Authorization: Bearer '.$token,
            'Content-Type: application/json',
        ];
        $ch = curl_init();

// Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

// Obtener el código de estado HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Verificar si hubo un error en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime el código de estado HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $httpCode . PHP_EOL;

            if($httpCode=='200'){
                $json = json_decode($response);
                $base64String = $json->base64;
                // Decodificar la cadena base64
                $decodedData = base64_decode($base64String);

                if ($decodedData === false) {
                    die('Error al decodificar la cadena base64.');
                }
                // Procesar el contenido XML

                if($_GET["idtipoArchivo"]==2){
                    $xml = simplexml_load_string($decodedData);
                    if ($xml === false) {
                        die('Error al cargar el XML.');
                    }
                    // Configurar las cabeceras para la descarga del archivo
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/xml');
                    header('Content-Disposition: attachment; filename="'.$json->originalFilename);
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . strlen($decodedData));
                    echo $decodedData;
                    exit;
                }else if($_GET["idtipoArchivo"]==3){
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment; filename="' . $json->originalFilename . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . strlen($decodedData));
                    echo $decodedData;
                }
            }
        }
    }
}