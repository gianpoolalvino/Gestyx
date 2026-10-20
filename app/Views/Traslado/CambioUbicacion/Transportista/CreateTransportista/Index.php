<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5 class="text-primary">Crear Transportista</h5>
        </div>
    </div>
    <form id="frmSaveTrans" method="POST" action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveTransportista")?>">
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm" autocomplete="off" name="documento">
                <label for="floatingSelect">Documento</label>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm" autocomplete="off" name="razonSocial">
                <label for="floatingSelect">Razon Social</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-floating">
                <textarea type="text" class="form-control form-control-sm" autocomplete="off" style="height: 80px" name="comentarios"></textarea>
                <label for="floatingSelect">Datos Adicionales</label>
            </div>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm" id="btnSaveTrans">Guardar</button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </div>
    </form>
</div>