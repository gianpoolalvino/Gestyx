<div class="row">
    <div class="col-12">
        <h6>Vins / Titulos Encontrados</h6>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="tableExample4" data-list='{"valueNames":["name","email","payment"],"page":5,"pagination":true,"filter":{"key":"payment"}}'>
            <div class="table-responsive">
                <table class="table table-sm fs-9 mb-0">
                    <thead>
                    <tr class="bg-body-highlight">
                        <th class="sort border-top border-translucent ps-3" data-sort="name">Titulo</th>
                        <th class="sort border-top border-translucent" data-sort="email">Vin</th>
                        <th class="sort border-top border-translucent ps-3" data-sort="payment">Opcion</th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    <?php foreach($vins as $vn){?>
                    <tr>
                        <td class="align-middle ps-3 name"><?php echo $vn["numeroTitulo"]?></td>
                        <td class="align-middle email"><?php echo $vn["vin"]?></td>
                        <td class="align-middle payment text-end py-3 pe-3">
                            <button class="btn btn-outline-primary btn-sm btnAddTacha" data-title="<?php echo $vn["numeroTitulo"]?>" data-vin="<?php echo $vn["vin"]?>">Marcar</button>
                        </td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <button class="btn btn-danger btn-sm" id="btnModalClose">CERRAR</button>
    </div>
</div>