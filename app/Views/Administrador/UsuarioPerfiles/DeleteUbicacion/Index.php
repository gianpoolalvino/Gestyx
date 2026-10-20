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
    <form action="<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/DeleteUbicacion") ?>" method="POST"
          id="formDeleteUbi">
        <div class="row">
            <div class="col-12 text-center">
                <i class="far fa-sad-tear fa-3x"></i>
                <h6>¿Desea eliminar la ubicacion del Usuario?</h6>
                <input hidden name="idusuarioGrupoUbicacion" value="<?php echo $idusuarioGrupoUbicacion?>">
                <span style="font-size: 14px">Se eliminara la ubicacion de accesos para el usuarios</span><hr>
                <button class="btn btn-primary btn-sm" id="btnDeleteAsc" type="submit">Eliminar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
</div>