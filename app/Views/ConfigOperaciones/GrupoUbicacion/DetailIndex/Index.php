<?php
$contador=0;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["grupoUbicacion"]?></td>
        <td><?php echo $di["empresa"]?></td>
        <td>
            <?php echo $di["ubicacionesVinculadas"]?>
        </td>
        <td>
            <?php echo $di["vehiculosVinculados"]?>
        </td>
        <td>
            <button class="btn btn-subtle-primary me-1 mb-1 btn-sm btnOpcGrupo" data-opcion="edit" data-idgrupoUbicacion="<?php echo $di["idgrupoUbicacion"]?>"><i class="fas fa-edit"></i></button>
            <button class="btn btn-subtle-dark me-1 mb-1 btn-sm btnOpcGrupo" data-opcion="add" data-idgrupoUbicacion="<?php echo $di["idgrupoUbicacion"]?>"><i class="fas fa-plus"></i></button>
            <button class="btn btn-subtle-danger me-1 mb-1 btn-sm btnOpcGrupo" data-opcion="delete" data-idgrupoUbicacion="<?php echo $di["idgrupoUbicacion"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>