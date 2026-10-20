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
    <form method="POST" id="formSaveCheckCalidad"
          action="<?php echo base_url("AlistamientoVehicular/ControlCalidad/SaveEditDelete/UpdateCheckCalidad") ?>">
        <input hidden name="idcheckCalidad" value="<?php echo $idcheckCalidad?>">
        <input hidden id="grupoCheckId" value="<?php echo $checkCalidad[0]["idgrupoCheckCalidad"]?>">
        <input hidden name="vinEq" id="vinEq" value="<?php echo $vin?>">
        <div class="row">
            <div class="col-12">
                Validar Check de <?php echo $checkCalidad[0]["descripcion"] ?>
            </div>
        </div>
        <?php if($checkCalidad[0]["estado"]!=3){?>
            <div class="row">
                <div class="col-12">
                    <h6>- Observaciones Presentadas -</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php foreach($estadoCheckCalidad as $esc){?>
                        <?php if($esc["idestadoCheckCalidad"]==$checkCalidad[0]["estado"]){?>
                            <span class="form-label spanlabel" for="estatus">Estado</span><br>
                            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo $esc["color"]?>"><span class="badge-label"><?php echo $esc["descripcion"]?></span><span class="ms-1" data-feather="package" style="height:12.8px;width:12.8px;"></span></span>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="form-label spanlabel" for="estatus">Comentarios</span><br>
                    <?php echo $checkCalidad[0]["comentarios"]?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                    if(!is_null($checkCalidad[0]["imagenAdjunto"])){
                        $base64 = 'data:image/' . $checkCalidad[0]["tipoImagen"] . ';base64,' . $checkCalidad[0]["imagenAdjunto"]; ?>
                        <img style="width:100%" src="<?php echo $base64?>">
                    <?php  } else{?>
                        <?php if($checkCalidad[0]["idtipoCarga"]==2){?>
                            <img style="width:100%" src="<?php echo base_url($checkCalidad[0]["rutaImagen"])?>">
                        <?php }?>
                    <?php }?>
                </div>
            </div><hr>
            <div class="row">
                <div class="col-12">
                    <h6>- Correcciones -</h6>
                </div>
            </div>
        <?php }?>
        <div class="row">
            <div class="col-8">
                <label class="form-label spanlabel" for="estatus">Estado</label>
                <select class="form-control form-control-sm" id="estatus" required name="estadoCalidad">
                    <option value="">Seleccione un Estado</option>
                    <?php if($checkCalidad[0]["estado"]==3){?>
                        <option value="4">CONFORME</option>
                        <option value="5">REVISAR / OBSERVACIONES</option>
                    <?php }else{?>
                        <option value="1">CORREGIDO</option>
                        <option value="2">ENTREGAR CON OBSERVACIONES</option>
                    <?php }?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label spanlabel" for="fechaRevision">Fecha</label>
                <input class="form-control form-control-sm" name="fechaRevision" required value="<?php echo $hoy?>" id="fechaRevision" type="date">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="comentariocheckCalidad">Observaciones</label>
                <textarea class="form-control form-control-sm" name="comentariocheckCalidad" id="comentariocheckCalidad" style="height:80px"></textarea>
            </div>
        </div><br>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceCheckCalidad">Subir Imagen</label>
                <input class="form-control form-control-sm" <?php echo ($checkCalidad[0]["required"]==1)?'required':''?> name="resourceCheckCalidad" id="resourceCheckCalidad" type="file"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-danger btn-sm" id="btnCloseAdicional" type="button">Cancelar</button>
            </div>
        </div>
    </form>
</div>
