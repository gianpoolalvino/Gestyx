</main><!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="<?php echo base_url('resource/plugin/jquery3/jquery3.js') ?>"></script>
<script src="<?php echo base_url('resource/plugin/select2/dist/js/select2.js')?>"></script>
<script src="<?php echo base_url("resource/plugin/fontawesomepro5/js/all.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/popper/popper.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/iziToast/dist/js/iziToast.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/bootstrap/bootstrap.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/anchorjs/anchor.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/is/is.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/fontawesome/all.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/lodash/lodash.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/polyfill.io/v3/polyfill.min58be.js?features=window.scroll") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/list.js/list.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/feather-icons/feather.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/dayjs/dayjs.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/assets/js/phoenix.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/echarts/echarts.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet/leaflet.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet.markercluster/leaflet.markercluster.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/assets/js/ecommerce-dashboard.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/list.js/list.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/choices/choices.min.js") ?>"></script>
<script src="<?php echo base_url("resource/plugin/alertifyjs/alertify.js") ?>"></script>
<script src="https://unpkg.com/fabric@5.3.0/dist/fabric.min.js"></script>
<script src="<?php echo base_url("resource/plugin/preloader/src/js/HoldOn.js")?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<div class="modal fade" id="ModalGuiaRemision" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
        <div class="modal-content">
            <div id="BodyGuiaRemision">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalInfoVehiculo" data-bs-backdrop="static" style="backdrop-filter: blur(4px);overflow-y: scroll !important;" tabindex="-1" aria-labelledby="staticBackdropLabel verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div id="bodyInfoVehicular">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalOpcionesAdicionales" style="backdrop-filter: blur(4px);overflow-y: scroll !important;" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:1px solid #3f3f3f">
            <div class="modal-body">
                <div id="BodyOpcionesAdicionales"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFiltrosData" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div id="bodyFiltrosData">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDiagramaVehiculo" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div id="BodyDiagramaVehiculo">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalUploadResource" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div id="bodyuploadResource"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRetornoEvento" style="backdrop-filter: blur(4px);overflow-y: scroll !important;" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:1px solid #3f3f3f">
            <div class="modal-body">
                <div id="BodyRetornoEvento"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAdicionales" data-bs-backdrop="static" style="backdrop-filter: blur(4px);overflow-y: scroll !important;" tabindex="-1" aria-labelledby="staticBackdropLabel verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:1px solid #3f3f3f">
            <div class="modal-body">
                <div id="BodyAdicionales"></div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" id="offcanvasRight" tabindex="-1" aria-labelledby="offcanvasRightLabel">
    <div id="ModalRight">

    </div>
</div><!-- Left Offcanvas-->


<div class="modal fade" id="ModalLogOut" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center">
                        <i class="far fa-sad-tear fa-3x text-danger"></i>
                        <h6 class="text-danger">¿Realmente desea cerrar sesion del sistema?</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="<?php echo base_url("Index/DestroySession") ?>" class="btn btn-danger btn-sm">Cerrar
                            Sesion</a>
                        <button class="btn btn-default btn-sm" id="btnCloseModalSession">Cancelar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var ModalGuiaRemision = new bootstrap.Modal(document.getElementById('ModalGuiaRemision'), {
        keyboard: false
    });

    var ModalInfoVehiculo = new bootstrap.Modal(document.getElementById('ModalInfoVehiculo'), {
        keyboard: false
    });

    var ModalOpcionesAdicionales = new bootstrap.Modal(document.getElementById('ModalOpcionesAdicionales'), {
        keyboard: false
    });

    var ModalRetornoEvento = new bootstrap.Modal(document.getElementById('ModalRetornoEvento'), {
        keyboard: false
    });

    var ModalFiltrosData = new bootstrap.Modal(document.getElementById('ModalFiltrosData'), {
        keyboard: false
    });

    var ModalDiagramaVehiculo = new bootstrap.Modal(document.getElementById('ModalDiagramaVehiculo'), {
        keyboard: false
    });

    var ModalUploadResource = new bootstrap.Modal(document.getElementById('ModalUploadResource'), {
        keyboard: false
    });

    var ModalAdicionales = new bootstrap.Modal(document.getElementById('ModalAdicionales'), {
        keyboard: false
    });

    var ModalSession = new bootstrap.Modal(document.getElementById('ModalLogOut'), {
        keyboard: false
    });

    function AlertSessionRemota(title,message)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Alerts/LogOutRemoto")?>",
            data: {title:title,message:message},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnRetornEvent', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("OpcionesGenerales/RetornarEvento")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    });


    $(document).on('click', '#BtnCreateReporteGarantia', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Garantias/ReporteGarantia/CreateViewEdit/CreateReporte")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnLougOut', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ModalSession.show();
    });

    $(document).on('click', '#btnCloseModalSession', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ModalSession.hide();
    });

    $(document).on('click', '#btnCreateTacha', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateTacha();
    });

    function CreateTacha()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/SinTitulo/CreateViewEdit/CreateTacha")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }


    $(document).on('click', '#btnSearchVinTacha', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var titulo = $("#tituloSearchTacha").val();
        var vin = $("#vinSearchTacha").val();
        if(vin!='' || titulo!=''){
            SearchVinTituloTacha(vin,titulo);
        }else{
            var status='warning';
            var title='Campos en blanco';
            var message='No puede dejar ambos campos en blanco';
            Notificacion(status, title, message)
        }
    });

    function SearchVinTituloTacha(vin,titulo) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/SinTitulo/CreateViewEdit/TitulosVigentes")?>",
            data: {vin:vin,titulo:titulo},
            beforeSend: function () {

            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function (xhr) {

            }
        });
    }

    function NotificacionCopy(vin) {
        // blue, red, green, yellow
        iziToast.show({
            title: 'Copia Correcta',
            message: 'El '+vin+' se copio al portapapel',
            color: 'success',
            position: 'bottomCenter',
        });
    }



    function Notificacion(status, title, message) {
        // blue, red, green, yellow
        var color;
        var icon;
        if (status == 'success') {
            icon = '<i class="far fa-check-circle"></i>';
            color = 'green';
        } else if (status == 'warning') {
            icon = '<i class="fas fa-exclamation-triangle"></i>';
            color = 'yellow';
        } else if (status == 'info') {
            icon = '<i class="fas fa-info-circle"></i>';
            color = 'blue';
        } else {
            icon = '<i class="fas fa-exclamation-triangle"></i>';
            color = 'red';
        }
        iziToast.show({
            title: icon + '&nbsp;' + title,
            message: message,
            color: color,
            position: 'topCenter',
        });
    }
    function Preloader(textoCarga)
    {
        var texto='';
        if(textoCarga==''){
            texto='Cargando Datos...'
        }else{
            texto=textoCarga;
        }
        HoldOn.open({
            theme:"sk-folding-cube",
            content:'',
            message:texto,
            background:'black',
            textColor:'white',
        });
    }

    function ClosePreloader()
    {
        HoldOn.close();
    }

