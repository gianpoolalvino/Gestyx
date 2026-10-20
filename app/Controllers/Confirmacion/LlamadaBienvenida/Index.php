<?php

namespace App\Controllers\Confirmacion\LlamadaBienvenida;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlSalidaVehicular;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(13,8,''));


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
        $alistamientoVehicular = new AlistamientoVehicularModel();
        $idevento = 8;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $filtroPrinci=[
            'ideventoActual'=>$idevento,
            'cotizacion'=>1
        ];
        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros
        $detail=$alistamientoVehicular->DetailIndexCall($filtroPrinci,'','','',$limit,$start);
        $countReg=$alistamientoVehicular->CountRegistroCall($filtroPrinci,'','','');

        $totalPages = ceil($countReg[0]["contadorTotal"] / $limit);

        $dato = [
            'idgrupoModulo' => 13,
            'idmodulo' => 8,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg[0]["contadorTotal"],
            'countReg' => $countReg[0]["contadorTotal"],
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,
        ];
        echo view("Layouts/Head", $dato);
        echo view("Confirmacion/LlamadaBienvenida/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Confirmacion/LlamadaBienvenida/Index/Scripts");
    }

    public function DetailIndex()
    {
        $alistamientoVehicular = new AlistamientoVehicularModel();
        $limit = 20; // Número de registros por página
        $idevento=8;
        $filtroPrinci=[
            'ideventoActual'=>$idevento,
            'cotizacion'=>1
        ];
        $filtro=$_POST["filtro"];
        $saldo=$_POST["saldo"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $idevento=1;
        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;


        $countReg=$alistamientoVehicular->CountRegistroCall($filtroPrinci,$tipoFiltro,$filtro,$saldo);
        $detail=$alistamientoVehicular->DetailIndexCall($filtroPrinci,$tipoFiltro,$filtro,$saldo,$limit,$start);

        // Calcular el número total de páginas
        $totalPages = ceil($countReg[0]["contadorTotal"] / $limit);

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
            'tbody'=>view("Confirmacion/LlamadaBienvenida/DetailIndex/Index",$dats).view("Confirmacion/LlamadaBienvenida/DetailIndex/Scripts"),
            'countReg' => $countReg[0]["contadorTotal"],
            'total' => $countReg[0]["contadorTotal"],
            'totalRegistroPagina'=>$start,
            'currentPage' => $pagina,
            'totalPages' => $totalPages,
            'paginationHtml' => $paginationHtml, // Agregar el HTML de paginación a la respuesta
        ];

        echo json_encode($dato);
        exit();
    }

    public function DetailIndexOld()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $idevento=8;
        $limit=10;
        $saldo=$_POST["saldo"];
        $countRegv2=$_POST["countReg"];
        $filtroPrinci=[
            'ideventoActual'=>$idevento,
            'cotizacion'=>1
        ];
        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$alistamientoVehicular->CountRegistroCall($filtroPrinci,$tipoFiltro,$filtro,$saldo);
        $detail=$alistamientoVehicular->DetailIndexCall($filtroPrinci,$tipoFiltro,$filtro,$saldo,$limit,$start);

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
            'tbody'=>view("Confirmacion/LlamadaBienvenida/DetailIndex/Index",$dats).view("Confirmacion/LlamadaBienvenida/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();

    }
}