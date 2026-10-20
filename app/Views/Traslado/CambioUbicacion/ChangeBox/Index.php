<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
    .select2-dropdown {
        z-index: 9999999 !important; /* Asegúrate de que tenga un valor mayor que el del modal */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
        padding-top: 14px;
        font-size: 14px;
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--single {
        height: 47px;
        line-height: 52px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Cambio de Box en la misma ubicacion (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <hr>
    <form id="formSaveBox" method="POST"
          action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveBox") ?>">
        <input hidden name="vinUbicacion" id="vinUbicacion" value="<?php echo $vin ?>">
        <div class="row">
            <div class="col-12">
                <h6>Ubicacion Fisica y Box Actuales</h6>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-6">
                <div class="form-floating">
                    <input hidden name="idgrupoUbicacionActual"
                           value="<?php echo $vinInfo[0]["idgrupoUbicacionActual"] ?>">
                    <select class="form-select" id="ubicacionAnterior" name="ubicacionAnterior"
                            aria-label="Floating label select example">
                        <option selected
                                value="<?php echo $vinInfo[0]["idubicacionActual"] ?>"><?php echo $vinInfo[0]["ubicacionActual"] ?></option>
                    </select>
                    <label for="floatingSelect">Ubicacion Anterior</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="boxAnterior" name="boxAnterior"
                            aria-label="Floating label select example">
                        <option selected
                                value="<?php echo $vinInfo[0]["idboxUbicacionActual"] ?>"><?php echo $vinInfo[0]["boxActual"] ?></option>
                    </select>
                    <label for="floatingSelect">Box Anterior</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Ubicacion Fisica y Box Nuevos</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" required id="ubicacionNueva" name="ubicacionNueva"
                            aria-label="Floating label select example">
                        <?php foreach ($ubicacion as $ubi) { ?>
                            <?php if ($vinInfo[0]["idubicacionActual"] == $ubi["idubicacion"]) { ?>
                                <option selected
                                        value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Ubicacion Nueva</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-control form-control-sm" id="boxNuevo" style="width: 100%" required name="boxNuevo">
                        <option selected
                                value="">Seleccione Box
                        </option>
                        <?php foreach ($boxUbicacion as $bx) { ?>
                            <option value="<?php echo $bx["idboxUbicacion"] ?>"><?php echo $bx["descripcion"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelecst">Ubicacion Nueva</label>
                </div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-12 text-center">
                <span id="alertBox"></span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm"
                              placeholder="Ingrese alguna observacion durante el traslado" style="height: 160px"
                              name="comentariosTraslado"></textarea>
                    <label for="floatingSelect">Comentarios</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnProcesarBx" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>