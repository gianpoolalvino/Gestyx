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
<div class="row mb-3 rowf">
    <a data-bs-toggle="collapse" href="#datosVin" role="button" aria-expanded="true"
       aria-controls="datosVin">
        <h6 class="form-label titleLabel text-primary">>- Datos del Vehiculo -<</h6></a>
</div>
<div class="collapse multi-collapse mb-3 show mb-sm-0 p-3" id="datosVin">
    <div class="row mb-3">
        <div class="col-lg-4 col-sm-12">
            <label class="form-label spanlabel">Vin</label><br>
            <strong><?php echo $vinInfo[0]["vin"] ?></strong><br>
            <label class="form-label spanlabel"
                   for="exampleFormControlInput">Familia</label><br>
            <strong><?php echo $vinInfo[0]["familia"] ?></strong><br>
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
                   for="exampleFormControlInput">Tipo Placa</label><br>
            <strong><?php echo ($vinInfo[0]["idtipoPlaca"] == 1) ? 'Rotativa' : (($vinInfo[0]["idtipoPlaca"] == 2) ? 'Permanente' : (($vinInfo[0]["idtipoPlaca"] == 3) ? 'Exibicion' : 'Sin Placa')) ?></strong><br>
        </div>

    </div>
    <hr>
</div>
<div class="row mb-3 rowf p-3">
    <div class="col-lg-12 col-sm-12">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
    </div>
</div>






