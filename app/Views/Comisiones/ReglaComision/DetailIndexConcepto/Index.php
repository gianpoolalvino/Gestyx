<?php
$contador=0;
foreach($detail as $dt){
    $contador++;
?>
<tr>
    <td><?php echo $contador?></td>
    <td><?php echo $dt["concepto"]?></td>
    <td><?php echo $dt["meta"]?></td>
    <td><?php echo $dt["peso"]?></td>
    <td>
        <button class="btn btn-danger btn-sm btnTrash" data-idconceptoRegla="<?php echo $dt["iddetalleReglaComisionVentaVehiculo"]?>"><i class="fas fa-trash"></i></button>
    </td>
</tr>
<?php }?>
