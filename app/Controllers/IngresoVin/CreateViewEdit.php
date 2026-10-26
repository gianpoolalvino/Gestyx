<?php

namespace App\Controllers\IngresoVin;
use App\Controllers\BaseController;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\GeneralesModel;
use App\Models\IngresoModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class CreateViewEdit extends BaseController
{

    public function ValidarVin()
    {
        $vin=$_POST["vin"];

        $cantidad=strlen($vin);

        if($cantidad<17){
            $send=[
                'status'=>'danger',
                'title'=>'Error en el Vin',
                'message'=>"El vin {$vin} No cumple los requisitos minimos de 17 Caracteres"
            ];
            echo json_encode($send);
        }

        // Datos dinámicos (puedes obtenerlos de POST, GET, base de datos, etc.)
        $token = "X0ZCuzfIov9TvV2e96yBd1egT2esrVPIiFa7ubtAv2XPqa3eE3iR360o8kZiwOZq";

// Configuración cURL
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.autoniza.net.pe/sincronizaColombia/VerificarExistenciaVin.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                "token" => $token,
                "vin" => $vin
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

// Ejecutar y capturar la respuesta
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

// Mostrar resultado
        if ($err) {
            $send=[
                'status'=>'danger',
                'title'=>'Error en el Vin',
                'message'=>'Error en la Api'
            ];
            echo json_encode($send);
            exit();
        } else {
            $result=json_decode($response);
            if($result->status=="success"){
                $send=[
                    'status'=>'success',
                    'title'=>'Ingreso de Vin',
                    'message'=>$result->message
                ];
            }else{
                $send=[
                    'status'=>'danger',
                    'title'=>'Error en el Vin',
                    'message'=>$result->message
                ];
            }
            echo json_encode($send);
            exit();
        }

    }
    public function CreateVehiculo()
    {
        $ubicacionModel=New TrasladoModel();
        $vinModel=New VinModel();
        $generalModel=New GeneralesModel();


        $dato=[
            'marca'=>$vinModel->MarcaVehiculo(),
            'bodega'=>$generalModel->SelectBodega()
        ];

        $send=[
            'status'=>'success',
            'info'=>view('IngresoVin/CreateVehiculo/Index',$dato).view('IngresoVin/CreateVehiculo/Scripts')
        ];
        // Mostrar el enlace al archivo generado
        echo json_encode($send);
        exit();
    }

    public function CreateQrs()
    {
        $ubicacionModel=New TrasladoModel();
        $datos=[
            'ubicacion'=>$ubicacionModel->SelectUbicacion()
        ];
        $send=[
            'status'=>'success',
            'info'=>view('IngresoVin/GenerateQrs/Index',$datos).view('IngresoVin/GenerateQrs/Scripts')
        ];
        // Mostrar el enlace al archivo generado
        echo json_encode($send);
        exit();
    }

    public function ViewQrPrint()
    {
        $IngresoModel=New IngresoModel();
        $vinModel=New VinModel();
        $fechaInicio=$_POST["fechaInicioRepo"];
        $fechaFin=$_POST["fechaFinRepo"];
        $idubicacion=$_POST["idubicacionRepo"];

        $filtro=[
            'fechaIngresoReal>='=>$fechaInicio,
            'fechaIngresoReal<='=>$fechaFin
        ];

        $detQr=$IngresoModel->DetailAddReporte($filtro);
        $vinQuery=[];
        foreach($detQr as $dt){
            $vins=$dt["vin"];
            array_push($vinQuery,$vins);
            $qrScan=$this->GenerateQrMasivo($vins);
        }

        $dato=[
            'vins'=>$vinModel->VinInfoMasivo($vinQuery,$idubicacion)
        ];


        echo view('IngresoVin/ViewQrPrint/Index',$dato);

        echo view('IngresoVin/ViewQrPrint/Scripts');

    }

    private function GenerateQrMasivo($vin)
    {
        $vinModel=New VinModel();
        // Datos que quieres codificar en el QR
        $data = $vin;
        $filtroVin=[
            'vin'=>$vin
        ];
        // Crear el objeto QrCode
        $qrCode = new QrCode($data);
        // Configurar el tamaño del QR
        $qrCode->setSize(350); // Ajusta el tamaño aquí
        // Configurar el nivel de corrección de errores
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
        // Configurar color y margen
        $qrCode->setMargin(2);  // Márgenes alrededor del QR
        // Crear el escritor PNG para generar la imagen
        $writer = new PngWriter();
        // Obtener el QR generado como string binario
        $result = $writer->write($qrCode);
        $qrImage = $result->getString(); // Aquí usamos getString() para obtener el binario de la imagen
        // Crear imagen desde el binario
        $qrImageResource = imagecreatefromstring($qrImage);
        // Definir el directorio donde quieres guardar la imagen
        $savePath = 'resource/qr/operaciones/'; // Asegúrate de que esta carpeta exista
        // Crear la carpeta si no existe
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }
        // Nombre del archivo de imagen (con timestamp para evitar conflictos)
        $filename = $vin.'.png';
        // Ruta del logo que deseas agregar
        $logoPath = 'resource/img/logoQr.png'; // Cambia esto a la ruta de tu logo
        // Verifica que el logo exista
        if (file_exists($logoPath)) {
            // Crear una imagen a partir del logo
            $logo = imagecreatefrompng($logoPath);

            // Obtener dimensiones de la imagen QR y del logo
            $qrWidth = imagesx($qrImageResource);
            $qrHeight = imagesy($qrImageResource);
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);

            // Determina el tamaño máximo que quieres para el logo
            $maxLogoWidth = $qrWidth / 4.5; // Redimensiona el logo al 20% del tamaño del QR
            $maxLogoHeight = $qrHeight / 4.5;

            // Mantener la relación de aspecto original
            $logoAspectRatio = $logoWidth / $logoHeight;

            // Calcular las nuevas dimensiones
            if ($logoWidth > $maxLogoWidth || $logoHeight > $maxLogoHeight) {
                if ($logoWidth / $maxLogoWidth > $logoHeight / $maxLogoHeight) {
                    $newLogoWidth = $maxLogoWidth;
                    $newLogoHeight = $maxLogoWidth / $logoAspectRatio;
                } else {
                    $newLogoHeight = $maxLogoHeight;
                    $newLogoWidth = $maxLogoHeight * $logoAspectRatio;
                }
            } else {
                $newLogoWidth = $logoWidth;
                $newLogoHeight = $logoHeight;
            }

            // Redimensionar el logo a las nuevas dimensiones
            $resizedLogo = imagescale($logo, $newLogoWidth, $newLogoHeight);

            // Calcular la posición del logo para centrarlo en la imagen QR
            $logoX = ($qrWidth - $newLogoWidth) / 2;
            $logoY = ($qrHeight - $newLogoHeight) / 2;

            // Combinar el logo con la imagen QR
            imagecopy($qrImageResource, $resizedLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);

            // Liberar memoria del logo redimensionado
            imagedestroy($resizedLogo);
        }

        // Guardar la imagen final en el servidor
        imagepng($qrImageResource, $savePath . $filename);

        $updateData=[
            'rutaImagenQr'=>$savePath.$filename
        ];

        $update=$vinModel->UpdateVin($filtroVin,$updateData);
        // Liberar memoria
        imagedestroy($qrImageResource);
        if (isset($logo)) {
            imagedestroy($logo);
        }
      //  exit();
    }

    public function ViewQrVin()
    {
        $vinModel=New VinModel();
        // Datos que quieres codificar en el QR
        $vin  = $_POST["vin"];
        $info = $vinModel->VinInfo($vin);                          // marca desde la base
        // $data = $vin . "\n" . ($info[0]["marca"] ?? "");           // VIN, salto de línea, MARCA
        $data = "vin: ". $vin . "\n" ."marca: " . $info[0]["marca"] . "\n" . "modelo: " . $info[0]["modelo"];



        // Crear el objeto QrCode
        $qrCode = new QrCode($data);

        // Configurar el tamaño del QR
        $qrCode->setSize(350); // Ajusta el tamaño aquí

        // Configurar el nivel de corrección de errores
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

        // Configurar color y margen

        $qrCode->setMargin(2);  // Márgenes alrededor del QR

        // Crear el escritor PNG para generar la imagen
        $writer = new PngWriter();

        // Obtener el QR generado como string binario
        $result = $writer->write($qrCode);
        $qrImage = $result->getString(); // Aquí usamos getString() para obtener el binario de la imagen

        // Crear imagen desde el binario
        $qrImageResource = imagecreatefromstring($qrImage);

        // Definir el directorio donde quieres guardar la imagen
        $savePath = 'resource/qr/operaciones/'; // Asegúrate de que esta carpeta exista

        // Crear la carpeta si no existe
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }

        // Nombre del archivo de imagen (con timestamp para evitar conflictos)
        $filename = $_POST["vin"].'.png';

        // Ruta del logo que deseas agregar
        $logoPath = 'resource/img/logoQr.png'; // Cambia esto a la ruta de tu logo

        // Verifica que el logo exista
        if (file_exists($logoPath)) {
            // Crear una imagen a partir del logo
            $logo = imagecreatefrompng($logoPath);

            // Obtener dimensiones de la imagen QR y del logo
            $qrWidth = imagesx($qrImageResource);
            $qrHeight = imagesy($qrImageResource);
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);

            // Determina el tamaño máximo que quieres para el logo
            $maxLogoWidth = $qrWidth / 4.5; // Redimensiona el logo al 20% del tamaño del QR
            $maxLogoHeight = $qrHeight / 4.5;

            // Mantener la relación de aspecto original
            $logoAspectRatio = $logoWidth / $logoHeight;

            // Calcular las nuevas dimensiones
            if ($logoWidth > $maxLogoWidth || $logoHeight > $maxLogoHeight) {
                if ($logoWidth / $maxLogoWidth > $logoHeight / $maxLogoHeight) {
                    $newLogoWidth = $maxLogoWidth;
                    $newLogoHeight = $maxLogoWidth / $logoAspectRatio;
                } else {
                    $newLogoHeight = $maxLogoHeight;
                    $newLogoWidth = $maxLogoHeight * $logoAspectRatio;
                }
            } else {
                $newLogoWidth = $logoWidth;
                $newLogoHeight = $logoHeight;
            }

            // Redimensionar el logo a las nuevas dimensiones
            $resizedLogo = imagescale($logo, $newLogoWidth, $newLogoHeight);

            // Calcular la posición del logo para centrarlo en la imagen QR
            $logoX = ($qrWidth - $newLogoWidth) / 2;
            $logoY = ($qrHeight - $newLogoHeight) / 2;

            // Combinar el logo con la imagen QR
            imagecopy($qrImageResource, $resizedLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);

            // Liberar memoria del logo redimensionado
            imagedestroy($resizedLogo);
        }

        // Guardar la imagen final en el servidor
        imagepng($qrImageResource, $savePath . $filename);

        $img="<img src='".base_url($savePath . $filename)."'>";
        // Liberar memoria
        imagedestroy($qrImageResource);
        if (isset($logo)) {
            imagedestroy($logo);
        }

        $dato=[
            'vinQr'=>$img,
            'vin'=>$_POST["vin"],
            'vinInfo'=>$vinModel->VinInfo($_POST["vin"])
        ];

        $send=[
            'info'=>view('IngresoVin/VinQr/Index',$dato).view('IngresoVin/VinQr/Scripts')
        ];

        // Mostrar el enlace al archivo generado
        echo json_encode($send);
        exit();
    }

    public function CreateReportePicking()
    {
        $ingresoModel=New IngresoModel();

        $send=[
            'info'=>view("IngresoVin/ModalReporteExcel/Index").view("IngresoVin/ModalReporteExcel/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();

    }

    public function CreateReporteExcel()
    {
        $ingresoModel=New IngresoModel();

        $filtroDelete=[
            'idusuarioGenerado'=>session('idusuario'),
            'idestadoReporte'=>1
        ];

        $delete=$ingresoModel->DeleteReporteTemporal($filtroDelete);

        $dato=[
            'vinIngreso'=>$ingresoModel->SelectVinIngreso()
        ];

        $send=[
            'info'=>view("IngresoVin/ModalReporteExcel/Index",$dato).view("IngresoVin/ModalReporteExcel/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteVinReporte()
    {
        $ingresoModel=New IngresoModel();
        date_default_timezone_set("America/Lima");

        $filtroDelete=[
            'iddetalleReporteIngresoVin'=>$_POST["iddetalleReporteIngresoVin"],
        ];

        $delete=$ingresoModel->DeleteReporteTemporal($filtroDelete);

        if($delete){
            $send=[
                'status'=>'success',
                'title'=>'Vin Retirado',
                'message'=>'El vin se retiro correctamente'
            ];

            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'El vin no se a podido retirar del reporte'
            ];

            echo json_encode($send);
            exit();
        }
    }

    public function DetailReporteIngresoFecha()
    {
        $ingresoModel=New IngresoModel();
        date_default_timezone_set("America/Lima");

        $filtro=[
            'fechaIngresoReal>='=>$_POST["fechaInicio"],
            'fechaIngresoReal<='=>$_POST["fechaFin"]
        ];
        $detReg=$ingresoModel->DetailAddReporte($filtro);
        $contador=0;
        foreach($detReg as $dt){
            $insert=[
                'vin'=>$dt["vin"],
                'idusuarioGenerado'=>session('idusuario'),
                'idestadoReporte'=>1,
                'fechaRegistro'=>date("Y-m-d"),
                'horaRegistro'=>date("H:i:s")
            ];
            $contador++;
            $store=$ingresoModel->StorageVinReporte($insert);
        }
        if($contador>0){
            $send=[
                'status'=>'success',
                'title'=>'Ingreso Correcto',
                'message'=>'Se agregaron correctamente los Vins ('.$contador.') al reporte, de click en Exportar'
            ];

            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'No Existe',
                'message'=>'No existen vins con la fecha seleccionada ('.$contador.')'
            ];

            echo json_encode($send);
            exit();
        }


    }
    public function DetailReporteIngreso()
    {
        $ingresoModel=New IngresoModel();
        date_default_timezone_set("America/Lima");

        $filtroDup=[
            'vin'=>$_POST["vin"],
            'idusuarioGenerado'=>session('idusuario'),
            'idestadoReporte'=>1
        ];

        $duplicate=$ingresoModel->DetailReporteTemporal($filtroDup);

        if($duplicate){
            $send=[
                'status'=>'danger',
                'title'=>'Duplicidad no permitida',
                'message'=>'El vin ya se encuentra registrado para generar el informe'
            ];

            echo json_encode($send);
            exit();
        }

        $insert=[
            'vin'=>$_POST['vin'],
            'idusuarioGenerado'=>session('idusuario'),
            'idestadoReporte'=>1,
            'fechaRegistro'=>date("Y-m-d"),
            'horaRegistro'=>date("H:i:s")
        ];

        $store=$ingresoModel->StorageVinReporte($insert);

        if($store!=''){
            $filtroDetail=[
                'idestadoReporte'=>1,
                'idusuarioGenerado'=>session('idusuario')
            ];
            $detailVin=$ingresoModel->DetailReporteTemporal($filtroDetail);
            $principal='';
            $contador=0;
            foreach($detailVin as $dv){
                $contador++;
                $principal.='<tr style="vertical-align: middle" id="'.$dv["iddetalleReporteIngresoVin"].'">';
                $principal.='<td style="padding-left:6px">'.$contador.'</td>';
                $principal.='<td>'.$dv["vin"].'</td>';
                $principal.='<td><button class="btn btn-danger btn-sm btnDeleteVin" data-iddetalleReporteIngresoVin="'.$dv["iddetalleReporteIngresoVin"].'"><i class="fas fa-trash"></i></button>';
                $principal.='</tr>';
            }

            $send=[
                'info'=>$principal,
                'status'=>'success',
                'title'=>'Ingreso Correcto',
                'message'=>'Se agrego correctamente el vin al reporte'
            ];

            echo json_encode($send);
            exit();

        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error al insertar',
                'message'=>'No se logro ingresar el vin al reporte de ingresos'
            ];

            echo json_encode($send);
            exit();
        }
    }

    public function Create()
    {
        $ingresoModel=New IngresoModel();

        $dato=[
            'selectVin'=>$ingresoModel->SelectVinPendiente()
        ];

        $send=[
            'info'=>view("IngresoVin/Create/Index",$dato).view("IngresoVin/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();

    }

    public function ViewEdit()
    {
        $ingresoModel=New IngresoModel();
        $infoVin=New VinModel();
        $generalModel=New GeneralesModel();
        $idingresoVin=$_POST["idingresoVin"];
        $vin=$_POST["vin"];

        $filtroIngreso=[
            'idingresoVin'=>$idingresoVin,
            'vin'=>$vin
        ];
        $datosIngreso=$ingresoModel->ViewIngresoVin($filtroIngreso);

        $filtroEquipamiento=[
            'idingresoVin'=>$idingresoVin
        ];

        $equipamientoInsert=$ingresoModel->ResultadoEquipamiento($filtroEquipamiento);

        $dato=[
            'vinInfo'=>$infoVin->VinInfo($vin),
            'vin'=>$vin,
            'datosIngreso'=>$datosIngreso,
            'idingresoVin'=>$idingresoVin,
            'ubicacion'=>$generalModel->SelectUbicacion(),
        ];

        if($equipamientoInsert){
            $dato+=[
                'equipamientoIngreso'=>$equipamientoInsert
            ];
        }else{
            $dato+=[
                'formularioEquipamiento'=>$ingresoModel->CheckFormularioEquipamiento()
            ];
        }

        $send=[
            'info'=>view("IngresoVin/ViewEdit/Index",$dato).view("IngresoVin/ViewEdit/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function PanelEquipamiento()
    {
        $ingresoModel=New IngresoModel();
        $infoVin=New VinModel();
        $generalModel=New GeneralesModel();
        $idingresoVin=$_POST["idingresoVin"];
        $vin=$_POST["vin"];

        $filtroEquipamiento=[
            'idingresoVin'=>$idingresoVin
        ];
        $dato=[];
        $equipamientoInsert=$ingresoModel->ResultadoEquipamiento($filtroEquipamiento);

        $dato=[
            'vin'=>$vin,
            'idingresoVin'=>$idingresoVin,
            'infoVin'=>$infoVin->VinInfo($vin),
        ];

        if($equipamientoInsert){
            $dato+=[
                'equipamientoIngreso'=>$equipamientoInsert
            ];
        }else{
            $dato+=[
                'formularioEquipamiento'=>$ingresoModel->CheckFormularioEquipamiento()
            ];
        }

        $send=[
            'info'=>view("IngresoVin/PanelEquipamiento/Index",$dato).view("IngresoVin/PanelEquipamiento/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();

    }

    public function UploadImagen()
    {
        $dato=[
            'iddetalleIngresoVehiculoImagen'=>$_POST["iddetalleIngresoVehiculoImagen"],
            'vin'=>$_POST["vin"]
        ];

        $send=[
            'info'=>view("IngresoVin/UploadImagen/Index",$dato).view("IngresoVin/UploadImagen/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function PanelImagenes()
    {
        $ingresoModel=New IngresoModel();
        $idingresoVin=$_POST["idingresoVin"];
        $vin=$_POST["vin"];

        $filtroImgen=[
            'idingresoVin'=>$idingresoVin,
            'vin'=>$vin
        ];

        $formulaImagen=$ingresoModel->FormularioImagen($filtroImgen);
        if(!$formulaImagen){
            $formImg=$ingresoModel->CheckImagenIngreso();
            foreach($formImg as $fimg){
                $storeImg=[
                    'idcheckImagenIngresoVin'=>$fimg["idcheckImagenIngresoVin"],
                    'idingresoVin'=>$idingresoVin,
                    'vin'=>$vin
                ];
                $stor=$ingresoModel->StorageImagenIngreso($storeImg);
            }
        }

        $dato=[
            'formularioImagen'=>$ingresoModel->FormularioImagen($filtroImgen)
        ];

        $send=[
            'info'=>view("IngresoVin/PanelImagenes/Index",$dato).view("IngresoVin/PanelImagenes/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();

    }

    public function PanelObservaciones()
    {
        $vin=$_POST["vin"];
        $idingresoVin=isset($_POST["idingresoVin"])?$_POST["idingresoVin"]:'';
        $ingresoVin= New IngresoModel();

        $dato=[
            'vin'=>$vin,
            'idingresoVin'=>$idingresoVin
        ];

        $filtro=[
            'vin'=>$vin,
            'idingresoVin'=>$idingresoVin
        ];

        $obs=$ingresoVin->DetailPanelObservaciones($filtro);

        if($obs){
            $dato+=[
                'detailObservacion'=>$obs
            ];
        }
        $send=[
            'info'=>view("IngresoVin/PanelObservaciones/Index",$dato).view("IngresoVin/PanelObservaciones/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }

    public function CreateObservacion()
    {
        $ingresoModel=New IngresoModel();
        $dato=[
            'idingresoVehiculo'=>$_POST["idingresoVin"],
            'vin'=>$_POST["vin"],
            'selectTipoDanho'=>$ingresoModel->SelectTipoDanho(),
            'selectNivelDanho'=>$ingresoModel->SelectNivelDanho(),
            'selectAreaDanho'=>$ingresoModel->SelectAreaDanho(),
            'selectSubAreaDanho'=>$ingresoModel->SelectSubAreaDanho(),
            'selectReparacion'=>$ingresoModel->SelectReparacion()
        ];

        $send=[
            'info'=>view("IngresoVin/CreateObservacion/Index",$dato).view("IngresoVin/CreateObservacion/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }

    public function ViewEditObservacion()
    {
        $ingresoModel=New IngresoModel();

        $filtro=[
            'idobservacionIngresoVin'=>$_POST["idobs"]
        ];

        $dato=[
            'idobservacionIngresoVin'=>$_POST["idobs"],
            'selectTipoDanho'=>$ingresoModel->SelectTipoDanho(),
            'selectNivelDanho'=>$ingresoModel->SelectNivelDanho(),
            'selectAreaDanho'=>$ingresoModel->SelectAreaDanho(),
            'selectSubAreaDanho'=>$ingresoModel->SelectSubAreaDanho(),
            'selectReparacion'=>$ingresoModel->SelectReparacion(),
            'viewIngreso'=>$ingresoModel->ObservacionesVin($filtro)
        ];

        $send=[
            'info'=>view("IngresoVin/ViewEditObservacion/Index",$dato).view("IngresoVin/ViewEditObservacion/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }

    public function PanelDuaf()
    {
        $ingresoModel=New IngresoModel();
        $vin=$_POST["vin"];
        $idingresoVin=isset($_POST["idingresoVin"])?$_POST["idingresoVin"]:'';

        $filtro=[
            'idingresoVin'=>$idingresoVin,
            'vin'=>$vin
        ];

        $dato=[
            'panelDuaf'=>$ingresoModel->ViewPanelDuaf($filtro),
            'idingresoVin'=>$idingresoVin,
            'vin'=>$vin
        ];

        $send=[
            'info'=>view("IngresoVin/PanelDuaf/Index",$dato).view("IngresoVin/PanelDuaf/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }

    public function PanelPrincipal()
    {
        $vin=$_POST["vin"];
        $idingresoVin=isset($_POST["idingresoVin"])?$_POST["idingresoVin"]:'';
        $ingresoModel=New IngresoModel();
        $infoVin=New VinModel();
        $generalModel=New GeneralesModel();

        $filtroIngreso=[
            'idingresoVin'=>$idingresoVin,
            'vin'=>$vin
        ];

        $datosIngreso=$ingresoModel->ViewIngresoVin($filtroIngreso);

        $dato=[
            'vinInfo'=>$infoVin->VinInfo($vin),
            'vin'=>$vin,
            'idingresoVin'=>$idingresoVin,
            'ubicacion'=>$generalModel->SelectUbicacion()
        ];

        $filtroEquipamiento=[
            'idingresoVin'=>$idingresoVin
        ];
        $equipamientoInsert=$ingresoModel->ResultadoEquipamiento($filtroEquipamiento);
        if($equipamientoInsert){
            $dato+=[
                'equipamientoIngreso'=>$equipamientoInsert
            ];
        }else{
            $dato+=[
                'formularioEquipamiento'=>$ingresoModel->CheckFormularioEquipamiento()
            ];
        }

        if($datosIngreso){
            $dato+=[
                'datosIngreso'=>$datosIngreso
            ];
        }else{
            $dato+=[
                'datosIngreso'=>[]
            ];
        }

        $send=[
            'info'=>view("IngresoVin/PanelPrincipal/Index",$dato).view("IngresoVin/PanelPrincipal/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();

    }

    public function ProcesarObservacion()
    {
        $idobservacionIngreso=$_POST["idobs"];

        $dato=[
            'idobservacionIngresoVin'=>$idobservacionIngreso
        ];

        $send=[
            'status'=>'success',
            'info'=>view("IngresoVin/ProcesarObservacion/Index",$dato).view("IngresoVin/ProcesarObservacion/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteObservacion()
    {
        $idobservacionIngreso=$_POST["idobs"];

        $dato=[
            'idobservacionIngresoVin'=>$idobservacionIngreso
        ];

        $send=[
            'status'=>'success',
            'info'=>view("IngresoVin/DeleteObservacion/Index",$dato).view("IngresoVin/DeleteObservacion/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailCheckIngreso()
    {
        $ingresoModel=New IngresoModel();
        $infoVin=New VinModel();
        $generalModel=New GeneralesModel();
        $vin=$_POST["vin"];
        $idingresoVehiculo=$_POST["idingresoVehiculo"];
        $dato=[
            'vin'=>$vin,
            'idingresoVehiculo'=>$idingresoVehiculo,
            'formIngreso'=>$ingresoModel->FormularioIngreso()
        ];

        $send=[
            'info'=>view("IngresoVin/DetailCheck/Index",$dato).view("IngresoVin/DetailCheck/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }
}