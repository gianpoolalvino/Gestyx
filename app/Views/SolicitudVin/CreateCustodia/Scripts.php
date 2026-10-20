<script>
    document.getElementById('telefonoCustodia').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#formCustodia").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Registrando Custodia...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    ModalAdicionales.hide();
                    $("#nombreCustodiaVin").html(dato.nombreCustodia);
                    $("#cargoCustodiaVin").html(dato.cargoCustodia);
                    $("#telefonoCustodiaVin").html(dato.telefonoCustodia);
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>