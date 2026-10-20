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
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$hora = date("H:i:s");
?>
<div class="modal-body">
    <form action="<?php echo base_url("Agendamiento/Agendados/SaveEditDelete/SaveEntrega") ?>" id="formSavePro" method="POST">
        <div class="row">
            <div class="col-12">
                <h5>Proceso de Entrega (<?php echo $vin ?>)</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                    <strong>Advertencia!</strong> Inicio el proceso de entrega para finalizarlo seleccione una de las
                    opciones del sistema.
                </div>
            </div>
        </div>
        <input hidden name="vinProcesoEntrega" value="<?php echo $vin ?>">
        <input hidden name="idcitaProcesoEntrega" value="<?php echo $idcitaEntrega ?>">
        <div class="row" style="padding-bottom:8px">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-control" id="estadoEntrega" name="estadoEntrega">
                            <option value="3">ENTREGA</option>
                            <option value="4">ENTREGADO CON OBSERVACIONES</option>
                            <option value="5">CANCELAR ENTREGA</option>
                        </select>
                        <label for="floatingInput">Estado Entrega</label>
                    </div>
                    <div class="input-group-append">
                        <div class="input-group">
                            <div class="form-floating">
                                <input class="form-control" readonly type="date" value="<?php echo $hoy ?>">
                                <label for="floatingInput">Fecha Entrega</label>
                            </div>
                            <div class="input-group-append">
                                <div class="form-floating">
                                    <input class="form-control" readonly type="time" value="<?php echo $hora ?>">
                                    <label for="floatingInput">Hora Entrega</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control" id="observacion" name="observacion" style="height:120px"></textarea>
                    <label for="floatingInput">Observacion</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-8">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
            <div class="col-4">
                <button class="btn btn-secondary btn-sm" id="btnPrintActa" data-vin="<?php echo $vin ?>"
                        data-idcitaEntrega="<?php echo $idcitaEntrega ?>"><i class="fas fa-print"></i>&nbsp;Imprimir
                    Acta
                </button>
            </div>
        </div>
    </form>
</div>