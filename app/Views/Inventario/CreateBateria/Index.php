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
        <form id="formBateria" method="POST" action="<?php echo base_url("Inventario/SaveEditDelete/SaveBateria") ?>">
            <div class="row" style="padding-top:1px">
                <div class="col-12">
                    <h4 class="text-primary">Test de Bateria (<?php echo $vin ?>)</h4>
                </div>
            </div>
            <?php
            $bloqueado = '';
            if ($viewVin[0]["ubicacion"] == '') {
                $bloqueado = 'disabled';
                ?>
                <div class="row" style="margin-bottom:0px">
                    <div class="col-12" style="margin-bottom:0px">
                        <div class="alert alert-subtle-warning" role="alert" style="margin-bottom:0px">
                            <strong>Advertencia: </strong>La Unidad no cuenta con una ubicacion fisica, dirijase a
                            ubicaciones fisicas para incorporarla o de click en el enlace
                            <a href="<?php echo base_url("Traslado/CambioUbicacion?vin=").$vin ?>">Ubicaciones</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <hr>
            <input hidden name="vinBateria" required value="<?php echo $vin ?>">
            <div class="row">
                <div class="col-8">
                    <div class="form-floating">
                        <select class="form-control form-control-sm" <?php echo $bloqueado ?> required
                                name="estadoBateria"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value="">Estado Bateria</option>
                            <option value="1">Optimo</option>
                            <option value="2">Requiere Cambio</option>
                        </select>
                        <label for="floatingSelect">Estado Bateria</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" <?php echo $bloqueado ?> type="date"
                               value="<?php echo isset($infoBateria[0]["fechaNuevoTest"])?$infoBateria[0]["fechaNuevoTest"]:$vinBatIng[0]['fechaIngreso']?>"
                               max="<?php echo $hoy ?>" placeholder="Fecha Test" name="fechaTestReal" required>
                        <label for="floatingSelect">Fecha Test</label>
                    </div>
                </div>
                <input hidden name="fechaTest" value="<?php echo isset($infoBateria[0]["fechaNuevoTest"])?$infoBateria[0]["fechaNuevoTest"]:$vinBatIng[0]['fechaIngreso']?>">
            </div>
            <div class="row" style="padding-top: 6px">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control form-control-sm" <?php echo $bloqueado ?> style="height:80px"
                                  name="observacion"></textarea>
                        <label for="floatingSelect">Observaciones</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label class="form-label spanlabel" for="resourceDetalleBat">Tomar Foto</label>
                    <input class="form-control form-control-sm" required name="resourceDetalleBat" id="resourceDetalleBat" accept="image/*" type="file" capture="camera"/>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary btn-sm" <?php echo $bloqueado ?> type="submit">PROCESAR</button>
                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </form>

</div>