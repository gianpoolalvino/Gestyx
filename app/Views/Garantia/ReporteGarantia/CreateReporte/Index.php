<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Garantias - Generar Reporte de Garantia</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <div class="form-floating">
                <select class="form-control form-control-sm" required
                        id="tipoReporte"
                        name="tipoReporte"
                        data-choices="data-choices"
                        aria-label="Floating label select example">
                    <?php foreach($tipoReporte as $tr){?>
                        <option selected value="<?php echo $tr["idtipoReporteGarantia"]?>"><?php echo $tr["descripcion"]?></option>
                    <?php }?>
                </select>
                <label for="floatingSelect">Tipo de Reporte</label>
            </div>
        </div>
    </div><hr>
    <div class="form-row">
        <div class="col-12">
            <label>Vins</label>
            <select class="form-control form-control-sm" data-live-search="true" id="vinReportar">
                <?php foreach($vins as $vn){?>
                    <option value="<?php echo $vn["vin"]?>"><?php echo $vn["vin"]?></option>
                <?php }?>
            </select>
        </div>
    </div><hr>
    <div class="form-row">
        <div class="col-12">

        </div>
    </div>
    <div class="form-row">
        <div class="col-12 text-right" style="text-align: right">
            <button class="btn btn-primary btn-sm">Añadir Item</button>
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="col-12">
            <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;PROCESAR</button>
            <button class="btn btn-outline-danger btn-sm" id="btnCloseReporte">CANCELAR</button>
        </div>
    </div>
</div>