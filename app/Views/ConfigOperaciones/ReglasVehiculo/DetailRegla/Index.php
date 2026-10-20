<?php
$contador=0;
foreach($detailRegla as $dr){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dr["nombreCampo"]?></td>
        <td><?php echo $dr["descripcionCampo"]?></td>
        <td><?php echo $dr["tipoRegla"]?></td>
        <td style="width: 30%">
            <?php if($dr["idtipoRegla"]==1){?>
                <button class="btn btn-outline-primary btn-sm btnOpcReglaVe"><i class="fas fa-edit"></i></button>
            <?php }else{?>
                <button class="btn btn-outline-primary btn-sm btnOpcReglaVe"><i class="fas fa-edit"></i></button>
                <button class="btn btn-outline-dark btn-sm btnOpcReglaVe" data-opcion="ViewCondicion" data-idreglaVehiculo="<?php echo $dr["idreglaEntrega"]?>"><i class="fas fa-eye"></i></button>
            <?php }?>
        </td>
    </tr>
<?php }?>