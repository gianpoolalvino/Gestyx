
<?php
$contador=0;
foreach($detailBodega as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["bodega"]?></td>
        <td>Habilitado</td>
        <td>
            <button class="btn btn-danger btn-sm btnOpcionBodg" data-opcion="delete" data-idusuarioBodega="<?php echo $di["idusuarioBodega"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
