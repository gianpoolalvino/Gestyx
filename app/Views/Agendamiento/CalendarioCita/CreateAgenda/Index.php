<div class="modal-body">
    <form id="formSave" method="POST" action="<?php echo base_url("Agendamiento/CalendarioCita/SaveEditDelete/SaveAgenda")?>">
    <div class="row">
        <div class="col-12">
            <h6 class="text-primary">AGENDAMIENTO DE VIN (<?php echo $usuario[0]["nombres"]." ".$usuario[0]["primerApellido"]." ".$usuario[0]["segundoApellido"]?>)</h6>
        </div>
    </div>
    <input hidden id="fechaAgenda" name="fechaAgenda" value="<?php echo $fecha?>">
    <input hidden id="horaAgenda" value="<?php echo $hora?>">
    <input hidden id="idasesorAgenda" name="idasesorAgenda" value="<?php echo $idasesor?>">
    <div class="row">
        <div class="col-12">
            <label>Vins</label>
            <select class="form-control form-control-sm" data-live-search="true" id="vinCalidad">
                <option value="">Seleccione Vin</option>
                <?php foreach($vin as $vn){?>
                        <?php if($requisitoCartera[0]["requeridoAgendamiento"]==1){?>
                            <option data-icon="<?php echo ($vn["liberado"]=='2')?'fas fa-lock-alt':''?>" value="<?php echo ($vn["liberado"]=='1')?$vn["vin"]:''?>"><?php echo $vn["vin"]." (".$vn["nombreCliente"].")"?></option>
                        <?php }else{?>
                            <option value="<?php echo $vn["vin"]?>"><?php echo $vn["vin"]." (".$vn["nombreCliente"].")"?></option>
                        <?php }?>
                <?php }?>
            </select>
        </div>
    </div><hr>
    <div id="panelVinPlaca">

    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-sm">Procesar</button>
            <button class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" type="button">Cancelar</button>
        </div>
    </div>
    </form>
</div>