<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\VinModel;


class Tokens extends BaseController
{
    public function AccessRolUser($idgrupoModulo='',$idmodulo='',$idsubModulo=''){

        if(session('idusuario')){
            $idusuario=session('idusuario');
            $accessUsuario=New AccessModel();
            $access='';

            $filtroValidador= [
                'idgrupoModulo' => $idgrupoModulo,
                'idusuario'=>$idusuario
            ];
            if($idmodulo!=''){
                $filtroValidador+= [
                    'idmodulo' => $idmodulo,
                ];
            }

            $validar=$accessUsuario->ValidadorAccess($filtroValidador);

            if($idsubModulo!=''){
                $filtro=[
                    // 'idgrupoModulo' => $idgrupoModulo,
                    'idusuario'=>$idusuario
                ];
                $subvali=$accessUsuario->ValidarAccessSubModulo($filtro);
                if($validar && !$subvali){
                    $access='error';
                }else if(!$validar && !$subvali){
                    $access='error';
                }else if($validar && $subvali){
                    $access='success';
                }
            }else{
                if(!$validar){
                    $access='error';
                }else{
                    $access='success';
                }
            }

            $send=[
                'status' => $access,
            ];

            return json_encode($send);
        }else if(!session('idusuario')){
            header('Location: '.base_url());
            exit;
        }
    }

    public function SendSocketGestyx()
    {

    }
    public function GenerarTokenPtesa(){
        // URL del endpoint para obtener el token
        $url = 'https://sso.ptesa.com.co/auth/realms/ptesa/protocol/openid-connect/token';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = [
            'client_id' => 'invoice-receipt-autoniza',
            'grant_type' => 'client_credentials',
            'client_secret' => '6c50282b-4755-498b-b150-bf3f12a5f901'
        ];
// Convierte los datos a formato URL-encoded
        $encodedData = http_build_query($data);
// Configura los campos de POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
// Configura los encabezados
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Ejecuta la solicitud cURL
        $response = curl_exec($ch);
// Verifica si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime la respuesta del servidor
            return json_decode($response)->access_token;
        }
// Cierra la sesión cURL
        curl_close($ch);
    }
}



