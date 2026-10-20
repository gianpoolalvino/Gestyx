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
<main class="main" id="top">
    <nav class="navbar navbar-vertical navbar-expand-lg" style="display:none;">
        <script>
            var navbarStyle = window.config.config.phoenixNavbarStyle;
            if (navbarStyle && navbarStyle !== 'transparent') {
                document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
            }
        </script>
        <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <!-- scrollbar removed-->
            <div class="navbar-vertical-content" style="padding-top: 0px">
                <ul class="navbar-nav flex-column" id="navbarVerticalNav">

                    <li class="nav-item">
                        <!-- label-->
                        <p class="navbar-vertical-label">Modulos</p>
                        <?php
                        $navbar = session("modulos");
                        ?>
                        <hr class="navbar-vertical-line"/><!-- parent pages-->
                        <?php foreach ($navbar as $nav) { ?>
                            <?php if ($nav["parent"] != 1) { ?>
                                <div class="nav-item-wrapper">
                                    <a class="nav-link label-1 <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'active' : '' ?>"
                                       href="<?php echo base_url($nav["url"]) ?>"
                                       role="button" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    data-feather="compass"></span></span><span
                                                class="nav-link-text-wrapper"><span
                                                    class="nav-link-text"><?php echo $nav["descripcion"] ?></span></span>
                                        </div>
                                    </a></div>
                            <?php } else { ?>
                                <div class="nav-item-wrapper">
                                    <a class="nav-link dropdown-indicator label-1"
                                       href="#nv-<?php echo $nav["idgrupoModulo"] ?>"
                                       role="button" data-bs-toggle="collapse" aria-expanded="false"
                                       aria-controls="nv-faq">
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown-indicator-icon"><span
                                                    class="fas fa-caret-right"></span></div>
                                            <span class="nav-link-icon"><span
                                                    data-feather="help-circle"></span></span><span
                                                class="nav-link-text"><?php echo $nav["descripcion"] ?></span><span
                                                class="fa-solid fa-circle text-info ms-1 new-page-indicator"
                                                style="font-size: 6px"></span>
                                        </div>
                                    </a>
                                    <div class="parent-wrapper label-1">
                                        <ul class="nav collapse parent <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'show' : '' ?>"
                                            data-bs-parent="#navbarVerticalCollapse"
                                            id="nv-<?php echo $nav["idgrupoModulo"] ?>">
                                            <li class="collapsed-nav-item-title d-none"><?php echo $nav["descripcion"] ?></li>
                                            <?php
                                            $snv = explode("@@", $nav["contenido"]);
                                            // Primero ordenamos el array $snv en base al valor de $datsnv[4]
                                            usort($snv, function($a, $b) {
                                                // Separamos los elementos de cada cadena
                                                $datsnv_a = explode("##", $a);
                                                $datsnv_b = explode("##", $b);

                                                // Si el campo $datsnv[4] no está vacío, lo usamos para comparar
                                                $order_a = isset($datsnv_a[4]) && $datsnv_a[4] !== '' ? (int)$datsnv_a[4] : PHP_INT_MAX;
                                                $order_b = isset($datsnv_b[4]) && $datsnv_b[4] !== '' ? (int)$datsnv_b[4] : PHP_INT_MAX;

                                                // Comparamos los valores de $datsnv[4], los que sean vacíos se colocan al final
                                                return $order_a - $order_b;
                                            });

                                            foreach ($snv as $snnv) {
                                                $datsnv = explode("##", $snnv);
                                                // Verificamos si el valor en el índice 5 es igual a 1
                                                $is_parent = isset($datsnv[5]) && $datsnv[5] == '1';
                                                ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo (isset($idmodulo)) ? (($datsnv[0] == $idmodulo) ? 'active' : '') : '' ?>"
                                                       href="<?php echo $is_parent ? base_url($datsnv[2]) : '#' ?>"
                                                       data-bs-toggle="" aria-expanded="false">
                                                        <div class="d-flex align-items-center">
                                                            <span class="nav-link-text"><?php echo $datsnv[1] ?></span>
                                                        </div>
                                                    </a><!-- more inner pages-->
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-vertical-footer">
            <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
                <span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span
                    class="navbar-vertical-footer-text ms-2">Reducir Menu</span></button>
        </div>
    </nav>
    <nav class="navbar navbar-top fixed-top navbar-expand-lg" id="navbarCombo" data-navbar-top="combo"
         data-move-target="#navbarVerticalNav" style="display:none;">
        <div class="navbar-logo">
            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                    aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span
                    class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="#">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center"><img
                            src="<?php echo base_url("resource/img/logo.png") ?>"
                            alt="phoenix" width="27"/>
                        <p class="logo-text ms-2 d-none d-sm-block">LOGISTICA <small>V7.9 (<i class="fas fa-link"></i>&nbsp;Integration WSP)</small></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center"
             id="navbarTopCollapse">
        </div>
        <ul class="navbar-nav navbar-nav-icons flex-row">

            <li class="nav-item">
                <?php
                $database = session("database");
                if (isset($database)) { ?>
                    <span style='font-size: 12px'
                          class="badge badge-phoenix badge-phoenix-<?php echo ($database != 'logistica_test') ? 'info' : 'secondary' ?>"><?php echo ($database != 'logistica_test') ? 'Entorno de Produccion : ' . $database : 'Entorno de Capacitacion' ?></span>
                <?php } else { ?>
                    <span style='font-size: 12px' class="badge badge-phoenix badge-phoenix-info">Entorno de Produccion: Peru</span>
                <?php }
                ?>
            </li>

            <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2"><input
                        class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                        data-theme-control="phoenixTheme" value="dark" id="themeControlToggle"/><label
                        class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" title="Cambie Color"><span class="icon"
                                                                                                     data-feather="moon"></span></label><label
                        class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" title="Cambie Color"><span class="icon"
                                                                                                     data-feather="sun"></span></label>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" data-bs-auto-close="outside" aria-expanded="false"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
                    </svg></a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nine-dots shadow border" aria-labelledby="navbarDropdownNindeDots">
                    <div class="card bg-body-emphasis position-relative border-0">
                        <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 10rem;">
                            <div class="row text-center align-items-center gx-0 gy-0">
                                <div class="col-4"><a class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3" href="javascript:void(0);" onclick="window.open('<?php echo base_url("ChatWsp/Index"); ?>', '_blank', 'width=1260,height=788');">
                                        <img src="<?php echo base_url("resource/img/whatsapp_logo.png")?>" alt="" width="50">
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Whatsapp</p>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#" role="button"
                                             data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                                             aria-expanded="false">
                    <div class="avatar avatar-l ">
                        <?php $imagen = session("imagenUsuario"); ?>
                        <img class="rounded-circle "
                             src="<?php echo base_url($imagen) ?>"
                             alt=""/>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border"
                     aria-labelledby="navbarDropdownUser">
                    <div class="card position-relative border-0">
                        <div class="card-body p-0">
                            <div class="text-center pt-4 pb-3">
                                <div class="avatar avatar-xl ">
                                    <img class="rounded-circle "
                                         src="<?php echo base_url($imagen) ?>"
                                         alt=""/>
                                </div>

                                <h6 class="mt-2 text-body-emphasis"><?php echo session("nombres") ?></h6>
                            </div>
                            <div class="mb-3 mx-3"><input class="form-control form-control-sm" id="statusUpdateInput"
                                                          type="text" placeholder="Update your status"/></div>
                        </div>
                        <div class="card-footer p-0 border-top border-translucent">
                            <div class="px-3"><br>
                                <div class="col-12 text-center">
                                    <strong id="alertConecSocket" style="width: 100%"></strong>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="input-group">
                                        <button class="btn btn-outline-primary btn-sm" type="button"
                                                id="btnUploadPerfil" style="width:50%">Perfil de Usuario
                                        </button>
                                        <button class="btn btn-outline-info btn-sm" id="BtnCreateReporteGarantia"
                                                style="width:50%"><i class="fas fa-car-mechanic"></i>&nbsp;Reportar
                                            Garantia
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <a class="btn btn-phoenix-secondary d-flex flex-center w-100" id="btnLougOut" href="#!">
                                    <span class="me-2" data-feather="log-out"> </span>Cerrar Sesion</a><br>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
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

