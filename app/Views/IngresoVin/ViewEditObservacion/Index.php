<style>
    .spanLabel{
        font-size: 12px;
    }
</style>
<?php if($viewIngreso[0]["idestadoObservacion"]==1){?>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <h5 class="text-primary">Editar Observaciones en Vehiculo</h5>
        </div>
    </div>
    <form id="formUpdateObs" method="POST" action="<?php echo base_url("IngresoVin/SaveEditDelete/UpdateObservacion") ?>">
        <input hidden name="idobservacionIngreso" value="<?php echo $idobservacionIngresoVin?>">
        <input hidden name="vinObs" value="<?php echo $viewIngreso[0]["vin"]?>">
        <div class="row" style="padding-bottom: 6px">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" required name="tipoDanho" id="selectTipoDanho">
                        <option value="">Seleccione Tipo Daño...</option>
                        <?php foreach($selectTipoDanho as $sta){?>
                            <option <?php echo ($sta["idtipoDanhoVin"]==$viewIngreso[0]["idtipoDanhoVin"]?'selected':'')?> value="<?php echo $sta["idtipoDanhoVin"]?>"><?php echo $sta["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="selectTipoDanho">Tipo Daño</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" required name="nivelDanho" id="selectNivelDanho">
                        <option value="">Seleccione Nivel de Daño...</option>
                        <?php foreach($selectNivelDanho as $sdna){?>
                            <option <?php echo ($sdna["idseveridadDanhoVin"]==$viewIngreso[0]["idseveridadDanhoVin"]?'selected':'')?> value="<?php echo $sdna["idseveridadDanhoVin"]?>"><?php echo $sdna["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="selectNivelDanho">Seleccione Nivel de Daño</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" required name="areaDanho" id="selectAreaDanho">
                        <option value="">Seleccione Area...</option>
                        <?php foreach($selectAreaDanho as $saad){?>
                            <option <?php echo ($saad["idareaDanhoVin"]==$viewIngreso[0]["idareaDanhoVin"]?'selected':'')?> value="<?php echo $saad["idareaDanhoVin"]?>"><?php echo $saad["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="selectAreaDanho">Area Daño</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" required name="subAreaDanho" id="selectSubAreaDanho">
                        <option value="">Seleccione Sub Area...</option>
                        <?php foreach($selectSubAreaDanho as $sabd){?>
                            <option <?php echo ($sabd["idsubAreaDanhoVin"]==$viewIngreso[0]["idsubAreaDanhoVin"]?'selected':'')?> value="<?php echo $sabd["idsubAreaDanhoVin"]?>"><?php echo $sabd["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="selectSubAreaDanho">Sub Area Daño</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-select-sm" required name="reparacion" id="selectReparacion">
                        <option value="">Seleccione Reparacion...</option>
                        <?php foreach($selectReparacion as $reps){?>
                            <option <?php echo ($reps["idreparacionVin"]==$viewIngreso[0]["idreparacionVin"]?'selected':'')?> value="<?php echo $reps["idreparacionVin"]?>"><?php echo $reps["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="selectReparacion">Reparacion</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm" required name="detalleRepuesto"
                          style="height: 120px"><?php echo $viewIngreso[0]["detalleRepuesto"]?></textarea>
                    <label for="selectAreaDanho">Detalle Repuesto</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-6">
                <label class="spanLabel" style="font-size: 12px">Registro en Guia</label>
                <div class="form-check form-check-inline">


                    <input class="form-check-input" id="inlineRadio1" <?php echo ($viewIngreso[0]["registroGuia"]==1)?'checked':''?> type="radio" name="registroGuia"
                           value="1"/>
                    <label class="form-check-label" for="inlineRadio1">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineRadio2" <?php echo ($viewIngreso[0]["registroGuia"]==2)?'checked':''?> type="radio" name="registroGuia"
                           value="2"/>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm" value="<?php echo $viewIngreso[0]["solucionObservacion"]?>" name="solucion">
                    <label for="selectAreaDanho">Solucion</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm" id="comentarioObs" name="comentarioObs"
                          style="height: 120px"><?php echo $viewIngreso[0]["comentarios"]?></textarea>
                    <label for="comentarioObs">Comentarios</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <label class="spanLabel">Cargar Imagenes</label>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <?php
                if($viewIngreso[0]["idtipoCargaImagen"]!=2) {
                    $base1 = 'data:image/' . $viewIngreso[0]["tipoImagen1"] . ';base64,' . $viewIngreso[0]["imagenVehiculo1"];
                }else{
                    $base1=$viewIngreso[0]["rutaImagen1"];
                }
                ?>
                <img style="width:100%;" src="<?php echo $base1?>">

                <input style="width: 100%" class="form-control form-control-sm"
                       name="imagenObs1"
                       id="imagenObs1" type="file"/>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <?php
                if($viewIngreso[0]["idtipoCargaImagen"]!=2) {
                    $base2 = 'data:image/' . $viewIngreso[0]["tipoImagen2"] . ';base64,' . $viewIngreso[0]["imagenVehiculo2"];
                }else{
                    $base2=$viewIngreso[0]["rutaImagen2"];
                }
                ?>
                <img style="width:100%;" src="<?php echo $base2?>">
                <input style="width: 100%" class="form-control form-control-sm"
                       name="imagenObs2"
                       id="imagenObs2" type="file"/>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <?php
                if($viewIngreso[0]["idtipoCargaImagen"]!=2) {
                    $base3= 'data:image/' . $viewIngreso[0]["tipoImagen3"] . ';base64,' . $viewIngreso[0]["imagenVehiculo3"];
                }else{
                    $base3=$viewIngreso[0]["rutaImagen3"];
                }
                ?>
                <img style="width:100%;" src="<?php echo $base3?>">
                <input style="width: 100%" class="form-control form-control-sm"
                       name="imagenObs3"
                       id="imagenObs3" type="file"/>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <button class="btn btn-outline-primary btn-sm" type="submit" id="btnProceObs">ACTUALIZAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
<?php }else{?>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <h5 class="text-primary">Ver Observaciones en Vehiculo</h5>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-6">
            <label class="spanLabel">Tipo Daño</label>
            <div class="form-floating">
                 <?php echo $viewIngreso[0]["tipoDanho"]?>
            </div>
        </div>
        <div class="col-6">
            <label class="spanLabel">Nivel Daño</label>
            <div class="form-floating">
                <?php echo $viewIngreso[0]["nivelDanho"]?>
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-6">
            <label class="spanLabel">Area Daño</label>
            <div class="form-floating">
                <?php echo $viewIngreso[0]["areaDanho"]?>
            </div>
        </div>
        <div class="col-6">
            <label class="spanLabel">Sub Area Daño</label>
            <div class="form-floating">
                <?php echo $viewIngreso[0]["subAreaDanho"]?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-6">
            <label class="spanLabel">Reparacion</label>
            <div class="form-floating">
                <?php echo $viewIngreso[0]["reparacion"]?>
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <label class="spanLabel">Detalle Repuesto</label><br>
            <?php echo $viewIngreso[0]["detalleRepuesto"]?>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-6">
            <label class="spanLabel" style="font-size: 12px">Registro en Guia</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" disabled id="inlineRadio1" <?php echo ($viewIngreso[0]["registroGuia"]==1)?'checked':''?> type="radio"
                       value="1"/>
                <label class="form-check-label" for="inlineRadio1">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" disabled id="inlineRadio2" <?php echo ($viewIngreso[0]["registroGuia"]==2)?'checked':''?> type="radio"
                       value="2"/>
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom:6px">
        <div class="col-12">
            <label class="spanLabel">Solucion</label><br>
            <?php echo $viewIngreso[0]["solucionObservacion"]?>
        </div>
    </div>
    <div class="row" style="padding-bottom:6px">
        <div class="col-12">
            <label class="spanLabel">Comentarios</label><br>
            <?php echo $viewIngreso[0]["comentarios"]?>
        </div>
    </div>
    <hr>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <label class="spanLabel">Cargar Imagenes</label>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <?php
            $base64 = 'data:image/' . $viewIngreso[0]["tipoImagen1"] . ';base64,' . $viewIngreso[0]["imagenVehiculo1"]; ?>
            <img style="width:100%;" src="<?php echo $base64?>">
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <?php
            $base64 = 'data:image/' . $viewIngreso[0]["tipoImagen2"] . ';base64,' . $viewIngreso[0]["imagenVehiculo2"]; ?>
            <?php if($viewIngreso[0]["tipoImagen2"]!=''){?>
                <img style="width:100%;" src="<?php echo $base64?>">
            <?php }?>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <?php
            $base64 = 'data:image/' . $viewIngreso[0]["tipoImagen3"] . ';base64,' . $viewIngreso[0]["imagenVehiculo3"]; ?>
            <?php if($viewIngreso[0]["imagenVehiculo3"]!=''){?>
            <img style="width:100%;" src="<?php echo $base64?>">
            <?php }?>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
        </div>
    </div>
<?php }?>
