<?php
$contador=0;
foreach($reporteInventario as $rinv){
    $contador++;
    ?>
<tr>
    <td><?php echo $contador?></td>
    <td><?php echo $rinv["vin"]?></td>
    <td><?php echo $rinv["marca"]?></td>
    <td><?php echo $rinv["modelo"]?></td>
    <td><?php echo $rinv["color"]?></td>
    <td><?php echo $rinv["anhoModelo"]?></td>
    <td><?php echo $rinv["ubicacion"]?></td>
    <td><?php echo $rinv["boxubicacion"]?></td>
    <td><?php echo $rinv["fechaIngreso"]?></td>
    <td><?php echo $rinv["fechaCompra"]?></td>
    <td><?php echo $rinv["diasInventario"]?></td>
</tr>
<?php }?>