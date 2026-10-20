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
    $hoy=date("Y-m-d");
    $fechaManhana = date("Y-m-d", strtotime($hoy . ' +1 days'));
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>

<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header pb-1">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Reglas Para Vehiculos / <small>(Total de Registros: <?php echo 0?>)</small></h3>

                        </div>
                    </div>
                    <div class="row align-items-center">
                        <!-- Input text -->
                        <div class="col-12 col-md-3 col-lg-2 mb-3" style="padding-left: 2px;padding-right: 2px">
                            <input class="form-control form-control-sm" type="text" id="filtro" placeholder="Input text">
                        </div>
                        <!-- Botones -->
                        <div class="col-12 col-md-3 col-lg-2 d-flex mb-3" style="padding-left: 2px;padding-right: 2px">

                            <button id="btnSearch" class="btn btn-outline-primary btn-sm me-2">Search</button>
                            <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="col-12 col-md-6 col-lg-8 mb-3" style="text-align:right">
                            <button class="btn btn-outline-primary btn-sm" id="btnCreateRegla"><i class="fas fa-plus"></i>&nbsp;Crear Grupo</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg">
                    <input hidden id="totalRegistros">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamientoSol" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th>Grupo Regla</th>
                                <th>Tipo Regla</th>
                                <th>Reglas</th>
                                <th style="width: 5%">Opc</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyGestionar" class="list">
                                <?php
                                $contador=0;
                                foreach($detailIndex as $di){
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td><?php echo $contador?></td>
                                        <td><?php echo $di["nombreGrupo"]?></td>
                                        <td><?php echo $di["tipoAplicacion"]?></td>
                                        <td>
                                            <a href="#" class="btnOpcRegla" data-opcion="viewReglas" data-idgrupoRegla="<?php echo $di["idgrupoRegla"]?>">Ver Reglas +</a><br>
                                        </td>
                                        <td>
                                            <button class="btn btn-subtle-success me-1 mb-1 btn-sm btnOpcRegla" data-opcion="play" data-idgrupoRegla="<?php echo $di["idgrupoRegla"]?>"><i class="fas fa-play"></i></button>
                                            <button class="btn btn-subtle-primary me-1 mb-1 btn-sm btnOpcRegla" data-opcion="edit" data-idgrupoRegla="<?php echo $di["idgrupoRegla"]?>"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-subtle-danger me-1 mb-1 btn-sm btnOpcRegla" data-opcion="delete" data-idgrupoRegla="<?php echo $di["idgrupoRegla"]?>"><i class="fas fa-trash"></i></button>
                                        </td>
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
