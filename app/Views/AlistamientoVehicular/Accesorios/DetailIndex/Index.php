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
    <tr class="<?php echo $color?>">
        <td class="sticky-col first-col"><?php echo $contador?></td>
        <td class="sticky-column vin"><?php echo ($dt["pegatinaComentarioLlamadaBienvenida"]==1)?'<i class="far fa-info-circle"></i>&nbsp;':''?><a href="#" class="vinAccesorios" data-opcion="Proceso" data-vin="<?php echo $dt["vin"]?>" <?php echo ($dt["pegatinaComentarioLlamadaBienvenida"]==1)?'data-bs-toggle="tooltip" data-bs-placement="bottom" title="Obs. Llamada Bienvenida: '.$dt["comentarioLlamadaBienvenida"].'"':''?> ><?php echo $dt["vin"]?></a></td>
        <td><?php echo $dt["estadoVin"]?></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php
                                        
                                            echo $dt["modelo"];
                                     
                                        ?></td>
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
            <?php if(!is_null($dt["urgente"])){?>
                <?php if($dt["urgente"]==1){?>
                    <span class="badge badge-phoenix badge-phoenix-danger">Urgente</span>
                <?php }else if($dt["urgente"]==2){?>
                    <span class="badge badge-phoenix badge-phoenix-warning">Moderado</span>
                <?php }else{?>
                    <span class="badge badge-phoenix badge-phoenix-info">Baja</span>
                <?php }?>
            <?php }else{?>
                <span class="badge badge-phoenix badge-phoenix-info">Baja</span>
            <?php }?>
        </td>
        <td><?php echo $dt["ubicacionActual"]?></td>
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
            <?php if($dt["gps"]==1){?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">GPS</span></h5>
            <?php }else if($dt["gps"]==2){?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary">GPS</span></h5>
            <?php }else if($dt["gps"]==3){?>
                <h5><span class="badge badge-phoenix badge-phoenix-warning">GPS</span></h5>
            <?php }?>
        </td>
        <td>
            <?php if(!is_null($dt["gas"])){?>
                <?php if($dt["gas"]==1){?>
                    <h5><span class="badge badge-phoenix badge-phoenix-danger">Requiere</span></h5>
                <?php }else if($dt["gas"]==2){?>
                    <h5><span class="badge badge-phoenix badge-phoenix-primary">Instalado</span></h5>
                <?php }else if($dt["gas"]==3){?>
                    <h5><span class="badge badge-phoenix badge-phoenix-warning">VALIDANDO</span></h5>
                <?php }?>
            <?php }else{?>
                <?php
                if ($dt["equipamiento"] != '') {
                    $det = explode("@@", $dt["equipamiento"]);
                    foreach ($det as $dts) {
                        $detal = explode("##", $dts);
                        if(isset($detal[3])){
                        // Verificar si $detal[3] contiene "GNV" o "GLP"
                        if (strpos($detal[3], 'GNV') !== false || strpos($detal[3], 'GLP') !== false) {
                            // Determinar el icono según el estado
                            $icon = '';
                            if ($detal[2] == 2) { ?>
                                <h5><span class="badge badge-phoenix badge-phoenix-primary">Instalado</span></h5>
                            <?php } else if ($detal[2] == 1) { ?>
                                <h5><span class="badge badge-phoenix badge-phoenix-danger">Requiere</span></h5>
                            <?php }
                        }
                        }
                    }
                }
                ?>
            <?php }?>
        </td>
        <td>
            <?php
            if($dt["equipamiento"]!=''){
                $det=explode("@@",$dt["equipamiento"]);
                foreach($det as $dts){
                    $detal=explode("##",$dts);
                    if(isset($detal[3])){
                    if (strpos($detal[3], 'KIT DE SEGU') !== false) {
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
                    <?php } } } }?>
        </td>
        <td>
            <?php
            if($dt["equipamiento"]!=''){
                $det=explode("@@",$dt["equipamiento"]);
                foreach($det as $dts){
                    $detal=explode("##",$dts);
                    if(isset($detal[3])){
                    if (strpos($detal[3], 'LAMINA') !== false) {
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
                    <?php } } } }?>
        </td>
        <td>
            <?php
            if ($dt["equipamiento"] != '') {
                $det = explode("@@", $dt["equipamiento"]);
                foreach ($det as $dts) {
                    $detal = explode("##", $dts);
                    if(isset($detal[3])){
                    // Verificar si $detal[3] no contiene ninguna de las palabras especificadas
                    $exclude = false;
                    $excludedWords = ['KIT DE SEGU', 'LAMINA', 'GPS', 'GNV', 'GLP'];
                    foreach ($excludedWords as $word) {
                        if (strpos($detal[3], $word) !== false) {
                            $exclude = true;
                            break;
                        }
                    }

                    if (!$exclude) {
                        // Determinar el icono según el estado
                        $icon = '';
                        if ($detal[2] == 2) {
                            $icon = '<i class="fas fa-check text-success"></i>';
                        } else if ($detal[2] == 1) {
                            $icon = '<i class="fas fa-times text-danger"></i>';
                        } else {
                            $icon = '<i class="far fa-exclamation-triangle text-warning"></i>';
                        }

                        // Mostrar el ícono y el texto
                        echo $icon . "&nbsp;" . $detal[3] . "<br>";
                    }
                }}
            }
            ?>
        </td>
        <td><?php echo $dt["numeroPedido"]?></td>
    </tr>
<?php
    $color='';
}?>