<?php
$contador=$countReg;
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dt["vin"]?></td>
        <td>
            <?php echo $dt["nombreCliente"]?>
        </td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["agencia"]?></td>
        <td><?php echo $dt["tipoPlaca"]?></td>
        <td><?php echo $dt["placaAsignada"]?></td>
        <td><?php echo $dt["nombreVendedor"]?></td>
        <td><?php echo $dt["asesor"]?></td>
        <td><?php echo $dt["fecha"]?></td>
        <td><?php echo $dt["horaAgendaInicio"]?></td>
        <td><?php echo $dt["numeroTitulo"]?></td>
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
            <?php if($dt["gas"]==1){?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">Requiere</span></h5>
            <?php }else if($dt["gas"]==2){?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary">Instalado</span></h5>
            <?php }else if($dt["gas"]==3){?>
                <h5><span class="badge badge-phoenix badge-phoenix-warning">VALIDANDO</span></h5>
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
                        <?php } }} }?>
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
                        <?php } }} }?>
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
        <td>
            <?php echo $dt["comentarioEntrega"]?>
        </td>
        <td>
            <?php
            $disabled='';
            if($requeridoEntrega==1){
                if($dt["liberado"]==1){
                    $disabled='';
                }else{
                    $disabled='disabled';
                }
            }?>
            <?php if($dt["idestadoEntrega"]==1){?>
                <button class="btn btn-subtle-warning btn-sm btnStartEntrega" <?php echo $disabled?> data-vin="<?php echo $dt["vin"]?>" data-idcitaEntrega="<?php echo $dt["idcitaEntrega"]?>">Iniciar Entrega</button>
            <?php }else{?>
                <button class="btn btn-subtle-primary btn-sm btnRestoreEntrega" <?php echo $disabled?> data-vin="<?php echo $dt["vin"]?>" data-idcitaEntrega="<?php echo $dt["idcitaEntrega"]?>">En Proceso</button>
            <?php }?>
        </td>
    </tr>
<?php }?>