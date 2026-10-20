<style>
    /* Contenedor principal fijo */
    /* Contenedor principal fijo */
    .content {
        position: fixed;
        top: 65px;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1000;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .content {
        padding-bottom: 60px; /* Ajuste para evitar que el contenido se solape con el footer */
    }

    /* Ajuste para la tabla y que se mantenga scrollable */
    .tableFixHead {
        overflow: auto;
        flex-grow: 1;
        white-space: nowrap;
        padding-bottom: 10px;
        max-height: calc(100vh - 250px); /* Ajuste de altura, dependiendo de la cabecera */
    }

    /* Encabezado fijo de la tabla */
    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #141824;
        color: white;
    }

    /* Card Footer no debe ocultarse */
    .card-footer {
        padding-top: 8px;
        padding-bottom: 8px;

        flex-shrink: 0; /* Evita que el pie de página se contraiga */
    }

    /* Estilos generales de la tabla */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    /* Responsivo: Evitar que el card footer se oculte en pantallas pequeñas */
    @media (max-width: 767px) {
        .content {
            padding-top: 3rem; /* Ajusta el padding superior para que se vea correctamente */
        }

        .tableFixHead {
            max-height: calc(100vh - 370px); /* Ajuste en pantallas pequeñas */

        }

        .card-footer {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    }

    /* Asegura que el footer no se oculte */
    @media (max-width: 576px) {
        .card-footer {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }

    .fixed-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 2px 0; /* Espaciado del footer */
        text-align: center; /* Centra el contenido */
        z-index: 1000; /* Asegura que esté por encima del contenido */
    }

    <?php
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>

<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 0rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Vehiculos Vendidos / <small>Facturados (Total de Registros: <?php echo $total?>)</small></h3>

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
                                        <option value="telefonoCliente">Telefono Cliente</option>
                                        <option value="agencia">Agencia</option>
                                        <option value="nombreVendedor">Nombre Vendedor</option>
                                        <option value="marca">Marca</option>
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
                        <div class="col-12 col-md-6 col-lg-6" style="text-align: right !important">
                            <button class="btn btn-info btn-sm" id="btnOrdenar"><i class="fas fa-filter"></i>&nbsp;Ordenar</button>
                            <?php
                            $retorn=session("permitirRetornarEvento");
                            ?>
                            <?php if(isset($retorn)){?>
                                    <?php if($retorn==1){?>
                                        <button class="btn btn-outline-secondary btn-sm" id="btnRetornEvent">Retornar Evento</button>
                                    <?php }?>
                            <?php }?>
                            <button class="btn btn-outline-success btn-sm" id="btnCreateExcel" type="button"><i class="fas fa-file-excel"></i>&nbsp;Excel</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="20">
                    <input hidden id="countReg" value="<?php echo $countReg?>">
                    <input hidden id="totalRegistros" value="<?php echo $count?>">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th>Fec. Limite Entrega</th>
                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Agencia</th>
                                <th>Prioridad</th>
                                <th>Documento Cliente</th>
                                <th>Cliente</th>
                                <th>Tipo de Negocio</th>
                                <th>Evento Actual</th>
                                <th>Liberado por Cartera</th>
                                <th>Revision de Campañas</th>
                                <th>Bodega</th>
                                <th>Ubicacion</th>
                                <th>GPS</th>
                                <th>Gas</th>
                                <th>Vendedor</th>
                                <th>F. Cita Entrega</th>
                                <th>Tipo Placa</th>
                                <th>Placa</th>
                                <th>F. Factura</th>
                                <th>Factura</th>
                                <th>F. Cancelado</th>
                                <th>Saldo</th>
                                <th>Nro Pedido</th>
                                <th>Fecha Compra</th>
                                <th>Pago a Marca</th>
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
                                    <td class="sticky-column vin">
                                        <a href="#" class="vinAccesorios" data-opcion="Proceso" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a>&nbsp;
                                        <a href="<?php echo base_url("VinAdministrador/Operaciones?vin=").$dt["vin"]?>"><i class="fas fa-share"></i></a>
                                    </td>
                                    <td><?php echo $dt["fechaProximaEntrega"]?></td>
                                    <td class="marca"><?php echo $dt["marca"]?></td>
                                    <td><?php
                                        $parte_despues_del_guion = substr(strstr($dt["modelo"], '-'), 1);
                                        echo ($parte_despues_del_guion=='')?$dt["modelo"]:$parte_despues_del_guion; ?></td>
                                    <td><?php echo $dt["color"]?></td>
                                    <td><?php echo $dt["agencia"]?></td>
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
                                    <td><?php echo $dt["documentoCliente"]?></td>
                                    <td><?php echo $dt["nombreCliente"]?></td>
                                    <td><?php echo $dt["tipoNegocio"]?></td>
                                    <td>

                                            <a class="badge badge-phoenix badge-phoenix-info"><?php echo $dt["eventoActual"]?></a>

                                    </td>
                                    <td>
                                        <?php if($dt["liberadoCartera"]==2){?>
                                            <h5><span class="badge badge-phoenix badge-phoenix-warning">No</span></h5>
                                        <?php }else{?>
                                            <h5><span class="badge badge-phoenix badge-phoenix-success">Si</span></h5>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if($dt["revisionCampanha"]==1){?>
                                            <h5><span class="badge badge-phoenix badge-phoenix-success">Si</span></h5>
                                        <?php }else{?>
                                            <h5><span class="badge badge-phoenix badge-phoenix-warning">No</span></h5>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php echo $dt["bodega"]?>
                                    </td>
                                    <td>
                                        <?php echo $dt["ubicacionActual"]?>
                                    </td>
                                    <td>
                                        <?php if(!is_null($dt["gps"])){?>
                                            <?php if($dt["gps"]==1){?>
                                                <h5><span class="badge badge-phoenix badge-phoenix-warning">No Instalado</span></h5>
                                            <?php }else{?>
                                                <h5><span class="badge badge-phoenix badge-phoenix-success">Instalado</span></h5>
                                            <?php }?>
                                        <?php }else{?>
                                            <h5><span class="badge badge-phoenix badge-phoenix-danger">No Requiere</span></h5>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if(!is_null($dt["gas"])){?>
                                            <?php if($dt["gas"]==1){?>
                                                <h5><span class="badge badge-phoenix badge-phoenix-warning">No Instalado</span></h5>
                                            <?php }else{?>
                                                <h5><span class="badge badge-phoenix badge-phoenix-success">Instalado</span></h5>
                                            <?php }?>
                                        <?php }else{?>
                                            <h5><span class="badge badge-phoenix badge-phoenix-danger">No Requiere</span></h5>
                                        <?php }?>
                                    </td>
                                    <td><?php echo $dt["nombreVendedor"]?></td>
                                    <td>
                                        <?php echo $dt["fechaAgendado"]." ".$dt["horaAgendado"]?>
                                    </td>
                                    <td>
                                        <?php echo ($dt["tipoPlaca"]!='')?$dt["tipoPlaca"]:'Sin Placa'?>
                                    </td>
                                    <td>
                                        <?php echo $dt["placa"]?>
                                    </td>
                                    <td><?php echo $dt["fechaFactura"]?></td>
                                    <td>
                                        <?php echo $dt["numeroFactura"]?>
                                    </td>
                                    <td>
                                        <?php echo $dt["fechaCancelado"]?>
                                    </td>
                                    <td>
                                        <?php
                                        $estadoVin='';
                                        if($dt["fechaCancelado"]!=''){
                                            $estadoVin='<h5><span class="badge badge-phoenix badge-phoenix-success">Cancelado</span></h5>';
                                        }else{
                                            $estadoVin='<h5><span class="badge badge-phoenix badge-phoenix-danger">'.$dt["saldoPendiente"].'</span></h5>';
                                        }
                                        echo $estadoVin;
                                        ?>
                                    </td>

                                    <td><?php echo $dt["numeroPedido"]?></td>
                                    <td><?php echo $dt["fechaCompra"]?></td>
                                    <td><?php echo ($dt["canceladoProveedor"]==1)?'Cancelado':'Pendiente Pago'?></td>
                                </tr>
                                <?php
                                $color='';
                            }?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-footer">
        <div class="row">
            <div class="col-12">
                <div id="pagination">
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <!-- Página anterior -->
                                <?php if ($pagina > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" onclick="changePage(<?= $pagina - 1; ?>)" aria-label="Previous">
                                            <span class="fas fa-chevron-left"> </span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Mostrar páginas de 5 en 5 -->
                                <?php
                                $range = 10;
                                $startPage = max(1, $pagina - floor($range / 2));
                                $endPage = min($totalPages, $startPage + $range - 1);

                                if ($endPage - $startPage + 1 < $range) {
                                    $startPage = max(1, $endPage - $range + 1);
                                }

                                for ($i = $startPage; $i <= $endPage; $i++):
                                    ?>
                                    <li class="page-item <?= ($pagina == $i) ? 'active' : ''; ?>">
                                        <a class="page-link" href="javascript:void(0)" onclick="changePage(<?= $i; ?>)"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Página siguiente -->
                                <?php if ($pagina < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" onclick="changePage(<?= $pagina + 1; ?>)" aria-label="Next">
                                            <span class="fas fa-chevron-right"></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

