<script>
    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Cargando Lavado...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
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
<script>


    $(document).on('click', '.btnLavadoItem', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleLavado = $(this).attr("data-id");
        ViewItemLavado(iddetalleLavado);
    });
    function ViewItemLavado(iddetalleLavado)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Lavado/CreateViewEdit/CreateLavado")?>",
            data: {iddetalleLavado:iddetalleLavado},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {
            }
        });
    }

    function DetalleLavado(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Lavado/CreateViewEdit/DetailCreate")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyLava").html(dato.info);
            },
            error: function(xhr) {
            }
        });
    }
</script>