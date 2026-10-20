
<?php
$contador=0;
foreach($detailUbicacion as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["grupoUbicacion"]?></td>
        <td>Habilitado</td>
        <td>
            <button class="btn btn-danger btn-sm btnOpcionUbic" data-opcion="delete" data-idusuarioGrupoUbicacion="<?php echo $di["idusuarioGrupoUbicacion"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
