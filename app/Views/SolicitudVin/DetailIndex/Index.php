<?php
$contador = 0;

if (empty($detail)) {
    echo '<tr><td colspan="10" class="text-center">No existen datos :(</td></tr>';
} else {
    foreach ($detail as $di) {
        $contador++;
        ?>
        <tr class="<?php echo $di["estadoClase"]?>">
            <td><?php echo $contador ?></td>
            <td><?php echo $di["numeroSolicitud"] ?></td>
            <td><?php echo $di["tipoSolicitud"] ?></td>
            <td><?php echo $di["solicitante"] ?></td>
            <td><?php echo $di["fechaSolicitud"] ?></td>
            <td><?php echo $di["fechaEnvio"] ?></td>
            <td><?php echo $di["fechaRetorno"] ?></td>
            <td>
                <span>Tipo Origen y Destino: </span>&nbsp;<strong><?php echo $di["tipoDestino"] ?></strong><br>
                <span>Origen: </span>&nbsp;<strong><?php echo $di["nombreOrigen"] ?></strong><br>
                <span>Destino: </span>&nbsp;<strong><?php echo $di["destino"] ?></strong>
            </td>
            <td><?php echo $di["estadoSolicitud"] ?></td>
            <td>
                <?php if(session("gestorSolicitudVehiculo")==1){?>
                    <?php if($di["idestadoSolicitud"]!=3 && $di["idestadoSolicitud"]!=4){?>
                        <button class="btn btn-primary btn-sm btnOpcAtender" data-opcion="procesar" data-idsolicitudVehiculo="<?php echo $di["idsolicitudVehiculo"] ?>"><i class="fas fa-check-circle"></i></button>
                    <?php }?>
                <?php }?>
                <button class="btn btn-light btn-sm btnOpcAtender" data-opcion="ver" data-idsolicitudVehiculo="<?php echo $di["idsolicitudVehiculo"] ?>"><i class="fas fa-eye"></i></button>
            </td>
        </tr>
    <?php }
} ?>
