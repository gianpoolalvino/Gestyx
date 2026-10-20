<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
$hora=date("H:i:s");
$hoyD = date("Y-m-d H:i:s");

$contador=0;
foreach($detailIndex as $dt){
    $contador++;
    if($dt["fechaEstimadaRetorno"]<$hoy){
        $danger='table-warning';
    }else{
        $danger='';
    }
    ?>
    <tr class="<?php echo $danger?>" style="vertical-align: middle">
        <td><?php echo $contador?></td>
        <td><?php echo $dt["vin"]?></td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["solicitante"]?></td>
        <td><?php echo $dt["agenciaSolicitante"]?></td>
        <td><?php echo $dt["fechaEstimadaRetorno"]?></td>
        <td>
            <?php
            $fechaFact=new DateTime($dt["fechaEstimadaRetorno"]);
            $fechaEnt=new DateTime($hoy);
            $diferencia = $fechaEnt->diff($fechaFact);
            $dias=$diferencia->days;
            if($fechaFact<$fechaEnt){
                echo '-'.$dias;
            }else{
                echo $dias;
            }
            ?>
        </td>
        <td>
            <?php
            if($dt["equipamiento"]!=''){
                $det=explode("@@",$dt["equipamiento"]);
                foreach($det as $dts){
                    $detal=explode("##",$dts);
                    ?>
                    <?php
                    $icon='';
                    if($detal[2]==2){
                        $icon='<i class="fas fa-check text-success"></i>';
                    }else if($detal[2]==1){
                        $icon='<i class="fas fa-times text-danger"></i>';
                    }else{
                        $icon='<i class="far fa-exclamation-triangle text-warning"></i>';
                    }?>
                    <?php echo $icon."&nbsp;".$detal[3]."<br>"?>
                <?php } }?>
        </td>
        <td>
            <?php echo 'En Exhibicion'?>
        </td>
        <td>
            <button class="btn btn-subtle-primary btn-sm btnRetornChasis" data-vin="<?php echo $dt["vin"]?>" data-idexhibicionVin="<?php echo $dt["idexhibicionVin"]?>" type="button"><i class="fas fa-car-garage"></i></button>
        </td>
    </tr>
<?php }?>