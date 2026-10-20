
<?php
$contador=0;
foreach($detailAgencia as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["descripcion"]?></td>
        <td>Habilitado</td>
        <td>
            <button class="btn btn-danger btn-sm btnOpcionAgen" data-opcion="delete" data-idusuarioSede="<?php echo $di["idusuarioSede"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
