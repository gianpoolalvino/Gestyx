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
    <form id="formUploadImage" enctype="multipart/form-data" method="POST" action="<?php echo base_url("IngresoVin/SaveEditDelete/UploadImagenVehiculo")?>">
    <div class="row">
        <div class="col-12">
            <h5>Carga de Imagen</h5>
        </div>
    </div>
    <input hidden name="iddetalleIngresoVehiculoImagen" value="<?php echo $iddetalleIngresoVehiculoImagen?>">
    <input hidden name="vin" value="<?php echo $vin?>">
    <div class="row" style="padding-bottom: 4px">
        <div class="col-12">
            <input style="width: 100%" class="form-control form-control-sm"
                   name="imagenUploadVehiculo"
                   required
                   id="imagenUploadVehiculo" type="file"/>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label class="spanlabel" style="font-size: 12px">Comentarios y/u Observaciones (*)</label>
            <textarea class="form-control form-control-sm" style="height: 160px" name="comentarioUpload"></textarea>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-sm" type="submit" id="btnUploadImagenPr">PROCESAR</button>
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CANCELAR</button>
        </div>
    </div>
    </form>
</div>