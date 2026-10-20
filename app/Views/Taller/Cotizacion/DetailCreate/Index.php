<?php
if($tipoMoneda==1){
foreach($detailView as $dv){
    ?>
    <tr id="det<?php echo $dv["iddetallePlanMantenimiento"]?>">
        <td>
            <?php echo $dv["codigo"]?>
            <input hidden name="iddetalleMantenimiento[]" value="<?php echo $dv["iddetallePlanMantenimiento"]?>">
            <input hidden name="cantidad[]" value="<?php echo $dv["cantidad"]?>">
            <input hidden name="precioUnitarioRepuesto[]" id="precioUnitarioRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo $dv["precioUnitario"]?>">
            <input hidden name="idrepuesto[]" value="<?php echo $dv["idrepuesto"]?>">
            <input hidden name="subTotalRepuesto[]" id="subTotalRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo $dv["precioTotal"]?>">
            <input hidden name="desctoRepuesto[]" id="desctoRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo ($descuento>0)?number_format((($dv["precioTotal"])*$descuento)/100,2,".",""):0;?>">
            <input hidden name="precioTotalRepuesto[]" id="precioTotalRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo ($descuento>0)?number_format(($dv["precioTotal"])-(($dv["precioTotal"])*$descuento)/100,2,".",""):number_format($dv["precioTotal"],2,".","");?>">
        </td>
        <td><?php echo $dv["cantidad"]?></td>
        <td><?php echo $dv["descripcion"]?></td>
        <td><?php echo $dv["precioUnitario"]?></td>
        <td><?php echo $dv["precioTotal"]?></td>
        <td>
            <?php
                echo ($descuento>0)?number_format(($dv["precioTotal"]*$descuento)/100,2,".",""):0;
            ?>
        </td>
        <td>
            <?php
            echo ($descuento>0)?number_format($dv["precioTotal"]-($dv["precioTotal"]*$descuento)/100,2,".",""):number_format($dv["precioTotal"],2,".","");
            ?>
        </td>
        <td>
            <button class="btn btn-danger btn-sm btnDeletDetCot" data-iddetalleMantenimiento="det<?php echo $dv["iddetallePlanMantenimiento"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>

<?php }else{?>

<?php foreach($detailView as $dv){
        ?>
        <tr id="det<?php echo $dv["iddetallePlanMantenimiento"]?>">
            <td>
                <?php echo $dv["codigo"]?>
                <input hidden name="iddetalleMantenimiento[]" value="<?php echo $dv["iddetallePlanMantenimiento"]?>">
                <input hidden name="cantidad[]" value="<?php echo $dv["cantidad"]?>">
                <input hidden name="precioUnitarioRepuesto[]" id="precioUnitarioRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo ($dv["precioUnitario"]*$precioVenta)?>">
                <input hidden name="idrepuesto[]" value="<?php echo $dv["idrepuesto"]?>">
                <input hidden name="subTotalRepuesto[]" id="subTotalRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo ($dv["precioTotal"]*$precioVenta)?>">
                <input hidden name="desctoRepuesto[]" id="desctoRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo ($descuento>0)?number_format((($dv["precioTotal"]*$precioVenta)*$descuento)/100,2,".",""):0;?>">
                <input hidden name="precioTotalRepuesto[]" id="precioTotalRepuesto<?php echo $dv["iddetallePlanMantenimiento"]?>" value="<?php echo ($descuento>0)?number_format(($dv["precioTotal"]*$precioVenta)-(($dv["precioTotal"]*$precioVenta)*$descuento)/100,2,".",""):number_format($dv["precioTotal"]*$precioVenta,2,".","");?>">
            </td>
            <td><?php echo $dv["cantidad"]?></td>
            <td><?php echo $dv["descripcion"]?></td>
            <td><?php echo number_format(($dv["precioUnitario"]*$precioVenta),2,".","")?></td>
            <td><?php echo number_format(($dv["precioTotal"]*$precioVenta),2,".","")?></td>
            <td>
                <?php
                echo ($descuento>0)?number_format((($dv["precioTotal"]*$precioVenta)*$descuento)/100,2,".",""):0;
                ?>
            </td>
            <td>
                <?php
                echo ($descuento>0)?number_format(($dv["precioTotal"]*$precioVenta)-(($dv["precioTotal"]*$precioVenta)*$descuento)/100,2,".",""):number_format($dv["precioTotal"]*$precioVenta,2,".","");
                ?>
            </td>
            <td>
                <button class="btn btn-danger btn-sm btnDeletDetCot" data-iddetalleMantenimiento="det<?php echo $dv["iddetallePlanMantenimiento"]?>"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    <?php }?>
<?php }?>
