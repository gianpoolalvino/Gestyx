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
    <div class="row pb-2">
        <div class="col-6">
            <h5>Tomar Foto Directa</h5>
        </div>
    </div>
    <form enctype="multipart/form-data" action="<?php echo base_url('AlistamientoVehicular/Pdi/SaveEditDelete/UploadImagenPdi'); ?>" method="POST" id="formCameraPdi">
        <input hidden id="grupoCheckIdPdi" name="idgrupoCheckListFormularioPdi" value="<?php echo $idgrupoCheckListFormularioPdi?>">
        <input hidden name="idresultadoCheckListPdi" value="<?php echo $idresultadoFormularioPdi?>">
        <input hidden id="procesoPdi" name="procesoPdi" value="<?php echo $idprocesoPdi?>">
        <input hidden name="vinPdi" id="vinPdi" value="<?php echo $vin?>">
        <?php
        $camera="";
        $image="";
        if(empty($viewResultadoPdi[0]["rutaImagen"])){
            $camera="block";
            $image="none";
        }else{
            $camera="none";
            $image="block";
        }
        ?>
        <div id="panelManual">
            <div id="capturePanel" style="display: <?php echo $camera?>">
                <div class="row pb-2">
                    <div class="col-12" style="text-align: center">
                        <video id="preview" style="width: 100%"></video>
                    </div>
                </div>
                <hr>
                <div class="row pb-2">
                    <div class="col-12">
                        <div class="input-group">
                            <div class="form-floating">
                                <select class="form-select form-control-sm"  id="camerasSelect">
                                    <option value="">Seleccione una cámara</option>
                                </select>
                                <label for="floatingSelect">Seleccione Camaras</label>
                            </div>
                            <div class="input-prepend">
                                <button class="btn btn-outline-dark btn-sm" id="btnCapture" type="button" style="height: 100%"><i class="fas fa-camera"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="previewPanelCapture" style="display:<?php echo $image?>">
                <canvas id="snapshot" style="display: none"></canvas>
                <input type="hidden" name="capturedImage" id="capturedImage">
                <div class="row pb-2">
                    <div class="col-12 text-center">
                        <?php if($image=='block'){?>
                            <img id="previewImg" src="<?php echo base_url($viewResultadoPdi[0]["rutaImagen"])?>" style="max-width: 100%; display: <?php echo $image?>; margin-top: 10px;" />
                        <?php }else{?>
                            <img id="previewImg" style="max-width: 100%; display: none; margin-top: 10px;" />
                        <?php }?>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12 text-center">
                        <button class="btn btn-warning btn-sm" type="button" id="btnVolverCapture"><i class="fas fa-refresh"></i>&nbsp;Volver a Tomar Foto</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit" disabled id="btnProcessCrea">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>