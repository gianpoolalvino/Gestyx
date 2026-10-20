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
    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Nuevo Ingreso Vehicular</h5><br>
        </div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8 text-center">
            <label class="spanlabel">Vehiculo (*)</label>
            <select id="selectVehiculo" style="width: 100%;height: 38px !important" class="form-control form-control-sm">
                <option value="">Seleccione Vehiculo...</option>
                <?php foreach($selectVin as $sl){?>
                    <option value="<?php echo $sl["vin"]?>"><?php echo $sl["vin"]?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-2"></div>
    </div><hr>
    <div id="panelVehiculoIngreso">

    </div>

    <div id="panelClose">
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>

</div>