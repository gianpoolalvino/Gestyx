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
        <div class="col-12">
            <h6>Nueva Regla Tiempo Entrega</h6>
        </div>
    </div>
    <hr>
    <form id="formSaveBox" method="POST"
          action="<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/SaveRegla") ?>">
        <input hidden name="idreglaVehiculo" id="idreglaVehiculo" value="<?php echo $idreglaEntrega?>">
        <div class="row" style="padding-bottom: 8px">
            <div class="col-5">
                <div class="form-floating">
                    <select class="form-select" disabled
                            aria-label="Floating label select example">
                        <option selected
                                value=""><?php echo $regla[0]["tipoRegla"]?></option>
                    </select>
                    <label for="floatingSelect">Tipo de Regla</label>
                </div>
            </div>
            <div class="col-5">
                <div class="form-floating">
                    <select class="form-select" disabled
                            aria-label="Floating label select example">
                        <?php foreach($camposRegla as $cr){?>
                            <?php if($regla[0]["idcampoVehiculo"]==$cr["idcampoVehiculo"]){?>
                                <option value="<?php echo $cr["idcampoVehiculo"]?>"><?php echo $cr["nombreCampoVehiculo"]?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Campo Regla</label>
                </div>
            </div>
            <div class="col-2">
                <button class="btn btn-outline-primary btn-sm" type="button" id="btnAddCondicion">Generar Condicion</button>
            </div>
        </div>
            <div class="row">
                <div class="col-12">
                    <table id="tableAlist" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                        <thead>
                        <tr>
                            <th class="sticky-col first-col">#</th>
                            <th>Valor</th>
                            <th>Operador</th>
                            <th>Tiempo</th>
                            <th>Opc</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyTare" class="list">
                            <?php
                            $contador=0;
                            foreach($detailCondiciones as $op){
                                $contador++;?>
                                <tr>
                                    <td><?php echo $contador?></td>
                                    <td><?php echo $op["valor"]?></td>
                                    <td><?php echo $op["operador"]?></td>
                                    <td><?php echo $op["dias"]?></td>
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm btnOpcCondicion" type="button" data-idcondicionRegla="<?php echo $op["iddetalleReglaEntrega"]?>"><i class="fas fa-trash"></i></button>
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
    </form>
</div>