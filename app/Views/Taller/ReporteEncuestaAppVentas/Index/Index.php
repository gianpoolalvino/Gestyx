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
        background: #141824;
        color: white
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
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Taller / <small>Reporte de Encuestas por Ventas (App de Encuestas)</small></h3>
                        </div>
                    </div>
                    <div class="row g-4">
                        <form action="<?php echo base_url("Taller/ReporteEncuestaAppVentas/Index/DetailIndexExcel")?>" method="POST">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="input-group">
                                <input class="form-control form-control-sm" value="<?php echo $hoy?>" name="fechaInicio" type="date" id="fechaInicio">
                                <div class="input-group-append">
                                    <input class="form-control form-control-sm" value="<?php echo $hoy?>" name="fechaFin" type="date" id="fechaFin">
                                </div>
                                <div class="input-group-prepend">
                                    <button id="btnSearch" type="button" class="btn btn-outline-primary btn-sm">Buscar</button>
                                    <button class="btn btn-outline-success btn-sm" type="submit"><i class="fas fa-file-excel"></i>&nbsp;Excel</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover">
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th>Tipo Encuesta</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Agencia</th>
                                <th class="sort" data-sort="marca">Asesor</th>
                                <th>Documento</th>
                                <th>Calificacion Autoniza</th>
                                <th>Calificacion Marca</th>
                                <th>Celular</th>
                                <th>Correo</th>
                                <th>Medio de Comunicacion</th>
                                <th>Opc</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>