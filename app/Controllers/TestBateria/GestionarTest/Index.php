<?php

namespace App\Controllers\TestBateria\GestionarTest;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\BateriaModel;
use App\Models\GeneralesModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use function PHPUnit\Framework\isNull;

class Index extends BaseController
{

    public function Index()
    {

        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(27,79,''));


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
        $bateriaModel=New BateriaModel();
        $generalModel=New GeneralesModel();

        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros
        // Obtener los detalles de los vehículos
        $detail = $bateriaModel->DetailIndex('','','', '', $limit, $start);
        // Obtener el número total de registros
        $countReg = count($bateriaModel->DetailIndex('','','', '', null, null));

        $enfecha=$bateriaModel->CountRegistros('','','',1);
        $porVencer=$bateriaModel->CountRegistros('','','',2);
        $vencidos=$bateriaModel->CountRegistros('','','',3);

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 27,
            'idmodulo' => 79,
            'detailIndex' => $detail,
            'finish' => $start,
            'ubicacion'=>$generalModel->UbicacionGrupoUbicacion(),
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
            'todos'=>$countReg,
            'enFecha'=>$enfecha[0]["contador"],
            'porVencer'=>$porVencer[0]["contador"],
            'vencidos'=>$vencidos[0]["contador"],
        ];

        // Cargar las vistas
        echo view("Layouts/Head", $dato);
        echo view("TestBateria/GestionarTest/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("TestBateria/GestionarTest/Index/Scripts");
    }

    public function DetailIndex()
    {
        $bateriaModel=New BateriaModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $ubicacion=$_POST["ubicacion"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $estadoAlerta=$_POST["estadoBateria"];

        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;
        // Consultar los registros paginados
        $detail = $bateriaModel->DetailIndex($ubicacion,$estadoAlerta,$tipoFiltro, $filtro, $limit, $start);
        // Obtener el número total de registros (sin paginación)
        $countReg = count($bateriaModel->DetailIndex($ubicacion,$estadoAlerta,$tipoFiltro, $filtro, null, null));


        $enfecha=$bateriaModel->CountRegistros($ubicacion,$tipoFiltro, $filtro,1);
        $porVencer=$bateriaModel->CountRegistros($ubicacion,$tipoFiltro, $filtro,2);
        $vencidos=$bateriaModel->CountRegistros($ubicacion,$tipoFiltro, $filtro,3);

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
            'tbody' => view("TestBateria/GestionarTest/DetailIndex/Index", $dats) . view("TestBateria/GestionarTest/DetailIndex/Scripts"),
            'countReg' => $countReg,
            'total' => $countReg,
            'totalRegistroPagina'=>$start,
            'currentPage' => $pagina,
            'enFecha'=>$enfecha[0]["contador"],
            'porVencer'=>$porVencer[0]["contador"],
            'vencidos'=>$vencidos[0]["contador"],
            'totalPages' => $totalPages,
            'paginationHtml' => $paginationHtml, // Agregar el HTML de paginación a la respuesta
        ];

        echo json_encode($dato);
        exit();
    }
}