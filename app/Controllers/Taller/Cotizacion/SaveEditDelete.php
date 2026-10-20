<?php

namespace App\Controllers\Taller\Cotizacion;

use App\Controllers\BaseController;
use App\Models\CotizacionModel;
use App\Models\GeneralesModel;
use App\Models\PlanMantenimientoModel;

class SaveEditDelete extends BaseController
{
    // --------------------------------------------------------------
    // Métodos públicos (acciones del controlador)
    // --------------------------------------------------------------

    public function SaveCotizacion()
    {
        $cotizacionModel = new CotizacionModel();
        $planMantenimiento = new PlanMantenimientoModel();

        // Obtener el número de cotización
        $filtroCot = ['idmarca' => $_POST["createMarca"]];
        $ultima = $cotizacionModel->NumeroCotizacion($filtroCot);
        $numeroCot = $ultima[0]["numeroCotizacion"] + 1;

        $digitos = 6; // puedes cambiarlo a 7 u 8 si necesitas crecer más
        $numeroCotizacion = str_pad($numeroCot, $digitos, "0", STR_PAD_LEFT);

        // Obtener datos del plan de mantenimiento
        $filtr = ['idplanMantenimiento' => $_POST["kilometraje"]];
        $viewPlanMto = $planMantenimiento->ViewPlanMantenimiento($filtr);

        // Construir cabecera de la cotización
        $cabeceraCotizacion = [
            "numero"                      => $numeroCotizacion,
            "documentoCliente"            => $_POST["documentoCliente"],
            "nombrecliente"               => $_POST["nombreCliente"],
            "direccionCliente"            => $_POST["direccionCliente"],
            "correoCliente"               => $_POST["correoCliente"],
            "telefonoCliente"             => $_POST["telefonoCliente"],
            "placaCliente"                => $_POST["placaCliente"],
            "idkilometrajeMantenimiento"  => $viewPlanMto[0]["idkilometraje"],
            "descuentoPorcentajeRepuestos"=> $_POST["descuento"],
            "descuentoTotal"              => $_POST["dscto"],
            "subTotal"                    => $_POST["subTotal"],
            "igv"                         => $_POST["igv"],
            "total"                       => $_POST["total"],
            "idtipoMoneda"                => $_POST["tipoMoneda"],
            "idmarca"                     => $_POST["createMarca"],
            "idmodelo"                    => $_POST["createModelo"],
            "observaciones"               => $_POST["observacionesCotizacion"],
            'idusuario'                   => session("idusuario"),
            'descuentoRepuestos'          => $_POST["descuentoRepuesto"],
            'tiempoManoObra'              => $_POST["cantidadManoObra"],
            'subTotalManoObra'            => $_POST["costoManoObra"],
            'descuentoPorcentajeManoObra' => $_POST["descuentoPorcentajeManoObra"],
            'descuentoManoObra'           => $_POST["descuentoMano"],
            'totalManoObra'               => $_POST["totalManoObra"],
        ];

        $idcotizacion = $cotizacionModel->StorageCotizacion($cabeceraCotizacion);

        if ($idcotizacion != '') {
            $this->guardarDetalleCotizacion($cotizacionModel, $idcotizacion);

            $this->responderJson('success', 'Operacion Correcta', 'Se logro almacenar correctamente la cotizacion');
        } else {
            $this->responderJson('danger', 'Operacion Errada', 'La cotizacion no se logro almacenar');
        }
    }

