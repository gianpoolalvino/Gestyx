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
                            <h3 class="mb-2">Vehiculos Entregados / <small>(Total de
                                    Registros: <span id="totalRegLabel"><?php echo $count ?></span>)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <form action="<?php echo base_url("Entregados/Index/DetailIndexExcel")?>" method="POST" target="_blank">
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 20%">
                                    <select class="form-select form-select-sm" name="tipoFiltro" id="tipoFiltro"
                                            aria-label=".form-select-sm example">
                                        <option selected value="">Tipo Filtro</option>
                                        <option value="vin">Vin</option>
                                        <option value="documentoCliente">Documento Cliente</option>
                                        <option value="nombreCliente">Nombre Cliente</option>
                                        <option value="marca">Marca</option>
                                    </select>
                                </div>
                                <div class="input-group-prepend">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <input class="form-control form-control-sm" name="fechaInicio" type="date" value="<?php echo $hoy?>" id="fechaInicio">
                                        </div>
                                        <div class="input-group-prepend">
                                            <input class="form-control form-control-sm" name="fechaFinal" type="date" value="<?php echo $hoy?>" id="fechaFinal">
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control form-control-sm" id="filtro" name="filtro" style="width: 20%">
                                <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                <button class="btn btn-outline-success btn-sm" type="submit"><i class="fas fa-file-excel"></i>&nbsp;Excel</button>
                                <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg" value="<?php echo $countReg ?>">
                    <input hidden id="totalRegistros" value="<?php echo $count ?>">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover"
                               data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th class="sort" data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Agencia</th>
                                <th>Asesor de Venta</th>
                                <th>Asesor Entrega</th>
                                <th>Factura</th>
                                <th>Fecha Factura</th>
                                <th>Fecha Cancelado</th>
                                <th>Fecha Entrega</th>
                                <th>Dias Alistamiento</th>
                                <th>Doc. Cliente</th>
                                <th>Placa</th>
                                <th>Cliente</th>
                                <th>Direccion</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Tipo Negocio</th>
                                <th>Nro Pedido</th>
                                <th>Accesorios Instalados</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador = 0;
                            foreach ($detailIndex as $dit) {
                                $contador++;
                                ?>
                                <tr>
                                    <td><?php echo $contador ?></td>
                                    <td><?php echo $dit["vin"] ?></td>
                                    <td><?php echo $dit["marca"] ?></td>
                                    <td><?php echo $dit["familia"] ?></td>
                                    <td><?php echo $dit["color"] ?></td>
                                    <td><?php echo $dit["agencia"] ?></td>
                                    <td><?php echo $dit["vendedor"] ?></td>
                                    <td><?php echo $dit["nombreAsesor"]?></td>
                                    <td><?php echo $dit["numeroFactura"]?></td>
                                    <td><?php echo $dit["fechaFacturaLabel"]; ?></td>
                                    <td><?php echo $dit["fechaCanceladoLabel"]; ?></td>
                                    <td><?php echo $dit["fechaEntregaLabel"]; ?></td>
                                    <td>
                                        <?php
                                        $days='';
                                        if($dit["fechaCancelado"]!=''){
                                            $fechaFact=date("Y-m-d",strtotime($dit["fechaFactura"]));
                                            $fechaEnt=date("Y-m-d",strtotime($dit["fechaEntrega"]));
                                            $fecha1=date_create($fechaEnt);
                                            $fecha2=date_create($fechaFact);
                                            $diff=date_diff($fecha2,$fecha1);
                                            $days=str_replace('+','',$diff->format('%R%a'));
                                        }else{
                                            $fechaFact=date("Y-m-d",strtotime($dit["fechaCancelado"]));
                                            $fechaEnt=date("Y-m-d",strtotime($dit["fechaEntrega"]));
                                            $fecha1=date_create($fechaEnt);
                                            $fecha2=date_create($fechaFact);
                                            $diff=date_diff($fecha2,$fecha1);
                                            $days=str_replace('+','',$diff->format('%R%a'));
                                        }
                                        ?>
                                        <?php echo $days." Dias"?>
                                    </td>
                                    <td><?php echo $dit["documentoCliente"] ?></td>
                                    <td><?php echo $dit["placa"]?></td>
                                    <td><?php echo $dit["nombreCliente"] ?></td>
                                    <td><?php echo $dit["direccionCliente"] ?></td>
                                    <td><?php echo $dit["correoCliente"]?></td>
                                    <td><?php echo $dit["telefonoCliente"] ?></td>
                                    <td><?php echo $dit["tipoNegocio"] ?></td>
                                    <td><?php echo $dit["numeroPedido"] ?></td>
                                </tr>
                            <?php } ?>
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