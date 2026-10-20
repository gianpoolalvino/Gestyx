<?php
$contador = 0;
foreach ($equipamientoInstalado as $eqi) {
    $contador++;
    ?>
    <tr>
        <td>
            <div class="form-check">

                <input class="form-check-input"
                       id="flexCheckChecked<?php echo $eqi['iddetalleEquipamientoCalidad'] ?>"
                       disabled
                       type="checkbox" <?php echo ($eqi["estadoEquipamientoCalidad"] != 3) ? 'checked' : '' ?>/>
                <label class="form-check-label"
                       for="flexCheckChecked<?php echo $eqi['iddetalleEquipamientoCalidad'] ?>"><?php echo ($eqi["estadoEquipamientoCalidad"] == 3) ? 'Pendiente' : 'Realizado' ?></label>
            </div>
        </td>
        <td>
            <input hidden name="estadoRevisadoEq[]"
                   value="<?php echo $eqi["estadoEquipamientoCalidad"] ?>">
            <input hidden name="idequipamientoCalidad[]" value="<?php echo $eqi["iddetalleEquipamientoCalidad"] ?>">
            <?php echo $eqi["equipamiento"] ?><br>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo $eqi['colorEstado']?>"><span class="badge-label"><?php echo $eqi['estado']?></span><span class="ms-1" data-feather="package" style="height:12.8px;width:12.8px;"></span></span>
        </td>
        <td><?php echo $eqi["nombreInstalo"] ?></td>
        <td><?php echo ($eqi["idestadoEquipamiento"] == 1) ? 'Pendiente' : 'Instalado' ?></td>
        <td>
            <?php if ($eqi["estadoEquipamientoCalidad"] == 3 || $eqi["estadoEquipamientoCalidad"]==5) { ?>
                <div class="input-group">
                    <div class="input-group-append">
                        <button class="btn btn-subtle-primary btn-sm btnEditEquipamiento"
                                data-vin="<?php echo $vin ?>"
                                data-idequipamientoCalidad="<?php echo $eqi["iddetalleEquipamientoCalidad"] ?>"
                                type="button"><i class="far fa-paperclip"></i>
                        </button>
                    </div>
                </div>
            <?php } ?>
        </td>
    </tr>
<?php } ?>