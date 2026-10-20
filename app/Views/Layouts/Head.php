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
    <title>GESTYX V10.4 (Notifications & Synchronizations)</title>

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
          href="<?php echo base_url("resource/plugin/phoenixv1/assets/img/favicons/logo.ico") ?>">
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
    <link href="<?php echo base_url("resource/plugin/qrcode-reader-master/dist/css/qrcode-reader.css") ?>"
          type="text/css"
          rel="stylesheet" id="style-default">
    <link href="<?php echo base_url("resource/plugin/phoenixv1/vendors/fullcalendar/main.min.css") ?>" type="text/css"
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

    <link href="<?php echo base_url("resource/plugin/alertifyjs/css/alertify.css") ?>" type="text/css"
          rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>


    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css"/>
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

    <style>
        .alertify, .alertify .ajs-modal {
            z-index: 999999 !important;
        }
    </style>
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
                        <?php
                        $labelGrupoModulo = session("labelGrupoModulo");
                        ?>
                        <!-- label-->

                        <?php foreach ($labelGrupoModulo as $lgmd) { ?>
                            <p class="navbar-vertical-label"><?php echo $lgmd["nombre"] ?></p>
                            <?php
                            $navbar = session("grupoModulo");
                            $modulo = session("modulo");
                            $subModulo = session("subModulo");
                            ?>
                            <hr class="navbar-vertical-line"/><!-- parent pages-->
                            <?php foreach ($navbar as $nav) { ?>
                                <?php if ($nav["idlabelGrupoModulo"] == $lgmd["idlabelGrupoModulo"]) { ?>
                                    <?php if ($nav["parent"] != 1) { ?>
                                        <div class="nav-item-wrapper">
                                            <a class="nav-link label-1 labelgrupo <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'active' : '' ?>"
                                                <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'style="background-color:#0055a5;color:white"' : '' ?>
                                               href="<?php echo base_url($nav["url"]) ?>"
                                               role="button" data-bs-toggle="" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span class="nav-link-icon"><img
                                                                style="width: 20px"
                                                                src="<?php echo base_url($nav["icono"]) ?>"></span><span
                                                            class="nav-link-text-wrapper"><span
                                                                class="nav-link-text"><?php echo $nav["descripcion"] ?></span></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="nav-item-wrapper">
                                            <a class="nav-link dropdown-indicator label-1 labelgrupo <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'active' : '' ?>"
                                                <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'style="background-color:#0055a5;color:white"' : '' ?>
                                               href="#nv-<?php echo $nav["idgrupoModulo"] ?>"
                                               role="button" data-bs-toggle="collapse" aria-expanded="false"
                                               aria-controls="nv-faq">
                                                <div class="d-flex align-items-center">
                                                    <div class="dropdown-indicator-icon"><span
                                                                class="fas fa-caret-right"></span></div>
                                                    <span class="nav-link-icon"><img style="width: 20px"
                                                                                     src="<?php echo base_url($nav["icono"]) ?>"></span><span
                                                            class="nav-link-text"><?php echo $nav["descripcion"] ?></span>
                                                </div>
                                            </a>
                                            <div class="parent-wrapper label-1">
                                                <ul class="nav collapse parent <?php echo ($nav["idgrupoModulo"] == $idgrupoModulo) ? 'show' : '' ?>"
                                                    data-bs-parent="#navbarVerticalCollapse"
                                                    id="nv-<?php echo $nav["idgrupoModulo"] ?>">
                                                    <li class="collapsed-nav-item-title d-none"><?php echo $nav["descripcion"] ?></li>
                                                    <?php
                                                    foreach ($modulo as $snnv) {
                                                        ?>
                                                        <?php if ($snnv["idgrupoModulo"] === $nav["idgrupoModulo"]) { ?>
                                                            <?php if ($snnv["parentUrl"] != 1) { ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link <?php echo (isset($idmodulo)) ? (($snnv["idmodulo"] == $idmodulo) ? 'active' : '') : '' ?>"
                                                                       href="<?php echo base_url($snnv["url"]) ?>"
                                                                       data-bs-toggle="" aria-expanded="false">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="nav-link-text"><?php echo $snnv["descripcion"] ?></span>
                                                                        </div>
                                                                    </a><!-- more inner pages-->
                                                                </li>
                                                            <?php } else { ?>
                                                                <li class="nav-item"><a
                                                                            class="nav-link dropdown-indicator collapsed <?php echo ($snnv["accesoData"] = 1) ? 'parentUrlData' : '' ?>"
                                                                            href="#nv-submod<?php echo $snnv["idmodulo"] ?>"
                                                                            data-url="<?php echo $snnv["url"] ?>"
                                                                            data-bs-toggle="collapse"
                                                                            aria-expanded="false"
                                                                            aria-controls="nv-basic">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="dropdown-indicator-icon">
                                                                                <svg class="svg-inline--fa fa-caret-right"
                                                                                     aria-hidden="true"
                                                                                     focusable="false"
                                                                                     data-prefix="fas"
                                                                                     data-icon="caret-right"
                                                                                     role="img"
                                                                                     xmlns="http://www.w3.org/2000/svg"
                                                                                     viewBox="0 0 256 512"
                                                                                     data-fa-i2svg="">
                                                                                    <path fill="currentColor"
                                                                                          d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path>
                                                                                </svg>
                                                                            </div>
                                                                            <span class="nav-link-text"><?php echo $snnv["descripcion"] ?></span>
                                                                        </div>
                                                                    </a><!-- more inner pages-->
                                                                    <div class="parent-wrapper">
                                                                        <ul class="nav collapse parent <?php echo ($snnv["idmodulo"] == $idmodulo) ? 'show' : '' ?>"
                                                                            data-bs-parent="#forms"
                                                                            id="nv-submod<?php echo $snnv["idmodulo"] ?>">
                                                                            <?php foreach ($subModulo as $sb) { ?>
                                                                                <?php if ($sb["idmodulo"] == $snnv["idmodulo"]) { ?>
                                                                                    <li class="nav-item"><a
                                                                                                class="nav-link <?php echo (isset($idsubModulo)) ? (($sb["idsubModuloPrincipal"] == $idsubModulo) ? 'active' : '') : '' ?>"
                                                                                                href="<?php echo base_url($sb["url"]) ?>"
                                                                                                data-bs-toggle=""
                                                                                                aria-expanded="false">
                                                                                            <div class="d-flex align-items-center"><span
                                                                                                        class="nav-link-text"><?php echo $sb["nombre"] ?></span>
                                                                                            </div>
                                                                                        </a><!-- more inner pages-->
                                                                                    </li>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-vertical-footer">
            <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
                <i class="far fa-arrow-circle-right fa-1x"></i>&nbsp;<span
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
            <a class="navbar-brand me-1 me-sm-3" href="#" id="btnHistorySincroniza">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div id="icon" style="display:block">
                            <img src="<?php echo base_url("resource/img/logo.png") ?>"
                                 alt="phoenix" width="27"/>
                        </div>
                        <div id="iconExecute" style="display: none">
                            <button class="btn btn-subtle-dark btn-sm" id="btnViewSincronizacion" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="fas fa-solid fa-sync fa-spin fa-1x"></i></button>
                        </div>

                        <p class="logo-text ms-2 d-none d-sm-block">GESTYX <small>V10.4 (<i class="fas fa-link"></i>&nbsp;Notifications
                                & Synchronizations)</small></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center"
             id="navbarTopCollapse">
        </div>


        <div class="search-box navbar-top-search-box d-none d-lg-block"
             data-list="{&quot;valueNames&quot;:[&quot;title&quot;]}" style="width:25rem;">
            <?php
            $database = session("database");
            if (isset($database)) { ?>
                <span style='font-size: 12px'
                      class="badge badge-phoenix badge-phoenix-<?php echo ($database != 'logistica_test') ? 'info' : 'secondary' ?>"><?php echo ($database != 'logistica_test') ? 'Entorno de Produccion : ' . $database : 'Entorno de Capacitacion' ?></span>
            <?php } else { ?>
                <span style='font-size: 12px'
                      class="badge badge-phoenix badge-phoenix-info">Entorno de Produccion: Peru</span>
            <?php }
            ?>

        </div>


        <ul class="navbar-nav navbar-nav-icons flex-row">

            <li class="nav-item">

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
                <a class="nav-link" href="#" style="min-width: 2.25rem" role="button" data-bs-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
                    <i class="far fa-bell fa-2x"></i>
                        <span class="badge bg-danger-dark ms-2" id="notificacionIcon" style="margin-left: -7px !important;display:none"><span id="notificationNumber">0</span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border navbar-dropdown-caret"
                     id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
                    <div class="card position-relative border-0">
                        <div class="card-header p-2">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-body-emphasis mb-0">Notificatons</h5>
                                <button class="btn btn-link p-0 fs-9 fw-normal" type="button">Mark all as read</button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="scrollbar-overlay" style="height: 17rem;" data-simplebar="init">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                                 aria-label="scrollable content"
                                                 style="height: auto; overflow: hidden;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <div class="px-2 px-sm-3 py-3 notification-card position-relative read border-bottom">
                                                        <div class="d-flex align-items-center justify-content-between position-relative">
                                                            <div class="d-flex">
                                                                <div class="flex-1 me-sm-3">
                                                                    <h4 class="fs-9 text-body-emphasis">Nuevo Vehiculo Facturado</h4>
                                                                    <p class="fs-9 text-body-highlight mb-2 mb-sm-3 fw-normal">
                                                                        <span class="me-1 fs-10"><i class="fas fa-car"></i></span>Chevrolet - CAPTIVA - 2025
                                                                    </p>

                                                                </div>
                                                            </div>
                                                            <div class="d-none d-sm-block">
                                                                <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        data-boundary="window" aria-haspopup="true"
                                                                        aria-expanded="false"
                                                                        data-bs-reference="parent">
                                                                    <svg class="svg-inline--fa fa-ellipsis fs-10 text-body"
                                                                         aria-hidden="true" focusable="false"
                                                                         data-prefix="fas" data-icon="ellipsis"
                                                                         role="img" xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 448 512" data-fa-i2svg="">
                                                                        <path fill="currentColor"
                                                                              d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path>
                                                                    </svg>
                                                                    <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end py-2"><a
                                                                            class="dropdown-item" href="#!">Mark as
                                                                        unread</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar"
                                         style="height: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-0 border-top border-translucent border-0">
                            <div class="my-2 text-center fw-bold fs-10 text-body-tertiary text-opactity-85"><a
                                        class="fw-bolder" href="pages/notifications.html">Notification history</a></div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="navbarDropdownNindeDots" href="#" role="button" data-bs-toggle="dropdown"
                   aria-haspopup="true" data-bs-auto-close="outside" aria-expanded="false">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                        <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="8" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="14" r="2" fill="currentColor"></circle>
                        <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
                        <circle cx="14" cy="2" r="2" fill="currentColor"></circle>
                    </svg>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-nine-dots shadow border"
                     aria-labelledby="navbarDropdownNindeDots">
                    <div class="card bg-body-emphasis position-relative border-0">
                        <div class="card-body pt-3 px-3 pb-0 overflow-auto scrollbar" style="height: 10rem;">
                            <div class="row text-center align-items-center gx-0 gy-0">
                                <div class="col-4"><a
                                            class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                            href="javascript:void(0);"
                                            onclick="window.open('<?php echo base_url("ChatWsp/Index"); ?>', '_blank', 'width=1260,height=788');">
                                        <img src="<?php echo base_url("resource/img/whatsapp_logo.png") ?>" alt=""
                                             width="50">
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Whatsapp</p>
                                    </a></div>
                                <div class="col-4"><a
                                            class="d-block bg-body-secondary-hover p-2 rounded-3 text-center text-decoration-none mb-3"
                                            id="btnScan"
                                            href="#">
                                        <i class="fal fa-scanner-keyboard fa-3x text-dark"></i>
                                        <p class="mb-0 text-body-emphasis text-truncate fs-10 mt-1 pt-1">Scaner Qr</p>
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

