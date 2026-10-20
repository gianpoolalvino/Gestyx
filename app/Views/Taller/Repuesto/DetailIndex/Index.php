<?php
$contador = $countReg;
foreach($detailIndex as $dic){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dic["marca"]?></td>
        <td><?php echo $dic["codigo"]?></td>
        <td><?php echo $dic["descripcion"]?></td>
        <td><?php echo $dic["precioSoles"]?></td>
        <td><?php echo $dic["precioDolares"]?></td>
        <td>
            <button class="btn btn-primary btn-sm btnOpcionRepuesto" data-opcion="edit" data-idrepuesto="<?php echo $dic["idrepuesto"]?>"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm btnOpcionRepuesto" data-opcion="trash" data-idrepuesto="<?php echo $dic["idrepuesto"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>