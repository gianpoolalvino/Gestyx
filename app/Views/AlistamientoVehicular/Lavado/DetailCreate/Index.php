<?php
$contador=0;
foreach($detailLavado as $di){
    $contador++;?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["descripcion"]?></td>
        <td>
            <?php echo ($di["idestadoLavado"]==1)?'<span class="badge badge-phoenix badge-phoenix-warning">Pendiente</span>':'<span class="badge badge-phoenix badge-phoenix-primary">Realizado</span>'?>
        </td>
        <td>
            <?php echo ($di["idestadoLavado"]==1)?'<button class="btn btn-outline-primary btn-sm btnLavadoItem" type="button" data-id="'.$di["iddetalleLavado"].'"><i class="fas fa-car-wash"></i></button>':''?>
        </td>
    </tr>
<?php }?>