<?php
date_default_timezone_set("America/Lima");
$hoyD=date("Y-m-d");
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    if(!is_null($dt["saldoPendiente"])){
        if($dt["saldoPendiente"]>0){
            $color='table-danger';
        }
    }
    $contador++;
    ?>
    <tr class="<?php echo $color?>" id="<?php echo $contador?>">
        <td class="sticky-column"><?php echo $contador?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso" data-estadoVin="<?php echo $dt["idestadoVin"]?>" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php
                                        
                                            echo $dt["modelo"];
                                       
                                        ?></td>
        <td><?php echo $dt["color"]?></td>

        <td><?php echo $dt["bodega"]?></td>
        <td><?php echo $dt["numeroTitulo"]?></td>
        <td><?php echo $dt["fechaInicio"]?></td>
        <td>

            <?php
            $fechaInicio = new DateTime($dt["fechaInicio"] . " " . $dt["horaInicio"]);
            $fechaFin = new DateTime($hoyD);
            $intervalo = $fechaInicio->diff($fechaFin);
            if ($intervalo->d == 0 || $intervalo->d < 2) {
                echo "<i class='far fa-clock text-success'></i>&nbsp;" . (($intervalo->d>0)?$intervalo->d." Dias&nbsp;":'').(($intervalo->h>0)?$intervalo->h." horas&nbsp;":'').$intervalo->i . " minutos ";
            } else if ($intervalo->d > 2 || $intervalo->d < 3) {
                echo "<i class='far fa-clock text-warning'></i>&nbsp;" . (($intervalo->d>0)?$intervalo->d." Dias&nbsp;":'').(($intervalo->h>0)?$intervalo->h." horas&nbsp;":'').$intervalo->i . " minutos ";
            } else if ($intervalo->d > 3) {
                echo "<i class='far fa-clock text-danger'></i>&nbsp;" . (($intervalo->d>0)?$intervalo->d." Dias&nbsp;":'').(($intervalo->h>0)?$intervalo->h." horas&nbsp;":'').$intervalo->i . " minutos ";
            }
            ?>
        </td>
        <td>
            <?php if(is_null($dt["ideventoActual"])){?>
                <a href=""><h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Eventos</span></h5></a>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["eventoActual"]?></span></h5>
            <?php }?>
        </td>
    </tr>
    <?php
    $color='';
}?>