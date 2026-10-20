<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }
</style>
<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formSaveEquipa"
          action="<?php echo base_url("AlistamientoVehicular/ControlCalidad/SaveEditDelete/UpdateEquipamientoCalidad") ?>">
        <input hidden name="idequipamientoCalidad" id="idequipamientoCalidad" value="<?php echo $idequipamientoCalidad?>">
        <input hidden name="vinEq" id="vinEq" value="<?php echo $vin?>">
        <div class="row">
            <div class="col-12">
                Validar Instalacion de <?php echo $equipamientoCalidad[0]["equipamiento"] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <label class="form-label spanlabel" for="estatus">Estado</label>
                <select class="form-control form-control-sm" id="estatus" required name="estadoCalidad">
                    <option value="">Seleccione un Estado</option>
                    <?php if($equipamientoCalidad[0]["estadoEquipamientoCalidad"]==3){?>
                        <option value="4">CONFORME</option>
                        <option value="5">REVISAR / OBSERVACIONES</option>
                        <option value="6">PENDIENTE INSTALACION</option>
                    <?php }else{?>
                        <option value="1">CORREGIDO</option>
                        <option value="2">ENTREGAR CON OBSERVACIONES</option>
                        <option value="6">PENDIENTE INSTALACION</option>
                    <?php }?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label spanlabel" for="fechaRevision">Fecha</label>
                <input class="form-control form-control-sm" id="fechaRevision" name="fechaRevision" required value="<?php echo $hoy?>" type="date">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="comentario">Observaciones</label>
                <textarea class="form-control form-control-sm" name="comentEquipamiento" id="comentarioEquipamiento" style="height:80px"></textarea>
            </div>
        </div><br>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceEquipamiento">Subir Imagen</label>
                <input class="form-control form-control-sm" accept="image/png,image/jpeg,image/jpg" type="file" name="resourceEquipamiento" id="resourceEquipamiento"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-danger btn-sm" id="btnCloseAdicional" type="button">Cancelar</button>
            </div>
        </div>
    </form>
</div>