<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }
</style>
<?php
$eventos = [
    [
        'idwebService' => '033',
        'idevento' => 'acc',
        'evento' => 'Aceptacion',
    ],
    [
        'idwebService' => '030',
        'idevento' => 'ack',
        'evento' => 'Acuse',
    ],
    [
        'idwebService' => '032',
        'idevento' => 'asr',
        'evento' => 'Aceptacion del Bien',
    ],
    [
        'idwebService' => '031',
        'idevento' => 'rej',
        'evento' => 'Reclamo',
    ],
];

$events = $cpe->events;

$bucle = [
    [
        'status' => isset($cpe->events->acc->status) ? ($cpe->events->acc->status != 'OK') ? 'danger' : 'success' : 'noRegister',
        'idevento' => 'acc'
    ],
    [
        'status' => isset($cpe->events->ack->status) ? ($cpe->events->ack->status != 'OK') ? 'danger' : 'success' : 'noRegister',
        'idevento' => 'ack'
    ],
    [
        'status' => isset($cpe->events->asr->status) ? ($cpe->events->asr->status != 'OK') ? 'danger' : 'success' : 'noRegister',
        'idevento' => 'asr'
    ],
    [
        'status' => isset($cpe->events->rej->status) ? ($cpe->events->rej->status != 'OK') ? 'danger' : 'success' : 'noRegister',
        'idevento' => 'rej'
    ],
];
$comparerId = [];
foreach ($bucle as $bc) {
    if ($bc["status"] == 'success') {
        $comparerId[] = $bc["idevento"];
    }
}
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5 class="text-primary">Generar Evento para el Comprobante: <?php echo $numeroFactura ?></h5>
        </div>
    </div>
    <form method="POST" id="formEvents"
          action="<?php echo base_url("ModuloElectronico/OpcionElectronica/Index/UploadEvento") ?>">
        <input hidden name="idcpe" value="<?php echo $idcpe ?>">
        <?php
            $tipoDocumento='';
            if($cpe->typeCode=='01' || $cpe->typeCode=='02' || $cpe->typeCode=='03'){
                $tipoDocumento='1'.$cpe->typeCode;
            }else{
                $tipoDocumento='2'.$cpe->typeCode;
            }
        ?>
        <input hidden name="typeCpe" value="<?php echo $tipoDocumento?>">
        <input hidden name="documentoProveedor" value="<?php echo $cpe->issuer->identification?>">
        <input hidden name="tipodocumentoProveedor" value="<?php echo $cpe->issuer->identificationTypeCode?>">
        <input hidden name="nombreProveedor" value="<?php echo $cpe->issuer->name?>">
        <div class="row">
            <div class="col-12">
                <label class="spanlabel titleLabel">Eventos de Comprobante</label>
                <select class="form-control form-control-sm" name="evento" id="eventoSelect">
                    <option value="">Seleccione Evento</option>
                    <?php foreach ($eventos as $evn) { ?>
                        <?php if (!in_array($evn["idevento"], $comparerId)) { ?>
                            <option value="<?php echo $evn["idwebService"] ?>"><?php echo $evn["evento"] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div id="panelReclamo" style="display: none">
            <div class="row">
                <div class="col-12">
                    <label class="spanlabel titleLabel">Motivo de Reclamo</label>
                    <select class="form-control form-control-sm" name="motivoReclamo" id="motivoReclamo">
                        <option value="">Seleccione un motivo de reclamo</option>
                        <option value="01-Documento con inconsistencias">Documento con inconsistencias</option>
                        <option value="02-Mercancía no entregada">Mercancía no entregada</option>
                        <option value="03-Mercancía entregada parcialmente">Mercancía entregada parcialmente</option>
                        <option value="04-Servicio no prestado">Servicio no prestado</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label class="spanlabel titleLabel">Observacion de Comprobante <small>En caso exista Reclamo</small></label>
                <textarea class="form-control form-control-sm" name="observacion" style="height: 120px"></textarea>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </form>
</div>