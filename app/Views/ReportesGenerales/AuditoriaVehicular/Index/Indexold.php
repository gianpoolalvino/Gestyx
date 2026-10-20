<style>

    #result {
        border-top:none !important;
        border-left: 0.1px solid #7b7b7b;
        border-right: 0.1px solid #7b7b7b;
        border-bottom: none !important;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        top: 36px;
        z-index: 1000;
        width: calc(100% - 1rem); /* Alinea con el input */
        margin-top: -1px; /* Para que se vea como parte del input */
        border-radius: 0 0 0.25rem 0.25rem; /* Bordes redondeados */
    }

    .result-item {
        padding: 10px;
        font-size:12px;
        cursor: pointer;
        backdrop-filter: blur(10px);
    }

    .result-item:hover {
        background: #4f4f4f; /* Fondo claro al pasar el mouse */
        color:white
    }

    .tableFixHeadv2 {
        overflow: auto;
        height: 160px;
        white-space: nowrap;
    }

    .tableFixHeadv2 thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #141824;
        color: white
    }


    .tableFixHead {
        overflow: auto;
        height: calc(39.8vh - 184px);
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
    .parte1, .parte2 {
        overflow-y: auto; /* Permite el desplazamiento vertical */
        overflow-x:hidden;
        padding: 0.2rem; /* Añade algo de espacio interior */
        box-sizing: border-box; /* Incluye el padding en el tamaño total */
    }

    .parte1 {
        flex: 40%; /* 60% de la anchura */
        display: flex;
        flex-direction: column;
    }

    .parte2 {
        flex: 60%; /* 40% de la anchura */

    }

    .subparte1 {
        flex: 0 0 65%; /* 65% de la altura */
        overflow-y: auto; /* Permite el desplazamiento vertical */
        padding-bottom: 5px;
    }

    .subparte2 {
        flex: 0 0 35%; /* 35% de la altura */
        overflow-y: auto; /* Permite el desplazamiento vertical */
        padding-bottom: 5px;
    }

    .subparte3{
        flex: 0 0 23%; /* 65% de la altura */
        overflow-y: auto; /* Permite el desplazamiento vertical */
        padding-bottom: 5px;
    }
    .subparte4{
        flex: 0 0 23%; /* 65% de la altura */
        overflow-y: auto; /* Permite el desplazamiento vertical */
        padding-bottom: 5px;
    }
    .subparte5{
        flex: 0 0 23%; /* 65% de la altura */
        overflow-y: auto; /* Permite el desplazamiento vertical */
        padding-bottom: 5px;
    }
    .subparte6{
        flex: 0 0 10%; /* 65% de la altura */
        overflow-y: auto; /* Permite el desplazamiento vertical */
        padding-bottom: 5px;
    }


    @media (max-width: 768px) {
        .content {
            flex-direction: column; /* Cambia a dirección vertical */
        }

        .parte1, .parte2 {
            flex: none; /* Permite que los divs ocupen el ancho completo */
            width: 100%; /* Asegura que ocupen el 100% del ancho */
        }
    }
</style>
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: row;overflow: hidden;">
    <div class="parte1" style="height: calc(100vh - 67px);">
        <div class="subparte1">
            <div class="card h-100" style="height: 100%">
                <div class="card-header pb-2 pt-2">
                    <div class="input-group">
                        <input class="form-control form-control-sm" id="vinVehicular" placeholder="Ingrese Chasis..." name="vinVehicular">
                        <div id="result"></div>
                    </div>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <div class="row pb-2">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <strong>Datos del Vehiculo</strong>
                                </div>
                                <div class="col-6" style="text-align: right">
                                    <span id="labelEstadoVin" class="badge badge-phoenix badge-phoenix-secondary">Estado Vin</span>
                                </div>
                            </div>

                            <table class="table fs-9 mb-0 border-translucent table-sm">
                                <tr>
                                    <td style="border: none"><span>Marca: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="marcaLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Modelo: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="modeloLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Color: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="colorLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Año Modelo: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="anhoLabel"></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <strong>Datos de Facturacion</strong>
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-translucent table-sm">
                                <tr>
                                    <td style="border: none"><span>Agencia Facturacion: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="agenciaLabel"></strong></td>
                                    <td style="border: none">Asesor Venta: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="vendedorLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Factura: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="facturaLabel"></strong></td>
                                    <td style="border: none">Fecha Factura: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="fechaFacturaLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Tipo de Negocio: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="tipoNegocioLabel"></strong></td>
                                    <td style="border: none">Nro Pedido: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="numeroPedidoLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none">Precio Venta: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="precioVentaLabel"></strong></td>
                                    <td style="border: none"><span>Precio Compra: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="precioCompraLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Fecha Cancelacion: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="fechaCanceladoLabel"></strong></td>
                                    <td style="border: none">Saldo Pendiente: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="saldoPendienteLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Monto Abonado: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="montoAbonadoLabel"></strong></td>
                                    <td style="border: none"></td>
                                    <td style="border: none"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <strong>Datos de Cliente</strong>
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-translucent table-sm">
                                <tr>
                                    <td style="border: none"><span>Documento: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="documentoLabel"></strong></td>
                                    <td style="border: none">Nombre Cliente: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="nombreCliLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Telefono: </span></td>
                                    <td style="border: none"><strong class="labelAuditoria" id="telefonoCliLabel"></strong></td>
                                    <td style="border: none">Correo: </td>
                                    <td style="border: none"><strong class="labelAuditoria" id="correoCliLabel"></strong></td>
                                </tr>
                                <tr>
                                    <td style="border: none"><span>Direccion: </span></td>
                                    <td colspan="3" style="border: none"><strong class="labelAuditoria" id="direccionCliLabel"></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="subparte2">
            <div class="card h-100" style="height: 100%">
                <div class="card-body">
                    <div class="row pb-2">
                        <strong>Accesorios Instalados</strong>
                        <div class="col-12">
                            <div class="tableFixHeadv2">
                                <table class="table fs-9 mb-0 border-translucent table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>Cant.</th>
                                        <th>Equipamiento</th>
                                        <th>Estado</th>
                                        <th>Proveedor Gas</th>
                                        <th>Usuario</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyAccesorioAudit">
                                    <tr>
                                        <td colspan="5">No tiene Refacturaciones</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="parte2" style="height: calc(100vh - 67px);">
        <div class="subparte6">
            <div class="card h-100" style="height: 100%">
                <div class="card-body" style="padding: 8px;">
                    <button class="btn btn-warning btn-sm">Reporte Ingreso</button>
                    <button class="btn btn-light btn-sm">Reporte Lavado</button>
                    <button class="btn btn-light btn-sm">Reporte Pdi</button>
                    <button class="btn btn-light btn-sm">Reporte Control Calidad</button>
                    <button class="btn btn-light btn-sm">Reporte Accesorios</button>
                </div>
            </div>
        </div>
        <div class="subparte3">
            <div class="card h-100" style="height: 100%">
                <div class="card-body">
                    <strong>Eventos Realizados</strong>
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover"
                        >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Evento</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Fecha Inicio por Usuario</th>
                                <th>Fecha Fin por Usuario</th>
                                <th>Fecha Inicio Sistema</th>
                                <th>Usuario</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyEventoRealizado"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="subparte4">
            <div class="card h-100" style="height: 100%">
                <div class="card-body">
                    <strong>Eventos Eliminados</strong>
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover"
                        >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Evento</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Fecha Inicio por Usuario</th>
                                <th>Fecha Fin por Usuario</th>
                                <th>Fecha Inicio Sistema</th>
                                <th>Usuario</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyEventoEliminado"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="subparte5">
            <div class="card h-100" style="height: 100%">
                <div class="card-body">
                    <strong>Registros de Traslados e Ingreso</strong>
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tablaTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover">
                            <thead>
                            <tr>
                                <th>Vin</th>
                                <th>Fecha Traslado</th>
                                <th>Hora Traslado</th>
                                <th>Tipo de Traslado</th>
                                <th>Origen</th>
                                <th>Destino</th>

                            </tr>
                            </thead>
                            <tbody id="tbodyTraslados"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>