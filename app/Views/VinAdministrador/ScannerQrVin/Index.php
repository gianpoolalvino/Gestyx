<style>
    .rowf {
        margin-bottom: 4px !important;
    }

    .titleLabel {
        font-size: 12px;
    }

    .spanlabel {
        padding-left: 0px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Ingreso Vehicular</h5><br>
        </div>
    </div>
    <form enctype="multipart/form-data" action="<?php echo base_url('VinAdministrador/ValidarQrVin'); ?>" method="POST" id="formQrVin">
        <div class="row pb-4">
            <div class="col-12" style="text-align: center">
                <video id="preview" style="width: 100%"></video>
            </div>
        </div>
        <hr>
        <div class="row pb-4">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select form-control-sm" id="camerasSelect">
                        <option value="">Seleccione una cámara</option>
                    </select>
                    <label for="floatingSelect">Seleccione Camaras</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>