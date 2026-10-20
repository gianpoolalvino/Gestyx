<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <form id="formAccess" method="POST" action="<?php echo base_url("Index/Access") ?>">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                        class="d-flex flex-center text-decoration-none mb-4">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                style="border-radius: 15px;width: 100%"
                                src="<?php echo base_url("resource/img/logoAutoniza.png") ?>"
                                alt="phoenix" width="100"/></div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Gestyx</h3>
                        <p class="text-body-tertiary" style="font-size: 10px">V10 <br><small>(<i class="fas fa-link"></i>&nbsp;Notifications & Synchronizations)</small></p>
                        <div id="alertsLogin">

                        </div>
                        <div class="mb-3 text-start"><label class="form-label" for="email">Correo Autoniza</label>
                            <div class="form-icon-container"><input class="form-control form-icon-input inputLogin"
                                                                    autocomplete="off" name="email" id="email"
                                                                    type="email" placeholder="name@example.com"/><span
                                    class="fas fa-user text-body fs-9 form-icon"></span></div>
                        </div>
                        <div class="mb-3 text-start"><label class="form-label" for="password">Contraseña</label>
                            <div class="form-icon-container"><input class="form-control form-icon-input inputLogin"
                                                                    autocomplete="off" name="password" id="password"
                                                                    type="password" placeholder="Password"/><span
                                    class="fas fa-key text-body fs-9 form-icon"></span></div>
                        </div>
                        <div class="mb-3 text-start"><label class="form-label" for="password">Base de Datos</label>
                            <div class="form-icon-container">
                                <select class="form-control form-icon-input inputLogin" required name="database" id="database">
                                    <option value="">Seleccione Operacion</option>
                                    <option value="logisticaperutest">Entorno de Capacitacion: Peru</option>
                                    <option value="logisticacolombiatest">Entorno de Capacitacion: Colombia</option>
                                </select>
                                <span
                                    class="fas fa-database text-body fs-9 form-icon"></span></div>
                        </div>
                        <div class="row flex-between-center mb-7">
                            <div class="col-auto">
                                <div class="form-check mb-0"><input class="form-check-input inputLogin"
                                                                    id="basic-checkbox"
                                                                    type="checkbox" checked="checked"/><label
                                        class="form-check-label mb-0" for="basic-checkbox">Recordar</label></div>
                            </div>

                        </div>
                        <button class="btn btn-primary w-100 mb-3" id="btnIngresar" type="submit">Ingresar</button>
                    </div>
                </div>
            </div>
    </form>
</main><!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
