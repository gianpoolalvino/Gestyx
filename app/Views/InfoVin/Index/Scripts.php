<script>
    document.getElementById('telefonoCliUp').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#formUpVinCli").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Actualizando Datos...")
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function (xhr) {
                ClosePreloader();
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>