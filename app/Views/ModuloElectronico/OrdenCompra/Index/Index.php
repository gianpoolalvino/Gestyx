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
    @media (max-width: 768px) {
        .container {
            flex-wrap: wrap; /* Permite que los inputs se envuelvan en nuevas filas si no caben en una fila */
        }

        .input-box {
            flex: 1 1 45%; /* En pantallas más pequeñas, cada input ocupará hasta el 45% del ancho del contenedor */
        }
    }
    @media (max-width: 480px) {
        .input-box {
            flex: 1 1 100%; /* En pantallas más pequeñas, cada input ocupará el 100% del ancho del contenedor */
        }
    }

    .containerDiv {
        display: flex;
        width: 100%; /* Ajusta la altura al 100% de la ventana del navegador */
        box-sizing: border-box;
        gap: 10px; /* Espacio entre los inputs */
        padding: 0px; /* Espacio interno del contenedor */
    }

    .input-box {
        flex: 1; /* Cada input ocupa el mismo espacio disponible */
        min-width: 0; /* Asegura que los inputs se reduzcan en tamaño si es necesario */
        box-sizing: border-box; /* Incluye el padding y border en el cálculo del ancho */
        border: 1px solid #ccc;
        border-radius: 4px;
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
                            <h3 class="mb-2">Modulo Electronico / <small>Ordenes de Compra (Total de
                                    Registros:)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="containerDiv">
                                <select class="form-control form-control-sm input-box" id="tipoOc">
                                    <option value="todos">Todos</option>
                                    <option value="conFactura">Con Facturas</option>
                                    <option value="sinFactura">Sin Facturas</option>
                                </select>
                                <input class="form-control form-control-sm input-box" type="date" value="<?php echo $hoy?>" id="fechaInicio">
                                <input class="form-control form-control-sm input-box" type="date" value="<?php echo $hoy?>" id="fechaFin">
                                <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i
                                            class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover">
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Nro OC</th>
                                <th class="sort" data-sort="marca">Factura</th>
                                <th>Fecha Emision</th>
                                <th>Usuario</th>
                                <th>Bodega</th>
                                <th>Centro de Costo</th>
                                <th>Doc. Proveedor</th>
                                <th>Proveedor</th>
                                <th>En WebService</th>
                                <th>Total</th>
                                <th>Opc.</th>
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