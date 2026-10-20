<?php
if(!empty($equipamientoIngreso)){?>
    <div class="row">
        <?php foreach ($equipamientoIngreso as $form) { ?>
            <div class="col-<?php echo $form["col"] ?>" style="padding-bottom: 8px">
                <label class="spanlabel" style="font-size: 12px"><?php echo $form["descripcion"] ?> (*)</label><br>
                <?php if ($form["tipoCampo"] == 'radiobutton') { ?>
                    <?php echo ($form["resultado"]==1)?'Si':'No'?>
                <?php }else{?>
                    <?php echo $form["resultado"];?>
                <?php }?>
            </div>
        <?php }?>
    </div>
    <div class="row" style="padding-bottom: 8px">
        <div class="col-12">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
        </div>
    </div>
<?php } else{?>
<form id="formEquipamientosVin"  method="POST" action="<?php echo base_url("IngresoVin/SaveEditDelete/SaveEquipamiento")?>">
    <input hidden name="idingresoCheckForm" value="<?php echo $idingresoVin?>">
    <input hidden name="viningresoCheckForm" value="<?php echo $vin?>">
    <div class="row">
        <?php foreach ($formularioEquipamiento as $form) { ?>
            <input hidden required name="campoCheck[]" value="<?php echo $form["idcheckIngresoVin"]?>">
            <div class="col-<?php echo $form["col"] ?>" style="padding-bottom: 8px">
                <label class="spanlabel" style="font-size: 12px"><?php echo $form["descripcion"] ?> (*)</label><br>
                <?php if ($form["tipoCampo"] == 'select') { ?>
                    <select class="form-control form-control-sm" required name="options<?php echo $form["idcheckIngresoVin"] ?>">
                        <option value="">Seleccione Opcion...</option>
                        <?php
                        $frm=explode('##',$form["opciones"]);
                        foreach($frm as $fm){?>
                            <option value="<?php echo $fm?>"><?php echo $fm?></option>
                        <?php }?>
                    </select>
                <?php } else if ($form["tipoCampo"] == 'radiobutton') { ?>
                    <input type="radio" class="btn-check" required name="options<?php echo $form["idcheckIngresoVin"] ?>"
                           id="option<?php echo $form["idcheckIngresoVin"] ?>1" value="1" autocomplete="off">
                    <label class="btn btn-outline-secondary"
                           for="option<?php echo $form["idcheckIngresoVin"] ?>1">Si</label>

                    <input type="radio" class="btn-check" required name="options<?php echo $form["idcheckIngresoVin"] ?>"
                           id="option<?php echo $form["idcheckIngresoVin"] ?>2" value="2" autocomplete="off">
                    <label class="btn btn-outline-secondary"
                           for="option<?php echo $form["idcheckIngresoVin"] ?>2">No</label>
                <?php } else if ($form["tipoCampo"] == "textarea") { ?>
                    <textarea class="form-control form-control-sm" name="options<?php echo $form["idcheckIngresoVin"] ?>" style="height: 80px"></textarea>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="row" style="padding-bottom: 8px">
        <div class="col-12">
            <button class="btn btn-primary btn-sm" type="submit" id="btnProcesar">PROCESAR</button>
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CANCELAR</button>
        </div>
    </div>
</form>
<?php }?>