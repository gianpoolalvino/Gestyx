<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$mesHoy=date("m");
$primerDiaDelMes = date('Y-m-01');
?>
<?php
// Array con los nombres de los meses en español
$meses = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];
$nombreMes='';
$numeroMes='';
// Crear las opciones del select
for ($i = 0; $i < 12; $i++) {
    $mesValue = sprintf('%02d', $i + 1); // El value es el número del mes (1-12)
    if($mesValue==$mesHoy){
        $nombreMes=$meses[$i];
        $numeroMes = $mesValue; // El texto es el nombre del mes en español
    }
}
?>

<div class="modal-body">
    <form method="POST" id="formBonoVehiculo" action="<?php echo base_url("Comisiones/VehiculosBono/SaveEditDelete/SaveBono") ?>">
        <div class="row">
            <div class="col-12">
                <h5>Carga de Bono Vehicular</h5>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-append" style="width: 40%">
                        <select class="form-select form-control-sm" name="marcaCarga" required>
                            <?php foreach($selectMarca as $mr){?>
                                <option value="<?php echo $mr["idmarca"]?>"><?php echo $mr["descripcion"]?></option>
                            <?php }?>
                        </select>
                    </div>
                    <select class="form-select form-control-sm" name="mesInicio" required>
                        <option value="">Mes Aplicar</option>
                        <option value="<?php echo $numeroMes?>"><?php echo $nombreMes?></option>
                    </select>
                    <div class="input-prepend">
                        <input class="form-control form-control-sm" style="height: 36px" name="fechaInicio" min="<?php echo $primerDiaDelMes?>" max="<?php echo $hoy?>" type="date">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label class="form-label spanlabel" for="resourceExcel">Subir Excel</label>
                <input class="form-control form-control-sm" required name="resourceExcel" id="resourceExcel"  type="file"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">PROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
</div>