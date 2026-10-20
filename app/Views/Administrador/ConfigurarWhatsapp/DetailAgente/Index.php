<?php
$contador=0;
foreach($agentes as $ag){
    $contador++;?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $ag["nombreUsuario"]?></td>
        <td><?php echo $ag["prioridad"]?></td>
        <td>
            <button class="btn btn-outline-danger btn-sm btnTrashAgent" data-idusuario="<?php echo $ag["idusuario"]?>" data-id="<?php echo $ag["idagenteWhatsapp"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>