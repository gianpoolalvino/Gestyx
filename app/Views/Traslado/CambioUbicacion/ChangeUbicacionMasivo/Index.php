<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Masivo</h5>
        </div>
    </div>
    <hr>
    <form id="formSaveUbi" method="POST"
          action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveUbicacion") ?>">
        <div class="row">
            <div class="col-12">
                <h6>Ubicacion Fisica Nueva</h6>
            </div>
        </div>
        <div class="row" style="padding-bottom:8px">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" required id="ubicacionNueva" name="ubicacionNueva" aria-label="Floating label select example">
                        <option selected="">Seleccione Ubicacion</option>
                        <?php foreach ($ubicacion as $ubi) { ?>

                            <option value="<?php echo $ubi["idubicacion"]."-".$ubi["descripcion"] ?>"><?php echo $ubi["descripcion"] ?></option>

                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Ubicacion Nueva</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <input style="width: 100%" class="form-control form-control-sm"
                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                       name="resourceExcel"
                       id="customFileSm" type="file"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <span style="font-size: 12px">Debe seleccionar una ubicacion, el Excel debe contar con los siguientes parametros:<br>
                1.- Columna Vin debe ser Columna A<br>
                2.- Columna Box debe ser la Columna D<br>
                3.- Si la Columna Box esta en blanco solo se ingresara la ubicacion<br>
                4.- La Pestaña del Excel debe tener el mismo nombre que la ubicacion seleccionada</span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>