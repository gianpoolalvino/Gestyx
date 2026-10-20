<?php if (!empty($equipamiento)) {
    $count = 0;
    ?>
    <?php foreach ($equipamiento as $eq) { ?>
        <?php if ($eq["eliminado"]!=1) {?>
            <tr style="vertical-align: middle;">
                <td class="px-2">
                    <?php if($eq["idestadoEquipamiento"]==1){?>
                        <i class="fas fa-times text-danger"></i>
                    <?php }else if($eq["idestadoEquipamiento"]==2){?>
                        <i class="fas fa-check text-success"></i>
                    <?php }else{?>
                        <i class="fas fa-check text-warning"></i>
                    <?php }?>
                    <?php echo $eq["equipamiento"]?><br>
                    <span><?php echo ($eq["idestadoEquipamiento"]!=2)?$eq["fechaInstalacion"]:''?></span></td>
                <td class="px-2" style="width: 20%">
                    <?php if($eq["idtipoEquipamiento"]==9 && $eq["eventoGas"]==0){?>
                        <button class="btn btn-outline-primary btnOpcionAccesorio" type="button" data-vin="<?php echo $vin?>" data-idequipamiento="<?php echo $eq["idequipamientoVin"]?>"><i class="fas fa-wrench"></i>&nbsp;Equipar</button>
                    <?php }?>
                    <?php if($eq["idtipoEquipamiento"]==9 && $eq["eventoGas"]==1){?>
                        <span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><i class="fas fa-cog fa-spin"></i>&nbsp;En Evento GAS</span>
                    <?php }?>
                    <?php if($eq["idtipoEquipamiento"]==2 && $eq["eventoGps"]==0){?>
                        <button class="btn btn-outline-primary btnOpcionAccesorio" type="button" data-vin="<?php echo $vin?>" data-idequipamiento="<?php echo $eq["idequipamientoVin"]?>"><i class="fas fa-wrench"></i>&nbsp;Equipar</button>
                    <?php }?>
                    <?php if($eq["idtipoEquipamiento"]==2 && $eq["eventoGps"]==1){?>
                        <span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><i class="fas fa-cog fa-spin"></i>&nbsp;En Evento GPS</span>
                    <?php }?>
                    <?php if($eq["idtipoEquipamiento"]==1 && $eq["idestadoEquipamiento"]!=2){?>
                        <?php if ($eq["eventoLamina"] > 0) { ?>
                            <span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><i
                                        class="fas fa-cog fa-spin"></i>&nbsp;Evento Lamina</span>
                        <?php } else { ?>
                            <button class="btn btn-outline-primary btnOpcionAccesorio"
                                    type="button" data-vin="<?php echo $vin ?>"
                                    data-idequipamiento="<?php echo $eq["idequipamientoVin"] ?>">
                                <i class="fas fa-wrench"></i>&nbsp;Equipar
                            </button>
                        <?php } ?>
                    <?php }?>
                    <?php if($eq["idtipoEquipamiento"]==1 && $eq["idestadoEquipamiento"]==2){?>
                        <span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="fas fa-cog fa-spin"></i>&nbsp;Instalado</span>
                    <?php }?>
                </td>
            </tr>

            <?php
        }
    }
} ?>