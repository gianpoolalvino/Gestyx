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
    <title>LOGISTICA V7.9 (Integration WSP)</title>

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

    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <link href="<?php echo base_url("resource/plugin/select2/dist/css/select2.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet/leaflet.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet.markercluster/MarkerCluster.css") ?>"
          rel="stylesheet">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet.markercluster/MarkerCluster.Default.css") ?>"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

</head>
<body>
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top" style="height: 100vh">
    <script>
        var navbarTopShape = window.config.config.phoenixNavbarTopShape;
        var navbarPosition = window.config.config.phoenixNavbarPosition;
        var body = document.querySelector('body');
        var navbarDefault = document.querySelector('#navbarDefault');
        var navbarTopNew = document.querySelector('#navbarTopNew');
        var navbarSlim = document.querySelector('#navbarSlim');
        var navbarTopSlimNew = document.querySelector('#navbarTopSlimNew');
        var navbarCombo = document.querySelector('#navbarCombo');
        var documentElement = document.documentElement;
        var navbarVertical = document.querySelector('.navbar-vertical');
        navbarCombo.removeAttribute('style');
        navbarVertical.removeAttribute('style');
        documentElement.setAttribute('data-navigation-type', 'combo');
    </script>

