<?php
$contador=$countReg;
$color='';
$alertTd='';
foreach($detailIndex as $dt){
    if($dt["estadoAlerta"]==2){
        $alertTd='warning';
    }else if($dt["estadoAlerta"]==3){
        $alertTd='danger';
    }
    $contador++;
    ?>
    <tr class="table-<?php echo $alertTd?>">
        <td><?php echo $contador?></td>
        <td>
            <a href="#" class="btnBateria"
               data-vin="<?php echo $dt["vin"] ?>"><?php echo $dt["vin"]?></a></td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["estadoVin"]?></td>
        <td><?php echo $dt["ubicacion"]?></td>
        <td>
            <?php if($dt['idestadoTest']==0){?>
                Sin realizar
            <?php }else{?>
                <?php if($dt["estadoAlerta"]==1){?>
                    Realizado
                <?php }else if($dt["estadoAlerta"]==2){?>
                    Por Vencer
                <?php }else{?>
                    Vencido
                <?php }?>
            <?php }?>
        </td>
        <td><?php echo $dt["eventoActual"]?></td>
        <td><?php echo $dt["fechaIngreso"]?></td>
        <td><?php echo $dt["fechaProximoTest"]?></td>
        <td><?php echo $dt["fechaTest"]?></td>
        <td>
            <button class="btn btn-outline-primary btn-sm btnHisto" data-vin="<?php echo $dt["vin"]?>"><i class="fas fa-table"></i></button>
        </td>
    </tr>
    <?php
    $color='';
}?>