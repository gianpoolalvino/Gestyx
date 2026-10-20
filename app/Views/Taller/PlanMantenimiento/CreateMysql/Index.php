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
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <input hidden id="idplanMantenimientoFamProcess" value="<?php echo $idplanMantenimientoFamilia?>">
    <div class="row pb-2">
        <div class="col-12 text-center">
            <?php if($status=='error'){?>
                <i class="far fa-exclamation-triangle fa-3x pb-1 text-danger"></i>
                        <h5 class="pb-2"><?php echo $title?></h5>
                        <?php if(isset($repuesto)){?>
                            <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Codigo Repuesto</th>
                                    <th>Error</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador=0;
                                    foreach($repuesto as $rep){
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador?></td>
                                            <td><?php echo $rep["codigoRepuesto"]?></td>
                                            <td>No Existe en BD</td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        <?php }?>
            <?php }else {?>
                    <div id="panelPrincipal" style="display: block">
                        <i class="far fa-check-circle fa-3x pb-1 text-success"></i>
                        <h5 class="pb-2" id="titleFinal">Puede procesar el plan de mantenimiento, no se detectaron errores</h5>
                    </div>
                    <div id="panelProcesoCarga" style="display:none">
                        <i class="fas fa-sync fa-spin fa-3x pb-1 text-success"></i>
                        <h5 class="pb-2">El sistema esta Procesando no cierra la ventana...</h5>
                        <span id="spanPreloader"></span>
                    </div>
                    <div id="panelErrorCarga" style="display:none">
                        <i class="far fa-exclamation-circle fa-3x pb-1 text-danger"></i>
                        <h5 class="pb-2" id="titleError">Error Demo</h5>
                        <span id="spanError">Pruebas de Error</span>
                    </div>
            <?php }?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <?php if($status!='error'){?>
                <button class="btn btn-primary btn-sm" type="button" id="btnProcesarCl">Procesar</button>
            <?php }?>
            <button class="btn btn-outline-danger btn-sm" type="button" id="btnCloseMd" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>