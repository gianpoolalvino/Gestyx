<style>

    .tableFixHead {
        overflow: auto;
        height: calc(100vh - 184px);
        white-space: nowrap;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background:#141824;
        color:white
    }

    /* Just common table stuff. Really. */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    .fixed-bottom {
        padding-top: 8px;
        padding-bottom: 8px;
        border-top: solid 1.5px #b9b9b9;
    }

    <?php
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>
<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Agendamiento / <small>Mis Agendados (Total de Registros: <?php echo $count?>)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 35%">
                                    <select class="form-select form-select-sm" id="tipoFiltro" aria-label=".form-select-sm example">
                                        <option selected value="">Tipo Filtro</option>
                                        <option value="vin">Vin</option>
                                        <option value="documentoCliente">Documento Cliente</option>
                                        <option value="nombreCliente">Nombre Cliente</option>
                                        <option value="modelo">Modelo</option>
                                    </select>
                                </div>
                                <input class="form-control form-control-sm" id="filtro" style="width: 35%">
                                <div class="input-group-prepend">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg" value="<?php echo $countReg?>">
                    <input hidden id="totalRegistros" value="<?php echo $count?>">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th>Cliente</th>
                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Agencia</th>
                                <th>Tipo Placa</th>
                                <th>Placa</th>
                                <th>Vendedor</th>
                                <th>Asesor Entrega</th>
                                <th>Fecha</th>
                                <th>Hora Entrega</th>
                                <th>Nro titulo</th>
                                <th>GPS</th>
                                <th>Conversion GAS</th>
                                <th>Kit de Seguros</th>
                                <th>Laminas</th>
                                <th>Otros</th>
                                <th>Entrega</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador=0;
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
                                <?php
                                $disabled='';
                            }?>
                            </tbody>
                            <tfoot id="cargarData">
                            <tr>
                                <td colspan="14" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando Datos...</span>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>