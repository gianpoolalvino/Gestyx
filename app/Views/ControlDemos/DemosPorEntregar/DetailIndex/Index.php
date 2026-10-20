<?php
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr class="<?php echo $color?>" id="<?php echo $contador?>">
        <td class="sticky-column"><?php echo $contador?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso" data-idasignarDemo="<?php echo $dt["idasignarDemo"]?>" data-idliberacionDemo="<?php echo $dt["idliberacionDemo"]?>" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a></td>
        <td><?php echo $dt["tipoDemo"]?></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["familia"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td>
            <?php echo $dt["nombreResponsable"]?>
        </td>
        <td>
            <?php echo $dt["fechaEntrega"]?>
        </td>
        <td>
            <?php echo $dt["fechaRetorno"]?>
        </td>
        <td>
            <?php if($dt["placa"]!=''){?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["placa"]?></span></h5>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Placa</span></h5>
            <?php }?>
        </td>

        <td>
            <?php echo $dt["estadoAsignado"]?>
        </td>
    </tr>
    <?php
    $color='';
}?>