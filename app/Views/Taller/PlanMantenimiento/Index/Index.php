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
        background: #141824;
        color: white
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
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Taller / <small>Plan de Mantenimiento</small></h3>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 45%">
                                    <div class="input-group">
                                        <select class="form-select form-select-sm" id="selectMarca"
                                                aria-label=".form-select-sm example">
                                            <option selected value="">Seleccione Marca</option>
                                            <?php foreach($selectMarca as $smc){?>
                                                <option value="<?php echo $smc["idmarca"]?>"><?php echo $smc["codigo"]." - ".$smc["descripcion"]?></option>
                                            <?php }?>
                                        </select>
                                        <div class="input-group-append">
                                            <select class="form-select form-select-sm" id="selectModelo"
                                                    aria-label=".form-select-sm example">
                                                <option selected value="">Seleccione Modelo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group-prepend">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Buscar</button>
                                    <button class="btn btn-outline-info btn-sm" id="btnViewPlan"><i
                                            class="fas fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4" style="text-align: right">
                            <button id="btnCreatePlan" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>&nbsp;Nuevo Plan</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>