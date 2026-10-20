<?php
namespace App\Controllers\ConfigOperaciones\GrupoUbicacion;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;
use App\Models\EventoModel;
use App\Models\ReglasModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VehiculosVendidosModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(28,86,''));

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
        // Instanciamos el modelo
        $trasladoModel=New TrasladoModel();

        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros
        $filtro='';
        // Obtener los detalles de los vehículos
        $detail = $trasladoModel->DetailGrupoUbicacion($filtro);
        // Obtener el número total de registros
        $countReg = count($trasladoModel->DetailGrupoUbicacion($filtro));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);
        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 28,
            'idmodulo' => 86,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
        ];

        // Cargar las vistas
        echo view("Layouts/Head", $dato);
        echo view("ConfigOperaciones/GrupoUbicacion/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ConfigOperaciones/GrupoUbicacion/Index/Scripts");

    }

    public function DetailIndex()
    {
        $trasladoModel=New TrasladoModel();
        $filtro = $_POST["filtro"];

        $detail = $trasladoModel->DetailGrupoUbicacion($filtro);

        $dato=[
            'detailIndex'=>$detail
        ];

        $send=[
            'status'=>'success',
            'title'=>'Resultados Encontrados',
            'message'=>'Se Encontraron los siguientes registros',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/DetailIndex/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/DetailIndex/Scripts"),
        ];
        echo json_encode($send);
        exit();
    }
}