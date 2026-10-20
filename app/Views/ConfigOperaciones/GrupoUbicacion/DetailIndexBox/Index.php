<?php
$counter=0;
foreach($detailIndex as $di){
    $counter++;
    ?>
    <tr>
        <td><?php echo $counter?></td>
        <td><?php echo $di["box"]?></td>
        <td><?php echo $di["vehiculosVinculados"]?>&nbsp;/&nbsp;<?php echo ($di["tipoBox"]==1)?'Unico':'General'?></td>
        <td>
            <button style="padding-left: 6px;padding-right: 6px;padding-top: 4px;padding-bottom: 4px" data-idboxUbicacion="<?php echo $di["idboxUbicacion"]?>" data-opcion="edit" class="btn btn-outline-primary btn-sm btnOpcBxUb"><i class="fas fa-edit"></i></button>
            <?php if($di["vehiculosVinculados"]==0){?>
                <button style="padding-left: 6px;padding-right: 6px;padding-top: 4px;padding-bottom: 4px" data-idboxUbicacion="<?php echo $di["idboxUbicacion"]?>" data-idubicacion="<?php echo $di["idubicacion"]?>" data-opcion="delete" class="btn btn-outline-danger btn-sm btnOpcBxUb"><i class="fas fa-trash"></i></button>
            <?php }?>
        </td>
    </tr>
<?php }?>