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
            <h6>Editar Box - <?php echo $boxUbicacion[0]["box"]?></h6>
        </div>
    </div>
    <form id="formUpdateBox" method="POST" action="<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/UpdateBoxUbicacion")?>">
        <input hidden name="idboxUbicacion" value="<?php echo $boxUbicacion[0]["idboxUbicacion"]?>">
        <input hidden id="idubicacionBox" value="<?php echo $boxUbicacion[0]["idubicacion"]?>">
        <div class="row pb-2">
            <div class="col-5">
                <div class="form-floating">
                    <input class="form-control form-control-sm" value="<?php echo $boxUbicacion[0]["box"]?>" name="nombreBox">
                    <label for="floatingSelect">Nombre Ubicacion</label>
                </div>
            </div>
            <div class="col-7">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="tipobox">
                        <option <?php echo ($boxUbicacion[0]["tipoBox"]==1)?'selected':''?> value="1">Unico</option>
                        <option <?php echo ($boxUbicacion[0]["tipoBox"]==2)?'selected':''?> value="2">Multiple</option>
                    </select>
                    <label for="floatingSelect">Tipo Box</label>
                </div>
            </div>
        </div>
        <strong style="font-size:12px">*Nota: </strong><span style="font-size:12px">El cambio de nombre en los box no afecta la estabilidad del sistema</span>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-outline-primary btn-sm">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>