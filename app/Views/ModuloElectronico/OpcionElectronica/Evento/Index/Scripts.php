<script>
    $("#formEvents").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Enviando Evento a WebService<br>No cierre la ventana...")
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                ClosePreloader();
                if(dato.status=='success'){
                    DetailIndexFilt();
                    ModalAdicionales.hide();
                }
            },
            error: function (xhr) {
              //  $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    $(document).ready(function() {
        $('#eventoSelect').change(function() {
            if ($(this).val().startsWith('031')) {
                $('#panelReclamo').show();
                $('#motivoReclamo').prop('required', true);
            } else {
                $('#panelReclamo').hide();
                $('#motivoReclamo').prop('required', false);
            }
        });
    });
</script>