<?php

namespace App\Controllers\PowerBi;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\OpcionesGeneralesModel;
use App\Models\ReportesGeneralModel;
use App\Models\VinModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Principal extends BaseController
{

    public function IngresoTraslado()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,85,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }

        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 85,
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/IngresoTraslado/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/IngresoTraslado/Index/Scripts");
    }
    public function Peru()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }

        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/Principal/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/Principal/Index/Scripts");
    }

    public function Colombia()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,66,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',

            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 66,
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/Colombia/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/Colombia/Index/Scripts");
    }


        public function VehiculosTallerChevroletColombia()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,82,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 82,
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/VehiculosTallerChevroletColombia/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/VehiculosTallerChevroletColombia/Index/Scripts");
    }


    public function Posventa()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,1));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>1
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/Posventa/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/Posventa/Index/Scripts");
    }

    public function CreditosSeguros()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,9));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>9
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/CreditosSeguros/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/CreditosSeguros/Index/Scripts");
    }

    public function Industria()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,2));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>2
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/Industria/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/Industria/Index/Scripts");
    }

    public function Rrhh()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,69,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 69,
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/Rrhh/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/Rrhh/Index/Scripts");
    }

    public function LeadsComercial()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,3));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>3
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/LeadsComercial/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/LeadsComercial/Index/Scripts");
    }

    public function LeadsPosventa()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,4));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>4
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/LeadsPosventa/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/LeadsPosventa/Index/Scripts");
    }

    public function HistoricoClienteTaller()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,5));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>5
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/HistoricoClienteTaller/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/HistoricoClienteTaller/Index/Scripts");
    }

    public function ReporteObsequios()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,7));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        // Datos de configuración de tu aplicación registrada en Azure AD
        $tenant_id = '36b54355-3871-4240-b1ee-3e65eeeabb93';  // Reemplaza con tu tenant ID
        $client_id = 'c5c6327e-ede3-4f7b-b920-96097e2d8adf';  // Reemplaza con tu client ID
        $client_secret = env('azure.clientSecret'); // Reemplaza con tu client secret
        $scope = 'https://graph.microsoft.com/.default';  // Puede variar dependiendo del permiso requerido
        $grant_type = 'client_credentials';  // Usamos el grant_type de client_credentials

// Endpoint de autenticación de Azure AD para obtener el token
        $token_url = "https://login.microsoftonline.com/{$tenant_id}/oauth2/v2.0/token";

// Datos que se enviarán en la solicitud de token
        $post_data = [
            'grant_type' => $grant_type,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'scope' => $scope,
        ];

// Inicializar cURL para realizar la solicitud
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));  // Enviar los datos como 'application/x-www-form-urlencoded'

// Ejecutar la solicitud
        $response = curl_exec($ch);
        curl_close($ch);

// Verificar si se obtuvo el token correctamente
        if ($response === false) {
            die('Error al obtener el token de acceso.');
        }

// Convertir la respuesta en formato JSON
        $response_data = json_decode($response, true);
        $access_token='';
// Verificar si el token de acceso está presente en la respuesta
        if (isset($response_data['access_token'])) {
            // Almacenar el Access Token
            $access_token = $response_data['access_token'];

        } else {
            $access_token='';
        }


        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>7,
            'token'=>$access_token
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/ReporteObsequios/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/ReporteObsequios/Index/Scripts");
    }

    public function OrdenesTrabajoAbiertasPeruSac()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,8));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>8
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/OrdenesTrabajoAbiertasPeruSac/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/OrdenesTrabajoAbiertasPeruSac/Index/Scripts");
    }

    public function OrdenerTrabajoAbiertasSac()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,6));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>6
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/OrdenerTrabajoAbiertasSac/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/OrdenerTrabajoAbiertasSac/Index/Scripts");
    }

    public function IndicadorEncuestaInterna()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,10));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>10
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/IndicadorEncuestaInterna/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/IndicadorEncuestaInterna/Index/Scripts");
    }

    public function TrackingVentas()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,11));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>11
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/TrackingVentas/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/TrackingVentas/Index/Scripts");
    }

    public function EstadoFinanciero()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(25,58,12));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
                'idsubModulo'=>''
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $dato = [
            'idgrupoModulo' => 25,
            'idmodulo' => 58,
            'idsubModulo'=>12
        ];
        echo view("Layouts/Head", $dato);
        echo view("PowerBi/EstadoFinanciero/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("PowerBi/EstadoFinanciero/Index/Scripts");
    }

}