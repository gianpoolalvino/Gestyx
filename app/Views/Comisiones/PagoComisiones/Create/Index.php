<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formUploadExcel" action="<?php echo base_url("Comisiones/PagoComisiones/SaveEditDelete/ReadExcel") ?>">
        <div class="row">
            <div class="col-12">
                <h5>Cargar Excel de Comisiones</h5>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-prepend">
                        <select class="form-control form-control-sm" name="marcaCarga">
                            <?php foreach ($selectMarca as $sm) { ?>
                                <option value="<?php echo $sm["descripcion"] ?>"><?php echo $sm["descripcion"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input class="form-control form-control-sm" disabled type="date" value="<?php echo $hoy ?>">
                    <a download="plantillaExcel.xlsx"
                       href="<?php echo base_url("resource/upload/plantillaComisiones.xlsx") ?>"
                       class="btn btn-outline-success">Plantilla XLS</a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <input style="width: 100%" class="form-control form-control-sm"
                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                       name="resourceExcel"
                       id="customFileSm" type="file"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12" style="font-size: 12px">
                <strong>Consideraciones para el Excel:</strong><br>
                1.- El Archivo debe contar con la hoja indicando la marca.<br>
                2.- El Dato Vin/Chasis debe estar en la columna "B"<br>
                3.- El Dato Vendedor debe encontrarse ubicado en la columna "K"<br>
                4.- El Dato Marca debe encontrarse en la columna "C"<br>
                5.- El Dato monto abonado debe encontrarse en la columna "AD"
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                    CANCELAR
                </button>
            </div>
        </div>
    </form>
</div>