<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formRetornVinExhi" action="<?php echo base_url("Exhibicion/Preparando/SaveEditDelete/SaveRetorno") ?>"
          method="POST">
        <div class="row">
            <div class="col-12">
                <h5>Retornar a Inventario - (VIN: <?php echo $vin ?>)</h5>
                <input hidden name="vin" value="<?php echo $vin?>">
                <input hidden name="idexhibicionVinRetorn" value="<?php echo $idexhibicionVin?>">
            </div>
        </div><br>
        <div class="row">
            <div class="col-12 text-center">
                <h5>¿Desea Retornar el Vehiculo a Inventario?, esto anulara los Eventos realizados hasta el momento</h5>
                <label style="font-size: 12px">Evento Actual</label><br>
                <?php echo $vinInfo[0]["eventoActual"]?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm"
                          name="comentarioRetornoInventario"
                          required
                          data-choices="data-choices"
                          style="height: 100px"
                          aria-label="Floating label select example"></textarea>
                    <label for="floatingSelect">Especifique las razones del Retorno (*)</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </form>
</div>