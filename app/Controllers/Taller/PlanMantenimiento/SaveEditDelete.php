<?php

namespace App\Controllers\Taller\PlanMantenimiento;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use Exception;
use App\Models\ModeloModel;
use App\Models\PlanMantenimientoModel;
use App\Models\RepuestoModel;

class SaveEditDelete extends BaseController
{
    public function testOne(){
        sleep(1);
        $dato=[
            'status'=>'success',
            'title'=>'Datos Eliminados',
            'message'=>'Los Datos del Plan se eliminaron 1/5',
        ];
        echo json_encode($dato);
        exit();
    }
    public function testTwo(){
        sleep(1);
        $dato=[
            'status'=>'success',
            'title'=>'Actualizando Plan',
            'message'=>'Se Actualizo el Plan General correctamente 2/5',
        ];
        echo json_encode($dato);
        exit();
    }
    public function testTree(){
        sleep(1);
        $dato=[
            'status'=>'success',
            'title'=>'Repuestos Insertados',
            'message'=>'Se insertaron los repuestos al plan general 3/5',
        ];
        echo json_encode($dato);
        exit();
    }
    public function testFour(){
        sleep(1);
        $dato=[
            'status'=>'success',
            'title'=>'Planes Mto Creados',
            'message'=>'Se Crearon los planes de mantenimiento 4/5',
        ];
        echo json_encode($dato);
        exit();
    }
    public function testFive(){
        sleep(1);
        $dato=[
            'status'=>'success',
            'title'=>'Finalizado',
            'message'=>'El Proceso de Carga a finalizado correctamente 5/5 - 100%',
        ];
        echo json_encode($dato);
        exit();
    }

    public function CargaMasivaRepuestos()
    {
        $planMantenimiento=New PlanMantenimientoModel();
        $filtro=[
            'idplanMantenimientoFamilia'=>$_POST["idplanMantenimientoFamilia"]
        ];
        $planman=$planMantenimiento->ViewPlanFam($filtro);
        $modelo=$planman[0]["modelo"];
        $marca=$planman[0]["marca"];

        $filtroCabe=[
            'modeloVersion'=>$modelo,
            'marca'=>$marca
        ];

        $repuesto=$planMantenimiento->CabeceraMasivaCargaRepuesto($filtroCabe);
        $codigosFallidos = [];
        foreach($repuesto as $rsp){
            $codigo=$rsp["codigoRepuesto"];
            $result=$this->RepuestoERP($codigo);
            // Si la API no devolvió datos o el repuesto no existe, lo consideramos fallido
            if ($result['status']=='danger') {
                $codigosFallidos[] = $codigo;
            }
        }

        $send=[
            'title'=>'La Operacion se realizo',
            'message'=>'Se Generaron los codigos en Gestyx '.implode(',', $codigosFallidos),
            'status'=>'success',
        ];

        echo json_encode($send);
    }

    public function RepuestoERP($codigo)
    {
        // URL del API
        $url = "https://api.autoniza.net.pe/coreSap/repuestoSap.php?codigo=".$codigo;

        // Inicializar cURL
        $ch = curl_init();

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Desactivar verificación SSL (NO recomendado en producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Ejecutar la petición
       $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            // En caso de error puedes lanzar una excepción, retornar false, o null
            return null; 
        }

        curl_close($ch);
    // var_dump($response);
        // Decodificar el JSON y devolverlo
        return json_decode($response, true); // true para obtener un array asociativo
    }


