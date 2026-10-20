<style>

    .tableFixHead {
        overflow: auto;
        height: calc(100vh - 260px);
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
                            <h3 class="mb-2">Campaña Vehicular / <small>Campaña (Total de Registros: <?php echo $count?>)</small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-md-6 col-lg-6">
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
                        <div class="col-4 col-md-6 col-lg-6 text-right" style="text-align: right">
                            <button class="btn btn-sm btn-primary" type="button" id="btnIndexCcampanhas" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Campañas Creadas</button>

                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg" value="<?php echo $countReg?>">
                    <input hidden id="totalRegistros" value="<?php echo $count?>">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Agencia</th>
                                <th>Bodega / Ubicacion</th>
                                <th>Campañas</th>
                                <th>Estado Vin</th>
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
                                    <td><?php

                                        echo $dt["modelo"]; ?></td>
                                    <td><?php echo $dt["color"]?></td>
                                    <td><?php echo (isset($dt["agencia"]))?$dt["agencia"]:'No Tiene'?></td>
                                    <td><?php echo $dt["bodega"]." / ".((isset($dt["ubicacion"]))?$dt["ubicacion"]:'Sin Ubicacion')?></td>
                                    <td>
                                        <?php
                                        $sincampanha=0;
                                        if($dt["campanhaRealizada"]!=1){?>
                                            <button data-vin="<?php echo $dt["vin"]?>" class="btn btn-sm btn-subtle-secondary me-1 mb-1 btnAddCampanha" type="button">Añadir Campaña</button>
                                        <?php }?>
                                    </td>
                                    <td>


                                        <h5><span class="badge badge-phoenix badge-phoenix-<?php echo $dt["estadoColor"]?>"><?php echo $dt["estadoVin"]?></span></h5>
                                    </td>
                                </tr>
                                <?php
                                $color='';
                            }?>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="card-footer" style="padding-top: 4px;padding-bottom:4px">
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
        </div>
    </div>
</div>