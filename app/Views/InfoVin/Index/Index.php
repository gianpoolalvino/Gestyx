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

<?php if ($vinInfo[0]["saldoPendiente"] > 0) { ?>
    <div class="row mb-3 rowf">
        <div class="col-12">
            <div class="alert alert-subtle-danger" role="alert">
                <strong><i class="far fa-info-circle"></i>&nbsp;Saldo Pendiente&nbsp;</strong>El Vin se encuentra con un
                Saldo pendiente de <?php echo round($vinInfo[0]["saldoPendiente"], 2) ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="row mb-3 rowf">
    <a data-bs-toggle="collapse" href="#datosCliente" role="button" aria-expanded="true"
       aria-controls="datosCliente"><h6 class="form-label titleLabel text-primary">>- Datos del Cliente -</h6>
    </a>
</div>
<div class="collapse multi-collapse mb-3 mb-sm-0 show p-3" id="datosCliente">
    <form action="<?php echo base_url("InfoVin/UpdateCliente")?>" method="POST" id="formUpVinCli">
    <input hidden name="vinCliUpd" value="<?php echo $vinInfo[0]["vin"]?>">
    <input hidden name="documentoCliUp" value="<?php echo $vinInfo[0]["documentoCliente"]?>">
    <div class="row mb-3 rowf">
        <div class="col-lg-6 col-sm-12">
            <label class="form-label spanlabel">Documento</label><br>
            <strong><?php echo $vinInfo[0]["documentoCliente"] ?></strong><br>
            <label class="form-label spanlabel"
                   for="exampleFormControlInput">Telefono</label><br>
            <input class="form-control form-control-sm" name="telefonoCliUp" id="telefonoCliUp" value="<?php echo $vinInfo[0]["telefonoCliente"] ?>">
        </div>
        <div class="col-lg-6 col-sm-12">
            <label class="form-label spanlabel"
                   for="exampleFormControlInput">Cliente</label><br>
            <strong><?php echo $vinInfo[0]["nombreCliente"] ?></strong><br>
            <label class="form-label spanlabel"
                   for="exampleFormControlInput">Correo</label><br>
            <input class="form-control form-control-sm" name="correoCliUp" type="email" value="<?php echo $vinInfo[0]["correoCliente"] ?>">
        </div>
    </div>
    <div class="row mb-3 pb-2">
        <div class="col-lg-12 col-sm-12">
            <label class="form-label spanlabel"
                   for="exampleFormControlInput">Direccion</label><br>
            <input class="form-control form-control-sm" name="direccionCliUp" value="<?php echo $vinInfo[0]["direccionCliente"] ?>">
        </div>
    </div>
        <div class="row mb-3">
            <div class="col-12">
                <button class="btn btn-info btn-sm" type="submit">Actualizar Cliente</button>
            </div>
        </div>
    </form>
    <hr>
</div>

<div class="row mb-3 rowf">
    <a data-bs-toggle="collapse" href="#datosVin" role="button" aria-expanded="false"
       aria-controls="datosVin">
        <h6 class="form-label titleLabel text-primary">>- Datos del Vehiculo -</h6></a>
</div>
<div class="collapse multi-collapse mb-3 mb-sm-0 p-3" id="datosVin">
<div class="row mb-3">
    <div class="col-lg-4 col-sm-12">
        <label class="form-label spanlabel">Vin</label><br>
        <strong><?php echo $vinInfo[0]["vin"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Familia</label><br>
        <strong><?php echo $vinInfo[0]["familia"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Color</label><br>
        <strong><?php echo $vinInfo[0]["color"]?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Placa</label><br>
        <strong><?php echo ($vinInfo[0]["placa"] != '') ? $vinInfo[0]["placa"] : 'Sin Placa' ?></strong><br>
    </div>
    <div class="col-lg-8 col-sm-12">
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Marca</label><br>
        <strong><?php echo $vinInfo[0]["marca"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Modelo</label><br>
        <strong><?php echo $vinInfo[0]["modelo"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Año</label><br>
        <strong><?php echo $vinInfo[0]["anhoModelo"]?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Tipo Placa</label><br>
        <strong><?php echo ($vinInfo[0]["idtipoPlaca"] == 1) ? 'Rotativa' : (($vinInfo[0]["idtipoPlaca"] == 2) ? 'Permanente' : (($vinInfo[0]["idtipoPlaca"] == 3) ? 'Exibicion' : 'Sin Placa')) ?></strong><br>
    </div>

</div>
    <hr>
</div>

<div class="row mb-3 rowf">
    <a data-bs-toggle="collapse" href="#datosFacturacion" role="button" aria-expanded="false"
       aria-controls="datosFacturacion">
    <h6 class="form-label titleLabel text-primary">>- Datos de Facturacion -</h6>
    </a>
</div>
<div class="collapse multi-collapse mb-3 mb-sm-0 p-3" id="datosFacturacion">
<div class="row mb-3 rowf">
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel">Tipo de Negocio</label><br>
        <strong><?php echo $vinInfo[0]["tipoNegocio"] ?></strong><br>
    </div>
    <div class="col-lg-6 col-sm-12">
        <label class="form-label spanlabel">Vendedor</label><br>
        <strong><?php echo $vinInfo[0]["vendedor"] ?></strong><br>
    </div>
</div>
<div class="row mb-3">
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel">Factura</label><br>
        <strong><?php echo $vinInfo[0]["numeroFactura"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Precio Venta</label><br>
        <strong><?php echo round($vinInfo[0]["precioVehiculo"], 2) ?></strong><br>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Fecha Factura</label><br>
        <strong><?php echo $vinInfo[0]["fechaFactura"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Abonado</label><br>
        <strong><?php echo round($vinInfo[0]["precioVehiculo"], 2) - $vinInfo[0]["saldoPendiente"] ?></strong><br>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Nro Pedido</label><br>
        <strong><?php echo $vinInfo[0]["numeroPedido"] ?></strong><br>
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Saldo</label><br>
        <strong><?php echo $vinInfo[0]["saldoPendiente"] ?></strong><br>

    </div>
    <div class="col-lg-3 col-sm-12">
        <?php if ($vinInfo[0]["saldoPendiente"] == 0) { ?>
            <label class="form-label spanlabel"
                   for="exampleFormControlInput">Fecha Cancelado</label><br>
            <strong><?php echo $vinInfo[0]["fechaCancelado"] ?></strong><br>
        <?php } ?>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Precio Costo</label><br>
        <strong><?php echo number_format($vinInfo[0]["precioCompra"],2,".","")?></strong><br>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Margen</label><br>
        <strong>
            <?php if($vinInfo[0]["precioVehiculo"]>0){?>
                <?php if($vinInfo[0]["precioCompra"]>0){?>
                     <?php echo round((($vinInfo[0]["precioVehiculo"]-$vinInfo[0]["precioCompra"])/$vinInfo[0]["precioCompra"])*100,2)." %" ?>
                <?php }else if($vinInfo[0]["precioCompra"]==0){?>
                    100%
                <?php }?>
            <?php }?>
        </strong><br>
    </div>
    <div class="col-lg-3 col-sm-12">
        <label class="form-label spanlabel"
               for="exampleFormControlInput">Utilidad</label><br>
        <strong>
            <?php if($vinInfo[0]["precioVehiculo"]>0){?>
                <?php echo round(($vinInfo[0]["precioVehiculo"]-$vinInfo[0]["precioCompra"]),2) ?>
            <?php }?>
        </strong><br>
    </div>
</div>



    <hr>
</div>
<div class="row mb-3 rowf">
    <a data-bs-toggle="collapse" href="#datosEquipamiento" role="button" aria-expanded="false"
       aria-controls="datosEquipamiento">
    <h6 class="form-label titleLabel text-primary">>- Equipamiento -</h6>
    </a>
</div>
<div class="collapse multi-collapse mb-3 mb-sm-0 p-3" id="datosEquipamiento">
<div class="row mb-3">
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
            if(!empty($equipamiento)){
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
            <?php } } ?>
            </tbody>
        </table>
    </div>
</div>
    <hr>
</div>
<div class="row mb-3 rowf p-3">
    <div class="col-lg-12 col-sm-12">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
    </div>
</div>






