<style>

    .tableFixHead {
        overflow: auto;
        height: calc(100vh - 184px);
        white-space: nowrap;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background:#141824;
        color:white
    }

    /* Just common table stuff. Really. */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    .fixed-bottom {
        padding-top: 8px;
        padding-bottom: 8px;
        border-top: solid 1.5px #b9b9b9;
    }

    <?php
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>
<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Comisiones / <small>Regla de Comisiones</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <select class="form-select form-select-sm" id="marcas" aria-label=".form-select-sm example">
                                                <option selected value="">Todas las Marcas</option>
                                                <?php foreach($selectMarca as $sm){?>
                                                    <option value="<?php echo $sm["idmarca"]?>"><?php echo $sm["descripcion"]?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group-append">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    <button class="btn btn-success btn-sm" type="button" id="btnNuevaRegla"><i class="fas fa-plus"></i>&nbsp;Nueva Regla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Marca</th>
                                <th>Fecha</th>
                                <th>Conceptos</th>
                                <th>Categorias</th>
                                <th>Opc</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>