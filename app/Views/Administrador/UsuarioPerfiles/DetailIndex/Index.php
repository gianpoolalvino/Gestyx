<?php
$contador=0;
foreach($detailIndex as $di){
    $contador++;?>
    <tr>
        <td style="vertical-align: middle"><?php echo $contador?></td>
        <td style="vertical-align: middle"><?php echo $di["tipoDocumento"]?></td>
        <td style="vertical-align: middle"><?php echo $di["documento"]?></td>
        <td style="vertical-align: middle"><?php echo $di["nombres"]?></td>
        <td style="vertical-align: middle"><?php echo $di["primerApellido"]." ".$di["segundoApellido"]?></td>
        <td style="vertical-align: middle"><?php echo $di["area"]?></td>
        <td style="vertical-align: middle"><?php echo $di["cargo"]?></td>
        <td style="vertical-align: middle"><?php echo ($di["estadoUsuario"]==1)?'Activo':'Deshabilitado'?></td>
        <td style="width: 10%;vertical-align: middle">
            <button class="btn btn-subtle-primary btn-sm btnOpcionUser" data-opcion="edit" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-edit"></i></button>
            <button class="btn btn-subtle-success btn-sm btnOpcionUser" data-opcion="send" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-paper-plane"></i></button>
            <button class="btn btn-subtle-info btn-sm btnOpcionUser" data-opcion="access" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-cogs"></i></button>
            <?php if($di['estadoUsuario']==1){?>
            <button class="btn btn-subtle-danger btn-sm btnOpcionUser" data-opcion="delete" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-trash"></i></button>
            <?php }?>
        </td>
    </tr>
<?php }?>