<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <h5>Vehiculos Creados sin ERP</h5>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <table id="tablePanel" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                <tr>
                    <th class="sticky-col first-col">#</th>
                    <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Color</th>
                    <th>Año</th>
                    <th>Fecha Creacion</th>
                    <th>Sincronizado ERP</th>
                    <th>Bodega</th>
                    <th>Dia Sincroniza</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $contador=0;
                    foreach($detailIndex as $di){
                        $contador++;
                        ?>
                        <tr>
                            <td><?php echo $contador?></td>
                            <td><?php echo $di["vin"]?></td>
                            <td><?php echo $di["marca"]?></td>
                            <td><?php echo $di["modelo"]?></td>
                            <td><?php echo $di["color"]?></td>
                            <td><?php echo $di["anhoModelo"]?></td>
                            <td><?php echo $di["fechaCreacion"]?></td>
                            <td>
                                <?php echo ($di["sincronizadoERP"]==1)?'Sincronizado':'No Existe'?>
                            </td>
                            <td>
                                <?php echo $di["bodega"]?>
                            </td>
                            <td>
                                <?php echo $di["diaIntento"]?>
                            </td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm btnOpcCreado" data-idcreaVinSinERP="<?php echo $di["idcreaVinSinERP"]?>" data-vin="<?php echo $di["vin"]?>" type="button"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-info btn-sm btnOpcCreado" data-idcreaVinSinERP="<?php echo $di["idcreaVinSinERP"]?>" data-vin="<?php echo $di["vin"]?>" type="button"><i class="far fa-repeat"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>