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
                        <div class="col-6 text-right" style="text-align: right">
                            <?php if(!is_null($estadoTraslado[0]["ingreso"])){?>
                                    <?php if($estadoTraslado[0]["idtrasladoUbicacion"]){?>
                                        <button class="btn btn-outline-primary btn-sm" id="btnOpcubica"><i class="fas fa-map-marker-alt"></i></button>
                                    <?php }else{?>
                                    <button class="btn btn-subtle-success btn-sm tooltipBtn" id="btnRebox" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar de box en la misma ubicacion al vin <?php echo $vin?>" type="button">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>

                                        <button class="btn btn-success btn-sm" id="btnOpcubica"><i class="fas fa-paper-plane"></i></button>
                                        <button class="btn btn-primary btn-sm" id="btnReUbi"><i class="fas fa-lock-alt"></i></button>
                                    <?php }?>
                            <?php }else{?>
                                <span class="badge badge-phoenix badge-phoenix-danger">No puede Gestionar Traslados<br>El Vin no tiene Ingreso</span>
                            <?php }?>
                        </div>
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

                        </div>
                    </div>
                    <?php if($vinInfo[0]["idestadoVin"]==2){?>
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
                            Monto Abonado: <strong><?php echo $vinInfo[0]["agencia"]?></strong><br>
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
                            <h6>Traslados de Vehiculo</h6><hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTraslado" class="table fs-9 mb-0 border-top border-translucent table-hover">
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
                                    <?php if(!empty($traslado)){?>
                                        <?php
                                        $contador=0;
                                        foreach($traslado as $tr){
                                            $contador++;
                                            ?>
                                            <tr>
                                                <td><?php echo $contador?></td>
                                                <td><?php echo $tr["fechaTraslado"]?></td>
                                                <td><?php echo $tr["origen"]?></td>
                                                <td><?php echo $tr["destino"]?></td>
                                                <td><?php echo $tr["tipo_traslado"]?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>