<div class="row">
<?php foreach($formularioImagen as $fim){?>
    <div class="col-<?php echo $fim["col"]?>" style="padding-bottom: 16px">
        <label style="font-size: 12px" class="spanLabel"><?php echo $fim["descripcion"]?></label><br>
        <div class="card">
            <div class="card-body text-center" style="height: 240px">
                <?php if($fim["imagenVehiculo"]!=''){?>
                    <?php if($fim["idtipoCarga"]==2){?>
                        <img style="height:220px;width: 80%" src="<?php echo base_url($fim["imagenVehiculo"])?>">
                        <?php }else{?>
                    <?php
                    $base64 = 'data:image/' . $fim["tipoImagen"] . ';base64,' . $fim["imagenVehiculo"]; ?>
                    <img style="height:220px;width: 80%" src="<?php echo $base64?>">
                    <?php }?>
                <?php }else{?>
                    <span>Carge una Imagen...</span>
                <?php }?>
            </div>
            <div class="card-footer" style="padding-top:4px;padding-bottom: 0px;padding-left: 4px;padding-right: 4px">
                <?php if($fim["imagenVehiculo"]!=''){?>
                    <button class="btn btn-subtle-warning me-1 mb-1 btnUploadImage" style="width: 100%" data-idimagen="<?php echo $fim["iddetalleIngresoVehiculoImagen"]?>" data-VinImagen="<?php echo $fim["vin"]?>" type="button"><i class="fas fa-upload"></i>&nbsp;Editar Imagen</button>
                <?php }else{?>
                    <button class="btn btn-subtle-secondary me-1 mb-1 btnUploadImage" style="width: 100%" data-idimagen="<?php echo $fim["iddetalleIngresoVehiculoImagen"]?>" data-VinImagen="<?php echo $fim["vin"]?>" type="button"><i class="fas fa-upload"></i>&nbsp;Cargar Imagen</button>
                <?php }?>
            </div>
        </div>
    </div>
<?php }?>
</div>
<div class="row" style="padding-bottom: 8px">
    <div class="col-12">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
    </div>
</div>