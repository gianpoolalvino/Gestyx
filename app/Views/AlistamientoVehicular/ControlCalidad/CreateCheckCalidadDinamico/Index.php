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
    <form method="POST" id="formSaveCheckCalidadDina"
          action="<?php echo base_url("AlistamientoVehicular/ControlCalidad/SaveEditDelete/StorageCheckCalidadDinamico") ?>">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="text-primary">Agregar Item de Calidad</h5>
            </div>
        </div>
        <input hidden id="grupoCheckId" name="idgrupoCheckId" value="<?php echo $idgrupoCheckCalidad?>">
        <input hidden name="procesoCalidad" value="<?php echo $idprocesoCalidad?>">
        <input hidden name="vinEq" id="vinEq" value="<?php echo $vin?>">
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control" id="tituloCheck" name="tituloCheck" type="text">
                    <label for="floatingInput">Descripcion</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-8">
                <div class="form-floating">
                <select class="form-control form-control-sm" id="estatus" required name="estadoCalidad">
                    <option value="">Seleccione un Estado</option>
                        <option value="4">CONFORME</option>
                        <option value="5">REVISAR / OBSERVACIONES</option>
                </select>
                    <label class="form-label">Estado</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="fechaRevision" required value="<?php echo $hoy?>" max="<?php echo $hoy?>" id="fechaRevision" type="date">
                    <label class="form-label">Fecha</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm" name="comentariocheckCalidad" id="comentariocheckCalidad" style="height:80px"></textarea>
                <label class="form-label">Observaciones</label>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceCheckCalidad">Subir Imagen</label>
                <input class="form-control form-control-sm"  name="resourceCheckCalidad" id="resourceCheckCalidad" type="file"/>
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
