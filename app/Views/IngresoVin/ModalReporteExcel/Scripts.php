<script>
    $('#vinReporte').select2({
        dropdownParent: $('#ModalInfoVehiculo .modal-body')
    });

    $(document).on('click', '#addGenerate', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        AgregarVinReporteFecha();
    });

    function AgregarVinReporteFecha()
    {
        var fechaInicio = $("#fechaInicioRepo").val();
        var fechaFin = $("#fechaFinRepo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/DetailReporteIngresoFecha")?>",
            data: {fechaInicio:fechaInicio,fechaFin:fechaFin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    $("#resultado").html(dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }


    $(document).on('click', '#btnSendVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        AgregarVinReporte();
    });

    function AgregarVinReporte()
    {
        var vin = $("#vinReporte").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/DetailReporteIngreso")?>",
            data: {vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    $("#tbodyVins").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnDeleteVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleReporteIngresoVin = $(this).attr("data-iddetalleReporteIngresoVin");
        // Mostrar alerta de confirmación
        if (confirm("¿Estás seguro de que deseas eliminar esta observación?")) {
            // Si el usuario confirma, llamar a la función DeleteObservacion
            DeleteObservacion(iddetalleReporteIngresoVin);
        } else {

        }
    });

    function DeleteObservacion(iddetalleReporteIngresoVin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/DeleteVinReporte")?>",
            data: {iddetalleReporteIngresoVin:iddetalleReporteIngresoVin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#"+iddetalleReporteIngresoVin).remove();
                }
                Notificacion(dato.status,dato.title,dato.message);

            },
            error: function(xhr) {

            }
        });
    }
</script>