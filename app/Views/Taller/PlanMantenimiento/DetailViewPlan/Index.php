<?php
$contador=0;
foreach($detailViewPlan as $dvp){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dvp["cantidad"]?></td>
        <td><?php echo $dvp["codigo"]?></td>
        <td><?php echo $dvp["repuesto"]?></td>
        <td><?php echo $dvp["precioUnidadDolares"]?></td>
        <td><?php echo $dvp["precioTotalDolares"]?></td>
        <td>
            <button class="btn btn-danger btn-sm btnDetailRepuesto" data-iddetallePlanMtoFam="<?php echo $dvp["iddetallePlanMantenimientoFamilia"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>