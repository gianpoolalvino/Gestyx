<div class="modal-body">

    <div class="row g-6">
        <div class="col-12 col-xl-4">
            <div class="card mb-5">
                <div class="card-header hover-actions-trigger position-relative mb-6" style="min-height: 130px; ">
                    <div class="bg-holder rounded-top"
                         style="background-image: linear-gradient(0deg, #084f83 -3%, rgba(103,201,255,0.15) 83%), url(../../assets/img/generic/59.png)">
                        <label
                            class="cover-image-file-input" for="upload-settings-cover-image"></label>
                        <div class="hover-actions end-0 bottom-0 pe-1 pb-2 text-white dark__text-gray-1100">
                            <svg class="svg-inline--fa fa-camera me-2" aria-hidden="true" focusable="false"
                                 data-prefix="fas" data-icon="camera" role="img" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor"
                                      d="M149.1 64.8L138.7 96H64C28.7 96 0 124.7 0 160V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H373.3L362.9 64.8C356.4 45.2 338.1 32 317.4 32H194.6c-20.7 0-39 13.2-45.5 32.8zM256 192a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"></path>
                            </svg><!-- <span class="fa-solid fa-camera me-2"></span> Font Awesome fontawesome.com -->
                        </div>
                    </div>
                    <label
                        class="avatar avatar-4xl status-online feed-avatar-profile cursor-pointer"
                        for="upload-settings-porfile-picture"><img
                            class="rounded-circle img-thumbnail shadow-sm border-0"
                            src="#" width="200" alt=""></label>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-wrap mb-2 align-items-center">
                                <h3 class="me-2">Crear Usuario en el Sistema</h3><span class="fw-normal fs-8">st/En Linea</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-8">
            <div class="border-bottom mb-4">
                <form method="POST" id="formCreatePerfil" action="<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/CreatePerfil")?>">
                    <div class="mb-6">
                        <h4 class="mb-4">Informacion Personal</h4>
                        <div class="row g-3">
                            <div class="col-12 col-sm-12">
                                <div class="form-icon-container">
                                    <div class="form-floating"><input class="form-control form-icon-input" name="nombres" id="nombres"
                                                                      type="text" placeholder="Nombres"><label
                                            class="text-body-tertiary form-icon-label" for="firstName">Nombres</label></div>
                                    <svg class="svg-inline--fa fa-user text-body fs-9 form-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="user" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path>
                                    </svg>
                                    <!-- <span class="fa-solid fa-user text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-icon-container">
                                    <div class="form-floating"><input class="form-control form-icon-input" id="primerApellido" name="primerApellido"
                                                                      type="text" placeholder="Primer Apellido"><label
                                            class="text-body-tertiary form-icon-label" for="lastName">Primer Apellido</label>
                                    </div>
                                    <svg class="svg-inline--fa fa-user text-body fs-9 form-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="user" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path>
                                    </svg>
                                    <!-- <span class="fa-solid fa-user text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-icon-container">
                                    <div class="form-floating"><input class="form-control form-icon-input" id="segundoApellido" name="segundoApellido"
                                                                      type="text" placeholder="Segundo Apellido"><label
                                            class="text-body-tertiary form-icon-label" for="lastName">Segundo Apellido</label>
                                    </div>
                                    <svg class="svg-inline--fa fa-user text-body fs-9 form-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="user" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path>
                                    </svg>
                                    <!-- <span class="fa-solid fa-user text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-icon-container">
                                    <div class="form-floating"><input class="form-control form-icon-input" id="correoElectronico" name="correoElectronico"
                                                                      type="email" placeholder="Correo Electronico"><label
                                            class="text-body-tertiary form-icon-label" for="emailSocial">Correo Electronico</label></div>
                                    <svg class="svg-inline--fa fa-envelope text-body fs-9 form-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="envelope" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                    </svg>
                                    <!-- <span class="fa-solid fa-envelope text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-icon-container">
                                    <div class="form-floating"><input class="form-control form-icon-input" id="telefono" name="telefono"
                                                                      type="tel" placeholder="Telefono"><label
                                            class="text-body-tertiary form-icon-label" for="phone">Telefono</label></div>
                                    <svg class="svg-inline--fa fa-phone text-body fs-9 form-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="phone" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                    </svg>
                                    <!-- <span class="fa-solid fa-phone text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="form-icon-container">
                                    <div class="form-floating"><textarea class="form-control form-icon-input" id="info" name="info"
                                                                         style="height: 115px;"
                                                                         placeholder="Info"></textarea><label
                                            class="text-body-tertiary form-icon-label" for="info">Informacion Breve</label></div>
                                    <svg class="svg-inline--fa fa-circle-info text-body fs-9 form-icon" aria-hidden="true"
                                         focusable="false" data-prefix="fas" data-icon="circle-info" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
                                    </svg>
                                    <!-- <span class="fa-solid fa-circle-info text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-3 mb-6 gy-6 gy-sm-3">
                        <div class="col-12 col-sm-6">
                            <h4 class="mb-4">Informacion Empresa</h4>
                            <div class="form-icon-container mb-3">
                                <div class="form-floating"><input class="form-control form-icon-input" value="AUTONIZA" readonly id="companyName"
                                                                  type="text" placeholder="Nombre Empresa"><label
                                        class="text-body-tertiary form-icon-label" for="companyName">Nombre Empresa</label></div>
                                <svg class="svg-inline--fa fa-building text-body fs-9 form-icon" aria-hidden="true"
                                     focusable="false" data-prefix="fas" data-icon="building" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16z"></path>
                                </svg>
                                <!-- <span class="fa-solid fa-building text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                            </div>
                            <div class="form-icon-container">
                                <div class="form-floating"><input class="form-control form-icon-input" id="website"
                                                                  type="text"readonly value="www.autoniza.com" placeholder="Sitio Web"><label
                                        class="text-body-tertiary form-icon-label" for="website">Sitio Web</label></div>
                                <svg class="svg-inline--fa fa-globe text-body fs-9 form-icon" aria-hidden="true"
                                     focusable="false" data-prefix="fas" data-icon="globe" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64H348.7c2.2 20.4 3.3 41.8 3.3 64zm28.8-64H503.9c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32H376.7c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0H167.7c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0H18.6C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192H131.2c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64H8.1C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6H344.3c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352H135.3zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6H493.4z"></path>
                                </svg>
                                <!-- <span class="fa-solid fa-globe text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h4 class="mb-4">Crear Contraseña</h4>
                            <div class="form-icon-container mb-3">
                                <div class="form-floating"><input class="form-control form-icon-input" id="newPassword" name="newPassword"
                                                                  type="password" autocomplete="off" placeholder="Nueva Contraseña"><label
                                        class="text-body-tertiary form-icon-label" for="newPassword">Nueva Contraseña</label></div>
                                <svg class="svg-inline--fa fa-key text-body fs-9 form-icon" aria-hidden="true"
                                     focusable="false" data-prefix="fas" data-icon="key" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"></path>
                                </svg>
                                <!-- <span class="fa-solid fa-key text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                            </div>
                            <div class="form-icon-container">
                                <div class="form-floating"><input class="form-control form-icon-input" autocomplete="off" id="newPassword2" name="newPassword2"
                                                                  type="password" placeholder="Confirmar Contraseña"><label
                                        class="text-body-tertiary form-icon-label" for="newPassword2">Confirmar Contraseña</label></div>
                                <svg class="svg-inline--fa fa-key text-body fs-9 form-icon" aria-hidden="true"
                                     focusable="false" data-prefix="fas" data-icon="key" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"></path>
                                </svg>
                                <!-- <span class="fa-solid fa-key text-body fs-9 form-icon"></span> Font Awesome fontawesome.com -->
                            </div>
                        </div>
                    </div>
                    <div class="text-end mb-6">
                        <div>
                            <button type="button" class="btn btn-phoenix-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn btn-phoenix-primary">Crear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>