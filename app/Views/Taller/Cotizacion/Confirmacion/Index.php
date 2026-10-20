<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form action="<?php echo base_url('Taller/Cotizacion/SaveEditDelete/SendERP') ?>" method="POST" id="FormSendCot">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <input hidden name="idcotizacion" value="<?php echo $idcotizacion ?>">
                <h5>Enviar a ERP</h5>
                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" name="agencia" required
                            aria-label="Floating label select example">
                        <option selected="">Seleccione Agencia</option>
                        <?php foreach ($selectAgencia as $sag) { ?>
                            <option value="<?php echo $sag["idagencia"] ?>"><?php echo $sag["descripcion"] . ' - ' . $sag["empresa"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Seleccione Agencia</label>
                </div>
                <span style="font-size: 12px">Debe confirmar la agencia donde se atendera para finalizar el proceso</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-outline-primary btn-sm" type="submit">PPROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
</div>