<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Taller (VIN: <?php echo $vin ?>) <?php echo (is_null($idtrasladoVin))?'':' - Envio'?></h5>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                <strong>Advertencia!</strong> Las Novedades no gestionadas por Operaciones seran enviadas a taller, el proceso es irreversible.
            </div>
        </div>
    </div>
    <form id="formSaveUbital" method="POST" action="<?php echo base_url("SolicitudVin/VinSolicitud/SaveEditDelete/SaveEnvioTaller") ?>">
            <input hidden name="idtipoTraslado" id="idtipoTraslado" value="5">
            <input hidden name="vinUbicacion" id="vinUbicacion" value="<?php echo $vin?>">
            <input hidden name="idtrasladoVin" id="idtrasladoVin" value="<?php echo $idtrasladoVin?>">
            <div class="row">
                <div class="col-12">
                    <h6>Ubicacion Fisica y Box Actuales</h6>
                </div>
            </div>
            <div class="row" style="padding-bottom: 8px">
                <div class="col-6">
                    <div class="form-floating">
                        <input hidden name="idgrupoUbicacionActual" value="<?php echo $idgrupoUbicacion?>">
                        <input hidden name="idsolicitudVin" value="<?php echo $idsolicitudVin?>">
                        <select class="form-select" id="ubicacionAnterior" name="ubicacionAnterior" aria-label="Floating label select example">
                            <option selected
                                    value="<?php echo $vinInfo[0]["idubicacionActual"] ?>"><?php echo $vinInfo[0]["ubicacionActual"] ?></option>
                        </select>
                        <label for="floatingSelect">Ubicacion Anterior</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select" id="boxAnterior" name="boxAnterior" aria-label="Floating label select example">
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
                        <select class="form-select" required id="ubicacionNueva" name="ubicacionNueva" aria-label="Floating label select example">
                            <option selected="">Seleccione Ubicacion</option>
                            <?php foreach ($ubicacion as $ubi) { ?>
                                <?php if($idgrupoUbicacion==$ubi["idgrupoUbicacion"]){?>
                                    <option value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                                <?php }?>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Ubicacion Nueva</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select" id="boxNuevo" name="boxNuevo" aria-label="Floating label select example">
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