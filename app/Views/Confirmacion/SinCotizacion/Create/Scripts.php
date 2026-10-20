<script>


    $(document).on('click', '#btnVerificar', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $("#vinPedido").val();
        var numeroPedido = $("#numeroPedido").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Confirmacion/SinCotizacion/SaveEditDelete/ValidarCotizacion")?>",
            data: {vin:vin,numeroPedido:numeroPedido},
            beforeSend: function() {
                $("#panelResultPedido").fadeOut();
                $("#preloaderFooterModal").fadeIn();
                $("#btnProcesarAccess").attr("disabled",true);
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#preloaderFooterModal").fadeOut();
                $("#panelResultPedido").fadeIn();
                $("#panelResultPedido").html(dato.panel);
                if(dato.status=='success'){
                    $("#btnProcesarAccess").attr("disabled",false);
                }
            },
            error: function(xhr) {

            }
        });
    });

    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    location.reload();
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