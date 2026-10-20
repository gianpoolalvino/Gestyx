<?php
$contador=0;
foreach($detailTipoSolicitud as $tss){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $tss["tipoSolicitud"]?></td>
        <td>Activo</td>
        <td>
            <button class="btn btn-outline-danger btn-sm btnDeletTipoSo" data-idusuario="<?php echo $tss["idusuario"]?>" data-idtipoSolicitudUsuario="<?php echo $tss["idtipoSolicitudUsuario"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>