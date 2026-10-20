<?php
namespace App\Controllers\ControlDemos\DemosAsignados;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveRetorno()
    {
        $controlDemo=New ControlDemosModel();
        $idasignarDemo=$_POST["idasignarDemo"];
        $vin=$_POST["vinAsignado"];

        $filtroAsignacion=[
            'vin'=>$vin,
            'idasignarDemo'=>$idasignarDemo
        ];

        $asignarUp=[
            'idestadoAsignacionDemo'=>3,
            'fechaRetornoReal'=>$_POST["fechaRetorno"],
            'horaRetornoReal'=>$_POST["horaRetorno"],
            'comentarioRetorno'=>$_POST["comentarioRetorno"],
            'checkListRetorno'=>1
        ];
        $upd=$controlDemo->UpdateAsignacionDemo($filtroAsignacion,$asignarUp);

        if($upd){

            $filtroUpdate=[
                'vin'=>$vin
            ];
            $update=[
                'idestadoLiberacion'=>1,
                'fechaUltimoRetorno'=>$_POST["fechaRetorno"],
                'kilometrajeActual'=>$_POST["kilometraje"]
            ];

            $upd=$controlDemo->UpdateLiberacionDemo($filtroUpdate,$update);


            $idcheckListDemo=$_POST["idcheckListRetorno"];

            $filtroUpCheck=[
                'idcheckListDemo'=>$idcheckListDemo
            ];

            $checkList=[
                'fecha'=>$_POST["fechaRetorno"],
                'hora'=>$_POST["horaRetorno"],
                'idinspector'=>session("idusuario"),
                'kilometrajeEntrega'=>$_POST["kilometraje"],
                'gasolinaEntrega'=>$_POST["gasolina"],
                'observaciones'=>$_POST["comentarioRetorno"],
                'idestadoCheckListDemo'=>1,
                'observacionesBajoPiso'=>$_POST["observacionesBajoPiso"]
            ];

            $upCheck=$controlDemo->UpdateCheckList($filtroUpCheck,$checkList);

            $countReso=0;
            while ($countReso < count($_POST["checkIdService"])) {
                $serviceSug=[
                    'idservicioSugerido'=>$_POST["checkIdService"][$countReso],
                    'estadoServicio'=>$_POST["checkService"][$countReso],
                    'idcheckListDemo'=>$idcheckListDemo
                ];
                $rest=$controlDemo->StorageSerivicioSugerido($serviceSug);
                $countReso=$countReso+1;
            }

            $countDet=0;
            while ($countDet < count($_POST["idinventarioDemo"])) {
                $idinventarioDemo=$_POST["idinventarioDemo"][$countDet];

                $equipado=[
                    'idcheckListDemo'=>$idcheckListDemo,
                    'idinventarioDemo'=>$idinventarioDemo,
                    'cantidad'=>$_POST["cantidadEq"][$countDet],
                    'estadoEquipamiento'=>$_POST["equipadoDemo"][$countDet]

                ];
                $ideq=$controlDemo->StorageDetailCheckList($equipado);
                $equipado=[];
                $countDet=$countDet+1;
            }

            $dato=[
                'status'=>'success',
                'title'=>'Proceso Correcto',
                'message'=>'Se Generaron correctamente los PDF',
                'idasignarDemo'=>$idasignarDemo,
                'vin'=>$vin
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'No se lograron generar los pdf'
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function UploadResource()
    {
        date_default_timezone_set("America/Lima");
        $controlDemo=New ControlDemosModel();
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $idasignarDemo=$_POST["idasignarDemoRetor"];

        $archivo = $_FILES['resourceImagen']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceImagen']['type'];
            $temp = $_FILES['resourceImagen']['name'];
            $tps=explode('/',$_FILES['resourceImagen']['type']);
            $typo=$tps[1];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    'idcheckListDemo'=>$_POST["idcheckListRetornoRetor"],
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                $path = $archivo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = $archivo;
                $resource = [
                    'idasignarDemo'=>$_POST["idasignarDemoRetor"],
                    'idcheckListDemo'=>$_POST["idcheckListRetornoRetor"],
                    'imagen' => base64_encode(file_get_contents($data)),
                    'nombreImagen'=>$temp,
                    'tipoImagen' =>$typo,
                    'fechaCarga'=>$hoy,
                    'horaCarga'=>$hora
                ];
                $storgs=$controlDemo->StorageResourceCheckList($resource);

                $return=[
                    'status'=>'success',
                    'title'=>'Archivo correcto',
                    'message'=>'Se adjunto correctamente la Imagen al check List',
                    'idcheckListDemo'=>$_POST["idcheckListRetornoRetor"],
                ];
                echo json_encode($return);
                exit();
            }
        }else{
            $return=[
                'status'=>'danger',
                'title'=>'Archivo vacio',
                'message'=>'No se encontro ',
                'idcheckListDemo'=>$_POST["idcheckListRetornoRetor"],
            ];
            echo json_encode($return);
            exit();
        }
    }
}