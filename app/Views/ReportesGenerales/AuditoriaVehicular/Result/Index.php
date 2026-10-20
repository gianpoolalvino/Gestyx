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
        background-color: gray;  /* Color gris por defecto */
    }

    .light-theme .timeline-item.active .timeline-icon {
        background-color: #0092ca; /* Azul para eventos finalizados */
    }

    .light-theme .timeline-item .timeline-content {
        background-color: #fff; /* Fondo blanco para el contenido */
        color: #333;  /* Texto oscuro */
    }

    /* Colores para el tema oscuro */
    .dark-theme .timeline-icon {
        background-color: #333;  /* Gris oscuro para el tema oscuro */
    }

    .dark-theme .timeline-item.active .timeline-icon {
        background-color: #005b8a; /* Azul oscuro para eventos finalizados */
    }

    .dark-theme .timeline-item .timeline-content {
        background-color: #444; /* Fondo gris oscuro para el contenido */
        color: #ddd;  /* Texto claro */
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

</style>
<?php
$bloqued='disabled';
?>
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="container">
        <div class="pb-5" style="padding-bottom:0px !important">
            <div class="card mb-1">
                <div class="card-header">
                    <input hidden id="vinUbicacion" value="<?php echo $vin?>">
                    <div class="row">
                        <div class="col-6">
                            <h4>Nro Chasis  <?php echo $vin?></h4>
                            <?php if($estadoTraslado[0]["idestadoTraslado"]!=1){?>
                                Ubicacion Actual: <strong><?php echo (is_null($estadoTraslado[0]["ubicacionActual"]))?'En Transito':$estadoTraslado[0]["ubicacionActual"]?></strong>
                            <?php }else{?>
                                <p><i class="fas fa-cog fa-spin"></i>&nbsp;En Transito - De: <?php echo $estadoTraslado[0]["ubicacionOrigen"]?> a: <?php echo $estadoTraslado[0]["ubicacionDestino"]?><br>
                                    Fecha y Hora Partida: <?php echo $estadoTraslado[0]["fechaEnvio"]." ".$estadoTraslado[0]["horaEnvio"]?></p>
                            <?php }?>
                        </div>
                        <?php
                        $auditoria=session("gestorAuditoria");
                        if(isset($auditoria)){
                        if($auditoria==1){
                        ?>
                        <div class="col-6 text-right" style="text-align: right">
                            <button class="btn btn-outline-primary btn-sm" id="btnPdi" data-vin="<?php echo $vin?>"><i class="fas fa-eye"></i>&nbsp;PDI</button>
                            <button class="btn btn-outline-primary btn-sm" id="btnLavadp" data-vin="<?php echo $vin?>"><i class="fas fa-eye"></i>&nbsp;Lavado</button>
                            <button class="btn btn-outline-primary btn-sm" id="btnControlCalidad" data-vin="<?php echo $vin?>"><i class="fas fa-eye"></i>&nbsp;Control de Calidad</button>
                            <button class="btn btn-outline-primary btn-sm" id="btnAccesorios" data-vin="<?php echo $vin?>"><i class="fas fa-eye"></i>&nbsp;Accesorios</button>
                        </div>
                        <?php } }?>
                    </div>
                </div>
                <div class="card-body p-3 p-sm-4">
                    <?php if($vinInfo[0]["idestadoVin"]!=1){?>
                        <div class="row">
                            <div class="col-12">
                                <h6>Linea de Tiempo Eventos</h6><hr>
                            </div>
                        </div>
                        <!-- Timeline -->
                        <div class="row pb-5">
                            <div class="col-12">
                                <div class="timeline">
                                    <ul class="timeline-list">
                                        <?php foreach($eventos as $ev): ?>
                                            <li class="timeline-item <?php echo ($ev["realizado"]!='No Realizado')?(($ev["realizado"]=='En Proceso')?'':'active'):''?>">
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
                    <?php }?>
                    <div class="row">
                        <div class="col-12">
                            <h6>Datos Vehiculo</h6><hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Marca: <strong><?php echo $vinInfo[0]["marca"]?></strong><br>
                            Modelo: <strong><?php echo $vinInfo[0]["modelo"]?></strong><br>
                            Color: <strong><?php echo $vinInfo[0]["color"]?></strong><br>
                            Año de Modelo: <strong><?php echo $vinInfo[0]["anhoModelo"]?></strong>
                        </div>
                        <div class="col-6">
                            Chasis: <strong><?php echo $vinInfo[0]["vin"]?></strong><br>
                            Nro Motor: <strong><?php echo $vinInfo[0]["numeroMotor"]?></strong><br>
                            Tipo Vehiculo: <strong><?php echo ($vinInfo[0]["idtipoVin"]==1)?'Nuevo':'Semi Nuevo'?></strong><br>
                            Estado: <strong><?php

                                if($vinInfo[0]["idestadoVin"]==1){
                                    echo "Inventario";
                                }else if($vinInfo[0]["idestadoVin"]==2){
                                    echo "Vendido / Sin Entregar";
                                }else if($vinInfo[0]["idestadoVin"]==3){
                                    echo "Entregado";
                                }else if($vinInfo[0]["idestadoVin"]==6){
                                    echo "Exhibicion";
                                }else if($vinInfo[0]["idestadoVin"]==7){
                                    echo "Demo";
                                }
                                ?></strong>
                        </div>
                    </div>
                    <?php if($vinInfo[0]["idestadoVin"]!=1){?>
                        <div class="row pt-4">
                            <div class="col-12">
                                <h6>Datos Facturacion</h6><hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Agencia: <strong><?php echo $vinInfo[0]["agencia"]?></strong><br>
                                Factura: <strong><?php echo $vinInfo[0]["numeroFactura"]?></strong><br>
                                Tipo Negocio: <strong><?php echo $vinInfo[0]["tipoNegocio"]?></strong><br>
                                Precio Venta: <strong><?php echo $vinInfo[0]["precioVehiculo"]?></strong><br>
                                Fecha Cancelado: <strong><?php echo $vinInfo[0]["fechaCancelado"]?></strong><br>
                                Monto Abonado: <strong><?php echo $vinInfo[0]["precioVehiculo"]-$vinInfo[0]["saldoPendiente"]?></strong><br>
                            </div>
                            <div class="col-6">
                                Asesor Venta: <strong><?php echo $vinInfo[0]["vendedor"]?></strong><br>
                                Fecha Factura: <strong><?php echo $vinInfo[0]["fechaFactura"]?></strong><br>
                                Nro Pedido: <strong><?php echo $vinInfo[0]["numeroPedido"]?></strong><br>
                                Precio Compra: <strong><?php echo $vinInfo[0]["precioCompra"]?></strong><br>
                                Saldo Pendiente: <strong><?php echo $vinInfo[0]["saldoPendiente"]?></strong><br>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-12">
                                <h6>Datos Cliente</h6><hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                Documento: <strong><?php echo $vinInfo[0]["documentoCliente"]?></strong><br>
                                Nombre Cliente: <strong><?php echo $vinInfo[0]["nombreCliente"]?></strong><br>
                                Telefono: <strong><?php echo $vinInfo[0]["telefonoCliente"]?></strong><br>
                            </div>
                            <div class="col-6">
                                Correo: <strong><?php echo $vinInfo[0]["correoCliente"]?></strong><br>
                                Direccion: <strong><?php echo $vinInfo[0]["direccionCliente"]?></strong><br>
                            </div>
                        </div>
                    <?php }?>
                    <?php if(!empty($citaEntrega)){?>
                        <?php foreach($citaEntrega as $cit){?>
                            <div class="row pt-4">
                                <div class="col-12">
                                    <h6>Datos Agendamiento</h6><hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    Asesor Entrega: <strong><?php echo $cit["asesor"]?></strong><br>
                                    Fecha Entrega: <strong><?php echo $cit["fecha"]?></strong><br>
                                    Hora Entrega: <strong><?php echo $cit["horaAgendaInicio"]?></strong><br>
                                </div>
                                <div class="col-6">
                                    Agencia Entrega: <strong><?php echo $cit["agenciaEntrega"]?></strong><br>
                                    Comentarios Entrega: <strong><?php echo $cit["comentarioEntrega"]?></strong><br>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Equiamiento de Vehiculo</h6><hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th class="sticky-col first-col">#</th>
                                    <th>Cantidad</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($equipamiento)){?>
                                    <?php
                                    $countp=0;
                                    foreach($equipamiento as $eq){
                                        $countp++;
                                        ?>
                                        <tr>
                                            <td><?php echo $countp?></td>
                                            <td><?php echo $eq["cantidad"]?></td>
                                            <td><?php echo $eq["equipamiento"]?></td>
                                            <td><?php echo $eq["estado"]?></td>
                                            <td><?php echo $eq["usuario"]?></td>
                                        </tr>
                                    <?php }?>
                                <?php }else{?>
                                    <tr>
                                        <td colspan="5">No cuenta con Equipamiento</td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Traslados de Vehiculo</h6><hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th class="sticky-col first-col">#</th>
                                    <th>Tipo</th>
                                    <th>Fecha Traslado</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Transportista</th>
                                    <th>Conductor - Placa</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($traslado)){?>
                                    <?php
                                    $contador=0;
                                    foreach($traslado as $tr){
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador?></td>
                                            <td><?php echo $tr["tipo_traslado"]?></td>
                                            <td><?php echo $tr["fechaTraslado"]?></td>
                                            <td><?php echo $tr["origen"]?></td>
                                            <td><?php echo $tr["destino"]." (".$tr["otros"].")"?></td>
                                            <td><?php echo $tr["transportista"]?></td>
                                            <td><?php echo $tr["conductor"]." - ".$tr["placa"]?></td>
                                        </tr>
                                    <?php }?>
                                <?php }else{?>
                                    <tr>
                                        <td colspan="5">No cuenta con traslados</td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                        $auditoria=session("gestorAuditoria");
                        if(isset($auditoria)){
                            if($auditoria==1){
                    ?>
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
                    <?php
                            }
                        }
                    ?>
                    <div class="row pt-4">
                        <div class="col-12">
                            <h6>Codigo QR</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <?php
                            $file_path = 'resource/qr/operaciones/' . $vin . '.png';
                            if (file_exists($file_path)) {
                                // If file exists, display the image
                                echo '<img src="' . base_url($file_path) . '">';
                            } else {
                                // If file doesn't exist, show an alternative message or content
                                echo 'No se genero un QR desde el modulo de ingreso';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>