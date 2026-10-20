<script>
    $(document).ready(function() {
        var idestadoSolicitud = '';
        DetailIndex(idestadoSolicitud);
    });
    $(document).ready(function() {
        // Detectar el cambio de opción en el select
        $('#estadoSolicitud').change(function() {
            var estadoSolicitud = $(this).val();  // Obtener el valor seleccionado
            if(estadoSolicitud==3){
                $("#comentario").attr("required",false);
            }else{
                $("#comentario").attr("required",true);
            }
        });
    });
</script>
<script>
    $("#formStorageEst").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Registrando Solicitud...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    var idestadoSolicitud = ''
                    DetailIndex(idestadoSolicitud);
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>