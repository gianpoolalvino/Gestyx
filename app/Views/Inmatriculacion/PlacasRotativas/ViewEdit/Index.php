<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 4px;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
    }
    #result {
        border-top: none !important;
        border-left: 0.1px solid #7b7b7b;
        border-right: 0.1px solid #7b7b7b;
        border-bottom: none !important;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        top: 36px;
        z-index: 1000;
        width: calc(100% - 1rem); /* Alinea con el input */
        margin-top: -1px; /* Para que se vea como parte del input */
        border-radius: 0 0 0.25rem 0.25rem; /* Bordes redondeados */
    }

    .result-item {
        padding: 10px;
        font-size: 12px;
        cursor: pointer;
        backdrop-filter: blur(10px);
    }

    .result-item:hover {
        background: #4f4f4f; /* Fondo claro al pasar el mouse */
        color: white
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Gestionar Placa Rotativa</h5>
        </div>
    </div><hr>
    <div class="row" style="padding-bottom: 4px">
        <div class="col-4">
            <label style="font-size: 14px">Placa</label>&nbsp;<strong style="font-size: 14px"><?php echo $placa[0]['placa']?></strong>
        </div>
        <div class="col-4">
            <label style="font-size: 14px">Placa</label>&nbsp;<strong style="font-size: 14px"><?php echo $placa[0]['fechaCreacion']?></strong>
        </div>
        <div class="col-4">
            <label style="font-size: 14px">Placa</label>&nbsp;<strong style="font-size: 14px"><?php echo $placa[0]['fechaVencimiento']?></strong>
        </div>
    </div>
    <div class="row" style="padding-bottom: 4px">
        <div class="col-6">
            <label style="font-size: 14px">Empresa</label>&nbsp;<strong style="font-size: 14px"><?php echo $placa[0]['empresa']?></strong>
        </div>
        <div class="col-6">
            <label style="font-size: 14px">Estado Placa</label>&nbsp;<strong style="font-size: 14px"><?php echo $placa[0]['estadoPlaca']?></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" <?php echo ($placa[0]['uso']==1)?'checked':'' ?> id="flexSwitchCheckDefault" type="checkbox" />
                <label class="form-check-label" for="flexSwitchCheckDefault"><?php echo ($placa[0]['uso']==1)?'La placa se encuentra asignada al Vehiculo ':'Asigne la placa Rotativa a un Vehiculo' ?></label>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <input class="form-control form-control-sm" id="vinVehicular"
                           placeholder="Ingrese Chasis, Marca, Modelo o Cliente..." name="vinVehicular">
                    <div id="result"></div>
                    <div class="input-group-append">
                        <button class="btn btn-subtle-primary btn-sm" style="height: 38px;"><i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

            </div>
        </div>
<hr>
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                Cerrar
            </button>
        </div>
    </div>
</div>