    public function SendERP()
    {
        $cotizacionModel = new CotizacionModel();
        $generalModel = new GeneralesModel();

        $filtroCot = ['idcotizacion' => $_POST['idcotizacion']];
        $filtroAgen = ['idagencia' => $_POST['agencia']];

        $agencias = $generalModel->Agencia($filtroAgen);
        $taller = $generalModel->Taller($filtroAgen);

        $cabeceraCotizacion = $cotizacionModel->ViewCotizacion($filtroCot);
        $detalleCotizacion = $cotizacionModel->ViewDetalleCotizacion($filtroCot);

        $codigoMarca = $cabeceraCotizacion[0]['codigoMarca'];
        $ocrCode1 = $this->mapOcrCode1ByMarca($codigoMarca);

        $marca = strtoupper(trim($cabeceraCotizacion[0]['marca']));

        // Configurar URL y código de mano de obra según la marca
        if ($marca === 'CHEVROLET' || $marca === 'ISUZU') {
            $url = "http://190.223.25.10:8093/api/ordenventa";
            $km = (int) preg_replace('/[^0-9]/', '', $cabeceraCotizacion[0]['kilometraje']);
            $codigoManoObra = $this->mapManoObraGM($km);
        } else {
            $url = "http://190.223.25.10:8066/api/ordenventa";
            $codigoManoObra = $cabeceraCotizacion[0]['codigoManoObra'];
        }

        // Asegurar que el cliente existe en el ERP
        $clienteResult = $this->ensureClienteERP($marca, $cabeceraCotizacion);
        if (!$clienteResult['success']) {
            echo json_encode([
                'status' => 'danger',
                'title'  => 'Error al crear cliente en ERP',
                'info'   => $clienteResult['error']
            ]);
            exit();
        }

        // Construir el payload de la orden de venta
        $payload = $this->buildOrdenVentaPayload(
            $cabeceraCotizacion,
            $detalleCotizacion,
            $ocrCode1,
            $codigoManoObra,
            $agencias[0]['codigoAgencia'],
            $taller[0]['codigoTaller']
        );

        // Enviar al ERP
        $response = $this->callApi($url, $payload);
        $result = json_decode($response);

        if ($result->Codigo == 0) {
            $buc = $result->ObjDetalle;
            $dato = [
                'status' => 'danger',
                'title'  => 'Errores Detectados',
                'detail' => $buc
            ];
            $send = [
                'status' => 'danger',
                'title'  => '',
                'info'   => view('Taller/Cotizacion/Notificacion/Index', $dato) .
                           view('Taller/Cotizacion/Notificacion/Scripts')
            ];
            echo json_encode($send);
            exit();
        } else {
            // Marcar como enviado
            $updateCot = ['sendErp' => 1];
            $cotizacionModel->UpgradeCotizacion($filtroCot, $updateCot);

            $dato = [
                'status'  => 'success',
                'title'   => 'Orden Generada con Éxito',
                'message' => 'La orden de pedido se generó correctamente en el ERP'
            ];
            $send = [
                'status' => 'success',
                'title'  => '',
                'info'   => view('Taller/Cotizacion/Notificacion/Index', $dato) .
                           view('Taller/Cotizacion/Notificacion/Scripts')
            ];
            echo json_encode($send);
            exit();
        }
    }

    // --------------------------------------------------------------
    // Métodos privados (lógica auxiliar)
    // --------------------------------------------------------------

    /**
     * Almacena el detalle de la cotización.
     */
    private function guardarDetalleCotizacion($cotizacionModel, $idcotizacion)
    {
        $countDet = 0;
        while ($countDet < count($_POST["iddetalleMantenimiento"])) {
            $detalleCotizacion = [
                'iddetalleMantenimiento' => $_POST["iddetalleMantenimiento"][$countDet],
                'cantidad'               => $_POST["cantidad"][$countDet],
                'precioUnitario'         => $_POST["precioUnitarioRepuesto"][$countDet],
                'precioSubTotal'         => $_POST["subTotalRepuesto"][$countDet],
                'descuento'              => $_POST["desctoRepuesto"][$countDet],
                'precioTotal'            => $_POST["precioTotalRepuesto"][$countDet],
                'idcotizacion'           => $idcotizacion,
                'idrepuesto'             => $_POST["idrepuesto"][$countDet],
            ];
            $cotizacionModel->StorageDetalleCotizacion($detalleCotizacion);
            $countDet++;
        }
    }

