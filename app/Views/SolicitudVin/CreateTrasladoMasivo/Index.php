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
    <form action="">
        <div class="row pb-2">
            <div class="col-12">
                <h5>Gestionar Traslado Masivo</h5>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <label class="spanlabel">Vehiculo (*)</label>
                <div class="input-group">
                    <div class="input-append" style="width: 80%">
                        <select id="selectVehiculo" style="width: 100%;height: 38px !important" class="form-control form-control-sm">
                            <option value="">Seleccione Vehiculo...</option>
                            <?php foreach($selectVin as $sl){?>
                                <option value="<?php echo $sl["vin"]?>"><?php echo $sl["vin"]." - ".$sl["tipoSolicitud"]." - ".$sl["modelo"]?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="input-prepend" style="width: 20%">
                        <button class="btn btn-outline-primary btn-sm">Agregar</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Chasis</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Opc.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">Ingrese Datos...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-12">
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">Cancelar</button>
                <button class="btn btn-primary btn-sm">Procesar</button>
            </div>
        </div>
    </form>
</div>