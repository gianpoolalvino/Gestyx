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
    <form action="<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/LogOutSession") ?>" method="POST"
          id="formSaveRemot">
        <div class="row">
            <div class="col-12" style="text-align: center">
                <i class="far fa-wifi-slash fa-3x"></i>
                <h5>Cerrar Sesion Remota</h5>
                Realmente desea cerrar la sesion remota, esto afectara la sesion del usuario y lo retirara del sistema<hr>
                <button class="btn btn-primary btn-sm" type="submit" id="btnProceSe">Procesar</button>
                <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <input hidden name="idusuario" value="<?php echo $idusuario?>">
    </form>
</div>