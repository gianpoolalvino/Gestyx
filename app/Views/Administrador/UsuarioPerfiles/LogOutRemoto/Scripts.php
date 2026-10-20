<script>
    $("#formSaveRemot").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Datos....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    ModalOpcionesAdicionales.hide();
                    $("#btnProceSe").attr("disabled",true);
                    //Evento+Base de datos+Variable
                    send('sessionRemotaFinalizada-'+'<?=session("database")?>'+'-'+dato.idusuario);
                   // DetailAgencia();
                }
            },
            error: function (xhr) {
                $("#btnProceSe").attr("disabled", false);
            }
        });
        return false;
    });

</script>