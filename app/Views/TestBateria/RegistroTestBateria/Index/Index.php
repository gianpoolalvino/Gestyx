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

    .iframe-container {
        display: none; /* Inicialmente oculto */
        width: 100%;
        height: 20vh; /* Ajusta la altura del div simulado */
        background-color: #ddd; /* Fondo para simular el iframe */
        border: 1px solid #ccc; /* Borde para simular un iframe */
    }

    .iframe-container.active {
        display: block;
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
    $actual=date("Y-m-d");
    $hoy = new DateTime(); // Obtiene la fecha y hora actuales
    $hoy->modify('-15 days'); // Resta 15 días
    $fechaInicio = $hoy->format('Y-m-d'); // Formatea la fecha en formato Y-m-d
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
                            <h3 class="mb-2">Test Bateria / <small>Registro de Test Bateria (Total de Registros: <?php echo $total?>)</small></h3>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 25%">
                                    <select class="form-select form-select-sm" id="tipoFiltro" aria-label=".form-select-sm example">
                                        <option selected value="">Tipo Filtro</option>
                                        <option value="vin">Vin</option>
                                        <option value="ubicacion">Ubicacion</option>
                                        <option value="marca">Marca</option>
                                        <option value="modelo">Modelo</option>
                                        <option value="color">Color</option>
                                    </select>
                                </div>
                                <input class="form-control form-control-sm" id="filtro" style="width: 25%">
                                <div class="input-group-prepend">
                                    <div class="input-group">
                                        <input class="form-control form-control-sm" type="date" value="<?php echo $fechaInicio?>" id="fechaInicio" name="fechaInicio">
                                        <div class="input-group-prepend">
                                            <input class="form-control form-control-sm" type="date" value="<?php echo $actual?>" id="fechaFin" name="fechaFin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" style="text-align: right !important">
                            <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                            <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
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
                                <th>Imagen</th>
                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Estado Vin</th>
                                <th>Ubicacion</th>
                                <th>Estado Test</th>
                                <th>Evento Actual</th>
                                <th>Fecha Test</th>
                                <th>Fecha Proximo Test</th>
                                <th>Fecha Registro Test</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador=0;
                            $color='';
                            foreach($detailIndex as $dt){
                                $contador++;
                                ?>
                                <tr style="vertical-align: middle">
                                    <td style="vertical-align: middle"><?php echo $contador?></td>
                                    <td style="vertical-align: middle">
                                        <?php echo $dt["vin"]?>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <button class="btn btn-sm btn-phoenix-primary btnVerRegistro" data-vin="<?php echo $dt["vin"]?>" data-idbateriaTest="<?php echo $dt["idbateriaTest"]?>" type="button"><i class="fas fa-eye"></i></button>
                                    </td>
                                    <td style="vertical-align: middle"><?php echo $dt["marca"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["modelo"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["color"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["estadoVin"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["ubicacion"]?></td>
                                    <td style="vertical-align: middle">
                                        <?php echo "Realizado"?>
                                    </td>
                                    <td style="vertical-align: middle"><?php echo $dt["eventoActual"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["fechaTest"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["fechaProximoTest"]?></td>
                                    <td style="vertical-align: middle"><?php echo $dt["fechaRegistro"]?></td>

                                </tr>
                                <?php
                                $color='';
                            }?>
                            </tbody>

                        </table>
                    </div>
                    <div class="iframe-container" style="width: 100%; background-color:white" id="iframeContainer">
                        <iframe style="width: 100%" src="<?php echo base_url("Notificacion/Index/NotificacionInferior")?>" id="iframe"></iframe>
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
