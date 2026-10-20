<?php
$contador=0;
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dt["categoria"]?></td>
        <td><?php echo $dt["condicion"]?></td>
        <td><?php echo $dt["porcentaje"]?></td>
        <td>
            <button class="btn btn-outline-danger btn-sm btnTrashCat" data-idcategoriaBono="<?php echo $dt["idcategoriaBono"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
