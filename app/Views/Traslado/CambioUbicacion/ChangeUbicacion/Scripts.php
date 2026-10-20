<script>
    $(document).on('click', '#btnaddobs', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ViewObs();
    });

    $(document).on('click','#btnaddobsSend',function(e){
       e.preventDefault();
       e.stopImmediatePropagation();
       ViewObsSend();
    });

    function ViewObsSend()
    {
        var vin = $("#vinUbicacion").val();
        var tokenSend = $("#tokenSend").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioAgencia/CreateViewEdit/CreateObservacionEnvio")?>",
            data: {vin:vin,tokenSend:tokenSend},
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

    function ViewObs()
    {
        var vin = $("#vinUbicacion").val();
        var idtrasladoVin = $("#idtrasladoVin").val();
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

    $(document).on('click', '.btpDelObsSend', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleEnvioVin = $(this).attr("data-iddetalleEnvioVin");
        // Mostrar alerta de confirmación
        if (confirm("¿Estás seguro de que deseas eliminar esta observación?")) {
            // Si el usuario confirma, llamar a la función DeleteObservacion
            DeleteObservacionEnvio(iddetalleEnvioVin);
        } else {

        }
    });

    function DeleteObservacionEnvio(iddetalleEnvioVin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioAgencia/SaveEditDelete/DeleteObservacionEnvio")?>",
            data: {iddetalleEnvioVin:iddetalleEnvioVin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                DetailEnvioTraslado();
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnOpcNovedadTr', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleTaller = $(this).attr("data-iddetalleTaller");
        var vin = $(this).attr("data-vin");
        var idtipoNovedad = $(this).attr("data-idtipoNovedad");
        var idtrasladoVin = $(this).attr("data-idtrasladoVin");
        ViewNovedadTaller(iddetalleTaller,vin,idtipoNovedad,idtrasladoVin);
    });


    function ViewNovedadTaller(iddetalleTaller,vin,idtipoNovedad,idtrasladoVin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/CheckNovedad")?>",
            data: {
                iddetalleTaller:iddetalleTaller,
                vin:vin,
                idtipoNovedad:idtipoNovedad,
                idtrasladoVin:idtrasladoVin
            },
            beforeSend: function() {
                Preloader('Cargando Interface...');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function DetailNovedadesTaller()
    {
        var identradaTaller = '<?=$vinGeneral[0]['identradaTaller']?>';
        var vin = '<?php echo $vin?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/DetailNovedadTaller")?>",
            data: {vin:vin,identradaTaller:identradaTaller},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyNoveda").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }



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
        var idtrasladoVin = $("#idtrasladoVin").val();
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

    function DetailEnvioTraslado()
    {
        var tokenSend = $("#tokenSend").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioAgencia/CreateViewEdit/DetalleEnvioVin")?>",
            data: {tokenSend:tokenSend},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyObsSend").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $("#formSaveUbi").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Enviado Datos a la BD...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                ClosePreloader();
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



    $(document).ready(function() {
        // Evento cuando cambia la ubicación
        $('#ubicacionNueva').on('change', function() {
            var idubicacion = $(this).val();
            // Realizar la solicitud AJAX
            SelectBox(idubicacion);

        });
    });
    <?php if(isset($idtrasladoVin)){?>
        $(document).ready(function() {
            var idubicacion = $("#ubicacionNueva").val();
            // Evento cuando cambia la ubicación
            SelectBox(idubicacion);
        });
    <?php }?>

    function SelectBox(idubicacion)
    {
        $.ajax({
            url: '<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/Box")?>', // Reemplaza con la ruta a tu archivo PHP
            type: 'POST',
            dataType: 'json',
            data: {
                idubicacion: idubicacion
            },
            success: function(response) {
                // Verificar si la solicitud fue exitosa
                if (response.status === 'success') {
                    // Actualizar el select de boxes
                    $('#boxNuevo').html(response.info);
                } else {
                    // Manejar el error (opcional)
                    $('#boxNuevo').html('<option value="">Error al cargar los boxes</option>');
                }
            },
            error: function(xhr, status, error) {
                // Manejar el error de la solicitud (opcional)
                $('#boxNuevo').html('<option value="">Error en la solicitud</option>');
            }
        });
    }
</script>