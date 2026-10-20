<?php
$rutaForm=base_url("IngresoVin/SaveEditDelete/SaveDuaf");
if(empty($panelDuaf)){?>
    <form enctype="multipart/form-data" id="formDuaf" action="<?php echo $rutaForm?>" method="POST">
        <input hidden id="vinDuaf" name="vinDuaf" value="<?php echo $vin?>">
        <input hidden id="idIngresoDuaf" name="idIngresoDuaf" value="<?php echo $idingresoVin?>">
    <div class="row pb-2">
        <div class="col-12">
            <label class="form-label" for="customFile">Agregar DUAF</label>
            <div class="input-group">
                <input class="form-control" id="customFile" name="resourceDuaf" type="file" />
                <div class="input-group-prepend">
                    <button class="btn btn-outline-info btn-sm" type="submit"><i class="fas fa-upload"></i>&nbsp;Cargar DUAF</button>
                </div>
            </div>
        </div>
    </div>
    </form>
<?php }else{ ?>
    <div class="row pb-2">
        <div class="col-12 text-center">
            <a download href="<?php echo $panelDuaf[0]["rutaArchivo"]?>" class="btn btn-dark btn-sm">Descargar DUAF</a>
        </div>
    </div>
<form enctype="multipart/form-data" id="formDuaf" action="<?php echo $rutaForm?>" method="POST">
    <input hidden id="vinDuaf" name="vinDuaf" value="<?php echo $vin?>">
    <input hidden id="idIngresoDuaf" name="idIngresoDuaf" value="<?php echo $idingresoVin?>">
    <div class="row pb-2">
        <div class="col-12">
            <label class="form-label" for="customFile">Agregar DUAF</label>
            <div class="input-group">
                <input class="form-control" id="customFile" name="resourceDuaf" type="file" />
                <div class="input-group-prepend">
                    <button class="btn btn-outline-info btn-sm" type="submit"><i class="fas fa-upload"></i>&nbsp;Cargar DUAF</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?><hr>
<div class="row">
    <div class="col-12">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>
