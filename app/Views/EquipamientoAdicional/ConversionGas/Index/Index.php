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
                            <h3 class="mb-2">Equipamiento Adicional / <small>Conversion a Gas (Total de Registros: <?php echo $count?>)</small></h3>

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
                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Agencia</th>
                                <th>Tiempo en Evento</th>
                                <th>Prioridad</th>
                                <th>Entrega</th>
                                <th>Conversion Gas</th>
                                <th>Evento Actual</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador=0;
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