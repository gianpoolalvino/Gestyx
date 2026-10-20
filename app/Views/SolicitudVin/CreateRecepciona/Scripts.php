<script>
    document.getElementById('telefonoRecepciona').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#formRecepciona").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Registrando Recepcion...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    ModalAdicionales.hide();
                    $("#nombreRecepcionaVin").html(dato.nombreRecepciona);
                    $("#cargoRecepcionaVin").html(dato.cargoRecepciona);
                    $("#telefonoRecepcionaVin").html(dato.telefonoRecepciona);
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>