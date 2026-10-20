<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <h6>Sincronizacion de Datos entre ERPs y Gestyx</h6>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo Sincronizacion</th>
                        <th>Fecha / Hora</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tbodySincroniza">
                    <?php
                    $contador=0;
                    foreach($detailIndex as $di){
                        $contador++;
                        ?>
                        <tr>
                            <td><?php echo $contador?></td>
                            <td><?php echo $di["tipoSincronizacion"]?></td>
                            <td><?php echo $di["fecha"]." ".$di["hora"]?></td>
                            <td><?php echo $di["nombre"]?></td>
                            <td><?php echo $di["descripcion"]?></td>
                            <td>
                                <?php if($di["idestadoSincronizacion"]==1){?>
                                    <span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="fas fa-solid fa-sync fa-spin fa-1x"></i>&nbsp;<span class="badge-label">En Proceso</span></span>
                                <?php }else{?>
                                    <span class="badge badge-phoenix fs-10 badge-phoenix-primary"><span class="badge-label">Finalizado</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
                                <?php }?>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12 text-center">
            <button class="btn btn-outline-danger btn-sm"  type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>