    /**
     * Construye el array completo que se enviará a la API de orden de venta.
     */
    private function buildOrdenVentaPayload(
        array $cabecera,
        array $detalle,
        string $ocrCode1,
        string $codigoManoObra,
        string $codigoAgencia,
        string $codigoTaller
    ): array {
        $cotiCab = [
            "CardCode"       => "C" . $cabecera[0]['documentoCliente'],
            "U_SYP_MARCA"    => $cabecera[0]['marca'],
            "U_SYP_MODELO"   => $cabecera[0]['modelo'],
            "U_SYP_PLACA"    => $cabecera[0]['placaCliente'],
            "NumAtCard"      => "GESTYX-" . $cabecera[0]['numero'],
            "DocCur"         => $cabecera[0]['codigoMoneda'],
            "DocDate"        => $cabecera[0]['fechaCotizacion'],
            "DocDueDate"     => $cabecera[0]['fechaCotizacion'],
            "TaxDate"        => $cabecera[0]['fechaCotizacion'],
            "SlpCode"        => "-1",
            // "DiscPrcnt"   => $cabecera[0]['descuentoTotal'],
            "ShipToCode"     => "",
            "Address2"       => "",
            "Address"        => "",
            "GroupNum"       => -1,
            "LicTradNum"     => $cabecera[0]['documentoCliente'],
            "U_SYP_TVENTA"   => "01",
            "U_SYP_NOCCLIENTE"=> "",
            "U_SYP_EXTERNO"  => "GESTYX-" . $cabecera[0]['numero'],
        ];

        // Campos personalizados
        $personalizados = [];
        $personalizados[] = [
            "Tipo"     => "string",
            "Nombre"   => "U_SYP_MARCA",
            "Valor"    => $cabecera[0]['marca'],
            "Procesar" => "Y"
        ];
        $personalizados[] = [
            "Tipo"     => "string",
            "Nombre"   => "U_SYP_MODELO",
            "Valor"    => $cabecera[0]['modelo'],
            "Procesar" => "Y"
        ];
        $personalizados[] = [
            "Tipo"     => "string",
            "Nombre"   => "U_SYP_PLACA",
            "Valor"    => $cabecera[0]['placaCliente'],
            "Procesar" => "Y"
        ];

        $retencion = (strlen($cabecera[0]['documentoCliente']) == 11) ? 'Y' : 'N';

        // Líneas de detalle
        $detail = [];

        // Línea de mano de obra
        $precioManoObra = ($cabecera[0]['subTotalManoObra'] / $cabecera[0]['tiempoManoObra']);
        $detail[] = [
            "BaseType"            => -1,
            "BaseEntry"           => -1,
            "BaseLine"            => -1,
            "ItemCode"            => $codigoManoObra,
            "Dscription"          => $cabecera[0]['descripcionManoObra'],
            "Quantity"            => $cabecera[0]['tiempoManoObra'],
            'DiscPrcnt'           => $cabecera[0]['descuentoPorcentajeManoObra'],
            "Price"               => ($precioManoObra / 1.18),
            "TaxCode"             => "IGV",
            "WhsCode"             => $codigoTaller,
            "OcrCode"             => $ocrCode1,
            "OcrCode2"            => $codigoAgencia,
            "OcrCode3"            => "L006",
            "OcrCode4"            => "A016",
            "OcrCode5"            => "",
            "U_SYP_ARTINV"        => "Y",
            "U_SYP_EXTERNO"       => "1GESTYX",
            "U_SYP_EXT_LINEA"     => 1,
            "WtLiable"            => $retencion
        ];

        // Líneas de repuestos
        $contador = 1;
        foreach ($detalle as $detCot) {
            $contador++;
            $detail[] = [
                "BaseType"        => -1,
                "BaseEntry"       => -1,
                "BaseLine"        => -1,
                "ItemCode"        => $detCot['codigo'],
                "Dscription"      => $detCot['repuesto'],
                "Quantity"        => $detCot['cantidad'],
                'DiscPrcnt'       => $cabecera[0]['descuentoAplicado'],
                "Price"           => ($detCot['precioUnitario'] / 1.18),
                "TaxCode"         => "IGV",
                "WhsCode"         => $codigoTaller,
                "OcrCode"         => $ocrCode1,
                "OcrCode2"        => $codigoAgencia,
                "OcrCode3"        => "L006",
                "OcrCode4"        => "A016",
                "OcrCode5"        => "",
                "U_SYP_ARTINV"    => "Y",
                "U_SYP_EXTERNO"   => "1GESTYX",
                "U_SYP_EXT_LINEA" => $contador,
                "WtLiable"        => $retencion
            ];
        }

        $cotiCab['ObjDetalle']             = $detail;
        $cotiCab['ObjCamposPersonalizados'] = $personalizados;

        return $cotiCab;
    }

