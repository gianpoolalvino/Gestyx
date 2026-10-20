<?php
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    if(!is_null($dt["saldoPendiente"])){
        if($dt["saldoPendiente"]>0){
            $color='table-danger';
        }
    }
    $contador++;
    ?>
    <tr class="<?php echo $color?>" id="<?php echo $contador?>">
        <td class="sticky-column"><?php echo $contador?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso" data-estadoVin="<?php echo $dt["idestadoVin"]?>" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php
                                        
                                            echo $dt["modelo"];
                                       
                                        ?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["bodega"]?></td>
        <td><?php echo $dt["estadoVin"]?></td>
        <td><?php echo $dt["numeroTitulo"]?></td>
        <td><?php echo $dt["fechaFin"]?></td>
        <td><?php echo $dt["placa"]?></td>
    </tr>
    <?php
    $color='';
}?>