    public function DeletePlanFamiliaMasivo()
    {
            $idplanMantenimientoFamilia=$_POST["idplanMantenimientoFamilia"];
            $planMantenimiento=New PlanMantenimientoModel();
            $filtroDelete=[
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
            ];
            $deletPlanMto=$planMantenimiento->DeletePlanMto($filtroDelete);
            $viewPlanMto=$planMantenimiento->ViewPlanMantenimientoFull($filtroDelete);


            foreach($viewPlanMto as $plm){
                $idplanMantenimiento=$plm["idplanMantenimiento"];
                $deletMasDet=$planMantenimiento->DeleteMasivoDetailMto($idplanMantenimiento);
            }

            $deleteDetFam=$planMantenimiento->DeleteDetailFamilia($filtroDelete);


            sleep(1);
            $dato=[
                'status'=>'success',
                'title'=>'Datos Eliminados',
                'message'=>'Los Datos del Plan se eliminaron 1/5',
            ];
            echo json_encode($dato);
            exit();
    }
public function UpdatePlanGeneralSql()
{
    try {
        $planMantenimiento = new PlanMantenimientoModel();
        $idplanMantenimientoFamilia = $_POST["idplanMantenimientoFamilia"];

        // Paso 1: Obtener Plan
        $planman = $planMantenimiento->ViewPlanFam([
            'idplanMantenimientoFamilia' => $idplanMantenimientoFamilia
        ]);
        if (empty($planman)) {
            throw new Exception("Fallo en ViewPlanFam: No se encontró el plan.");
        }

        $modelo = $planman[0]["modelo"] ?? null;
        $marca = $planman[0]["marca"] ?? null;
        if (!$modelo || !$marca) {
            throw new Exception("Fallo al obtener modelo o marca del plan.");
        }

        // Paso 2: Cabecera Masiva
        $cabeceras = $planMantenimiento->CabeceraMasivaPlan([
            'modeloVersion' => $modelo,
            'marca' => $marca
        ]);
        if (empty($cabeceras)) {
            throw new Exception("Fallo en CabeceraMasivaPlan: No se encontraron cabeceras.");
        }

        // Paso 3: Procesar kilometraje
        $valores = [];
        foreach ($cabeceras as $cb) {
            $valorLimpio = trim(str_ireplace('k', '', $cb["kilometraje"]));
            $valores[] = $valorLimpio;
        }

        if (empty($valores)) {
            throw new Exception("Fallo al procesar valores de kilometraje.");
        }

        $valorManoObra = 76.7;
        $kilometrajeMax = max($valores) . "000";

        // Paso 4: ViewKilometraje
        $kil = $planMantenimiento->ViewKilometraje([
            'kilometraje' => $kilometrajeMax
        ]);
        if (empty($kil)) {
            throw new Exception("Fallo en ViewKilometraje: No se encontró kilometraje para $kilometrajeMax.");
        }

        // Paso 5: Actualizar plan
        $upd = $planMantenimiento->UpgradePlanFamilia(
            ['idplanMantenimientoFamilia' => $idplanMantenimientoFamilia],
            [
                'idkilometroMaximo' => $kil[0]["idkilometrajeMantenimiento"],
                'costoManoObra' => $valorManoObra,
                'idestadoPlanMantenimientoFamilia' => 2
            ]
        );
        sleep(1);

        if ($upd) {
            echo json_encode([
                'status' => 'success',
                'title' => 'Actualizando Plan',
                'message' => 'Se Actualizo el Plan General correctamente 2/5'
            ]);
            exit();
        } else {
            throw new Exception("Fallo en UpgradePlanFamilia: No se pudo actualizar el plan.");
        }

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'danger',
            'title' => 'Error en ' . __FUNCTION__,
            'message' => $e->getMessage()
        ]);
        exit();
    }
}


    public function StorageDetallePlanMtoGeneralSql()
    {
        try {
            $planMantenimiento = new PlanMantenimientoModel();
            $idplanMantenimientoFamilia = $_POST["idplanMantenimientoFamilia"];

            $filtro = [
                'idplanMantenimientoFamilia' => $idplanMantenimientoFamilia
            ];
            $planman = $planMantenimiento->ViewPlanFam($filtro);

            // Verificar si se obtienen resultados
            if (empty($planman)) {
                throw new Exception('No se encontraron datos del plan de mantenimiento');
            }

            $modelo = $planman[0]["modelo"];
            $marca = $planman[0]["marca"];

            $filtroDet = [
                'modeloVersion' => $modelo,
                'marca' => $marca
            ];

            $detail = $planMantenimiento->DetailCargaMasivaPlanMtoSql($filtroDet);

            // Verificar si se obtienen detalles
            if (empty($detail)) {
                throw new Exception('No se encontraron detalles para el plan de mantenimiento');
            }

            $countDuplicado = 0;
            $countErrors = 0;
            $countCorrects = 0;

            foreach ($detail as $dt) {
                $detailPlan = [
                    'idplanMantenimientoFamilia' => $idplanMantenimientoFamilia,
                    'idrepuesto' => $dt["idrepuesto"],
                    'cantidad' => $dt["cantidad"],
                    'precioTotalDolares' => $dt["totalPrecio"],
                    'precioUnidadDolares' => $dt["precioDolares"]
                ];

                $filtDet = [
                    'idplanMantenimientoFamilia' => $idplanMantenimientoFamilia,
                    'idrepuesto' => $dt["idrepuesto"],
                    'cantidad'=>$dt["cantidad"]
                ];

                $detplanF = $planMantenimiento->DetailViewPlanFam($filtDet);

                if (!$detplanF) {
                    $iddetallePlan = $planMantenimiento->StoragePlanDetalle($detailPlan);
                    if ($iddetallePlan != '') {
                        $countCorrects++;
                    } else {
                        $countErrors++;
                    }
                } else {
                    $countDuplicado++;
                }
            }

            // Calcular el total de registros procesados
            $totalRecords = $countErrors + $countCorrects + $countDuplicado;

            sleep(1);

            if ($totalRecords>0) {
                $dato = [
                    'status' => 'success',
                    'title' => 'Repuestos Insertados',
                    'message' => 'Se insertaron los repuestos al plan general 3/5',
                ];
                echo json_encode($dato);
                exit();
            } else if ($countErrors > 0) {
                $send = [
                    'status' => 'danger',
                    'title' => 'Error de Proceso',
                    'message' => 'Se Encontraron errores al intentar ingresar los repuestos al plan general'
                ];
                echo json_encode($send);
                exit();
            }
        } catch (Exception $e) {
            // Capturar cualquier error y mostrarlo
            $errorMessage = $e->getMessage();
            $send = [
                'status' => 'danger',
                'title' => 'Error inesperado',
                'message' => 'Ocurrió un error: ' . $errorMessage
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function StoragePlanMtoSql()
    {
       $idplanMantenimientoFamilia=$_POST["idplanMantenimientoFamilia"];
        $planFamilia=New PlanMantenimientoModel();

        $filterView=[
            'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
        ];
        $viewPlan=$planFamilia->ViewPlanFam($filterView);

        $filtroMs=[
            'marca'=>$viewPlan[0]["marca"],
            'modeloVersion'=>$viewPlan[0]["modelo"]
        ];
        $contador=0;
        $count=0;
        $countDuplicado=0;
        $countErrors=0;
        $countSuccess=0;
        $kilometrajeCargamasi=$planFamilia->CabeceraMasivaPlan($filtroMs);
        foreach($kilometrajeCargamasi as $plan){
            $filtroKilometraje=[
                'equivalente'=>trim($plan["kilometraje"])
            ];
            $kilo=$planFamilia->ViewKilometraje($filtroKilometraje);

            $planStorage=[
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'idkilometraje'=>$kilo[0]["idkilometrajeMantenimiento"],
                'idmarca'=>$viewPlan[0]["idmarca"],
                'idmodelo'=>$viewPlan[0]["idmodelo"],
                'costoManoObra'=>$viewPlan[0]["costoManoObra"],
                'tiempoManoObra'=>$plan["cantidad"],
                'totalManoObra'=>$viewPlan[0]["costoManoObra"],
            ];
            $existe=$planFamilia->ViewPlanMantenimiento($planStorage);
            if($existe){
                $countDuplicado++;
            }else{
                $stor=$planFamilia->StoragePlanMantenimiento($planStorage);
                if($stor){
                    $countSuccess++;
                }else{
                    $countErrors++;
                }
            }
            $count++;
        }

        sleep(1);
        if($countSuccess>0){
            $dato=[
                'status'=>'success',
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'title'=>'Planes Mto Creados',
                'message'=>'Se Crearon los planes de mantenimiento 4/5',
            ];
            echo json_encode($dato);
            exit();
        }else if($countDuplicado>0 and $countSuccess==0){
            $resultado=[
                'status'=>'warning',
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'title'=>'Operacion omitida',
                'message'=>'Ya existen los kilometrajes'
            ];
            echo json_encode($resultado);
            exit();
        }

    }
    public function StoragePlanMtoSql_old()
    {
       $idplanMantenimientoFamilia=$_POST["idplanMantenimientoFamilia"];
        $planFamilia=New PlanMantenimientoModel();

        $filterView=[
            'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
        ];

        $viewPlan=$planFamilia->ViewPlanFam($filterView);

        $kilometrajefinal=$viewPlan[0]["kilometraje"];
        $frecuencia=$viewPlan[0]["frecuencia"];
        $bucle=$kilometrajefinal/$frecuencia;

        //echo $bucle;
        $contador=0;
        $count=0;
        $countDuplicado=0;
        $countErrors=0;
        $countSuccess=0;
        for ($i = 1; $i <= $bucle; $i++) {
            $count++;
            $contador=$contador+$frecuencia;
            $filtroKilometraje=[
                'kilometraje'=>$contador
            ];
            $kilo=$planFamilia->ViewKilometraje($filtroKilometraje);

            $filtroMs=[
                'kilometraje'=>$kilo[0]['equivalente'],
                'marca'=>$viewPlan[0]["marca"],
                'modeloVersion'=>$viewPlan[0]["modelo"]
            ];

            $kilometrajeCargamasi=$planFamilia->CabeceraMasivaPlan($filtroMs);

            $planStorage=[
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'idkilometraje'=>$kilo[0]["idkilometrajeMantenimiento"],
                'idmarca'=>$viewPlan[0]["idmarca"],
                'idmodelo'=>$viewPlan[0]["idmodelo"],
                'costoManoObra'=>$viewPlan[0]["costoManoObra"],
                'tiempoManoObra'=>$kilometrajeCargamasi[0]["cantidad"],
                'totalManoObra'=>$viewPlan[0]["costoManoObra"]
            ];

            $existe=$planFamilia->ViewPlanMantenimiento($planStorage);
            if($existe){
                $countDuplicado++;
            }else{
                $stor=$planFamilia->StoragePlanMantenimiento($planStorage);
                if($stor){
                    $countSuccess++;
                }else{
                    $countErrors++;
                }
            }
        }
        sleep(1);
        if($count==$countSuccess){
            $dato=[
                'status'=>'success',
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'title'=>'Planes Mto Creados',
                'message'=>'Se Crearon los planes de mantenimiento 4/5',
            ];
            echo json_encode($dato);
            exit();
        }else if($countDuplicado>0 and $countSuccess==0){
            $resultado=[
                'status'=>'warning',
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'title'=>'Operacion omitida',
                'message'=>'Ya existen los kilometrajes'
            ];
            echo json_encode($resultado);
            exit();
        }

    }
    public function StorageDetallePlanMtoSql()
    {
        $planMantenimiento=New PlanMantenimientoModel();
        $idplanMantenimientoFamilia=$_POST["idplanMantenimientoFamilia"];
        $filtro=[
            'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
        ];

        $planMto=$planMantenimiento->ViewPlanMantenimientoFull($filtro);

       // and cdpm.modeloVersion = 'VERSA MT' and cdpm.marca = 'NISSAN' and cdpm.kilometraje = '5K'
        $totalRecords=0;
        $contadorExito=0;
        $contadorDuplicado=0;
        $contadorError=0;
        foreach($planMto as $pl){
          //  echo $pl["kilometrajeEquivalente"]." - ".$pl["modelo"]." - ".$pl["marca"]."<br>";
            $idplanMantenimiento=$pl["idplanMantenimiento"];
            $filtroCarga=[
                'modeloVersion'=>$pl["modelo"],
                'marca'=>$pl["marca"],
                'kilometraje'=>$pl["kilometrajeEquivalente"],
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
            ];
            $detCargaMas=$planMantenimiento->DetalleCargaPlanMtoUnico($filtroCarga);
            foreach($detCargaMas as $detc){
                $totalRecords++;
                $stor=[
                    'idplanMantenimiento'=>$idplanMantenimiento,
                    'iddetallePlanMantenimientoFamilia'=>$detc["iddetallePlanMantenimientoFamilia"],
                    'idrepuesto'=>$detc["idrepuesto"],
                    'cantidad'=>$detc["cantidad"],
                    'precioUnitario'=>$detc["precioDolares"],
                    'precioTotal'=>$detc["totalPrecio"]
                ];

                $resu=$planMantenimiento->DuplicateNot($stor);

                if(!$resu){
                    $idstor=$planMantenimiento->StorageDetallePlanMantenimiento($stor);
                    if($idstor!=''){
                        $contadorExito++;
                    }else{
                        $contadorError++;
                    }
                }else{
                    $contadorDuplicado++;
                }
            }
        }

        if($totalRecords==$contadorExito && $contadorError==0){
            $send=[
                'status'=>'success',
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'title'=>'Ingreso de Repuestos',
                'message'=>'Se Agregaron los Repuesto al Plan de Mantenimiento'
            ];
            echo json_encode($send);
            exit();
        }else if($contadorError>0){
            $send=[
                'status'=>'danger',
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'title'=>'Error de Proceso',
                'message'=>'Se Encontraron errores al intentar ingresar los repuestos al plan general'
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function UpdatePlanFamilia()
    {
        $planMantenimiento=New PlanMantenimientoModel();

        $idplanMantenimientoFamilia=$_POST["idplanMto"];

        if($_POST["tipoProceso"]==1){
            $updatePlan=[
                'idkilometroMaximo'=>$_POST["kilometrajeMax"],
                'costoManoObra'=>$_POST["costoManoObra"],
                'idestadoPlanMantenimientoFamilia'=>$_POST["tipoProceso"]
            ];
            $filtroUp=[
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
            ];
            $upd=$planMantenimiento->UpgradePlanFamilia($filtroUp,$updatePlan);
            if($upd){
                $result=[
                    'status'=>'success',
                    'title'=>'Actualizacion Correcta',
                    'message'=>'Los Cambios se almacenaron correctamente'
                ];
                echo json_encode($result);
                exit();
            }else{
                $result=[
                    'status'=>'danger',
                    'title'=>'Actualizacion Errada',
                    'message'=>'Los Cambios no se almacenaron'
                ];
                echo json_encode($result);
                exit();
            }
        }else{

            $updatePlanV2=[
                'idkilometroMaximo'=>$_POST["kilometrajeMax"],
                'costoManoObra'=>$_POST["costoManoObra"],
                'idestadoPlanMantenimientoFamilia'=>$_POST["tipoProceso"]
            ];
            $filtroUpV2=[
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
            ];
            $upd=$planMantenimiento->UpgradePlanFamilia($filtroUpV2,$updatePlanV2);

            if($upd){
                $resultado=$this->ProcesarPlanFamilia($idplanMantenimientoFamilia);
                echo $resultado;
                exit();
            }else{

            }
        }
    }

    public function StorageHoraPlanMantenimiento()
    {
        $planFamilia=New PlanMantenimientoModel();

        $filtroUpdate=[
          'idplanMantenimiento'=>$_POST["idplanMantenimiento"]
        ];

        $updateMto=[
            'tiempoManoObra'=>$_POST["horaPlan"],
            'totalManoObra'=>$_POST["costoManoObra"]
        ];

        $plan=$planFamilia->UpgradePlanMantenimiento($filtroUpdate,$updateMto);

        if($plan){
            $dato=[
                'status'=>'success',
                'title'=>'Actualizacion Corrrecta',
                'message'=>'Se actualizo el tiempo de mano de obra'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Actualizacion Errada',
                'message'=>'No se logro actualizar el tiempo de mano de obra'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function StoragePlanMantenimiento()
    {
        $planFamilia=New PlanMantenimientoModel();

        if($_POST["opcion"]=="add"){

            $filtroDet=[
                'iddetallePlanMantenimientoFamilia'=>$_POST["iddetallePlanMantenimientoFamilia"]
            ];

            $viewDet=$planFamilia->DetailViewPlanFam($filtroDet);

            $detallePlan=[
                'iddetallePlanMantenimientoFamilia'=>$_POST["iddetallePlanMantenimientoFamilia"],
                'idplanMantenimiento'=>$_POST["idplanMantenimiento"],
                'idrepuesto'=>$viewDet[0]["idrepuesto"],
                'cantidad'=>$viewDet[0]["cantidad"],
                'precioUnitario'=>$viewDet[0]["precioUnidadDolares"],
                'precioTotal'=>$viewDet[0]["precioTotalDolares"],
            ];
            $storageDetPlan=$planFamilia->StorageDetallePlanMantenimiento($detallePlan);

            if($storageDetPlan){
                $dato=[
                    'status'=>'success',
                    'title'=>'Añadido Correctamente',
                    'message'=>'Se añadio correctamente el repuesto '.$viewDet[0]["repuesto"].' al plan de mantenimiento'
                ];
                echo json_encode($dato);
                exit();
            }else{
                $dato=[
                    'status'=>'danger',
                    'title'=>'Error en proceso',
                    'message'=>'Ocurrio un error inesperado y no se logro agregar el repuesto al plan de mantenimiento'
                ];
                echo json_encode($dato);
                exit();
            }
        }else{

            $filtroDetv4=[
                'iddetallePlanMantenimientoFamilia'=>$_POST["iddetallePlanMantenimientoFamilia"]
            ];

            $viewDet=$planFamilia->DetailViewPlanFam($filtroDetv4);


            $filtroDet=[
                'iddetallePlanMantenimientoFamilia'=>$_POST["iddetallePlanMantenimientoFamilia"],
                'idplanMantenimiento'=>$_POST["idplanMantenimiento"]
            ];
            $delete=$planFamilia->DeleteDetailPlanMantenimiento($filtroDet);
            if($delete){
                $dato=[
                    'status'=>'success',
                    'title'=>'Retirado Correctamente',
                    'message'=>'Se retiro correctamente el repuesto '.$viewDet[0]["repuesto"].' al plan de mantenimiento'
                ];
                echo json_encode($dato);
                exit();
            }else{
                $dato=[
                    'status'=>'danger',
                    'title'=>'Error en proceso',
                    'message'=>'Ocurrio un error inesperado y no se logro retirar el repuesto del plan de mantenimiento'
                ];
                echo json_encode($dato);
                exit();
            }
        }
    }

    public function ProcesarPlanFamilia($idplanMantenimientoFamilia='')
    {
        $planFamilia=New PlanMantenimientoModel();

        $filterView=[
            'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia
        ];

        $viewPlan=$planFamilia->ViewPlanFam($filterView);

        $kilometrajefinal=$viewPlan[0]["kilometraje"];
        $frecuencia=$viewPlan[0]["frecuencia"];
        $bucle=$kilometrajefinal/$frecuencia;

        //echo $bucle;
        $contador=0;
        $count=0;
        $countDuplicado=0;
        $countErrors=0;
        $countSuccess=0;
        for ($i = 1; $i <= $bucle; $i++) {
            $count++;
            $contador=$contador+$frecuencia;
            $filtroKilometraje=[
                'kilometraje'=>$contador
            ];

            $kilo=$planFamilia->ViewKilometraje($filtroKilometraje);

            $planStorage=[
                'idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia,
                'idkilometraje'=>$kilo[0]["idkilometrajeMantenimiento"],
                'idmarca'=>$viewPlan[0]["idmarca"],
                'idmodelo'=>$viewPlan[0]["idmodelo"],
                'costoManoObra'=>$viewPlan[0]["costoManoObra"]
            ];

            $existe=$planFamilia->ViewPlanMantenimiento($planStorage);
            if($existe){
                $countDuplicado++;
            }else{
                $stor=$planFamilia->StoragePlanMantenimiento($planStorage);
                if($stor){
                    $countSuccess++;
                }else{
                    $countErrors++;
                }
            }
        }

        if($countSuccess==$count){
            $resultado=[
                'status'=>'success',
                'title'=>'Operacion correcta',
                'message'=>'Se generaron los Kilometrajes para el plan de mantenimiento'
            ];
            return json_encode($resultado);
            exit();
        }

        if($countDuplicado>0 and $countSuccess>0){
            $resultado=[
                'status'=>'success',
                'title'=>'Operacion correcta',
                'message'=>'Se generaron los Kilometrajes pendientes, se omitieron duplicados'
            ];
            return json_encode($resultado);
            exit();
        }else if($countDuplicado>0 and $countSuccess==0){
            $resultado=[
                'status'=>'warning',
                'title'=>'Operacion omitida',
                'message'=>'Ya existen los kilometrajes'
            ];
            return json_encode($resultado);
            exit();
        }

    }

    public function DeleteDetailFamilia()
    {
        $planMantenimiento=New PlanMantenimientoModel();
        $iddetallePlanMantenimientoFamilia=$_POST["iddetallePlanMantenimientoFamilia"];

        $filtroDelete=[
            'iddetallePlanMantenimientoFamilia'=>$iddetallePlanMantenimientoFamilia
        ];

        $verifi=$planMantenimiento->VerificarDetailPlan($filtroDelete);

        if($verifi){
            $dato=[
                'status'=>'danger',
                'title'=>'No se puede eliminar',
                'message'=>'El repuesto debe ser retirado de los kilometrajes para ser eliminado'
            ];
            echo json_encode($dato);
            exit();
        }

        $deleteDetail=$planMantenimiento->DeleteDetailFamilia($filtroDelete);

       $view=$planMantenimiento->DetailViewPlanFam($filtroDelete);

        if(!$view){
            $dato=[
                'status'=>'success',
                'title'=>'Repuesto eliminado',
                'message'=>'Se Elimino correctamente el repuesto'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en operacion',
                'message'=>'No se logro eliminar el repuesto del plan de mantenimiento'
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function SaveDetailFamilia()
    {
        $planMantenimiento=New PlanMantenimientoModel();
        $idrepuestoAgregar=$_POST["idrepuestoAgregar"];
        $idplanMantenimientoFamiliaAgregar=$_POST["idplanMantenimientoFamiliaAgregar"];
        $cantidadRepuesto=$_POST["cantidadRepuesto"];
        $precioDolares=$_POST["precioDolaresRepuesto"];


        $detailPlan=[
            'idplanMantenimientoFamilia'=>$idplanMantenimientoFamiliaAgregar,
            'idrepuesto'=>$idrepuestoAgregar,
            'cantidad'=>$cantidadRepuesto,
            'precioTotalDolares'=>($cantidadRepuesto*$precioDolares),
            'precioUnidadDolares'=>$precioDolares
        ];

        $iddetallePlan=$planMantenimiento->StoragePlanDetalle($detailPlan);

        if($iddetallePlan!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Repuesto agregado',
                'message'=>'El repuesto se agrego correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en operacion',
                'message'=>'No se logro agregar el repuesto'
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function GenerarPlantilla()
    {
        $planMantenimientoModel=New PlanMantenimientoModel();
        $planmto=[
            'idmarca'=>$_POST["idmarca"],
            'idmodelo'=>$_POST["idmodelo"],
            'frecuencia'=>$_POST["frecuencia"],
            'estado'=>2
        ];

        $idplanMantenimientoFamilia=$planMantenimientoModel->StoragePlan($planmto);

        if($idplanMantenimientoFamilia!=''){
            $dato=[
                'idplanmantenimientofamilia'=>$idplanMantenimientoFamilia,
                'status'=>'success',
                'title'=>'Generado',
                'message'=>'Ingrese los repuestos para el plan de mantenimiento general'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'error',
                'message'=>'No se logro generar el plan general'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}