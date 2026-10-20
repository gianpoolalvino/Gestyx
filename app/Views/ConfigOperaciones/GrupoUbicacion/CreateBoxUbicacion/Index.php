<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .tableFixHeadV2 {
        overflow: auto;
        height: 340px;
        white-space: nowrap;
    }

    .tableFixHeadV2 thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background:#141824;
        color:white
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h6>Crear Box</h6>
        </div>
    </div>
    <form id="formSaveBox" method="POST" action="<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/SaveBoxUbicacion")?>">
        <div class="row pb-2">
            <div class="col-5">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="nombreBox">
                    <label for="floatingSelect">Nombre Ubicacion</label>
                </div>
            </div>
            <div class="col-7">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="tipobox">
                        <option selected value="1">Unico</option>
                        <option value="2">Multiple</option>
                    </select>
                    <label for="floatingSelect">Tipo Box</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="ubicacionBox" id="ubicacionBox">
                        <?php foreach($ubicacion as $ubi){?>
                            <option value="<?php echo $ubi["idubicacion"]?>"><?php echo $ubi["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Ubicacion</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-outline-primary btn-sm">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>