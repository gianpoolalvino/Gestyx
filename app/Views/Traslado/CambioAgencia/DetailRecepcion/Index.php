<?php
$contador=0;
foreach($detalleRecepcion as $dt){
    $contador++;
    ?>
    <tr style="vertical-align: middle">
        <td style="width: 10%" class="ps-2"><?php echo $contador?></td>
        <td style="width: 20%" class="ps-2">
            <img style="width: 100%"  src="<?php echo base_url($dt["rutaImagen"])?>">
        </td>
        <td style="width: 60%" class="ps-2"><?php echo $dt["descripcion"]?></td>
        <td style="width: 10%" class="ps-2 pe-2">
            <button class="btn btn-danger btn-sm btpDelObs" data-iddetalleRecepion="<?php echo $dt["iddetalleRecepcionVin"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>