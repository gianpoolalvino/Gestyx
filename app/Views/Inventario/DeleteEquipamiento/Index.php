


<div class="modal-body">
    <form method="POST" id="formEquipamientoExhibicionDelt" action="<?php echo base_url("Inventario/SaveEditDelete/DeleteEquipamiento") ?>">
        <div class="form-row">
            <div class="col-12 text-center">
                <i class="far fa-sad-tear fa-4x text-danger"></i>
                <input hidden name="idequipamientoVinExhi" value="<?php echo $viewEquipamiento[0]["idequipamientoVin"]?>">
                <h5 class="text-danger">¿Seguro desea eliminar el equipamiento <?php echo $viewEquipamiento[0]["equipamiento"]?> del Vehiculo?</h5>
            </div>
            <br>
        </div>
        <div class="form-row" style="padding-bottom: 6px">
            <div class="col-12 text-center">
                <button class="btn btn-danger btn-sm" type="submit">ELIMINAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </form>
</div>