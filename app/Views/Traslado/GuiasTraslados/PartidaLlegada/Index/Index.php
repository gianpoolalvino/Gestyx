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
                <th class="sort border-top border-translucent" data-sort="email">Departamento</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Provincia</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Distrito</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Direccion</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Opc.</th>
            </tr>
            </thead>
            <tbody class="list" id="tbodyPartida">
            <tr>
                <td colspan="6" class="text-center">No ingreso ningun direccion...</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row pb-2">
    <div class="col-12">
        <table class="table table-sm fs-9 mb-0 table-hover">
            <thead>
            <tr class="bg-body-highlight">
                <th class="sort border-top border-translucent ps-3" data-sort="name">#</th>
                <th class="sort border-top border-translucent" data-sort="email">Departamento</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Provincia</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Distrito</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Direccion</th>
                <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Opc.</th>
            </tr>
            </thead>
            <tbody class="list" id="tbodyPartida">
            <tr>
                <td colspan="6" class="text-center">No ingreso ningun direccion...</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row pb-2">
    <div class="col-12 text-right">
        <button class="btn btn-light btn-sm" id="btnReturnGuia" data-opcion="docRelacionado" type="button"><< Anterior</button>
        <button class="btn btn-primary btn-sm btnGuiaNext" id="btnGuiaNext" data-opcion="partidaLlegada" type="button">Siguiente >></button>
    </div>
</div>