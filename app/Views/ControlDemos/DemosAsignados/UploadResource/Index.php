<div class="modal-body">
    <form method="POST" id="formUploadResource" action="<?php echo base_url("ControlDemos/DemosAsignados/SaveEditDelete/UploadResource")?>">
        <input hidden name="idcheckListRetornoRetor" id="idcheckListRetornoImg" value="<?php echo $idcheckListRetorno ?>">
        <input hidden name="idasignarDemoRetor" id="idasignarDemoRetorImg" value="<?php echo $idasignarDemo?>">
        <div class="row">
            <div class="col-12">
                <h5>Cargar Imagen</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <input accept="image/png,image/jpeg,image/jpg" type="file" class="form-control form-control-sm" name="resourceImagen">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm">Subir Imagen</button>
                <button class="btn btn-default btn-sm" type="button" id="btnCloseModalUpload">Cerrar</button>
            </div>
        </div>
    </form>
</div>