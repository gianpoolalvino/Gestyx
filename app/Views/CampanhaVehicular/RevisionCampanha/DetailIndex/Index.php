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
        <td><?php echo $dt["familia"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo (isset($dt["agencia"]))?$dt["agencia"]:'No Tiene'?></td>
        <td><?php echo $dt["bodega"]." / ".((isset($dt["ubicacion"]))?$dt["ubicacion"]:'Sin Ubicacion')?></td>
        <td>
            <button class="btn btn-subtle-<?php echo $dt["colorCampanha"]?> btn-sm btnApliCampanha" data-estado="<?php echo $dt["idestadoCampanha"]?>" data-idcampanha="<?php echo $dt["idcampanha"]?>" data-vin="<?php echo $dt["vin"]?>" data-idvinCampanha="<?php echo $dt["idcampanhaVin"]?>" type="button"><?php echo $dt["campanha"]?></button>
        </td>
        <td>
            <h5><span class="badge badge-phoenix badge-phoenix-<?php echo $dt["estadoColor"]?>"><?php echo $dt["estadoVin"]?></span></h5>
        </td>
    </tr>
    <?php
    $color='';
}?>