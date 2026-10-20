<?php

namespace App\Controllers\AlistamientoVehicular\Lavado;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;

class Index extends BaseController
{

    public function Index()
    {
        // Instanciamos el modelo
        $alistamientoModel = new AlistamientoVehicularModel();
        $idevento=3;
        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros

        // Obtener los detalles de los vehículos
        $detail = $alistamientoModel->DetailIndex($idevento,'', '', $limit, $start);

        // Obtener el número total de registros
        $countReg = count($alistamientoModel->DetailIndex($idevento,'', '', '', ''));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo'=>8,
            'idmodulo'=>3,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
        ];

        // Cargar las vistas
        echo view("Layouts/Head",$dato);
        echo view("AlistamientoVehicular/Lavado/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("AlistamientoVehicular/Lavado/Index/Scripts");
    }

    public function Indexold()
    {
        $alistamientoVehicular = new AlistamientoVehicularModel();
        $idevento = 3;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $alistamientoVehicular->DetailIndex($idevento, '', '', $limit, $start);
        $countReg = count($alistamientoVehicular->DetailIndex($idevento,'', '', '', ''));
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;
        }
        $dato = [
            'idgrupoModulo' => 8,
            'idmodulo' => 3,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => 0,
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("AlistamientoVehicular/Lavado/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("AlistamientoVehicular/Lavado/Index/Scripts");
    }

    public function DetailIndex()
    {
        $alistamientoVehicular = new AlistamientoVehicularModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $idevento=3;
        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        // Consultar los registros paginados
        $detail = $alistamientoVehicular->DetailIndex($idevento,$tipoFiltro, $filtro, $limit, $start);

        // Obtener el número total de registros (sin paginación)
        $countReg = $alistamientoVehicular->CountRegistro($idevento,$tipoFiltro, $filtro);

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
            'tbody'=>view("AlistamientoVehicular/Lavado/DetailIndex/Index",$dats).view("AlistamientoVehicular/Lavado/DetailIndex/Scripts"),
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

    public function DetailIndexold()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $idevento=3;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$alistamientoVehicular->CountRegistro($idevento,$tipoFiltro,$filtro);
        $detail=$alistamientoVehicular->DetailIndex($idevento,$tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("AlistamientoVehicular/Lavado/DetailIndex/Index",$dats).view("AlistamientoVehicular/Lavado/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}