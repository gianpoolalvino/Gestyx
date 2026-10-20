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
            <h6>Crear Ubicacion</h6>
        </div>
    </div>
    <form id="formSaveUbicacion" method="POST" action="<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/SaveUbicacion")?>">
        <div class="row pb-2">
            <div class="col-5">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="nombreUbicacion">
                    <label for="floatingSelect">Nombre Ubicacion</label>
                </div>
            </div>
            <div class="col-7">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="grupoUbicacion">
                        <?php foreach($grupoUbicacion as $grp){?>
                            <?php if($grp["idgrupoUbicacion"]==$idgrupoUbicacion){?>
                                <option selected value="<?php echo $grp["idgrupoUbicacion"]?>"><?php echo $grp["grupoUbicacion"]?></option>
                            <?php }else{?>
                                <option value="<?php echo $grp["idgrupoUbicacion"]?>"><?php echo $grp["grupoUbicacion"]?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Grupo Ubicacion</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-check">
                        <input class="form-check-input" id="flexCheckDefault" name="autoRecepcion" type="checkbox" value="1" />
                        <label class="form-check-label" for="flexCheckDefault">Recepcionar Vehiculo automaticamente</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" id="flexCheckDefault2" name="visible" type="checkbox" value="1" />
                    <label class="form-check-label" for="flexCheckDefault2">Mostrar para Traslados</label>
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