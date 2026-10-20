<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <h5><?php echo $title?></h5>
                <span style="font-size: 12px"><?php echo $message?></span>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                    <thead>
                    <tr>
                        <th class="sticky-col first-col">#</th>
                        <th>Vin</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th style="width: 5%">Color</th>
                        <th>Fecha Manifiesto</th>
                        <th>Dias</th>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody  class="list">
                        <?php
                        $contador=0;
                            foreach($detailVehicles as $dv){
                                $contador++;
                                ?>
                                <tr>
                                    <td><?php echo $contador?></td>
                                    <td><?php echo $dv->vin?></td>
                                    <td><?php echo $dv->marca?></td>
                                    <td><?php echo $dv->modelo?></td>
                                    <td><?php echo $dv->color?></td>
                                    <td><?php echo $dv->fechaOriginal?></td>
                                    <td><?php echo $dv->diasTotales?></td>
                                    <td><?php echo $dv->fechaModificada?></td>

                                    <td>Realizado</td>
                                </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
</div>