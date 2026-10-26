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
<div class="content " style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">
            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header" style="padding-bottom: 4px">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Ingreso Vehicular <small>(Total de Registros: <?php echo 0?>)</small></h3>
                        </div>
                    </div>
                    <form action="<?php echo base_url("ExcelExport/Agendamiento/ExportAgendados")?>" method="POST" class="w-100 d-flex flex-md-row justify-content-between gap-4 flex-column">
                        <!-- <div class="d-flex justify-content-between gap-4"> -->
                            <div class="w-sm-50 p-2 w-100 ">
                                <div class="input-group">
                                    <input class="form-control form-control-sm"  placeholder="Ingrese Busqueda..." autocomplete="off" id="filtro" name="filtro" style="width: 35%">
                                    <div class="input-group-prepend">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <input class="form-control form-control-sm" type="date" name="fechaInicio" id="fechaInicio" value="<?php echo $hoy?>" max="<?php echo $hoy?>">
                                            </div>
                                            <div class="input-group-prepend">
                                                <input class="form-control form-control-sm" type="date" name="fechaFin" id="fechaFin" value="<?php echo $hoy?>" max="<?php echo $hoy?>">
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 d-flex flex-wrap justify-content-md-end gap-2">
                                <button class="btn btn-outline-primary btn-sm btn" id="btnCreateVehicle" type="button"><i class="fas fa-camera"></i>&nbsp;Crear Vehiculo</button>
                                <button class="btn btn-outline-info btn-sm" id="btnPanelCreado" type="button"><i class="fas fa-eye"></i>&nbsp;Vins Creados</button>
                                <button class="btn btn-primary btn-sm" type="button" id="btnPrintQr"><i class="fas fa-qrcode"></i>&nbsp;Generar Qrs</button>
                                <button class="btn btn-dark btn-sm" id="btnNewIngreso" type="button"><i class="fas fa-registered"></i>&nbsp;Nuevo Ingreso</button>
                                <button class="btn btn-success btn-sm" type="button" id="btnReportExc"><i class="fas fa-file-excel"></i>&nbsp;Excel</button>
                            </div>
                        <!-- </div> -->
                    </form>
                </div>
                <div class="card-body flex-grow-1 overflow-hidden">
                    <div class="tableFixHead h-100" id="tableAccess">

                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="d-none d-md-table-cell sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th class="d-none d-md-table-cell">Estado</th>
                                <th class="sort d-none d-md-table-cell" data-sort="marca">Marca</th>
                                <th class="d-none d-md-table-cell">Modelo</th>
                                <th class="d-none d-md-table-cell">Color</th>
                                <th class="d-none d-md-table-cell">Bodega</th>
                                <th class="d-none d-md-table-cell">Ubicacion</th>
                                <th class="d-none d-md-table-cell">Fecha Ingreso</th>
                                <th class="d-none d-md-table-cell">Hora Ingreso</th>
                                <th class="d-none d-md-table-cell">Acciones</th>
                            </tr>
                            </thead>

                            <tbody id="tbodyAlistamiento" class="list">
                                <?php echo view("IngresoVin/DetailIndex/Index", ["detailIndex" => $detailIndex]);?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>