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
    <form method="POST" id="formSaveCheckPdi"
          action="<?php echo base_url("AlistamientoVehicular/Pdi/SaveEditDelete/StorageCheckPdi") ?>">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="text-primary">Validar Item de PDI</h5>
            </div>
        </div>
        <input hidden id="grupoCheckIdPdi" name="idgrupoCheckListFormularioPdi" value="<?php echo $idgrupoCheckListFormularioPdi?>">
        <input hidden name="idresultadoCheckListPdi" value="<?php echo $idresultadoFormularioPdi?>">
        <input hidden id="procesoPdi" name="procesoPdi" value="<?php echo $idprocesoPdi?>">
        <input hidden name="vinPdi" id="vinPdi" value="<?php echo $vin?>">
        <div class="row pb-2">
            <div class="col-8">
                <div class="form-floating">
                    <select class="form-control form-control-sm" id="estadoCheckPdi" required name="estadoCheckPdi">
                        <option value="2">NO CONFORME</option>
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
                    <textarea class="form-control form-control-sm" required name="comentariocheckPdi" id="comentariocheckPdi" style="height:80px"></textarea>
                    <label class="form-label">Observaciones</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
</div>
