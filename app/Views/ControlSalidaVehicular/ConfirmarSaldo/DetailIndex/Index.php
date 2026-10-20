<?php
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    if($dt["saldoPendiente"]>0){
        $color='table-danger';
    }
    $contador++;
    ?>
    <tr class="<?php echo $color?>" id="<?php echo $contador?>">
        <td class="sticky-column"><?php echo $contador?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["agencia"]?></td>
        <td><?php echo $dt["documentoCliente"]?></td>
        <td style="white-space: pre-line;"><?php echo $dt["nombreCliente"]?></td>
        <td>
            <?php echo $dt["numeroFactura"]?>
        </td>
        <td>
            <?php
            $estadoVin='';
            if($dt["saldoPendiente"]==0){
                $estadoVin='<h5><span class="badge badge-phoenix badge-phoenix-success">Cancelado</span></h5>';
            }else{
                $estadoVin='<h5><span class="badge badge-phoenix badge-phoenix-danger">'.$dt["saldoPendiente"].'</span></h5>';
            }
            echo $estadoVin;
            ?>
        </td>

        <td><?php echo $dt["numeroPedido"]?></td>
    </tr>
    <?php
    $color='';
}?>