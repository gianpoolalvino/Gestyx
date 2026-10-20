<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Grupo de Ubicacion (Liberacion) (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <hr>
    <form id="formSaveUbiGp" method="POST"
          action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveGrupoUbicacion") ?>">
        <input hidden name="vinUbicacion" value="<?php echo $vin?>">
        <input hidden name="idgrupoUbicacionOrigen" value="<?php echo $idgrupoUbicacion?>">
        <div class="row">
            <div class="col-12">
                <h6>Grupo de Ubicacion Actual</h6>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-control form-control-sm">
                        <?php foreach($grupoUbicacion as $gub){?>
                            <?php if($gub["idgrupoUbicacion"]==$idgrupoUbicacion){?>
                                <option value="<?php echo $gub["idgrupoUbicacion"]?>"><?php echo $gub["grupoUbicacion"]." - ".$gub["empresa"]?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Grupo de Origen</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Grupo de Ubicacion Nuevo</h6>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="transportista" name="transportista" aria-label="Floating label select example">
                        <option selected="">Seleccione Transportista</option>
                        <?php foreach ($transportista as $trs) { ?>
                            <option value="<?php echo $trs["idtransportista"] ?>"><?php echo $trs["razonSocial"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Transportista</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-8">
                <div class="form-floating">
                    <input class="form-control" id="conductor" name="conductor" aria-label="Floating label select example">
                    <label for="floatingSelect">Conductor</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input class="form-control" id="placaVehiculo" name="placaVehiculo" aria-label="Floating label select example">
                    <label for="floatingSelect">Placa</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="idgrupoUbicacionDestino">
                        <?php foreach($grupoUbicacion as $gub){?>

                                <?php if($gub["idgrupoUbicacion"]!=$idgrupoUbicacion){?>
                                    <option value="<?php echo $gub["idgrupoUbicacion"]?>"><?php echo $gub["grupoUbicacion"]." - ".$gub["empresa"]?></option>
                                <?php }?>

                        <?php }?>
                    </select>
                    <label for="floatingSelect">Grupo de Destino</label>
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