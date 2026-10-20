<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/phoenix/v1.14.0/demo/combo-nav.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jan 2024 17:38:10 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>LOGISTICA V4.2</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/apple-touch-icon.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/favicon-16x16.png") ?>">
    <link rel="shortcut icon" type="image/x-icon"
          href="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/favicon.ico") ?>">
    <link rel="manifest" href="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/manifest.json") ?>">
    <meta name="msapplication-TileImage"
          content="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/mstile-150x150.png") ?>">
    <meta name="theme-color" content="#ffffff">
    <script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/imagesloaded/imagesloaded.pkgd.min.js") ?>"></script>
    <script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/simplebar/simplebar.min.js") ?>"></script>
    <script src="<?php echo base_url("resource/plugin/phoenixv1/assets/js/config.js") ?>"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resource/plugin/fontawesomepro5/css/all.css") ?>">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
          rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/simplebar/simplebar.min.css") ?>"
          rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("resource/plugin/iziToast/dist/css/iziToast.css") ?>">
    <link rel="stylesheet"
          href="<?php echo base_url("resource/plugin/phoenixv1/unicons.iconscout.com/release/v4.0.8/css/line.css") ?>">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/assets/css/theme-rtl.min.css") ?>" type="text/css"
          rel="stylesheet" id="style-rtl">
    <link rel="stylesheet" href="<?php echo base_url("resource/plugin/preloader/src/css/HoldOn.css") ?>">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/assets/css/theme.min.css") ?>" type="text/css"
          rel="stylesheet" id="style-default">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/assets/css/user-rtl.min.css") ?>" type="text/css"
          rel="stylesheet" id="user-style-rtl">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/assets/css/user.min.css") ?>" type="text/css"
          rel="stylesheet" id="user-style-default">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/choices/choices.min.css") ?>" type="text/css"
          rel="stylesheet" id="user-style-default">
    <link href="<?php echo base_url("resource/plugin/canvasJquery/css/bcPaint.css") ?>" type="text/css"
          rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/canvasJquery/css/bcPaint.mobile.css") ?>" type="text/css"
          rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/select2/dist/css/select2.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet/leaflet.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet.markercluster/MarkerCluster.css") ?>"
          rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet.markercluster/MarkerCluster.Default.css") ?>"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <style>

        .table-container {
            height: 100vh; /* Ajusta la altura según sea necesario */
            overflow-y: auto; /* Permite el desplazamiento vertical */
            border: 1px solid #ddd; /* Opcional: agrega un borde alrededor del contenedor */
        }

        .table-container thead th {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #bababa;
            color: #414141
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Opcional: para que las celdas se unan sin bordes dobles */
        }

        th, td {
            border: 1px solid #ddd; /* Opcional: agrega un borde a las celdas */
            padding: 8px; /* Opcional: agrega un poco de relleno dentro de las celdas */
            text-align: left; /* Opcional: alinea el texto a la izquierda */
        }


    </style>

</head>
<body>
<div class="table-container">
    <table class="table table-responsive-sm table-hover table-bordered table-sm fs-9 mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>Vin</th>
            <th>Evento</th>
            <th>Fecha y Hora</th>
            <th>Tipo Evento</th>
        </tr>
        </thead>
        <tbody id="tbodyLogs">
        <?php
        $contador = 0;
        foreach ($detail as $di) {
            $contador++;
            ?>
            <tr>
                <td><?php echo $contador ?></td>
                <td><?php echo $di["nombreUsuario"] ?></td>
                <td><?php echo $di["vin"] ?></td>
                <td><?php echo $di["eventoRealizado"] ?></td>
                <td><?php echo $di["fechaHoraEvento"] ?></td>
                <td>Realizado</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>