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
            <h6>Gestionar Ubicaciones y Box</h6>
        </div>
    </div>
    <form id="formUpdateUbicacion" method="POST" action="<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/UpdateUbicacion")?>">
    <input hidden name="idubicacion" value="<?php echo $ubicacion[0]["idubicacion"]?>">
        <div class="row pb-2">
        <div class="col-5">
            <div class="form-floating">
                <input class="form-control form-control-sm" value="<?php echo $ubicacion[0]["descripcion"]?>" name="nombreUbicacion">
                <label for="floatingSelect">Nombre Ubicacion</label>
            </div>
        </div>
        <div class="col-7">
            <div class="form-floating">
                <select class="form-control form-control-sm" name="grupoUbicacion">
                    <?php foreach($grupoUbicacion as $grp){?>
                        <?php if($grp["idgrupoUbicacion"]==$ubicacion[0]["idgrupoUbicacion"]){?>
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
                <?php if($ubicacion[0]["autoRecepcion"]==1){?>
                    <input class="form-check-input" id="flexCheckDefault" name="autoRecepcion" checked  type="checkbox" value="1" />
                    <label class="form-check-label" for="flexCheckDefault">Recepcionar Vehiculo automaticamente</label>
                <?php }else{?>
                    <input class="form-check-input" id="flexCheckDefault" name="autoRecepcion" type="checkbox" value="1" />
                    <label class="form-check-label" for="flexCheckDefault">Recepcionar Vehiculo automaticamente</label>
                <?php }?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-check">
                <?php if($ubicacion[0]["visible"]==1){?>
                    <input class="form-check-input" id="flexCheckDefault2" name="visible" checked  type="checkbox" value="1" />
                    <label class="form-check-label" for="flexCheckDefault2">Mostrar para Traslados</label>
                <?php }else{?>
                    <input class="form-check-input" id="flexCheckDefault2" name="visible" type="checkbox" value="1" />
                    <label class="form-check-label" for="flexCheckDefault2">Mostrar para Traslados</label>
                <?php }?>
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