<style>
    /* Estilo general para la lista */
    .timeline li:not(:last-child):before {
        position: absolute;
        content: "";
        height: 50%;
        width: 1px;
        background-color: var(--phoenix-secondary-bg);
        top: 50%;
        left: .3125rem;
    }

    .timeline {
        position: relative;
        padding-top: 20px;
        white-space: nowrap;
    }

    .timeline-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
    }

    .timeline-item {
        display: inline-block;
        margin-right: 50px;
        position: relative;
    }

    .timeline-icon {
        width: 30px;
        height: 30px;
        background-color: gray;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        color: white;
        position: relative;
        margin-bottom: 10px;
    }

    .timeline-icon i {
        font-size: 18px;
    }

    .timeline-content {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        min-width: 150px;
    }

    /* Colores para el tema claro */
    .light-theme .timeline-icon {
        background-color: gray; /* Color gris por defecto */
    }

    .light-theme .timeline-item.active .timeline-icon {
        background-color: #0092ca; /* Azul para eventos finalizados */
    }

    .light-theme .timeline-item .timeline-content {
        background-color: #fff; /* Fondo blanco para el contenido */
        color: #333; /* Texto oscuro */
    }

    /* Colores para el tema oscuro */
    .dark-theme .timeline-icon {
        background-color: #333; /* Gris oscuro para el tema oscuro */
    }

    .dark-theme .timeline-item.active .timeline-icon {
        background-color: #005b8a; /* Azul oscuro para eventos finalizados */
    }

    .dark-theme .timeline-item .timeline-content {
        background-color: #444; /* Fondo gris oscuro para el contenido */
        color: #ddd; /* Texto claro */
    }

    /* Estilo de los iconos */
    .timeline-item .timeline-content h6 {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .timeline-item .timeline-content p {
        margin: 5px 0;
    }

    /* Estilo responsivo */
    @media (max-width: 768px) {
        .timeline-list {
            flex-direction: column;
            align-items: center;
        }

        .timeline-item {
            margin-right: 0;
            margin-bottom: 30px;
        }
    }
    .btpOpc {
            padding: 7px;
            padding-left: 9px;
            padding-right: 9px;
    }

</style>
<?php
$bloqued='';
$bloqueoTotal='';
?>
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="container">
        <div class="pb-5" style="padding-bottom:0px !important">
            <div class="card mb-1">
                <div class="card-header" style="padding-top: 10px">
                    <input hidden id="vinUbicacion" value="<?php echo $vin ?>">
                    <div class="row">
                        <div class="col-12">
                            <a href="<?php echo base_url('SolicitudVin/GestionarVehiculos')?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                    <?php if($gestorVin[0]['idestadoSolicitudVehiculo']==1){
                        $bloqued='disabled';
                        ?>
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                                    <strong>No inicio Gestion</strong> No inicio la gestion del vehiculo, para iniciar las funciones debe iniciar dar click en Iniciar Gestion del vehiculo
                                </div>
                            </div>
                        </div>
                    <?php }else if(($gestorVin[0]['idestadoSolicitudVehiculo']==5) || ($gestorVin[0]['idestadoSolicitudVehiculo']==6)){
                        $bloqued='disabled';
                        $bloqueoTotal='disabled';
                        ?>
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="alert alert-subtle-primary alert-dismissible fade show" role="alert">
                                    <strong>Gestionado</strong> El vehiculo ya fue gestionado
                                </div>
                            </div>
                        </div>
                    <?php }else if($gestorVin[0]["idestadoSolicitudVehiculo"]==4){
                        $bloqued='disabled';
                        $bloqueoTotal='disabled';
                        ?>
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="alert alert-subtle-danger alert-dismissible fade show" role="alert">
                                    <strong>Gestionado</strong> El vehiculo fue rechazado
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <?php if($vinInfo[0]["saldoPendiente"]>0){?>
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="alert alert-subtle-danger alert-dismissible fade show" role="alert">
                                    <strong>Saldo Pendiente</strong> El vehiculo cuenta con un saldo de <?php echo $vinInfo[0]["saldoPendiente"]?>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <div class="row pt-2">
                        <div class="col-6">
                            <h4>Nro Chasis <?php echo $vin ?></h4>
                                <?php if ($estadoTraslado[0]["idestadoTraslado"] != 1) { ?>
                                    Ubicacion Actual:
                                    <strong><?php echo (is_null($estadoTraslado[0]["ubicacionActual"])) ? 'En Transito' : $estadoTraslado[0]["ubicacionActual"] ?></strong>
                                <?php } else { ?>
                                    <p><i class="fas fa-cog fa-spin"></i>&nbsp;En Transito -
                                        De: <?php echo $estadoTraslado[0]["ubicacionOrigen"] ?>
                                        a: <?php echo $estadoTraslado[0]["ubicacionDestino"] ?><br>
                                        Fecha y Hora
                                        Partida: <?php echo $estadoTraslado[0]["fechaEnvio"] . " " . $estadoTraslado[0]["horaEnvio"] ?>
                                    </p>
                                <?php } ?>
                                <?php if($vinInfo[0]["enTaller"]==1){?>
                                    <i class="fas fa-cog"></i>&nbsp;En Taller
                                <?php }?>
                        </div>
                        <div class="col-6 text-right" style="text-align: right">
                            <?php if (!is_null($estadoTraslado[0]["ingreso"])) { ?>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-outline-dark btn-sm dropdown-toggle" <?php echo $bloqueoTotal?> id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Opciones adiconales para el vin <?php echo $vin ?>"><i class="fas fa-cog"></i></button><span class="caret"> </span>
                                    <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="dropdownMenuButton">
                                        <?php if($gestorVin[0]['idestadoSolicitudVehiculo']==1){?>
                                        <a class="dropdown-item" id="btnStartGestion" href="#"><i class="fas fa-play"></i>&nbsp;Iniciar Gestion</a>
                                        <a class="dropdown-item" id="btnDenegarGestion" href="#"><i class="far fa-times-circle"></i>&nbsp;Rechazar Solicitud</a>
                                        <?php }?>
                                        <?php if($gestorVin[0]['idestadoSolicitudVehiculo']!=1){?>
                                            <a class="dropdown-item" id="btnSendSolicitante" href="#"><i class="fas fa-car-building"></i>&nbsp;Enviar a Destino</a>
                                            <a class="dropdown-item" id="btnSendTaller" href="#"><i class="fas fa-car-mechanic"></i>&nbsp;Enviar a Taller</a>
                                        <?php }?>
                                    </div>
                                </div>
                                <button class="btn btn-outline-warning btn-sm" <?php echo $bloqued?> id="btnRegisterNovedad" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Registrar Novedades del vin <?php echo $vin ?>"><i class="fas fa-exclamation-triangle"></i></button>

                                <?php if ($estadoTraslado[0]["idtrasladoUbicacion"]) { ?>
                                    <button class="btn btn-outline-primary btn-sm" <?php echo $bloqued?> id="btnOpcubica"><i
                                                class="fas fa-map-marker-alt"></i></button>
                                <?php } else { ?>
                                    <button class="btn btn-subtle-success btn-sm tooltipBtn" <?php echo $bloqued?> id="btnRebox"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Cambiar de box en la misma ubicacion al vin <?php echo $vin ?>"
                                            type="button">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" <?php echo $bloqued?> id="btnOpcubica"><i
                                                class="fas fa-paper-plane"></i></button>
                                    <button class="btn btn-primary btn-sm" <?php echo $bloqued?> id="btnReUbi"><i class="fas fa-lock-alt"></i>
                                    </button>
                            <?php } } else { ?>
                                <span class="badge badge-phoenix badge-phoenix-danger">No puede Gestionar Traslados<br>El Vin no tiene Ingreso <a  id="btnDenegarGestion" href="#"><i class="far fa-times-circle"></i>&nbsp;Rechazar Solicitud</a></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 p-sm-4">
                    <?php if ($vinInfo[0]["idestadoVin"] != 1) { ?>
                        <div class="row">
                            <div class="col-12">
                                <h6>Linea de Tiempo Eventos</h6>
                                <hr>
                            </div>
                        </div>
                        <!-- Timeline -->
                        <div class="row pb-5">
                            <div class="col-12">
                                <div class="timeline">
                                    <ul class="timeline-list">
                                        <?php foreach ($eventos as $ev): ?>
                                            <li class="timeline-item <?php echo ($ev["realizado"] != 'No Realizado') ? (($ev["realizado"] == 'En Proceso') ? '' : 'active') : '' ?>">
                                                <!-- Icono del carrito con colores según el estado -->
                                                <div class="timeline-icon"
                                                     style="background-color:
                                                <?php
                                                     if ($ev["estadoEvento"] == 'Finalizado') {
                                                         echo '#0092ca';
                                                     } elseif ($ev["estadoEvento"] == 'En Proceso') {
                                                         echo '#ffc93c';
                                                     } else {
                                                         echo 'gray';
                                                     }
                                                     ?>">
                                                    <i class="fas fa-car-side"></i>  <!-- Carrito -->
                                                </div>

                                                <!-- Contenido del evento -->
                                                <div class="timeline-content">
                                                    <h6><?php echo $ev["nombre"]; ?></h6>
                                                    <p><?php echo $ev["fechaInicio"]; ?></p>
                                                    <p><?php echo $ev["estadoEvento"]; ?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-12">
                            <h6>Datos de Solicitud</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Tipo Solicitud: <strong><?php echo $gestorVin[0]["tipoSolicitud"] ?></strong><br>
                            Fecha Solicitud: <strong><?php echo $gestorVin[0]["fechaSolicitud"] ?></strong><br>
                            Fecha Inicio Atencion: <strong><?php echo $gestorVin[0]["fechaAtencion"] ?></strong><br>
                            Fecha Max. Entrega: <strong><?php echo $gestorVin[0]["fechaMaximaEntrega"] ?></strong>
                        </div>
                        <div class="col-6">
                            Novedades: <strong><?php echo $gestorVin[0]["novedades"] ?></strong><br>
                            Estado Solicitud: <strong><?php echo $gestorVin[0]["estadoSolicitud"] ?></strong><br>
                            Estado Vehiculo: <strong><?php echo $gestorVin[0]["estadoVehiculo"] ?></strong><br>
                            Centro de Costo: <strong><?php echo $gestorVin[0]["centroCosto"] ?></strong><br>
                            Destino: <strong><?php echo $gestorVin[0]["destino"] ?></strong><br>
                        </div>
                    </div>
                    <hr>
                    <div class="row pb-2">
                        <div class="col-12">
                            <span style="font-size: 12px">Comentario Solicitud</span><br>
                            <strong style="font-size: 14px"><?php echo $gestorVin[0]["comentarioSolicitud"]?></strong><br>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Datos Vehiculo</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Marca: <strong><?php echo $vinInfo[0]["marca"] ?></strong><br>
                            Modelo: <strong><?php echo $vinInfo[0]["modelo"] ?></strong><br>
                            Color: <strong><?php echo $vinInfo[0]["color"] ?></strong><br>
                            Año de Modelo: <strong><?php echo $vinInfo[0]["anhoModelo"] ?></strong>
                        </div>
                        <div class="col-6">
                            Chasis: <strong><?php echo $vinInfo[0]["vin"] ?></strong><br>
                            Nro Motor: <strong><?php echo $vinInfo[0]["numeroMotor"] ?></strong><br>
                            Tipo Vehiculo:
                            <strong><?php echo ($vinInfo[0]["idtipoVin"] == 1) ? 'Nuevo' : 'Semi Nuevo' ?></strong><br>

                        </div>
                    </div>

                    <?php if(!empty($equipamiento)){?>
                        <div class="row pt-4">
                            <div class="col-12">
                                <h6>Equipamiento Vehicular</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                    <thead>
                                    <tr>
                                        <th class="sticky-col first-col">#</th>
                                        <th>Equipamiento</th>
                                        <th>Estado</th>
                                        <th>Tipo Negocio</th>
                                        <th>Fecha Inst.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $contad = 0;
                                    foreach ($equipamiento as $eq) {
                                        $contad++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contad ?></td>
                                            <td><?php echo $eq["equipamiento"] ?></td>
                                            <td>
                                                <?php if($eq['idestadoEquipamiento']==1){?>
                                                    Instalado
                                                <?php }else{?>
                                                    Pendiente Instalacion
                                                <?php }?>
                                            </td>
                                            <td>
                                                <?php if($eq['tipoFacturacionEquipamiento']=='F'){?>
                                                    Facturado
                                                <?php }else{?>
                                                    Obsequio
                                                <?php }?>
                                            </td>
                                            <td><?php echo $eq["fechaInstalacion"] ?></td>

                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php }?>

                    <?php if ($vinInfo[0]["idestadoVin"] == 2) { ?>
                        <div class="row pt-4">
                            <div class="col-12">
                                <h6>Datos Facturacion</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Agencia: <strong><?php echo $vinInfo[0]["agencia"] ?></strong><br>
                                Factura: <strong><?php echo $vinInfo[0]["numeroFactura"] ?></strong><br>
                                Tipo Negocio: <strong><?php echo $vinInfo[0]["tipoNegocio"] ?></strong><br>
                                Precio Venta: <strong><?php echo $vinInfo[0]["precioVehiculo"] ?></strong><br>
                                Fecha Cancelado: <strong><?php echo $vinInfo[0]["fechaCancelado"] ?></strong><br>
                                Monto Abonado: <strong><?php echo $vinInfo[0]["agencia"] ?></strong><br>
                            </div>
                            <div class="col-6">
                                Asesor Venta: <strong><?php echo $vinInfo[0]["vendedor"] ?></strong><br>
                                Fecha Factura: <strong><?php echo $vinInfo[0]["fechaFactura"] ?></strong><br>
                                Nro Pedido: <strong><?php echo $vinInfo[0]["numeroPedido"] ?></strong><br>
                                Precio Compra: <strong><?php echo $vinInfo[0]["precioCompra"] ?></strong><br>
                                Saldo Pendiente: <strong><?php echo $vinInfo[0]["saldoPendiente"] ?></strong><br>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-12">
                                <h6>Datos Cliente</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Documento: <strong><?php echo $vinInfo[0]["documentoCliente"] ?></strong><br>
                                Nombre Cliente: <strong><?php echo $vinInfo[0]["nombreCliente"] ?></strong><br>
                                Telefono: <strong><?php echo $vinInfo[0]["telefonoCliente"] ?></strong><br>
                            </div>
                            <div class="col-6">
                                Correo: <strong><?php echo $vinInfo[0]["correoCliente"] ?></strong><br>
                                Direccion: <strong><?php echo $vinInfo[0]["direccionCliente"] ?></strong><br>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($citaEntrega)) { ?>
                        <?php foreach ($citaEntrega as $cit) { ?>
                            <div class="row pt-4">
                                <div class="col-12">
                                    <h6>Datos Agendamiento</h6>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    Asesor Entrega: <strong><?php echo $cit["asesor"] ?></strong><br>
                                    Fecha Entrega: <strong><?php echo $cit["fecha"] ?></strong><br>
                                    Hora Entrega: <strong><?php echo $cit["horaAgendaInicio"] ?></strong><br>
                                </div>
                                <div class="col-6">
                                    Agencia Entrega: <strong><?php echo $cit["agenciaEntrega"] ?></strong><br>
                                    Comentarios Entrega: <strong><?php echo $cit["comentarioEntrega"] ?></strong><br>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if (!empty($traslado)) { ?>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Traslados de Vehiculo</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class="sticky-col first-col">#</th>
                                    <th>Fecha Traslado</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Tipo</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $contador = 0;
                                    foreach ($traslado as $tr) {
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador ?></td>
                                            <td><?php echo $tr["fechaTraslado"] ?></td>
                                            <td><?php echo $tr["origen"] ?></td>
                                            <td><?php echo $tr["destino"] ?></td>
                                            <td><?php echo $tr["tipo_traslado"] ?></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php }  ?>
                    <?php if (!empty($novedadesIngreso)) { ?>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Novedades al Ingreso</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class="sticky-col first-col">#</th>
                                    <th>Fecha Registro</th>
                                    <th>Tipo Daño</th>
                                    <th>Severidad Daño</th>
                                    <th>Area Daño</th>
                                    <th>Sub Area Daño</th>
                                    <th>Detalle Repuesto</th>
                                    <th>Solucion</th>
                                    <th>Comentarios</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($novedadesIngreso as $inv) {
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador ?></td>
                                            <td><?php echo $inv["fechaRegistro"] ?></td>
                                            <td><?php echo $inv["tipoDanho"] ?></td>
                                            <td><?php echo $inv["severidadDanho"] ?></td>
                                            <td><?php echo $inv["areaDanho"] ?></td>
                                            <td><?php echo $inv["subAreaDanho"] ?></td>
                                            <td><?php echo $inv["detalleRepuesto"] ?></td>
                                            <td><?php echo $inv["solucionObservacion"]?></td>
                                            <td><?php echo $inv["comentarios"]?></td>
                                            <td>
                                                <?php if($inv["idestadoObservacion"]==1){?>
                                                    <button class="btn btn-primary btn-sm btnOpcNovedad" data-idtipoNovedad="1" data-vin="<?php echo $vin?>" data-idnovedad="<?php echo $inv['idobservacionIngresoVin']?>" data-idcabeceraNovedad="<?php echo $inv["idingresoVin"]?>" <?php echo $bloqued?>><i class="fas fa-tools"></i></button>
                                                <?php }else{?>
                                                    <button class="btn btn-primary btn-sm btnOpcNovedad" data-idtipoNovedad="1" data-vin="<?php echo $vin?>" data-idnovedad="<?php echo $inv['idobservacionIngresoVin']?>" data-idcabeceraNovedad="<?php echo $inv["idingresoVin"]?>" disabled <?php echo $bloqued?>><i class="fas fa-tools"></i></button>
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php }  ?>
                    <?php if (!empty($novedadesRecepcion)) { ?>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Novedades al Generar Traslados</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class="sticky-col first-col">#</th>
                                    <th>Fecha Obs</th>
                                    <th>Descripcion</th>
                                    <th>Detalles</th>
                                    <th>Ubicacion Origen</th>
                                    <th>Ubicacion Destino</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $contador = 0;
                                    foreach ($novedadesRecepcion as $rcp) {
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador ?></td>
                                            <td><?php echo $rcp["fechaObservacion"] ?></td>
                                            <td><?php echo $rcp["descripcion"] ?></td>
                                            <td><?php echo $rcp["detalles"] ?></td>
                                            <td><?php echo $rcp["ubicacionOrigen"] ?></td>
                                            <td><?php echo $rcp["ubicacionDestino"] ?></td>
                                            <td>
                                                <?php if($rcp["idestadoNovedad"]==1){?>
                                                    <button class="btn btn-primary btn-sm btnOpcNovedad" data-idtipoNovedad="2" data-vin="<?php echo $vin?>" data-idnovedad="<?php echo $rcp['iddetalleRecepcionVin']?>" data-idcabeceraNovedad="<?php echo $rcp["idtrasladoVin"]?>" <?php echo $bloqued?>><i class="fas fa-tools"></i></button>
                                                <?php }else{?>
                                                    <button class="btn btn-primary btn-sm btnOpcNovedad" data-idtipoNovedad="2" data-vin="<?php echo $vin?>" data-idnovedad="<?php echo $rcp['iddetalleRecepcionVin']?>" data-idcabeceraNovedad="<?php echo $rcp["idtrasladoVin"]?>" disabled <?php echo $bloqued?>><i class="fas fa-tools"></i></button>
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php }  ?>
                    <?php if(!empty($novedadesSolicitud)){?>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Novedades Adicionales</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class="sticky-col first-col">#</th>
                                    <th>Fecha Registro</th>
                                    <th>Descripcion Novedad</th>
                                    <th>Detalle</th>
                                    <th>Estado</th>
                                    <th>Opc.</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador=0;
                                foreach($novedadesSolicitud as $ns){
                                    $contador++;
                                    ?>
                                    <tr>
                                        <td><?php echo $contador?></td>
                                        <td><?php echo $ns["fecha"]?></td>
                                        <td><?php echo $ns["tituloNovedad"]?></td>
                                        <td><?php echo $ns["detalles"] ?></td>
                                        <td><?php echo $ns["estadoNovedad"]?></td>

                                        <td>
                                            <?php if($ns["idestadoNovedad"]==1){?>
                                            <button class="btn btn-primary btn-sm btnOpcNovedad" data-idtipoNovedad="3" data-vin="<?php echo $vin?>" data-idnovedad="<?php echo $ns['idnovedadesDetalleSolicitudVehiculo']?>" data-idcabeceraNovedad="<?php echo $ns["idsolicitudVehiculo"]?>" <?php echo $bloqued?>><i class="fas fa-tools"></i></button>

                                        <?php }else{?>
                                            <button class="btn btn-primary btn-sm btnOpcNovedad" disabled <?php echo $bloqued?>><i class="fas fa-tools"></i></button>
                                        <?php }?>
                                        </td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>