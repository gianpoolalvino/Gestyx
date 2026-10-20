<?php
$contador=0;
foreach($detailCondiciones as $op){
    $contador++;?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $op["valor"]?></td>
        <td><?php echo $op["operador"]?></td>
        <td><?php echo $op["dias"]?></td>
        <td>
            <button class="btn btn-outline-danger btn-sm btnOpcCondicion" type="button" data-idcondicionRegla="<?php echo $op["iddetalleReglaEntrega"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>