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
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Descargar Archivos</h5>
        </div>
        <br>
    </div>
    <div class="form-row">
        <div class="col-12">
            <a class="btn btn-warning btn-sm" download="<?php echo $numeroFactura?>" href="<?php echo base_url("ModuloElectronico/OpcionElectronica/Index/Download?idcpe=".$idcpe."&idtipoArchivo=3")?>">Descargar PDF</a>
            <a class="btn btn-primary btn-sm" download="<?php echo $numeroFactura?>" href="<?php echo base_url("ModuloElectronico/OpcionElectronica/Index/Download?idcpe=".$idcpe."&idtipoArchivo=2")?>">Descargar XML</a>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                CERRAR
            </button>
        </div>
    </div>
</div>