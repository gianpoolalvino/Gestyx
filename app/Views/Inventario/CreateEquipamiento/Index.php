<div class="modal-body">
    <form method="POST" id="formEquipamientoExhibicion" action="<?php echo base_url("Inventario/SaveEditDelete/SaveEquipamientoExhibicion") ?>">
        <div class="form-row">
            <div class="col-12">
                <h5>Agregar Equipamiento</h5>
            </div>
            <br>
        </div>
        <input hidden name="idexhibicionVin" value="<?php echo $idexhibicionVin ?>">
        <input hidden name="vinExhibicion" value="<?php echo $vin ?>">
        <div class="form-row" style="padding-bottom: 6px">
            <div class="col-12">
                <div class="input-group" style="width: 100%">
                    <div class="input-group-prepend" style="width: 35%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" required
                                   name="cantidadEquipamiento"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   data-choices="data-choices"
                                   aria-label="Floating label select example">
                            <label for="floatingSelect">Cantidad</label>
                        </div>
                    </div>
                    <div class="input-group-append" style="width: 65%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" required
                                   name="codigoEquipamiento"
                                   data-choices="data-choices"
                                   aria-label="Floating label select example">
                            <label for="floatingSelect">Codigo</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-row" style="padding-bottom: 6px">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm" required
                          style="height: 100px"
                          name="equipamiento"
                          data-choices="data-choices"
                          aria-label="Floating label select example"></textarea>
                    <label for="floatingSelect">Descripcion Equipamiento</label>
                </div>
            </div>
        </div>
        <div class="form-row" style="padding-bottom: 6px">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">PROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
</div>