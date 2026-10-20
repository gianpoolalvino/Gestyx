<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }

    .select2-dropdown {
        z-index: 9999999 !important; /* Asegúrate de que tenga un valor mayor que el del modal */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
        padding-top: 14px;
        font-size: 14px;
        padding-left: 15px;
    }

    .select2-container--default .select2-selection--single {
        height: 47px;
        line-height: 52px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-8">
            <h6>Reglas dentro del Grupo <?php echo $viewGrupoRegla[0]["nombreGrupo"]?></h6>
        </div>
        <div class="col-4">
            <input hidden id="idgrupoReglaVehiculo" value="<?php echo $viewGrupoRegla[0]["idgrupoRegla"]?>">
            <button class="btn btn-primary btn-sm btnOpcRegla" data-opcion="addRegla" data-idgrupoRegla="<?php echo $viewGrupoRegla[0]["idgrupoRegla"]?>">Agregar Regla</button>
        </div>
    </div>
    <hr>
        <div class="row">
            <div class="col-12">
                <table id="tableAlist" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                    <thead>
                    <tr>
                        <th class="sticky-col first-col">#</th>
                        <th>Nombre Campo</th>
                        <th>Tag</th>
                        <th>Tipo Regla</th>
                        <th>Opc</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyTareRe" class="list">
                        <?php
                        $contador=0;
                        foreach($detailRegla as $dr){
                            $contador++;
                            ?>
                            <tr>
                                <td><?php echo $contador?></td>
                                <td><?php echo $dr["nombreCampo"]?></td>
                                <td><?php echo $dr["descripcionCampo"]?></td>
                                <td><?php echo $dr["tipoRegla"]?></td>
                                <td style="width: 30%">
                                    <?php if($dr["idtipoRegla"]==1){?>
                                    <?php }else{?>
                                        <button class="btn btn-subtle-secondary me-1 mb-1 btn-sm btnOpcReglaVe" data-opcion="ViewCondicion" data-idreglaVehiculo="<?php echo $dr["idreglaEntrega"]?>"><i class="fas fa-eye"></i></button>
                                    <?php }?>
                                    <button class="btn btn-subtle-danger btn-sm me-1 mb-1" type="button"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>