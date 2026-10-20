
<?php
$contador=0;
foreach($detailGrupo as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["grupoModulo"]?></td>
        <td><?php echo $di["modulo"]?></td>
        <td>Habilitado</td>
        <td>
            <?php if($di["parentUrl"]==1){?>
                <button class="btn btn-outline-primary btn-sm btnOpcionRol" data-opcion="subModulo" data-idrol="<?php echo $di["idrol"]?>" data-idmodulo="<?php echo $di["idmodulo"]?>" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-chart-network"></i></button>
            <?php } ?>
            <button class="btn btn-danger btn-sm btnOpcionRol" data-opcion="delete" data-idrol="<?php echo $di["idrol"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
