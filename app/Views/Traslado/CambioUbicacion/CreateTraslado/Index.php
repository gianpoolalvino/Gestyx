<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Generar Traslado Vehicular</h5>
        </div>
    </div>
    <hr>
    <form id="formSaveUbi" method="POST"
          action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveUbicacion") ?>">
        <div class="row">
            <div class="col-12">
                <h6>Datos Actuales de Vehiculo</h6>
            </div>
        </div>
        <div class="row pb-2">
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Ubicacion Fisica y Box Nuevos</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" required id="ubicacionNueva" name="ubicacionNueva" aria-label="Floating label select example">
                        <option selected="">Seleccione Ubicacion</option>
                        <?php foreach ($ubicacion as $ubi) { ?>
                            <option value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Ubicacion Nueva</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="boxNuevo" required name="boxNuevo" aria-label="Floating label select example">
                        <option selected
                                value="">Seleccione Box</option>
                    </select>
                    <label for="floatingSelect">Box Nuevo</label>
                </div>
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