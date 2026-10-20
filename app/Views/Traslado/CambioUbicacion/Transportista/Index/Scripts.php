<script>
    function DetailIndexTransportista()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/DetailIndexTransportista")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyTransportista").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '.btnOpcTrans', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idtransportista = $(this).attr("data-idtransportista")
        // Mostrar el cuadro de confirmación con Alertify
        //  alertify.set('title', 'Confirmación de operación');
        alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que desea eliminar el transportista?",
            function() {
                // Si el usuario hace clic en "Aceptar", ejecutar la función
                DeleteTransportista(idtransportista);
            },
            function() {
                // Si el usuario hace clic en "Cancelar", no hacer nada
                alertify.error('Operación cancelada');
            }
        ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
    });


    function DeleteTransportista(idtransportista)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/DeleteTransportista")?>",
            data: {idtransportista:idtransportista},
            beforeSend: function() {
                Preloader("Enviando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                DetailIndexTransportista();
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>