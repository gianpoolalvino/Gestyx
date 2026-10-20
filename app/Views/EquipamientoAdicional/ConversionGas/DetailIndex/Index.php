<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
$hoyD = date("Y-m-d H:i:s");
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
        <td><?php echo $dt["agencia"]?></td>
        <td>
            <?php
            $fechaInicio = new DateTime($dt["fechaEventoActual"] . " " . $dt["horaEventoActual"]);
            $fechaFin = new DateTime($hoyD);
            $intervalo = $fechaInicio->diff($fechaFin);
            if ($intervalo->d == 0 || $intervalo->d < 2) {
                echo "<i class='far fa-clock text-success'></i>&nbsp;" . (($intervalo->d>0)?$intervalo->d." Dias&nbsp;":'').(($intervalo->h>0)?$intervalo->h." horas&nbsp;":'').$intervalo->i . " minutos ";
            } else if ($intervalo->d > 2 || $intervalo->d < 3) {
                echo "<i class='fas fa-clock text-warning'></i>&nbsp;" . (($intervalo->d>0)?$intervalo->d." Dias&nbsp;":'').(($intervalo->h>0)?$intervalo->h." horas&nbsp;":'').$intervalo->i . " minutos ";
            } else if ($intervalo->d > 3) {
                echo "<i class='fas fa-clock text-danger'></i>&nbsp;" . (($intervalo->d>0)?$intervalo->d." Dias&nbsp;":'').(($intervalo->h>0)?$intervalo->h." horas&nbsp;":'').$intervalo->i . " minutos ";
            }
            ?>
        </td>
        <td>
            <h5><span class="badge badge-phoenix badge-phoenix-success">Baja</span></h5>
        </td>
        <td>
            <?php
            $days='';
            if($dt["fechaCancelado"]!=''){
                $fechaFact=date("Y-m-d",strtotime($dt["fechaCancelado"]));
                $fechaEnt=date("Y-m-d",strtotime($fechaFact."+ 20 days"));
                $fecha1=date_create($hoy);
                $fecha2=date_create($fechaEnt);
                $diff=date_diff($fecha1,$fecha2);
                $days=str_replace('+','',$diff->format('%R%a'));
            }else{
                $days=20;
            }
            ?>
            <?php echo $days?>
        </td>
        <td>
            <?php if($dt["gas"]==1){?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">REQUIERE</span></h5>
            <?php }else if($dt["gas"]==2){?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary">CONVERTIDO</span></h5>
            <?php }else if($dt["gas"]==3){?>
                <h5><span class="badge badge-phoenix badge-phoenix-warning">VALIDANDO</span></h5>
            <?php }?>
        </td>
        <td><?php echo $dt["eventoActual"]?></td>
    </tr>
    <?php
    $color='';
}?>