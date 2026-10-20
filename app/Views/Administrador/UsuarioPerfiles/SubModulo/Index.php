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

    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
</style>
<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <h5>Accesos a Sub Modulo</h5>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Modulo</th>
                    <th>Sub Modulo</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody id="tbodySubMod">
                    <?php
                    $contador=0;
                    foreach($subModulo as $sb){
                        $contador++;
                        ?>
                        <tr>
                            <td><?php echo $contador?></td>
                            <td><?php echo $sb["modulo"]?></td>
                            <td><?php echo $sb["nombre"]?></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input subModAdd" data-idsubModulo="<?php echo $sb["idsubModuloPrincipal"]?>" data-idusuario="<?php echo $idusuario?>" id="checkSubMod<?php echo $sb["idsubModuloPrincipal"]?>" value="<?php echo $sb["idsubModuloPrincipal"]?>" <?php echo $sb["check_status"]?> type="checkbox"/>
                                    <label class="form-check-label" for="checkSubMod<?php echo $sb["idsubModuloPrincipal"]?>"></label>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-8">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>