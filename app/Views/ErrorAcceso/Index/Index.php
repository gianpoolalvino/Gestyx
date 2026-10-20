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
        color: white;
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

    .message-container {
        display: flex;
        justify-content: center;
        align-items: center;  /* Centrado vertical */
        flex-direction: column;   /* Asegura que los elementos estén apilados verticalmente */
        height: 100%; /* Full height of the card */
        text-align: center;
        font-size: 20px;
        padding: 20px;
    }

    .sad-face {
        font-size: 40px;
        margin-left: 10px;
    }

    .card {
        border: 0px;
        border-radius: 0px;
    }

    .card-body {
        padding: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    h4 {
        margin-bottom: 10px; /* Añade espacio debajo del título */
    }

    .message-text {
        display: block; /* Asegura que el texto del mensaje se muestra debajo del título */
        margin-top: 10px; /* Espaciado entre el encabezado y el mensaje largo */
        text-align: center; /* Asegura que el texto largo esté centrado */
    }

    <?php
    date_default_timezone_set("America/Lima");
    $hoy = date("Y-m-d");
    $hora = date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>

<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">
            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-body" style="padding:0px">
                    <!-- Message centered inside the card -->
                    <div class="message-container">
                        <i class="far fa-sad-tear fa-2x"></i>
                        <h4 style="margin-bottom: 0px">No tiene acceso a este módulo</h4>
                        <span class="message-text" style="margin-top: 0px;font-size: 14px">Usted no tiene acceso a este módulo, valide sus permisos o comuniquese con el Administrador.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
