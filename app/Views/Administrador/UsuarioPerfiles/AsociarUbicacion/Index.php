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
    <form action="<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/SaveUbicacion") ?>" method="POST"
          id="formSaveUbi">
        <div class="row">
            <div class="col-12">
                <h5>Asociar Ubicacion</h5><br>
            </div>
        </div>
        <input hidden name="idusuario" value="<?php echo $idusuario?>">
        <input hidden name="idempresa" value="<?php echo $idempresa?>">
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" name="idgrupoUbicacion" required id="floatingSelect" aria-label="Floating label select example">
                        <option value="" selected>Seleccione Ubicacion...</option>
                        <?php foreach($grupoUbicacion as $ag){?>
                            <option value="<?php echo $ag["idgrupoUbicacion"]?>"><?php echo $ag["descripcion"]?></option>
                            <option value="-1">Todas los grupos de ubicacion no asociados</option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Ubicacion Aisgnada</label>
                </div>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnProcess" type="submit">Asociar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
</div>