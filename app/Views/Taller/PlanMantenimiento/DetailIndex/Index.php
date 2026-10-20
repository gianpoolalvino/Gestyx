<?php
$planesMantenimiento = [];
?>
<table class="table fs-9 mb-0 border-top border-translucent table-hover">
    <thead>
    <tr>
        <th><?php echo $viewPlan[0]["modelo"] . " " . $viewPlan[0]["version"] ?></th>
        <th>Cant.</th>
        <?php
        $detplan = [];
        foreach ($viewPlanFull as $dpl) {
            if ($dpl["detallePlan"] != '') {
                $dets = explode("@@", $dpl["detallePlan"]);
                foreach ($dets as $dts) {
                    $dat = explode("##", $dts);
                    $detplan[] = $dat[1];
                }
            }
            $datos = [
                'idplanMantenimiento' => $dpl["idplanMantenimiento"],
                'idplanMantenimientoFamilia' => $dpl["idplanMantenimientoFamilia"],
                'iddetallePlanMantenimientoFamilia' => $detplan,
            ];
            array_push($planesMantenimiento,$datos);
            $detplan = [];
            ?>
            <th><?php echo $dpl["kilometraje"] ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($detailView as $df) { ?>
        <tr>
            <td><?php echo $df["repuesto"] ?></td>
            <td><?php echo $df["cantidad"] ?></td>
            <?php foreach ($planesMantenimiento as $plms) { ?>
                <?php if(in_array($df["iddetallePlanMantenimientoFamilia"],$plms["iddetallePlanMantenimientoFamilia"])){?>
                    <td>
                        <button class="btn btn-primary bn-sm opcionRepuesto" data-opcion="delete" data-iddetallePlanMantenimientoFamilia="<?php echo $df["iddetallePlanMantenimientoFamilia"]?>" data-idplanMantenimientoFamilia="<?php echo $plms["idplanMantenimientoFamilia"]?>" data-idplanMantenimiento="<?php echo $plms["idplanMantenimiento"]?>"><?php echo $df["precioUnidadDolares"]?></button>
                    </td>
                <?php }else{?>
                    <td>
                        <button class="btn btn-outline-primary bn-sm opcionRepuesto" data-opcion="add" data-iddetallePlanMantenimientoFamilia="<?php echo $df["iddetallePlanMantenimientoFamilia"]?>" data-idplanMantenimientoFamilia="<?php echo $df["idplanMantenimientoFamilia"]?>" data-idplanMantenimiento="<?php echo $plms["idplanMantenimiento"]?>"><?php echo $df["precioUnidadDolares"]?></button>
                    </td>
                <?php }?>
            <?php } ?>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="2">Mano de Obra <?php echo $viewPlan[0]["costoManoObra"] . " x Hora" ?>
        <input hidden id="costoManoObraPlan" value="<?php echo $viewPlan[0]["costoManoObra"]?>">
        </td>
        <?php
            foreach ($viewPlanFull as $dplv2) { ?>
                <td>
                    <div class="input-group">
                        <input class="form-control form-control-sm inputMant" id="inputHora<?php echo $dplv2["idplanMantenimiento"]?>" style="width:50%" data-valorManoObra="<?php echo $viewPlan[0]["costoManoObra"]?>" data-idplanMantenimiento="<?php echo $dplv2["idplanMantenimiento"]?>"  value="<?php echo $dplv2["tiempoManoObra"]?>">
                        <div class="input-group-prepend">
                            <button class="btn btn-primary btn-sm btnSaveHora" data-idplanMantenimiento="<?php echo $dplv2["idplanMantenimiento"]?>" style="width:33px;padding-left:0px;padding-right:0px"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </td>
        <?php } ?>
    </tr>
    </tbody>
</table>
