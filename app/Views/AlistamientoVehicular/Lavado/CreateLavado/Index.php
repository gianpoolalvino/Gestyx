<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formLavadoDet"
          enctype="multipart/form-data"
          action="<?php echo base_url("AlistamientoVehicular/Lavado/SaveEditDelete/SaveLavadoDet") ?>" method="POST">
        <input hidden name="vinLavado" id="vinLavado" value="<?php echo $vin?>">
        <input hidden name="iddetalleLavado" value="<?php echo $iddetalleLavado?>">
        <div class="row pb-2">
            <div class="col-12">
                <h5>Proceso Vehicular - <?php echo $tipoLavado ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="input-group" style="padding-bottom: 4px">
                    <div class="form-floating">
                        <select class="form-control form-control-sm selectEquiVin" required
                                name="estadoLavado"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value="2">Realizado</option>
                        </select>
                        <label for="floatingSelect">Estado de Lavado</label>
                    </div>
                    <div class="input-group-append">
                        <div class="form-floating mb-3">
                            <input class="form-control" required name="fechaLavado" type="date"
                                   value="<?php echo $hoy ?>"
                                   max="<?php echo $hoy ?>"/>
                            <label for="floatingInput">Fecha Lavado.</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="input-group-append">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" style="height: 120px" name="comentarioLavado"></textarea>
                        <label for="floatingInput">Observaciones o Comentarios</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceUploadImg">Subir Imagen</label>
                <input class="form-control form-control-sm" name="resourceUploadImg" id="resourceUploadImg" type="file"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button type="submit" id="btnProcesarTipoLavado" class="btn btn-primary btn-sm">PROCESAR</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </form>
</div>