    /**
     * Asegura que el cliente exista en el ERP, creándolo si es necesario.
     */
    private function ensureClienteERP(string $marca, array $cabecera): array
    {
        $doc = $cabecera[0]['documentoCliente'];
        $cardCode = "C" . $doc;
        $nombres = $this->separarNombreCompleto($cabecera[0]['nombreCliente']);

        $clienteData = [
            "CardCode"    => $cardCode,
            "LicTradNum"  => $doc,
            "CardName"    => $cabecera[0]['nombreCliente'],
            "CardType"    => "C",
            "GroupCode"   => 100,
            "Currency"    => "##",
            "GroupNum"    => -1,
            "SlpCode"     => -1,
            "WTLiable"    => "Y",
            "VatStatus"   => "Y",
            "VatGroup"    => "IGV",
            "validFor"    => "Y",
            "frozenFor"   => "N",
            "Cellular"    => $cabecera[0]['telefonoCliente'],
            "E_Mail"      => $cabecera[0]['correoCliente'],

            // Campos fiscales Perú
            "U_SYP_BPAP"  => strlen($doc) == 11 ? '' : $nombres['apellidoPaterno'],
            "U_SYP_BPAM"  => strlen($doc) == 11 ? '' : $nombres['apellidoMaterno'],
            "U_SYP_BPNO"  => strlen($doc) == 11 ? '' : $nombres['primerNombre'],
            "U_SYP_BPN2"  => strlen($doc) == 11 ? '' : $nombres['segundoNombre'],
            "U_SYP_BPTP"  => strlen($doc) == 11 ? "TPJ" : "TPN",
            "U_SYP_BPTD"  => strlen($doc) == 8 ? "1" : (strlen($doc) == 11 ? "6" : (strlen($doc) == 9 ? "4" : "")),
            "U_SYP_BPAT"  => "N",
            "U_SYP_AGENRE"=> "N",
            "U_SYP_SNBUEN"=> "N",
            "U_SYP_TPER"  => "N",
            "U_SYP_EXOPER"=> "N",
            "U_SYP_CONV"  => "0",
            "U_SYP_SVIN"  => "N",
            "U_SYP_CDRCLI"=> "N",
            "U_SYP_PROVHNRS" => "N",
            "U_SYP_LIBRET"=> "Y",
            "U_SYP_APLIFACT" => "N",
            "U_SYP_CGT_PRICEFROM" => "01",
            "U_SYP_TVN"   => "01",
            "U_SYP_DIRSUNAT" => $cabecera[0]['direccionCliente']
        ];

        // Seleccionar URL según marca
        if ($marca === 'CHEVROLET' || $marca === 'ISUZU') {
            $urlSocio = "http://190.223.25.10:8094/api/socionegocio";
        } else {
            $urlSocio = "http://190.223.25.10:8068/api/socionegocio";
        }

        $response = $this->callApi($urlSocio, $clienteData);
        $httpCode = $this->lastHttpCode;

        if ($this->lastCurlError) {
            return [
                'success' => false,
                'error'   => "Error CURL: " . $this->lastCurlError
            ];
        }

        $result = json_decode($response);

        // Éxito
        if ($httpCode == 200 || $httpCode == 201) {
            return ['success' => true];
        }

        // Ya existe
        if ($result && isset($result->Mensaje)) {
            if (stripos($result->Mensaje, 'existe') !== false) {
                return ['success' => true];
            }
            return [
                'success' => false,
                'error'   => $result->Mensaje
            ];
        }

        // Error genérico
        return [
            'success' => false,
            'error'   => "HTTP $httpCode - Respuesta: " . $response
        ];
    }

