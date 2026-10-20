<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
$contador=$countReg;
$color='';
$colorTable='';
foreach($detailIndex as $dt){
    if($hoy>=$dt["fechaFinaliza"]){
        $color='table-danger';
    }
    $contador++;
    ?>
    <tr class="<?php echo $color?>" id="<?php echo $contador?>">
        <td class="sticky-column"><?php echo $contador?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso" data-idliberacionDemo="<?php echo $dt["idliberacionDemo"]?>" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a></td>
        <td><?php echo $dt["tipoDemo"]?></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["familia"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td>
            <?php if(!is_null($dt["numeroTitulo"])){?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["numeroTitulo"]?></span></h5>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Titulo</span></h5>
            <?php }?>
        </td>
        <td>
            <?php if($dt["placa"]!=''){?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["placa"]?></span></h5>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Placa</span></h5>
            <?php }?>
        </td>
        <td>
            <?php echo date("d/m/Y",strtotime($dt["fechaFinaliza"]));?>
        </td>
        <td><?php echo $dt["bodega"]?></td>
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