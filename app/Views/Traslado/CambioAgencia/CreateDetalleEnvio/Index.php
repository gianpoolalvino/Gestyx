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
</style>
<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formSaveDetalleTrasladoSend" enctype="multipart/form-data"
          action="<?php echo base_url("Traslado/CambioAgencia/SaveEditDelete/SaveObservacionEnvio") ?>">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="text-primary">Agregar Observacion Envio</h5>
            </div>
        </div>
        <input hidden name="tokenSendEnvio" id="tokenSendEnvio" value="<?php echo $tokenSend?>">
        <input hidden name="vinTraslado" id="vinTraslado" value="<?php echo $vin?>">
        <div class="row pb-2">
            <div class="col-8">
                <div class="form-floating">
                    <input class="form-control" id="tituloObservacion" name="tituloObservacion" type="text">
                    <label for="floatingInput">Descripcion</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="fechaRevision" required value="<?php echo $hoy?>" max="<?php echo $hoy?>" id="fechaRevision" type="date">
                    <label class="form-label">Fecha</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm" name="comentarioDetalleTraslado" id="comentarioDetalleTraslado" style="height:80px"></textarea>
                    <label class="form-label">Observaciones</label>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceDetalleTraslado">Subir Imagen</label>
                <input class="form-control form-control-sm"
                       name="resourceDetalleTraslado"
                       id="resourceDetalleTraslado"
                       type="file"
                       accept="image/*"
                       capture="camera" />
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
</div>
