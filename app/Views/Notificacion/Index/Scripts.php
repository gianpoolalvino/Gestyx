<!-- ===============================================-->
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
<script src="https://unpkg.com/fabric@5.3.0/dist/fabric.min.js"></script>
<script src="<?php echo base_url("resource/plugin/preloader/src/js/HoldOn.js")?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<script>

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
            not = '<span id="alertConecSocket" style="font-size: 12px" class="badge badge-phoenix badge-phoenix-primary"><i class="fas fa-wifi"></i>&nbsp;Conectado a Servidor</span>';
        }
        $("#alertConecSocket").html(not);
    }


    $(document).ready(function () {
        initSocket();
    });


    function initSocket() {
        socket = new WebSocket("wss://pdicontrol.autoniza.net.pe:5000/");
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
                if(dato.evento==='PDI' && dato.database==='<?=session("database")?>'){
                    if (dato.status === 'success') {
                        DetailNotificacion();
                    }else{
                        Notificacion(dato.status,dato.title,dato.message);
                    }
                }else if(dato.evento==='Accesorios' && dato.database==='<?=session("database")?>'){
                    if (dato.status === 'success') {
                        DetailNotificacion();
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

    function DetailNotificacion()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Notificacion/Index/DetailNotificacionInferior")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyLogs").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>


</body>


<!-- Mirrored from prium.github.io/phoenix/v1.14.0/demo/combo-nav.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jan 2024 17:38:10 GMT -->
</html>