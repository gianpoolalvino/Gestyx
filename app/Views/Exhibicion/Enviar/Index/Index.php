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
                            <h3 class="mb-2">Exhibicion / <small>Enviar a Exhibicion (Total de Registros: <?php echo (isset($count)?'':'')?>)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 35%">
                                    <select class="form-select form-select-sm" id="tipoFiltro" aria-label=".form-select-sm example">
                                        <option selected value="">Todos</option>
                                        <option value="vn.vin">Vin</option>
                                        <option value="vn.modelo">Modelo</option>
                                        <option value="vvn.color">Color</option>
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
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>

                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Solicitante</th>
                                <th>Agencia Solicitante</th>
                                <th>Fecha Estimada Envio</th>
                                <th>Fecha Estimada Retorno</th>
                                <th>Accesorios</th>
                                <th>Estado Vin</th>
                                <th>
                                    Accion
                                </th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                                <?php
                                $contador=0;
                                foreach($detailIndex as $dt){
                                    $contador++;
                                    ?>
                                    <tr style="vertical-align: middle">
                                        <td><?php echo $contador?></td>
                                        <td><?php echo $dt["vin"]?></td>

                                        <td><?php echo $dt["marca"]?></td>
                                        <td><?php echo $dt["modelo"]?></td>
                                        <td><?php echo $dt["color"]?></td>
                                        <td><?php echo $dt["solicitante"]?></td>
                                        <td><?php echo $dt["agenciaSolicitante"]?></td>
                                        <td><?php echo $dt["fechaEstimadaEnvio"]?></td>
                                        <td><?php echo $dt["fechaEstimadaRetorno"]?></td>
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
                                            <?php echo 'Pendiente Envio'?>
                                        </td>
                                        <td>
                                            <button class="btn btn-subtle-success btn-sm btnSendExhibicion" data-vin="<?php echo $dt["vin"]?>" data-idexhibicionVin="<?php echo $dt["idexhibicionVin"]?>" type="button"><i class="fas fa-cars"></i></button>
                                            <button class="btn btn-subtle-danger btn-sm btnRetornChasis" data-vin="<?php echo $dt["vin"]?>" data-idexhibicionVin="<?php echo $dt["idexhibicionVin"]?>" type="button"><i class="fas fa-undo-alt"></i></button>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>