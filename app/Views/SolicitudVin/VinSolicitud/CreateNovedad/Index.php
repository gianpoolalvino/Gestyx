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

    .bodyCotizacion {
        overflow: auto;
        height: 100%;
        white-space: nowrap;
    }

    .bodyCotizacion thead th {
        position: sticky;
        color: white;
        background: #505050;
        top: 0;
        z-index: 1;
    }

    .bodyCotizacion {
        height: 400px;
        width: 100%;
        overflow: auto;
    }

</style>
<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formSaveNovedad" method="POST"
          action="<?php echo base_url("SolicitudVin/VinSolicitud/SaveEditDelete/StorageNovedad") ?>">
        <div class="row pb-2">
            <div class="col-12"><h5>Registrar Novedad</h5></div>
        </div>
        <input hidden name="vin" value="<?php echo $vin?>">
        <input hidden name="idsolicitudVin" value="<?php echo $idsolicitudVin?>">
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm" name="descripcion" required>
                    <label for="floatingSelect">Descripcion</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <textarea type="text" class="form-control form-control-sm" style="height: 140px" name="comentarios"
                              required></textarea>
                    <label for="floatingSelect">Comentarios</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceDetalleNovedad">Subir Imagen</label>
                <input class="form-control form-control-sm" name="resourceDetalleNovedad" id="resourceDetalleNovedad"
                       type="file"/>
            </div>
        </div>
        <hr>
        <div class="row pb-2">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm">PROCESAR</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">CERRAR</button>
            </div>
        </div>
    </form>
</div>