<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h6><?php echo "Iniciar Entrega de Vehiculo: ".$viewCita[0]["asesor"]?></h6><br>
            Resumen de Datos
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label class="form-label spanlabel">Marca: </label><br><strong><?php echo $viewCita[0]["marca"]?></strong><br>
            <label class="form-label spanlabel">Modelo: </label><br><strong><?php echo $viewCita[0]["familia"]?></strong><br>
            <label class="form-label spanlabel">Color: </label><br><strong><?php echo $viewCita[0]["color"]?></strong><br>
        </div>
        <div class="col-6">
            <label class="form-label spanlabel">Cliente: </label><br><strong><?php echo $viewCita[0]["nombreCliente"]?></strong><br>
            <label class="form-label spanlabel">Telefono: </label><br><strong><?php echo $viewCita[0]["telefonoCliente"]?></strong><br>
            <label class="form-label spanlabel">Correo: </label><br><strong><?php echo $viewCita[0]["correoCliente"]?></strong><br>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-12">
            Equipamiento Instalado
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Equipamiento</th>
                    <th scope="col">Fecha Inst.</th>
                    <th scope="col">Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $contador = 0;
                foreach ($equipamiento as $eq) {
                    $contador++;
                    ?>
                    <tr>
                        <th scope="row"><?php echo $contador ?></th>
                        <td><?php echo $eq["equipamiento"] ?></td>
                        <td>
                            <?php echo $eq["fechaInstalacion"] ?>
                        </td>
                        <td>
                            <?php if ($eq["idestadoEquipamiento"] == 1) { ?>
                                Por Instalar
                            <?php } else if ($eq["idestadoEquipamiento"] == 2) { ?>
                                Instalado
                            <?php } else { ?>
                                Por Validar
                            <?php } ?>

                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-sm" id="btnIniciar">Iniciar Entrega</button>
            <button class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>