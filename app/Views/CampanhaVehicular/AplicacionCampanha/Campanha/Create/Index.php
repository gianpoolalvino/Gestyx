<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5 class="text-primary">Crear Campaña</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("CampanhaVehicular/AplicacionCampanha/SaveEditDelete/SaveCampanha") ?>"
                  id="formSave" method="POST">
                <div class="input-group  mb-1" style="padding-bottom: 4px">
                    <div class="input-group-prepend">
                        <div class="form-floating" style="margin-bottom: 0px">
                            <input class="form-control form-control-sm" name="codigoCampanha">
                            <label for="floatingSelect">Codigo</label>
                        </div>
                    </div>
                    <div class="form-floating" style="margin-bottom: 0px">
                        <input class="form-control form-control-sm" name="nombreCampanha">
                        <label for="floatingSelect">Nombre</label>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-12">
                        <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
