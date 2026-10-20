<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .tableFixHeadV2 {
        overflow: auto;
        height: 340px;
        white-space: nowrap;
    }

    .tableFixHeadV2 thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background:#141824;
        color:white
    }
</style>
<div class="modal-body">
    <input hidden id="idgrupoUbicacionGeneralView" value="<?php echo $idgrupoUbicacion?>">
    <div class="row">
        <div class="col-12">
            <h6>Gestionar Ubicaciones y Box</h6>
        </div>
    </div>
    <hr>
    <div class="row pb-2">
        <div class="col-7">
            <div class="tableFixHeadV2">
            <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ubicacion</th>
                        <th>Vehiculos</th>
                        <th>Box</th>
                        <th>Opc.</th>
                    </tr>
                </thead>
                <tbody id="tbodyUbicacion">
                    <?php
                    $counter=0;
                    foreach($detailIndex as $di){
                        $counter++;
                        ?>
                        <tr>
                            <td><?php echo $counter?></td>
                            <td><?php echo $di["descripcion"]?></td>
                            <td><?php echo $di["vehiculosVinculados"]?></td>
                            <td><?php echo $di["boxVinculados"]?></td>
                            <td>
                                <button style="padding-left: 6px;padding-right: 6px;padding-top: 4px;padding-bottom: 4px" data-idubicacion="<?php echo $di["idubicacion"]?>" data-opcion="edit" class="btn btn-outline-primary btn-sm btnOpcUbi"><i class="fas fa-edit"></i></button>
                                <?php if(($di["vehiculosVinculados"]==0) AND ($di["boxVinculados"]==0)){?>
                                    <button style="padding-left: 6px;padding-right: 6px;padding-top: 4px;padding-bottom: 4px" data-idubicacion="<?php echo $di["idubicacion"]?>" data-opcion="delete" class="btn btn-outline-danger btn-sm btnOpcUbi"><i class="fas fa-trash"></i></button>
                                <?php }?>
                                <button style="padding-left: 6px;padding-right: 6px;padding-top: 4px;padding-bottom: 4px" data-idubicacion="<?php echo $di["idubicacion"]?>" data-opcion="view" class="btn btn-outline-success btn-sm btnOpcUbi"><i class="fas fa-arrow-right"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
            </div><br>
            <button class="btn btn-primary btn-sm" id="btnAddUbicacion" type="button"><i class="fas fa-plus"></i>&nbsp;Agregar Ubicacion</button>
        </div>
        <div class="col-5">
            <div class="tableFixHeadV2">
            <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Box</th>
                    <th>Vehiculos</th>
                    <th>Opc.</th>
                </tr>
                </thead>
                <tbody id="tbodyBox">
                    <tr>
                        <td colspan="4" class="text-center">Seleccione una Ubicacion para visualizar los Box</td>
                    </tr>
                </tbody>
            </table>
            </div><br>
            <button class="btn btn-info btn-sm" type="button" id="btnAddBoxUbicacion"><i class="fas fa-plus"></i>&nbsp;Agregar Box</button>
        </div>
    </div><hr>
    <div class="row pb-2">
        <div class="col-12">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>