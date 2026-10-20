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
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formUploadExcel" method="POST"
          action="<?php echo base_url("Taller/Modelo/SaveEditDelete/UploadCargaExcel") ?>" enctype="multipart/form-data">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Carga Masiva Planes de Mto</h4>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-control form-control-sm" required
                                name="marca"
                                id="marcaAfectada"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value="">Seleccione Marca</option>
                            <?php foreach ($selectMarca as $smr) { ?>
                                <option value="<?php echo $smr["idmarca"] ?>"><?php echo $smr["descripcion"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Marca</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="input-group">
                    <input style="width: 78%" class="form-control form-control-sm"
                           required
                           accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                           name="resourceExcel"
                           id="customFileSm" type="file"/>
                    <div class="input-group-prepend">
                        <button class="btn btn-info btn-sm" type="submit" id="btnUploadFile"><i class="fas fa-upload"></i>&nbsp;Cargar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row pb-2">
        <div class="col-12">
                <span style="font-size: 12px">Debe seleccionar una Marca, el Excel debe contar con los siguientes parametros:<br>
                1.- Columna A: Debe contener la Marca<br>
                2.- Columna B: Debe contener el Modelo, si no existe como modelo el sistema lo podra generar apartir de la carga, si existe debe ser igual al ya creado<br>
                3.- Columna C: Debe contener el Kilometraje de los planes de mantenimiento en formato 5K, 10K, 15K etc.<br>
                4.- Columna D: Debe contener el codigo de Repuesto.<br>
                5.- Columna E: Debe contener la cantidad de Repuesto.</span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-subtle-warning" role="alert"><strong>Advertencia: </strong>La Carga Masiva elimina
                los datos temporales de la tabla de cargas de la marca seleccionada, asegurese que nadie este ejecutando
                un proceso dependiente de esta tabla.
            </div>
        </div>
    </div>
    <hr>
    <form id="formProcesar" method="POST" action="<?php echo base_url("Taller/Modelo/SaveEditDelete/CargaMasivaPlanesExcelMysql") ?>">
        <div class="row">
            <input hidden name="idmarcaAfectada" id="idmarcaAfectada">
            <input hidden name="rutaExcel" id="rutaExcel">
            <div class="col-12">
                <div class="input-group">
                    <select class="form-control form-control-sm" disabled id="selectPestanha" name="selectPestanha">
                    </select>
                    <div class="input-group-prepend">
                        <button class="btn btn-primary btn-sm" id="btnProcesarCarga" disabled type="submit">PROCESAR</button>
                        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>