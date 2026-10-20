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
<?php
date_default_timezone_set("America/Lima");
$horas=date("H:i:s");
?>
<div class="row">
    <div class="col-12">
        <h6>Datos de Cliente y vehiculo</h6>
    </div>
</div>
<input hidden name="vinAgendado" value="<?php echo $vin?>">
<div class="row">
    <div class="col-6">
        <label class="form-label spanlabel">Marca: </label><br><strong><?php echo $VinInfo[0]["marca"]?></strong><br>
        <label class="form-label spanlabel">Modelo: </label><br><strong><?php echo $VinInfo[0]["familia"]?></strong><br>
        <label class="form-label spanlabel">Color: </label><br><strong><?php echo $VinInfo[0]["color"]?></strong><br>
    </div>
    <div class="col-6">
        <label class="form-label spanlabel">Cliente: </label><br><strong><?php echo $VinInfo[0]["nombreCliente"]?></strong><br>
        <label class="form-label spanlabel">Telefono: </label><br><strong><?php echo $VinInfo[0]["telefonoCliente"]?></strong><br>
        <label class="form-label spanlabel">Correo: </label><br><strong><?php echo $VinInfo[0]["correoCliente"]?></strong><br>
    </div>
</div><hr>
<div class="row">
    <div class="col-12">
        <h6>- Opciones Agencia de Entrega y Hora -</h6>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <select class="form-control form-control-sm" required name="agenciaAgenda" id="agenciaAgenda">
            <option value="">Seleccione Agencia</option>
            <?php foreach($agencia as $ag){?>
                <option value="<?php echo $ag["idagencia"]?>"><?php echo $ag["descripcion"]?></option>
            <?php }?>
        </select>
    </div>
    <div class="col-6">
        <div class="input-group">
            <select class="form-control form-control-sm" required name="horaAgendaInicio" style="width: 50%">
                <?php foreach($horario as $hr){?>
                    <?php if($hr["horaAgenda"]==$horaAgenda){?>
                        <option value="<?php echo $hr["horaAgenda"]?>"><?php echo $hr["horaAgenda"]?></option>
                    <?php }?>
                <?php }?>
            </select>
            <div class="input-group-append" style="width: 50%">
                <select class="form-control form-control-sm" required name="horaAgendaFin">
                    <?php foreach($horario as $hr){?>
                        <?php if($hr["horaAgenda"]>$horaAgenda){?>
                            <option value="<?php echo $hr["horaAgenda"]?>"><?php echo $hr["horaAgenda"]?></option>
                        <?php }?>
                    <?php }?>
                </select>
            </div>
        </div>
    </div>
</div><hr>
<div class="row">
    <div class="col-12">
        <h6>- Opciones de Placa -</h6>
    </div>
</div>
<?php if($VinInfo[0]["idtipoPlaca"]!=2){?>
<div class="row">
    <div class="col-12">
        <input hidden name="checkTipoPlaca" required id="checkTipoPlaca">
        <div class="input-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input checkTipoPlaca" data-idcheck="1" id="flexRadioDefault1" type="radio" name="idtipoPlaca"/>
                <label class="form-check-label" for="flexRadioDefault1">Utilizar Placa Rotativa para Entrega</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkTipoPlaca" data-idcheck="4" id="flexRadioDefault2" type="radio" name="idtipoPlaca"/>
                <label class="form-check-label" for="flexRadioDefault2">Realizar entrega sin Placa</label>
            </div>
            <div class="input-group-append">
                <div id="placaRota" style="display:none">
                    <select class="form-control form-control-sm" id="placaAgendaRotativa" name="placa">
                        <option value="">Seleccione Placa Rotativa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div><br>
<?php }else{?>
    <div class="row">
        <div class="col-12">
            <label class="form-label spanlabel">Tipo de Placa: </label><br><strong><?php echo "Permanente"?></strong><br>
            <label class="form-label spanlabel">Placa: </label><br><strong><?php echo $VinInfo[0]["placa"]?></strong><br>
        </div>
    </div>
    <input hidden name="checkTipoPlaca" required id="checkTipoPlaca" value="2">
    <input hidden name="placa" required value="<?php echo $VinInfo[0]["placa"]?>">
<?php }?>
<div class="row">
    <div class="col-12">
        <h6>Comentarios de Entrega</h6>
        <textarea class="form-control form-control-sm" required rows="5" name="comentarioEntrega" placeholder="Ingrese Comentarios..."></textarea>
    </div>
</div>