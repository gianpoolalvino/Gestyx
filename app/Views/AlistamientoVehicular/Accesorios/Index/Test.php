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
    ?>
</style>
<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

        <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
            <div class="card-header">
                <div class="row g-4">
                    <div class="col-12">
                        <h3 class="mb-2">Alistamiento Vehicular / <small>Accesorios</small></h3>
                        <?php echo $count?>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-3">
                        <div class="input-group">
                            <div class="input-group-append" style="width: 45%">
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                    <option selected="">Tipo Filtro</option>
                                    <option value="vin">Vin</option>
                                    <option value="documentoCliente">Documento Cliente</option>
                                    <option value="nombreCliente">Nombre Cliente</option>
                                    <option value="modelo">Modelo</option>
                                    <option value="gps">GPS</option>
                                </select>
                            </div>
                            <input class="form-control form-control-sm" style="width: 35%">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary btn-sm">Filtrar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <form method="POST" id="formFiltro" action="<?php echo base_url("AlistamientoVehicular/Accesorios/Index/DetailIndex")?>">
                            <div id="panelform">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding:0px">
                <div class="tableFixHead">
                    <table class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="sort" data-sort="vin">Vin</th>
                            <th class="sort"  data-sort="marca">Marca</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Agencia</th>
                            <th>Prioridad</th>
                            <th>Entrega</th>
                            <th>GPS</th>
                            <th>Cliente</th>
                            <th>Accesorios</th>
                            <th>Nro Pedido</th>
                            <th>Evento Actual</th>
                            <th>Opc</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <?php
                        $contador=0;
                        foreach($detailIndex as $dt){
                            $contador++;
                            ?>
                            <tr>
                                <td><?php echo $contador?></td>
                                <td class="vin"><?php echo $dt["vin"]?></td>
                                <td class="marca"><?php echo $dt["marca"]?></td>
                                <td><?php echo $dt["familia"]?></td>
                                <td><?php echo $dt["color"]?></td>
                                <td><?php echo $dt["agencia"]?></td>
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
                                    <?php if($dt["gps"]==1){?>
                                        <h5><span class="badge badge-phoenix badge-phoenix-primary">GPS</span></h5>
                                    <?php }?>
                                </td>
                                <td>
                                    <strong>Cliente:</strong>&nbsp;<?php echo $dt["nombreCliente"]?><br>
                                    <strong>Documento:</strong>&nbsp;<?php echo $dt["documentoCliente"]?><br>
                                    <strong>Cel:</strong>&nbsp;<?php echo $dt["telefonoCliente"]?><br>
                                    <strong>Correo:</strong>&nbsp;<?php echo $dt["correoCliente"]?>
                                </td>
                                <td>

                                </td>
                                <td><?php echo $dt["numeroPedido"]?></td>
                                <td><?php echo $dt["eventoActual"]?></td>
                                <td>
                                    <button class="btn btn-subtle-success me-1 mb-1 btnVehiculo" data-opcion="Info" data-vin="<?php echo $dt["vin"]?>" type="button"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-subtle-info me-1 mb-1 btnVehiculo" data-opcion="Edit" data-vin="<?php echo $dt["vin"]?>" type="button"><i class="fas fa-cog"></i></button>
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