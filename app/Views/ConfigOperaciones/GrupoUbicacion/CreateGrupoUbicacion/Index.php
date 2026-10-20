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
            <h6>Crear Grupo Ubicacion</h6>
        </div>
    </div>
    <form id="formSaveGrupoUbicacion" method="POST" action="<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/SaveGrupoUbicacion")?>">
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="nombreGrupo">
                    <label for="floatingSelect">Nombre Grupo Ubicacion</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="empresa" id="empresa">
                        <?php foreach($empresa as $emp){?>
                            <option value="<?php echo $emp["idempresa"]?>"><?php echo $emp["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Empresa</label>
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