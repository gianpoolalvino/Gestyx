<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .select2-container .select2-selection--single {
        height: 34px; /* Cambia este valor según el tamaño que desees */
        line-height: 40px; /* Asegura que el texto se alinee verticalmente */
    }
    .select2-container .select2-selection--single span {
        font-size: 12px;  /* Ajusta el tamaño de la fuente */
        padding-top: 5px;  /* Ajusta el padding superior para centrar el texto */
        padding-bottom: 5px;  /* Ajusta el padding inferior si es necesario */
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 23px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px;
    }
</style>
<div class="modal-body">
    <form method="POST" id="formSaveWsp" action="<?php echo base_url("Administrador/ConfigurarWhatsapp/SaveEditDelete/StorageAgenteWhatsapp")?>">
        <div class="row pb-2">
            <div class="col-12" style="text-align: center">
                <h5>Asocie Agentes al Whatsapp <?php echo $whatsapp[0]["numero"]?></h5>
            </div>
        </div>
        <input hidden name="idsessionWhatsapp" id="idsessionWhatsapp" value="<?php echo $idsessionWhatsapp?>">
        <div class="row pb-2">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-append">
                        <select class="form-select form-control-sm" id="agente" name="agente">
                            <?php foreach($selectAgentes as $sg){?>
                                <option value="<?php echo $sg["idusuario"]?>"><?php echo $sg["nombreUsuario"]?></option>
                            <?php }?>
                        </select>
                    </div>
                    <input class="form-control form-control-sm" name="prioridad" placeholder="Prioridad...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary btn-sm" type="submit">Asociar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row pb-2">
        <div class="col-12">
            <table id="tableAgents" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                <thead>
                <tr>
                    <th class="sticky-col first-col">#</th>
                    <th style="vertical-align: middle">Nombre Agente</th>
                    <th style="vertical-align: middle">Prioridad</th>
                    <th style="vertical-align: middle;width:10%">Acciones</th>
                </tr>
                </thead>
                <tbody id="tbodyAgents">
                    <?php
                        $contador=0;
                        foreach($agentes as $ag){
                            $contador++;?>
                        <tr>
                            <td><?php echo $contador?></td>
                            <td><?php echo $ag["nombreUsuario"]?></td>
                            <td><?php echo $ag["prioridad"]?></td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm btnTrashAgent" data-idusuario="<?php echo $ag["idusuario"]?>"  data-id="<?php echo $ag["idagenteWhatsapp"]?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row pb-2">
        <div class="col-12">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                CERRAR
            </button>
        </div>
    </div>
</div>