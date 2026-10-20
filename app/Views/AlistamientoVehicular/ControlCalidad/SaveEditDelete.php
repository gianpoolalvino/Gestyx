<?php
namespace App\Controllers\AlistamientoVehicular\ControlCalidad;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function UpdateReporte()
    {
        date_default_timezone_set("America/Lima");
        $fecha=date("Y-m-d");
        $hora=date("H:i:s");
        $controlcalidad=New ControlCalidadModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        $countErrorsC=0;
        $countTotalC=0;
        $countObs=0;
        $countEqC=0;
        $countErrorsEqC=0;
        $countFallidos=0;
        $reportecalidad=[];
        $idreporteCalidad=$_POST["idreporteCalidad"];
        $vin=$_POST["vinReporteCalidad"];

        $filtEvent=[
            'vin'=>$vin,
            'ideventoActual'=>7,
            'idestadoEvento'=>1
        ];

        $eventoCalida=$eventoModel->ViewEventoVin($filtEvent);

        $filtroEq=[
            'idprocesoCalidad'=>$idreporteCalidad
        ];
        $detalleEq=$controlcalidad->EquipamientoCalidad($filtroEq);
        $detCheckCali=$controlcalidad->DetalleCheckCalidad($filtroEq);

        foreach($detalleEq as $detEq){
            if($detEq["estadoEquipamientoCalidad"]==3){
                $countErrorsEqC++;
            }
            if($detEq["estadoEquipamientoCalidad"]==5){
                $countFallidos++;
            }
            if($detEq["estadoEquipamientoCalidad"]==2){
                $countObs++;
            }
        }

        foreach($detCheckCali as $ch){
            if($ch["estado"]==3){
                $countErrorsC++;
            }
            if($ch["estado"]==5){
                $countFallidos++;
            }
            if($ch["estado"]==2){
                $countObs++;
            }
        }

        if($countErrorsC>0 || $countErrorsEqC>0){
            $dato=[
                'status'=>'danger',
                'title'=>'Check List Pendientes',
                'message'=>'Tiene '.($countErrorsC+$countErrorsEqC).' de check list pendientes'
            ];
            echo json_encode($dato);
            exit();
        }


        if($countFallidos>0){
            $dato=[
                'status'=>'danger',
                'title'=>'Checks por Corregir',
                'message'=>'El Reporte tiene Check pendientes de correccion, verifiquelos y reintente'
            ];
            echo json_encode($dato);
            exit();
        }

        $estadoProceso=0;

        if($countObs>0){
            $reportecalidad+=[
                'idestadoProceso'=>3,
                'fechaObs'=>$fecha,
                'horaObs'=>$hora
            ];
        }else{
            $reportecalidad+=[
                'idestadoProceso'=>2,
                'fechaFin'=>$fecha,
                'horaFin'=>$hora
            ];
        }

        $reportecalidad+=[
            'idusuarioFinal'=>session("idusuario")
        ];

        $filtroCalidad=[
            'idprocesoCalidad'=>$idreporteCalidad
        ];

        $update=$controlcalidad->UpdateReporteCalidad($filtroCalidad,$reportecalidad);

        $filtroOrd=[
            'idevento'=>7
        ];
        $odpdi=$eventoModel->OrdenEvento($filtroOrd);
        $ordenNuevoEvent=$odpdi[0]['orden']+1;

        $filtrOn=[
            'orden'=>$ordenNuevoEvent
        ];
        $odnuEv=$eventoModel->OrdenEvento($filtrOn);

        if($update){
            $filtroEventoAnterior=[
                'ideventoActual'=>7,
                'vin'=>$_POST["vinReporteCalidad"],
                'idestadoEvento'=>1
            ];
            $eventoAnterior=[
                'fechaFin'=>$fecha,
                'idestadoEvento'=>2,
                'horaFin'=>$hora,
                'idusuarioFinaliza'=>session("idusuario"),
                'comentarios'=>$_POST["comentarioReporteCalidad"]
            ];
            $updt=$eventoModel->UpdateEvento($filtroEventoAnterior,$eventoAnterior);

            $filtroVin=[
                'vin'=>$_POST["vinReporteCalidad"]
            ];

            $vinFil=$_POST["vinReporteCalidad"];
            $vinInfo=$vinModel->VinInfo($vinFil);
            $updateVin=[];
            $eventoActual=[];
            if($vinInfo[0]["idestadoVin"]==6){
                $updateVin+=[
                    'ideventoAnterior'=>7,
                    'eventoAnterior'=>'Control de Calidad',
                    'eventoActual'=>'Listo para Enviar Exhibicion',
                    'fechaEventoAnterior'=>$fecha,
                    'horaEventoAnterior'=>$hora
                ];
                $eventoActual+=[
                    'ideventoActual'=>31,
                    'eventoActual'=>'Listo para Exhibicion',
                    'fechaInicio'=>$fecha,
                    'horaInicio'=>$hora,
                    'vin'=>$vin,
                    'idusuario'=>session("idusuario"),
                    'ideventoAnterior'=>7,
                    'eventoAnterior'=>'Control de Calidad',
                    'idestadoEvento'=>1
                ];
            }else{
                $updateVin+=[
                    'ideventoAnterior'=>7,
                    'eventoAnterior'=>'Control de Calidad',
                    'ideventoActual'=>$odnuEv[0]['idevento'],
                    'eventoActual'=>$odnuEv[0]['descripcionOrden'],
                    'fechaEventoAnterior'=>$fecha,
                    'horaEventoAnterior'=>$hora
                ];
                $eventoActual+=[
                    'ideventoActual'=>$odnuEv[0]['idevento'],
                    'eventoActual'=>$odnuEv[0]['descripcionOrden'],
                    'fechaInicio'=>$fecha,
                    'horaInicio'=>$hora,
                    'vin'=>$vin,
                    'idusuario'=>session("idusuario"),
                    'ideventoAnterior'=>7,
                    'eventoAnterior'=>'Control de Calidad',
                    'idestadoEvento'=>1
                ];
            }

            $updateVn=$vinModel->UpdateVin($filtroVin,$updateVin);

            $stor=$eventoModel->StorageEvento($eventoActual);

            if($stor!=""){
                $dato=[
                    'status'=>'success',
                    'title'=>'Proceso Finalizado',
                    'message'=>'Se Genero el reporte de Calidad ya puede agendar el Vin'
                ];
                echo json_encode($dato);
            }else{
                $dato=[
                    'status'=>'danger',
                    'title'=>'Proceso Errado',
                    'message'=>'No se logro almacenar el reporte'
                ];
                echo json_encode($dato);
            }
        }
    }
    public function UpdateEquipamientoCalidadoold()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad=New ControlCalidadModel();
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $idequipamientoCalidad=$_POST["idequipamientoCalidad"];

        $equipamienCalidad=[
            'idestado'=>$_POST["estadoCalidad"],
            'fecha'=>$_POST["fechaRevision"],
            'comentarios'=>$_POST["comentEquipamiento"]
        ];

        $archivo = $_FILES['resourceEquipamiento']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceEquipamiento']['type'];
            $temp = $_FILES['resourceEquipamiento']['name'];
            $tps = explode('/', $_FILES['resourceEquipamiento']['type']);
            $typo = $tps[1];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                $path = $archivo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = $archivo;
                $equipamienCalidad+=[
                    'imagenAdjunto' => base64_encode(file_get_contents($data)),
                    'nombreImagen' => $temp,
                    'tipoImagen' => $typo,
                    'fechaCarga' => $hoy,
                    'horaCarga' => $hora
                ];
            }
        }

        $filtro=[
            'iddetalleEquipamientoCalidad'=>$idequipamientoCalidad
        ];

        $update=$controlCalidad->UpdateEquipamientoCalidad($filtro,$equipamienCalidad);

        if($update){
            $equipamienCalidad+=[
                'iddetalleEquipamientoCalidad'=>$idequipamientoCalidad
            ];
            $store=$controlCalidad->StorageLogEquipamientoCalidad($equipamienCalidad);

            $dato=[
                'status'=>'success',
                'title'=>'Verificado',
                'message'=>'Registrado correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'No se logro procesar la data'
            ];
            echo json_encode($dato);
            exit();
        }

    }

    public function UpdateEquipamientoCalidad()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad = New ControlCalidadModel();
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");

        $idequipamientoCalidad = $_POST["idequipamientoCalidad"];
        $vin=$_POST["vinEq"];

        $equipamienCalidad = [
            'idestado' => $_POST["estadoCalidad"],
            'fecha' => $_POST["fechaRevision"],
            'comentarios' => $_POST["comentEquipamiento"]
        ];

        $archivo = $_FILES['resourceEquipamiento']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            // Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceEquipamiento']['type'];
            $temp = $_FILES['resourceEquipamiento']['name'];
            $tps = explode('/', $_FILES['resourceEquipamiento']['type']);
            $typo = $tps[1];

            // Se comprueba si el archivo a cargar es correcto observando su extensión
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                // Directorio donde se guardarán las imágenes (asegúrate de que sea accesible y escribible)
                $directorioImagenes = "controlcalidad/vins/".$vin."/";

                // Asegurarse de que el directorio existe
                if (!is_dir($directorioImagenes)) {
                    mkdir($directorioImagenes, 0777, true);
                }

                // Crear un nombre único para la imagen
                $nombreImagen = uniqid() . "." . $typo;

                // Movemos el archivo a la carpeta de imágenes
                $rutaImagen = $directorioImagenes . $nombreImagen;

                if (move_uploaded_file($archivo, $rutaImagen)) {
                    // Actualizamos la información del equipamienCalidad con la ruta de la imagen
                    $equipamienCalidad += [
                        'rutaImagen' => $rutaImagen, // Ruta de la imagen en el servidor
                        'idtipoCarga' => 2,           // El tipo de carga es 2 para diferenciarla
                        'nombreImagen' => $temp,
                        'tipoImagen' => $typo,
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora
                    ];
                } else {
                    $dato = [
                        "status" => "danger",
                        "title" => "Error de carga",
                        "message" => "No se pudo guardar la imagen en el servidor"
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }

        // Filtro para actualizar el equipamiento
        $filtro = [
            'iddetalleEquipamientoCalidad' => $idequipamientoCalidad
        ];

        // Llamada para actualizar la información
        $update = $controlCalidad->UpdateEquipamientoCalidad($filtro, $equipamienCalidad);

        if ($update) {
            $equipamienCalidad += [
                'iddetalleEquipamientoCalidad' => $idequipamientoCalidad
            ];

            // Almacenamos en el log de equipamiento
            $store = $controlCalidad->StorageLogEquipamientoCalidad($equipamienCalidad);

            $dato = [
                'status' => 'success',
                'title' => 'Verificado',
                'message' => 'Registrado correctamente'
            ];
            echo json_encode($dato);
            exit();
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'No se logró procesar la data'
            ];
            echo json_encode($dato);
            exit();
        }
    }


    public function StorageCheckCalidadDinamicoold()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad=New ControlCalidadModel();
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $idgrupoCheckCalidad=$_POST["idgrupoCheckId"];

        $checkCalidad=[
            'tituloCheckCalidad'=>$_POST["tituloCheck"],
            'idgrupoCheckCalidad'=>$idgrupoCheckCalidad,
            'idprocesoCalidad'=>$_POST["procesoCalidad"],
            'estado'=>$_POST["estadoCalidad"],
            'comentarios'=>$_POST["comentariocheckCalidad"],
            'fecha'=>$_POST["fechaRevision"],
            'hora'=>$hora
        ];

        $archivo = $_FILES['resourceCheckCalidad']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceCheckCalidad']['type'];
            $temp = $_FILES['resourceCheckCalidad']['name'];
            $tps = explode('/', $_FILES['resourceCheckCalidad']['type']);
            $typo = $tps[1];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                $path = $archivo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = $archivo;
                $checkCalidad+=[
                    'imagenAdjunto' => base64_encode(file_get_contents($data)),
                    'nombreImagen' => $temp,
                    'tipoImagen' => $typo,
                    'fechaCarga' => $hoy,
                    'horaCarga' => $hora
                ];
            }
        }


        $iddetalleCheckCalidad=$controlCalidad->StorageDetalleCheckCalidad($checkCalidad);

        $checkCalidad+=[
            'iddetalleReporteCheckListCalidad'=>$iddetalleCheckCalidad
        ];

        $stor=$controlCalidad->StorageLogCheckCalidad($checkCalidad);

        if($iddetalleCheckCalidad!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Verificado',
                'message'=>'Registrado correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'No se logro procesar la data'
            ];
            echo json_encode($dato);
            exit();
        }

    }

    public function StorageCheckCalidadDinamico()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad = New ControlCalidadModel();
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $idgrupoCheckCalidad = $_POST["idgrupoCheckId"];

        $vin=$_POST["vinEq"];

        $checkCalidad = [
            'tituloCheckCalidad' => $_POST["tituloCheck"],
            'idgrupoCheckCalidad' => $idgrupoCheckCalidad,
            'idprocesoCalidad' => $_POST["procesoCalidad"],
            'estado' => $_POST["estadoCalidad"],
            'comentarios' => $_POST["comentariocheckCalidad"],
            'fecha' => $_POST["fechaRevision"],
            'hora' => $hora
        ];

        $archivo = $_FILES['resourceCheckCalidad']['tmp_name'];

        if (isset($archivo) && $archivo != "") {
            // Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceCheckCalidad']['type'];
            $temp = $_FILES['resourceCheckCalidad']['name'];
            $tps = explode('/', $_FILES['resourceCheckCalidad']['type']);
            $typo = $tps[1];

            // Se comprueba si el archivo a cargar es correcto observando su extensión
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                // Directorio donde se guardarán las imágenes (asegúrate de que sea accesible y escribible)
                $directorioImagenes = "controlcalidad/vins/".$vin."/";

                // Asegurarse de que el directorio existe
                if (!is_dir($directorioImagenes)) {
                    mkdir($directorioImagenes, 0777, true);
                }

                // Crear un nombre único para la imagen
                $nombreImagen = uniqid() . "." . $typo;

                // Movemos el archivo a la carpeta de imágenes
                $rutaImagen = $directorioImagenes . $nombreImagen;

                if (move_uploaded_file($archivo, $rutaImagen)) {
                    // Actualizamos la información del checkCalidad con la ruta de la imagen
                    $checkCalidad += [
                        'rutaImagen' => $rutaImagen, // Ruta de la imagen en el servidor
                        'idtipoCarga' => 2,           // El tipo de carga es 2 para diferenciarla
                        'nombreImagen' => $temp,
                        'tipoImagen' => $typo,
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora
                    ];
                } else {
                    $dato = [
                        "status" => "danger",
                        "title" => "Error de carga",
                        "message" => "No se pudo guardar la imagen en el servidor"
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }

        $iddetalleCheckCalidad = $controlCalidad->StorageDetalleCheckCalidad($checkCalidad);

        $checkCalidad += [
            'iddetalleReporteCheckListCalidad' => $iddetalleCheckCalidad
        ];

        $stor = $controlCalidad->StorageLogCheckCalidad($checkCalidad);

        if ($iddetalleCheckCalidad != '') {
            $dato = [
                'status' => 'success',
                'title' => 'Verificado',
                'message' => 'Registrado correctamente'
            ];
            echo json_encode($dato);
            exit();
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'No se logró procesar la data'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function UpdateCheckCalidadold2()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad = New ControlCalidadModel();
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $vin=$_POST["vinEq"];

        $idcheckCalidad = $_POST["idcheckCalidad"];

        $checkCalidad = [
            'estado' => $_POST["estadoCalidad"],
            'comentarios' => $_POST["comentariocheckCalidad"],
            'fecha' => $_POST["fechaRevision"],
            'hora' => $hora
        ];

        $archivo = $_FILES['resourceCheckCalidad']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            // Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceCheckCalidad']['type'];
            $temp = $_FILES['resourceCheckCalidad']['name'];
            $tps = explode('/', $_FILES['resourceCheckCalidad']['type']);
            $typo = $tps[1];

            // Se comprueba si el archivo a cargar es correcto observando su extensión
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                // Directorio donde se guardarán las imágenes (asegúrate de que sea accesible y escribible)
                $directorioImagenes = "controlcalidad/vins/".$vin."/";

                // Asegurarse de que el directorio existe
                if (!is_dir($directorioImagenes)) {
                    mkdir($directorioImagenes, 0777, true);
                }

                // Crear un nombre único para la imagen
                $nombreImagen = uniqid() . "." . $typo;

                // Movemos el archivo a la carpeta de imágenes
                $rutaImagen = $directorioImagenes . $nombreImagen;

                if (move_uploaded_file($archivo, $rutaImagen)) {
                    // Actualizamos la información del checkCalidad con la ruta de la imagen
                    $checkCalidad += [
                        'rutaImagen' => $rutaImagen, // Ruta de la imagen en el servidor
                        'idtipoCarga' => 2,           // El tipo de carga es 2 para diferenciarla
                        'nombreImagen' => $temp,
                        'tipoImagen' => $typo,
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora
                    ];
                } else {
                    $dato = [
                        "status" => "danger",
                        "title" => "Error de carga",
                        "message" => "No se pudo guardar la imagen en el servidor"
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }

        // Filtro para actualizar el check de calidad
        $filtro = [
            'iddetalleCheckListCalidad' => $idcheckCalidad,
        ];

        // Llamada para actualizar la información
        $update = $controlCalidad->UpdateDetalleCheckCalidad($filtro, $checkCalidad);

        $checkCalidad += [
            'iddetalleReporteCheckListCalidad' => $idcheckCalidad
        ];
        // Almacenamos en el log de check de calidad
        $stor = $controlCalidad->StorageLogCheckCalidad($checkCalidad);

        if ($update) {
            $dato = [
                'status' => 'success',
                'title' => 'Verificado',
                'message' => 'Registrado correctamente'
            ];
            echo json_encode($dato);
            exit();
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'No se logró procesar la data'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function UpdateCheckCalidad()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad = New ControlCalidadModel();
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $vin = $_POST["vinEq"];
        $idcheckCalidad = $_POST["idcheckCalidad"];

        $checkCalidad = [
            'estado' => $_POST["estadoCalidad"],
            'comentarios' => $_POST["comentariocheckCalidad"],
            'fecha' => $_POST["fechaRevision"],
            'hora' => $hora
        ];

        // Datos de la imagen, si se proporciona
        $rutaImagen = null;
        $idtipoCarga = null;
        $nombreImagen = null;
        $tipoImagen = null;

        $archivo = $_FILES['resourceCheckCalidad']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            // Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceCheckCalidad']['type'];
            $temp = $_FILES['resourceCheckCalidad']['name'];
            $tps = explode('/', $_FILES['resourceCheckCalidad']['type']);
            $typo = $tps[1];

            // Se comprueba si el archivo a cargar es correcto observando su extensión
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                // Directorio donde se guardarán las imágenes (asegúrate de que sea accesible y escribible)
                $directorioImagenes = "controlcalidad/vins/".$vin."/";

                // Asegurarse de que el directorio existe
                if (!is_dir($directorioImagenes)) {
                    mkdir($directorioImagenes, 0777, true);
                }

                // Crear un nombre único para la imagen
                $nombreImagen = uniqid() . "." . $typo;

                // Movemos el archivo a la carpeta de imágenes
                $rutaImagen = $directorioImagenes . $nombreImagen;

                if (move_uploaded_file($archivo, $rutaImagen)) {
                    // Asignamos los valores para la imagen
                    $idtipoCarga = 2; // El tipo de carga es 2 para diferenciarla
                    $tipoImagen = $typo;
                } else {
                    $dato = [
                        "status" => "danger",
                        "title" => "Error de carga",
                        "message" => "No se pudo guardar la imagen en el servidor"
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }

        // Llamada al procedimiento almacenado
        $query = "CALL UpdateCheckCalidadProc(
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Pasamos los parámetros al procedimiento almacenado
        $params = [
            $checkCalidad['estado'],
            $checkCalidad['comentarios'],
            $checkCalidad['fecha'],
            $checkCalidad['hora'],
            $rutaImagen,
            $idtipoCarga,
            $nombreImagen,
            $tipoImagen,
            $hoy,
            $hora
        ];


        // Ejecutar el procedimiento
        $result = $controlCalidad->UpdateDetalleCheckCalidadv2($idcheckCalidad, $params);

        if ($result) {
            $dato = [
                'status' => 'success',
                'title' => 'Verificado',
                'message' => 'Registrado correctamente'
            ];
            echo json_encode($dato);
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'No se logró procesar la data'
            ];
            echo json_encode($dato);
        }
    }


    public function UpdateCheckCalidadold()
    {
        date_default_timezone_set("America/Lima");
        $controlCalidad=New ControlCalidadModel();
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $idcheckCalidad=$_POST["idcheckCalidad"];

        $checkCalidad=[
            'estado'=>$_POST["estadoCalidad"],
            'comentarios'=>$_POST["comentariocheckCalidad"],
            'fecha'=>$_POST["fechaRevision"],
            'hora'=>$hora
        ];

        $archivo = $_FILES['resourceCheckCalidad']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceCheckCalidad']['type'];
            $temp = $_FILES['resourceCheckCalidad']['name'];
            $tps = explode('/', $_FILES['resourceCheckCalidad']['type']);
            $typo = $tps[1];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                $path = $archivo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = $archivo;
                $checkCalidad+=[
                    'imagenAdjunto' => base64_encode(file_get_contents($data)),
                    'nombreImagen' => $temp,
                    'tipoImagen' => $typo,
                    'fechaCarga' => $hoy,
                    'horaCarga' => $hora
                ];
            }
        }

        $filtro=[
            'iddetalleCheckListCalidad'=>$idcheckCalidad
        ];

        $update=$controlCalidad->UpdateDetalleCheckCalidad($filtro,$checkCalidad);

        $checkCalidad+=[
            'iddetalleReporteCheckListCalidad'=>$idcheckCalidad
        ];

        $stor=$controlCalidad->StorageLogCheckCalidad($checkCalidad);

        if($update){
            $dato=[
                'status'=>'success',
                'title'=>'Verificado',
                'message'=>'Registrado correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'No se logro procesar la data'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}