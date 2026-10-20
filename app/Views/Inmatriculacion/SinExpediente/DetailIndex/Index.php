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
        <td><?php echo $dt["fechaFacturaLabel"]?></td>
        <td><?php echo $dt["fechaCanceladoLabel"]?></td>
        <td><?php echo $dt["tipoVin"]?></td>
        <td>
            <?php if(is_null($dt["ideventoActual"])){?>
                <a href=""><h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Eventos</span></h5></a>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["eventoActual"]?></span></h5>
            <?php }?>
        </td>
    </tr>
    <?php
    $color='';
}?>