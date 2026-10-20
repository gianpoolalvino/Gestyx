<script>
    $(document).on('click', '#btnaddobs', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ViewObs();
    });

    function ViewObs()
    {
        var vin = $("#vinRecep").val();
        var idtrasladoVin = $("#idtrasladoVinRecep").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioAgencia/CreateViewEdit/CreateObservacionRecepcion")?>",
            data: {vin:vin,idtrasladoVin:idtrasladoVin},
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

    $(document).on('click', '.btpDelObs', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleRecepcion = $(this).attr("data-iddetalleRecepion");
        // Mostrar alerta de confirmación
        if (confirm("¿Estás seguro de que deseas eliminar esta observación?")) {
            // Si el usuario confirma, llamar a la función DeleteObservacion
            DeleteObservacion(iddetalleRecepcion);
        } else {

        }
    });

    function DeleteObservacion(iddetalleRecepcion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioAgencia/SaveEditDelete/DeleteObservacionRecepcion")?>",
            data: {iddetalleRecepcion:iddetalleRecepcion},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                DetailRecepcion();
            },
            error: function(xhr) {

            }
        });
    }


    function DetailRecepcion()
    {
        var idtrasladoVin = $("#idtrasladoVinRecep").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioAgencia/CreateViewEdit/DetalleRecepcionVin")?>",
            data: {idtrasladoVin:idtrasladoVin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyObs").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>

<script>
    $("#formSaveRecep").bind("submit", function () {
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
                    ModalOpcionesAdicionales.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>