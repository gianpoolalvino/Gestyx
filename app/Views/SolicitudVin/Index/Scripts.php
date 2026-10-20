<script>
    $(document).on('click', '#btnNewSoli', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateSolicitud();
    });

    function CreateSolicitud()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnOpcAtender', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idsolicitudVehiculo = $(this).attr("data-idsolicitudVehiculo");
        var opcion = $(this).attr("data-opcion");

        if(opcion=="procesar"){
            ProcesarSolicitud(idsolicitudVehiculo);
        }else{
            ViewSolicitud(idsolicitudVehiculo)
        }
    });

    function ProcesarSolicitud(idsolicitudVehiculo)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/View")?>",
            data: {idsolicitudVehiculo:idsolicitudVehiculo},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function ViewSolicitud(idsolicitudVehiculo)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/ViewSolicitud")?>",
            data: {idsolicitudVehiculo:idsolicitudVehiculo},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }


    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idestadoSolicitud = 1
        DetailIndex(idestadoSolicitud);
    });


    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idestadoSolicitud = ''
        DetailIndex(idestadoSolicitud);
    });

    $(document).on('click', '.btnEstados', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idestadoSolicitud = $(this).attr("data-idestadoSolicitud");
        DetailIndex(idestadoSolicitud);
    });

    function DetailIndex(idestadoSolicitud)
    {
        var fechaInicio=$("#fechaInicio").val();
        var fechaFin=$("#fechaFin").val();
        var searchVin=$("#searchVin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/Index/DetailIndex")?>",
            data: {fechaInicio:fechaInicio,fechaFin:fechaFin,idestadoSolicitud:idestadoSolicitud,searchVin:searchVin},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodySolicitud").html(dato.info);
                $("#recibidaLabel").html(dato.recibidas);
                $("#vistaLabel").html(dato.vistas);
                $("#realizadaLabel").html(dato.realizadas);
                $("#rechazadaLabel").html(dato.rechazadas);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>