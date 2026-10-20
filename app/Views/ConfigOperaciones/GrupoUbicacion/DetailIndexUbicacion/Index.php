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