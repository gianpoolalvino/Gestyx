<div class="row pb-2">
    <div class="col-12">
        <strong></strong><span>Bienes a Transportar</span>
        <input hidden id="idguiaRemision" name="idguiaRemision" value="<?php echo $idguiaRemision?>">
    </div>
</div>
<div class="row pb-2">
    <div class="col-8">
        <h6>Detalle de bienes</h6>
    </div>
    <div class="col-4" style="text-align: right">
        <button class="btn btn-outline-primary btn-sm" type="button" id="btnAddVin"><i class="fas fa-plus"></i>&nbsp;Agregar</button>
    </div>
</div>
<div class="row pb-2">
    <div class="col-12">
        <table class="table table-sm fs-9 mb-0 table-hover">
            <thead>
            <tr class="bg-body-highlight">
                <th class="sort border-top border-translucent ps-3" data-sort="name">#</th>
                <th class="sort border-top border-translucent" data-sort="email">Vin</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Marca</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Modelo</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Color</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Unid. Medida</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Opc.</th>
            </tr>
            </thead>
            <tbody class="list" id="tbodyVinGuia">
                <tr>
                    <td colspan="7" class="text-center">No ingreso ningun VIN :(</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row pb-2">
    <div class="col-6">
        <div class="form-floating">
            <select class="form-select" id="unidadMedidaGuia" name="unidadMedidaGuia" aria-label="Floating label select example">
                <option value="">Seleccione unidad de Medida Peso</option>
                <?php foreach($unidadMedida as $um){?>
                    <option value="<?php echo $um["idunidadMedida"]?>"><?php echo $um["descripcion"]?></option>
                <?php }?>
            </select>
            <label for="unidadMedidaGuia">Unidad de medida de peso bruto</label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-floating">
            <input class="form-control form-control-sm" id="pesoGuia" name="pesoGuia">
            <label for="pesoGuia">Peso bruto total de la carga</label>
        </div>
    </div>
</div>
<hr>
<div class="row pb-2">
    <div class="col-12 text-right">
        <button class="btn btn-light btn-sm" id="btnReturnGuia" data-opcion="docRelacionado" type="button"><< Anterior</button>
        <button class="btn btn-primary btn-sm btnGuiaNext" id="btnGuiaNext" data-opcion="partidaLlegada" type="button">Siguiente >></button>
    </div>
</div>