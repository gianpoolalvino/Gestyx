<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Envio Solicitante (VIN: <?php echo $vin ?>) <?php echo (is_null($idtrasladoVin))?'':' - Envio'?></h5>
        </div>
    </div>
    <hr>
    <form id="formSaveUbi" method="POST" action="<?php echo base_url("SolicitudVin/VinSolicitud/SaveEditDelete/SaveEnvioSolicitante") ?>">
        <input hidden name="idtipoTraslado" id="idtipoTraslado" value="6">
        <input hidden name="vinUbicacion" id="vinUbicacion" value="<?php echo $vin?>">
        <input hidden name="idtrasladoVin" id="idtrasladoVin" value="<?php echo $idtrasladoVin?>">
        <input hidden name="idsolicitudvehiculo" value="<?php echo $idsolicitudVehiculo?>">
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
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" required id="grupoNuevo" name="grupoNuevo">
                        <?php foreach($grupoUbicacion as $gu){?>
                            <?php if($idgrupoUbicacion==$gu["idgrupoUbicacion"]){?>
                                <option value="<?php echo $gu["idgrupoUbicacion"] ?>"><?php echo $gu["grupoUbicacion"] ?></option>
                            <?php }else{?>
                                <option value="<?php echo $gu["idgrupoUbicacion"] ?>"><?php echo $gu["grupoUbicacion"] ?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Grupo Ubicacion</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" required id="transportista" name="transportista">
                        <option value="">Seleccione Transportista</option>
                        <?php foreach($transportista as $trs){?>
                            <option value="<?php echo $trs["idtransportista"]?>"><?php echo $trs["razonSocial"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Transportista</label>
                </div>
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