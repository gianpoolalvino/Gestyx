<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
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
    <div class="form-row">
        <div class="col-12">
            <h5>Vehiculo en Inventario (VIN: <?php echo $vin ?>)</h5>
        </div><br>
    </div>
    <div class="form-row">
        <div class="col-12">
            <div class="row mb-3 rowf">
                <a data-bs-toggle="collapse" href="#datosCliente" role="button" aria-expanded="true"
                   aria-controls="datosCliente"><h6 class="form-label titleLabel text-primary">>- Datos del Vehiculo -</h6>
                </a>
            </div>
            <div class="collapse multi-collapse mb-3 mb-sm-0 show p-3" id="datosCliente">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <label class="form-label spanlabel">Vin</label><br>
                        <strong><?php echo $vinInfo[0]["vin"] ?></strong><br>
                        <label class="form-label spanlabel"
                               for="exampleFormControlInput">Familia</label><br>
                        <strong><?php echo $vinInfo[0]["familia"] ?></strong><br>
                        <label class="form-label spanlabel"
                               for="exampleFormControlInput">Color</label><br>
                        <strong><?php echo $vinInfo[0]["color"]?></strong><br>
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
                    </div>
                </div>

                <hr>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                CERRAR
            </button>
        </div>
    </div>
</div>