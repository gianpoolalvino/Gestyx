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
?>
<div class="modal-body">
        <div class="row">
            <div class="col-12">
                <h5>Test Bateria (<?php echo $vin ?>)</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label class="form-label spanlabel">Fecha Test Bateria</label><br>
                <strong><?php echo $infoBateria[0]["fechaTest"] . " " . $infoBateria[0]["horaTest"] ?></strong><br>
            </div>
            <div class="col-6">
                <label class="form-label spanlabel">Fecha Proximo Test</label><br>
                <strong><?php echo $infoBateria[0]["fechaProximoTest"] ?></strong><br>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label class="form-label spanlabel">Estado Actual Bateria</label><br>
                <strong><?php echo $infoBateria[0]["estadoBateria"] ?></strong><br>
            </div>
            <div class="col-6">
                <label class="form-label spanlabel">Usuario Test</label><br>
                <strong><?php echo $infoBateria[0]["usuario"] ?></strong><br>
            </div>
        </div>
        <?php if($infoBateria[0]['rutaImagen']!=''){?>
            <div class="row">
                <div class="col-12">
                    <img src="<?php echo base_url($infoBateria[0]["rutaImagen"]) ?>" style="width: 100%">
                </div>
            </div>
        <?php }?>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
</div>