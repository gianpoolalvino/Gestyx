<?php
$contador = $countReg;
foreach ($detailIndex as $di) {
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador ?></td>
        <td><?php echo $di["vin"] ?></td>
        <td><?php echo $di["marca"] ?></td>
<td><?php
                                            echo $di["modelo"];
                                        ?></td>
        <td><?php echo $di["color"] ?></td>
        <td><?php echo $di["agenciaAnterior"] ?></td>
        <td><?php echo $di["estadoTraslado"] ?></td>
        <td><?php echo $di["estadoVin"] ?></td>
        <td>
            <?php if(($di["idestadoTraslado"]==1) && $di["codigoAgenciaDestino"]!=""){?>
                <?php if(in_array($di["codigoAgenciaDestino"],session("codigoAgencia"))){?>
                    <button class="btn btn-subtle-warning btn-sm btnOrecep" data-idtrasladoVin="<?php echo $di["idtrasladoVin"]?>" data-vin="<?php echo $di["vin"]?>" type="button">Recepcionar</button>
                <?php }else{?>
                    <button class="btn btn-subtle-warning btn-sm btnOrecep" disabled><i class="fas fa-cog fa-spin"></i>&nbsp;En Transito</button>
                <?php }?>
            <?php }else{?>
                <button class="btn btn-subtle-primary btn-sm btnOpcubica" data-vin="<?php echo $di["vin"]?>" type="button">Enviar</button>
            <?php }?>
        </td>
    </tr>
<?php } ?>