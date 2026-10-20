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
                            <h3 class="mb-2">Comisiones / <small>Vehiculos con Bono (Total de Registros: <?php echo isset($count)?$count:''?>)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="form-select form-control-sm" style="height:31px" id="marca">
                                                <option value="">Todos</option>
                                                <?php foreach($selectMarca as $mr){?>
                                                    <option value="<?php echo $mr["idmarca"]?>"><?php echo $mr["descripcion"]?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group-append">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-success btn-sm" type="button" id="btnExcelUpload"><i class="fas fa-file-excel"></i>&nbsp;Subir Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Marca</th>
                                <th>Fecha Carga</th>
                                <th>Codigo Modelo</th>
                                <th>Modelo</th>
                                <th>Tipo Cargas</th>
                                <th>Bono Aplicado</th>
                                <th>Opc</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                                <?php
                                $contador=0;
                                foreach($detailIndex as $di){
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td><?php echo $contador?></td>
                                        <td><?php echo $di["marca"]?></td>
                                        <td></td>
                                        <td><?php echo $di["codigoModelo"]?></td>
                                        <td><?php echo $di["modelo"]?></td>
                                        <td>Carga de Bono</td>
                                        <td><?php echo $di["bono"]?></td>
                                        <td></td>
                                    </tr>
                                <?php }?>
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