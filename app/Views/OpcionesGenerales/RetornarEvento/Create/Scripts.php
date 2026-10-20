<script>
    $(document).on('click', '#btnCheckVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $("#vinRetorno").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("OpcionesGenerales/EventosRealizados")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    $("#panelEventos").html(dato.info);
                    $("#btnProcesarRetorno").prop("disabled",false);
                }
            },
            error: function(xhr) {

            }
        });
    });


    $("#formRetorno").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnProcesarRetorno").prop("disabled",true);
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    location.reload();
                    ModalRetornoEvento.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>