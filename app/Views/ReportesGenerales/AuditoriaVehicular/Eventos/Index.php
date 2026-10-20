<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5 class="text-primary">Eventos Realizados</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="tableEventos" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                <tr>
                    <th class="sticky-col first-col">#</th>
                    <th>Evento Anterior</th>
                    <th>Fecha Inicio</th>
                    <th>Hora Inicio</th>
                    <th>Usuario Inicio</th>
                    <th>Evento Actual</th>
                    <th>Fecha Fin</th>
                    <th>Hora Fin</th>
                    <th>Usuario Fin</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $contador=0;
                    foreach($eventos as $ev){
                        $contador++;
                        ?>
                        <tr>
                            <td><?php echo $contador?></td>
                            <td><?php echo $ev["eventoAnterior"]?></td>
                            <td><?php echo $ev["fechaInicio"]?></td>
                            <td><?php echo $ev["horaInicio"]?></td>
                            <td><?php echo $ev["usuarioInicio"]?></td>
                            <td><?php echo $ev["eventoActual"]?></td>
                            <td><?php echo $ev["fechaFin"]?></td>
                            <td><?php echo $ev["horaFin"]?></td>
                            <td><?php echo $ev["usuarioFinal"]?></td>
                            <td><?php echo $ev["estadoEvento"]?></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                Cerrar
            </button>
        </div>
    </div>
</div>