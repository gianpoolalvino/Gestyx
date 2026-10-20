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
    <form action="<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/SavePassword") ?>" method="POST"
          id="formChagePass">
        <div class="row">
            <div class="col-12">
                <h5>Contraseña de Usuario
                    : <?php echo $viewUser[0]["nombres"] . " " . $viewUser[0]["primerApellido"] . " " . $viewUser[0]["segundoApellido"] ?></h5>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="mb-3 text-start"><label class="form-label" for="password">Insertar Contraseña</label>
                    <div class="form-icon-container"><input class="form-control form-icon-input inputLogin"
                                                            autocomplete="off" name="passUser" id="passUser"
                                                            type="password" placeholder="Password"/><span
                                class="fas fa-key text-body fs-9 form-icon"></span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="mb-3 text-start"><label class="form-label" for="password">Repetir Contraseña</label>
                    <div class="form-icon-container"><input class="form-control form-icon-input inputLogin"
                                                            autocomplete="off" name="rePassUser" id="rePassUser"
                                                            type="password" placeholder="Password"/><span
                                class="fas fa-key text-body fs-9 form-icon"></span></div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm">Actuaslizar Contraseña</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>