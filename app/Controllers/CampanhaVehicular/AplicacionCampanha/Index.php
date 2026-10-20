<?php

namespace App\Controllers\CampanhaVehicular\AplicacionCampanha;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;
use App\Models\VehiculosVendidosModel;

class Index extends BaseController
{

    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(16,22,''));


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
        $alistamientoVehicular = new CampanhaModel();

        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros

        // Obtener los detalles de los vehículos
        $detail = $alistamientoVehicular->DetailIndex('', '', $limit, $start);

        // Obtener el número total de registros
        $countReg = count($alistamientoVehicular->DetailIndex('', '', '', ''));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 16,
            'idmodulo' => 22,
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
        echo view("CampanhaVehicular/AplicacionCampanha/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("CampanhaVehicular/AplicacionCampanha/Index/Scripts");
    }

    public function DetailIndex()
    {
        $alistamientoVehicular = new CampanhaModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];

        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        $detail = $alistamientoVehicular->DetailIndex($tipoFiltro, $filtro, $limit, $start);

        // Obtener el número total de registros
        $countReg = $alistamientoVehicular->CountRegistro($tipoFiltro, $filtro);

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Generar la paginación HTML
        $paginationHtml = '';
        if ($totalPages > 1) {
            $paginationHtml .= '<nav aria-label="Page navigation example"><ul class="pagination">';

            // Página anterior
            if ($pagina > 1) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . ($pagina - 1) . ')"><span class="fas fa-chevron-left"></span></a></li>';
            }

            // Mostrar páginas de 5 en 5
            $range = 10;
            $startPage = max(1, $pagina - floor($range / 2));
            $endPage = min($totalPages, $startPage + $range - 1);

            if ($endPage - $startPage + 1 < $range) {
                $startPage = max(1, $endPage - $range + 1);
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $activeClass = ($pagina == $i) ? 'active' : '';
                $paginationHtml .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . $i . ')">' . $i . '</a></li>';
            }

            // Página siguiente
            if ($pagina < $totalPages) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . ($pagina + 1) . ')"><span class="fas fa-chevron-right"></span></a></li>';
            }

            $paginationHtml .= '</ul></nav>';
        }

        // Preparar los datos para la respuesta
        $dats = [
            'detailIndex' => $detail,
            'countReg' => $start,
        ];

        $dato = [
            'tbody' => view("CampanhaVehicular/AplicacionCampanha/DetailIndex/Index", $dats) . view("CampanhaVehicular/AplicacionCampanha/DetailIndex/Scripts"),
            'countReg' => $countReg,
            'total' => $countReg,
            'totalRegistroPagina'=>$start,
            'currentPage' => $pagina,
            'totalPages' => $totalPages,
            'paginationHtml' => $paginationHtml, // Agregar el HTML de paginación a la respuesta
        ];
        echo json_encode($dato);
        exit();
    }
    public function Index_old()
    {
        $alistamientoVehicular = new CampanhaModel();
        $idevento = 3;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $alistamientoVehicular->DetailIndex( '', '');
        $co = $alistamientoVehicular->CountDetail( '', '');

        $dato = [
            'idgrupoModulo' => 16,
            'idmodulo' => 22,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => 0,
            'countReg' => 0
        ];
        echo view("Layouts/Head", $dato);
        echo view("CampanhaVehicular/AplicacionCampanha/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("CampanhaVehicular/AplicacionCampanha/Index/Scripts");
    }

    public function DetailIndex_old()
    {
        $alistamientoVehicular=new CampanhaModel();
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$alistamientoVehicular->CountDetail($tipoFiltro,$filtro);
        $detail=$alistamientoVehicular->DetailIndex($tipoFiltro,$filtro);

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>0,
        ];

        $dato=[
            'tbody'=>view("CampanhaVehicular/AplicacionCampanha/DetailIndex/Index",$dats).view("CampanhaVehicular/AplicacionCampanha/DetailIndex/Scripts"),
            'countReg'=>0,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }

    public function IndexCampanha()
    {
        $campanhaModel=New CampanhaModel();

        $dats=[
            'detailCampanha'=>$campanhaModel->Campanhas()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("CampanhaVehicular/AplicacionCampanha/Campanha/Index/Index",$dats).view("CampanhaVehicular/AplicacionCampanha/Campanha/Index/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}