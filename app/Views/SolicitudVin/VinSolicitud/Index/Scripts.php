<script>
    $(document).on('click', '#btnReUbi', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $("#vinUbicacion").val();
        VinLiberaUbicacion(vin);
    });

    function VinLiberaUbicacion(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/ChangeGrupoUbicacion")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnSendSolicitante', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        EnvioSolicitante();
    });

    function EnvioSolicitante()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/CreateViewEdit/CreateTrasladoSolicitante")?>",
            data: {
                idsolicitudVin:'<?=$idsolicitudVehiculo?>',
                vin:'<?=$vin?>'
            },
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }


    $(document).on('click', '#btnSendTaller', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        EnvioTaller();
    });

    function EnvioTaller()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/CreateViewEdit/CreateTrasladoTaller")?>",
            data: {
                idsolicitudVin:'<?=$idsolicitudVehiculo?>',
                vin:'<?=$vin?>'
            },
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnOpcNovedad', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $(this).attr('data-vin');
        var idtipoNovedad = $(this).attr('data-idtipoNovedad');
        var idnovedad = $(this).attr('data-idnovedad');
        var idcabeceraNovedad = $(this).attr('data-idcabeceraNovedad');

        ViewNovedadId(vin,idtipoNovedad,idnovedad,idcabeceraNovedad);
    });

    function ViewNovedadId(vin,idtipoNovedad,idnovedad,idcabeceraNovedad)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/CreateViewEdit/CheckNovedad")?>",
            data: {vin:vin,idtipoNovedad:idtipoNovedad,idnovedad:idnovedad,idcabeceraNovedad:idcabeceraNovedad},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }



    $(document).on('click', '#btnOpcubica', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $("#vinUbicacion").val();
        CambioUbicacion(vin);
    });

    function CambioUbicacion(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/ChangeUbicacion")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnRebox', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $("#vinUbicacion").val();
        VinBoxChange(vin);
    });

    function VinBoxChange(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/CreateTrasladoBox")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    $(document).on('click', '#btnRegisterNovedad', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateNovedad();
    });

    function CreateNovedad()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/CreateViewEdit/CreateNovedad")?>",
            data: {
                idsolicitudVin:'<?=$idsolicitudVehiculo?>',
                vin:'<?=$vin?>'
            },
            beforeSend: function() {
                Preloader('Cargando Interface...');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnDenegarGestion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        // Mostrar el cuadro de confirmación con Alertify
        //  alertify.set('title', 'Confirmación de operación');
        alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas rechazar la gestión?",
            function() {
                // Si el usuario hace clic en "Aceptar", ejecutar la función
                StopGestion();
            },
            function() {
                // Si el usuario hace clic en "Cancelar", no hacer nada
                alertify.error('Operación cancelada');
            }
        ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
    });


    $(document).on('click', '#btnStartGestion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        // Mostrar el cuadro de confirmación con Alertify
      //  alertify.set('title', 'Confirmación de operación');
        alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas iniciar la gestión?",
            function() {
                // Si el usuario hace clic en "Aceptar", ejecutar la función
                StarGestion();
            },
            function() {
                // Si el usuario hace clic en "Cancelar", no hacer nada
                alertify.error('Operación cancelada');
            }
        ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
    });

    function StopGestion()
    {
        var vin = '<?=$vin?>';
        var iddetalleSolicitudVehiculo = '<?=$gestorVin[0]["iddetalleSolicitudVehiculo"]?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/SaveEditDelete/UpdateGestionVehiculoStop")?>",
            data: {vin:vin,iddetalleSolicitudVehiculo:iddetalleSolicitudVehiculo},
            beforeSend: function() {
                Preloader('Enviando datos...');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                location.reload();
                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function(xhr) {

            }
        });
    }


    function StarGestion()
    {
        var vin = '<?=$vin?>';
        var iddetalleSolicitudVehiculo = '<?=$gestorVin[0]["iddetalleSolicitudVehiculo"]?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/SaveEditDelete/UpdateGestionVehiculo")?>",
            data: {vin:vin,iddetalleSolicitudVehiculo:iddetalleSolicitudVehiculo},
            beforeSend: function() {
                Preloader('Enviando datos...');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                location.reload();
                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function(xhr) {

            }
        });
    }
</script>

