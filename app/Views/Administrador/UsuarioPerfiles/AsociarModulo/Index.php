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

    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
</style>
<div class="modal-body">
    <form action="<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/SaveGrupoModulo") ?>" method="POST"
          id="formSaveGMD">
        <?php if($parentGrupo!=1){?>
                <input hidden name="idgrupoModulo" value="<?php echo $idgrupoModulo?>">
                <input hidden name="idtipoGrupoModulo" value="2">
                <input hidden name="idmodulo" value="-1">
                <input hidden name="idusuario" value="<?php echo $idusuario?>">
        <div class="row">
            <div class="col-12">
                <h5>Asociar Grupo Modulo : <?php echo $grupoModulo[0]["descripcion"]?></h5>
            </div>
        </div><hr>
            <div class="row">
                <div class="col-12">
                    <span style="font-size: 12px">El grupo de modulos no tiene modulos asociados y se considera grupo de modulo unico, para validar los permisos de click en asociar</span>
                </div>
            </div>
        <?php }else{?>
            <input hidden name="idgrupoModulo" value="<?php echo $idgrupoModulo?>">
            <input hidden name="idtipoGrupoModulo" value="2">
            <input hidden name="idusuario" value="<?php echo $idusuario?>">
            <div class="row">
                <div class="col-12">
                    <h5>Asociar Modulos del Grupo : <?php echo $grupoModulo[0]["descripcion"]?></h5>
                </div>
            </div><hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-floating">
                        <select class="form-select" name="idmodulo" required id="floatingSelect" aria-label="Floating label select example">
                            <option value="" selected>Seleccione Modulo...</option>
                            <?php foreach($modulo as $md){?>
                                <option value="<?php echo $md["idmodulo"]?>"><?php echo $md["descripcion"]?></option>
                            <?php }?>
                        </select>
                        <label for="floatingSelect">Modulo Aisgnado</label>
                    </div>
                </div>
            </div>
        <?php }?>
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="checkModuloIn" name="checkModuloIn" value="1" type="checkbox" />
                    <label class="form-check-label" for="checkModuloIn">Marcar como Modulo Inicial (Actualiza el modulo inicial del usuario)</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnProcess" type="submit">Asociar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
</div>