<?php
$contador=0;
    foreach($detailIndex as $di){
        $contador++;
?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["tipoEncuesta"]?></td>
        <td><?php echo ($di["taller"]!='')?$di["taller"]:$di["nombreAgencia"]?></td>
        <td><?php echo ($di["nombreTecnico"]!='')?$di["nombreTecnico"]:$di["asesor"]?></td>
        <td><?php echo $di["placa"]?></td>
        <td><?php echo $di["documento"]?></td>
        <td><?php echo $di["resultadoAutoniza"]?></td>
        <td><?php echo $di["resultadoMarca"]?></td>
        <td><?php echo $di["celular"]?></td>
        <td><?php echo $di["email"]?></td>
        <td><?php echo $di["canal"]?></td>
        <td>
            <button class="btn btn-light btn-sm"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
<?php }?>
