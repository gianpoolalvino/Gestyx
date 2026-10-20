<div class="modal-body">
    <div class="row pb-2">
        <div class="col-8">
            <h5 class="text-primary">Transportista</h5>
        </div>
        <div class="col-4" style="text-align: right">
            <button type="button" class="btn btn-primary btn-sm" id="btnNewTransportista">Agregar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="tableTransportista" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Documento</th>
                    <th>Nombre / Razon Social</th>
                    <th>Opc</th>
                </tr>
                </thead>
                <tbody id="tbodyTransportista">
                    <?php
                    $contador=0;
                    foreach($detailTransporte as $dt){
                        $contador++;
                        ?>
                        <tr style="vertical-align: middle">
                            <td><?=$contador?></td>
                            <td><?=$dt["documento"]?></td>
                            <td><?=$dt["razonSocial"]?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger btnOpcTrans" data-idtransportista="<?php echo $dt["idtransportista"]?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancelar</button>
        </div>
    </div>
</div>