    /**
     * Separa un nombre completo en apellidos y nombres.
     */
    private function separarNombreCompleto(string $nombreCompleto): array
    {
        $nombreCompleto = trim($nombreCompleto);
        $partes = preg_split('/\s+/', $nombreCompleto);
        $cantidad = count($partes);

        $apellidoPaterno = '';
        $apellidoMaterno = '';
        $primerNombre = '';
        $segundoNombre = '';

        if ($cantidad >= 4) {
            $apellidoPaterno = $partes[$cantidad - 2];
            $apellidoMaterno = $partes[$cantidad - 1];
            $nombres = array_slice($partes, 0, $cantidad - 2);
            $primerNombre = $nombres[0] ?? '';
            $segundoNombre = implode(' ', array_slice($nombres, 1));
        } elseif ($cantidad == 3) {
            $primerNombre = $partes[0];
            $apellidoPaterno = $partes[1];
            $apellidoMaterno = $partes[2];
        } elseif ($cantidad == 2) {
            $primerNombre = $partes[0];
            $apellidoPaterno = $partes[1];
        } elseif ($cantidad == 1) {
            $primerNombre = $partes[0];
        }

        return [
            'apellidoPaterno' => $apellidoPaterno,
            'apellidoMaterno' => $apellidoMaterno,
            'primerNombre'    => $primerNombre,
            'segundoNombre'   => $segundoNombre
        ];
    }

    /**
     * Mapea kilometraje a código de mano de obra para GM.
     */
    private function mapManoObraGM(int $km): ?string
    {
        return match ($km) {
            5000   => '5040814',
            10000  => '5041014',
            15000  => '5041114',
            20000  => '5041214',
            25000  => '5041314',
            30000  => '5041414',
            35000  => '5041514',
            40000  => '5041614',
            45000  => '5041714',
            50000  => '5041814',
            55000  => '5041914',
            60000  => '5042014',
            65000  => '5042114',
            70000  => '5042214',
            75000  => '5042314',
            80000  => '5042414',
            85000  => '5042514',
            90000  => '5042614',
            95000  => '5042714',
            100000 => '5042814',
            default => null,
        };
    }

    /**
     * Mapea código de marca a código de centro de costo 1.
     */
    private function mapOcrCode1ByMarca(string $codigoMarca): string
    {
        return match ($codigoMarca) {
            'NIS001' => 'M006', // NISSAN
            'HYD001' => 'M004', // HYUNDAI
            'CHV001' => 'M005', // CHEVROLET
            'FS001'  => 'M002', // FUSO
            'IZS001' => 'M008', // ISUZU
            'MTS001' => 'M001', // MITSUBISHI
            default  => 'M999', // fallback seguro
        };
    }

    /**
     * Realiza una llamada a una API REST usando cURL.
     * Almacena el código HTTP y posibles errores para uso posterior.
     */
    private $lastHttpCode = 0;
    private $lastCurlError = '';

    private function callApi(string $url, array $data): string
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => [
                "Authorization: Basic emlxRGpyMjNabWRjUHVzVlFDT1k3djN6YUt1eFJod2o5MFdjUWk4d29kYz06K0M1UnYwcTRZcHdoNjJvRkc0bjZ5dz09",
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);

        $response = curl_exec($ch);
        $this->lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $this->lastCurlError = curl_error($ch);
        } else {
            $this->lastCurlError = '';
        }

        curl_close($ch);
        return $response;
    }

    /**
     * Envía una respuesta JSON estándar y termina la ejecución.
     */
    private function responderJson(string $status, string $title, string $message): void
    {
        echo json_encode([
            'status'  => $status,
            'title'   => $title,
            'message' => $message
        ]);
        exit();
    }
}