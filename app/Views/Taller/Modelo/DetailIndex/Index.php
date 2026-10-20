<?php
$contador = $countReg;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td style="vertical-align: middle"><?php echo $contador?></td>
        <td style="vertical-align: middle"><?php echo $di["codigo"]?></td>
        <td style="vertical-align: middle"><?php echo $di["marca"]?></td>
        <td style="vertical-align: middle"><?php echo $di["descripcion"]?></td>
        <td style="vertical-align: middle"><?php echo $di["version"]?></td>
        <td style="vertical-align: middle"><?php echo $di["anho"]?></td>
        <td style="width: 7%;vertical-align: middle">
            <button data-opcion="trash" data-idmodelo="<?php echo $di["idmodelo"]?>" class="btn btn-outline-danger btn-sm btnOpcionModelo"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>