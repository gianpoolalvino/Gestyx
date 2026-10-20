<?php

namespace App\Controllers\Inventario;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Index extends BaseController
{

    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(2,'',''));


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
        $inventarioModel =New InventarioModel();
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros
        $detail = $inventarioModel->DetailIndex('', '', $limit, $start);
        $countReg = count($inventarioModel->DetailIndex('', '', '', ''));
        $totalPages = ceil($countReg / $limit);

        $dato = [
            'idgrupoModulo' => 2,
            'idmodulo' => '',
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual

        ];
        echo view("Layouts/Head", $dato);
        echo view("Inventario/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inventario/Index/Scripts");
    }
    public function Index_old()
    {
        $inventarioModel =New InventarioModel();
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $inventarioModel->DetailIndex('', '', $limit, $start);
        $co = $inventarioModel->CountDetail('', '');

        $dato = [
            'idgrupoModulo' => 2,
            'idmodulo' => '',
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => 0,

        ];
        echo view("Layouts/Head", $dato);
        echo view("Inventario/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inventario/Index/Scripts");
    }

    public function DetailIndex()
    {
        $inventarioModel = new InventarioModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];

        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        // Consultar los registros paginados
        $detail = $inventarioModel->DetailIndex($tipoFiltro, $filtro, $limit, $start);

        // Obtener el número total de registros (sin paginación)
        $countReg = $inventarioModel->CountDetail($tipoFiltro, $filtro);

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
            'tbody'=>view("Inventario/DetailIndex/Index",$dats).view("Inventario/DetailIndex/Scripts"),
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

    public function DetailIndex_old()
    {
        $inventarioModel=New InventarioModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$inventarioModel->CountDetail($tipoFiltro,$filtro);
        $detail=$inventarioModel->DetailIndex($tipoFiltro,$filtro,$limit,$start);
        $cnt=0;
        foreach($detail as $dt){
            $cnt++;
        }

        $countReg=$cnt+$countRegv2;

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
        ];

        $dato=[
            'tbody'=>view("Inventario/DetailIndex/Index",$dats).view("Inventario/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}