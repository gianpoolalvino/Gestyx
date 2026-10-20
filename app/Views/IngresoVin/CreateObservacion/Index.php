
<div class="row" style="padding-bottom: 6px">
    <div class="col-12">
        <h5 class="text-primary">Crear Observaciones en Vehiculo</h5>
    </div>
</div>
<form id="formCreateObs" method="POST" enctype="multipart/form-data" action="<?php echo base_url("IngresoVin/SaveEditDelete/SaveObservacion") ?>">
    <input hidden name="idingresoVinObs" value="<?php echo $idingresoVehiculo?>">
    <input hidden name="vinObs" value="<?php echo $vin?>">
    <div class="row" style="padding-bottom: 6px">
        <div class="col-6">
            <div class="form-floating">
                <select class="form-select form-select-sm" required name="tipoDanho" id="selectTipoDanho">
                    <option value="">Seleccione Tipo Daño...</option>
                    <?php foreach($selectTipoDanho as $sta){?>
                        <option value="<?php echo $sta["idtipoDanhoVin"]?>"><?php echo $sta["descripcion"]?></option>
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
                        <option value="<?php echo $sdna["idseveridadDanhoVin"]?>"><?php echo $sdna["descripcion"]?></option>
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
                        <option value="<?php echo $saad["idareaDanhoVin"]?>"><?php echo $saad["descripcion"]?></option>
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
                        <option value="<?php echo $sabd["idsubAreaDanhoVin"]?>"><?php echo $sabd["descripcion"]?></option>
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
                        <option value="<?php echo $reps["idreparacionVin"]?>"><?php echo $reps["descripcion"]?></option>
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
                          style="height: 120px"></textarea>
                <label for="selectAreaDanho">Detalle Repuesto</label>
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-6">
            <label class="spanLabel" style="font-size: 12px">Registro en Guia</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" id="inlineRadio1" type="radio" name="registroGuia"
                       value="1"/>
                <label class="form-check-label" for="inlineRadio1">Si</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" id="inlineRadio2" type="radio" name="registroGuia"
                       value="2"/>
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-floating">
                <input class="form-control form-control-sm" name="solucion">
                <label for="selectAreaDanho">Solucion</label>
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <div class="form-floating">
                <textarea class="form-control form-control-sm" id="comentarioObs" name="comentarioObs"
                          style="height: 120px"></textarea>
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
            <input style="width: 100%" class="form-control form-control-sm"
                   name="imagenObs1"
                   required
                   id="imagenObs1" type="file"/>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <input style="width: 100%" class="form-control form-control-sm"
                   name="imagenObs2"
                   id="imagenObs2" type="file"/>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <input style="width: 100%" class="form-control form-control-sm"
                   name="imagenObs3"
                   id="imagenObs3" type="file"/>
        </div>
    </div>
    <div class="row" style="padding-bottom: 6px">
        <div class="col-12">
            <button class="btn btn-outline-primary btn-sm" type="submit" id="btnProceObs">GUARDAR</button>
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
        </div>
    </div>
</form>
