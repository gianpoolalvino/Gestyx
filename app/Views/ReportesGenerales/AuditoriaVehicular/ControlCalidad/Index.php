<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12 text-center">
            <h5>Reporte Control de Calidad <?php echo $vin ?></h5>
        </div>
    </div>
    <?php foreach ($grupoCheck as $gc) { ?>
        <div class="row pb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6><?php echo $gc["nombre"] ?></h6>

                        <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Comentarios</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Imagen</th>
                            </tr>
                            </thead>
                            <?php foreach ($checkCalidad as $cc) { ?>
                                <?php if ($cc["idgrupoCheckCalidad"] == $gc["idgrupoCheckCalidad"]) { ?>
                                    <tr>
                                        <td style="width: 30%"><?php echo $cc["tituloItemCalidad"] ?></td>
                                        <td style="width: 25%"><?php echo $cc["comentarios"] ?></td>
                                        <td style="width: 10%"><?php echo $cc["descripcion"] ?></td>
                                        <td style="width: 15%"><?php echo $cc["fecha"] ?></td>
                                        <td style="text-align: right;width: 20%">
                                            <?php
                                            if (!is_null($cc["rutaImagen"])) {
                                                if (is_null($cc["idtipoCarga"])) {
                                                    $base64 = 'data:image/' . $cc["tipoImagen"] . ';base64,' . $cc["rutaImagen"]; ?>
                                                    <img style="width:50%" src="<?php echo $base64 ?>">
                                                <?php } else { ?>
                                                    <img style="width:50%"
                                                         src="<?php echo base_url($cc["rutaImagen"]) ?>">
                                                <?php }
                                            }else{
                                                echo "Sin Imagen :(";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <hr>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
        </div>
    </div>
</div>