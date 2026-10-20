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
    .logoBar{
        display: none !important;
    }
    .navigation-wrapper{
        display:none !important;
    }
    .socialSharing{
        display:none !important;
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
                            <h3 class="mb-2">Power Bi / <small>Reporte RR.HH - Peru</small></h3>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <iframe title="PRINCIPAL" width="100%" height="100%"
                            src="https://app.powerbi.com/view?r=eyJrIjoiZDg0MzI5OGEtMDJiYi00N2FlLTlhYjMtOTMzYTBhM2YxMjdiIiwidCI6IjM2YjU0MzU1LTM4NzEtNDI0MC1iMWVlLTNlNjVlZWVhYmI5MyIsImMiOjR9"
                            frameborder="0" allowFullScreen="true"></iframe>                </div>
            </div>
        </div>
    </div>
</div>