</script>

<script>
    function NotificacionSocket(dato)
    {
        var not;
        if(dato=="error"){
            not = '<span id="alertConecSocket" style="font-size: 12px" class="badge badge-phoenix badge-phoenix-danger"><i class="fas fa-wifi-slash"></i>&nbsp;Sin Servidor Socket</span>';
        }else{
            not = '<span id="alertConecSocket" style="font-size: 12px" class="badge badge-phoenix badge-phoenix-primary"><i class="fas fa-wifi"></i>&nbsp;Conectado a Servidor Socket</span>';
        }
        $("#alertConecSocket").html(not);
    }


    $(document).ready(function () {
        //  initSocket();

    });

    function initSocket() {
        socket = new WebSocket("wss://pdicontrol.autoniza.net.pe:5000/");
        // socket = new WebSocket("ws://localhost:5000/");
        socket.onopen = function (msg) {
            NotificacionSocket('success');
        };
        socket.onclose = function (msg) {
            NotificacionSocket('error');
        };
        socket.onmessage = function (msg) {
            try {
                // Convertir la cadena JSON en un objeto JavaScript
                let dato = JSON.parse(msg.data);
                // Mostrar el objeto en un alert (o manejar los datos de otra forma)
                console.log(dato); // Mejor usar console.log para depuración en lugar de alert
                if (dato.evento === 'sessionRemotaFinalizada' && dato.idusuario === '<?= session("idusuario") ?>') {
                    if (dato.status === 'success') {
                        AlertSessionRemota(dato.title, dato.message);
                    }
                }else if(dato.evento==='sessionFinalizada' && dato.idusuario==='<?= session("idusuario") ?>'){
                    if (dato.status === 'success') {
                        AlertSessionRemota(dato.title, dato.message);
                    }
                }else if(dato.evento==='PDI' && dato.database==='<?=session("database")?>'){
                    if (dato.status === 'success') {
                        Notificacion(dato.status,dato.title,dato.message);
                    }else{
                        Notificacion(dato.status,dato.title,dato.message);
                    }
                }else if(dato.evento==='Accesorios' && dato.database==='<?=session("database")?>'){
                    if (dato.status === 'success') {
                        Notificacion(dato.status,dato.title,dato.message);
                    }
                }
            } catch (e) {
                // Manejo de errores si la conversión JSON falla
                console.error('Error al analizar JSON:', e);
            }
        };
    }

    function send(msg){
        if(msg.length > 0) {
            socket.send(msg);
        }
    }
</script>

<script>
    $(document).on('click', '#btnUploadPerfil', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = '<?=session("idusuario")?>';
        ViewUsuario(idusuario);

    });

    function ViewUsuario(idusuario) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/EditUsuario")?>",
            data: {idusuario:idusuario},
            beforeSend: function () {

            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function (xhr) {

            }
        });
    }

</script>


</body>


<!-- Mirrored from prium.github.io/phoenix/v1.14.0/demo/combo-nav.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jan 2024 17:38:10 GMT -->
</html>