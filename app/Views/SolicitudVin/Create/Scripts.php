<script>
    $('#ModalInfoVehiculo').on('shown.bs.modal', function () {
        $('#centroCosto').select2({
            placeholder: "Selecciona un centro Costo",
            dropdownParent:$('#bodyInfoVehicular')
        });
    });

    $('#ModalInfoVehiculo').on('shown.bs.modal', function () {
        $('#selectVehiculo').select2({
            placeholder: "Selecciona un Vin...",
            dropdownParent:$('#bodyInfoVehicular')
        });
    });

    $('#ModalInfoVehiculo').on('shown.bs.modal', function () {
        $('#agenciaSolicitud').select2({
            placeholder: "Selecciona una Agencia...",
            dropdownParent:$('#bodyInfoVehicular')
        });
    });

    $(document).ready(function(){
        // Detectar el cambio de opción en el select con id="tipoSolicitud"
        $('#tipoSolicitud').change(function(){
            // Obtener el valor seleccionado

            var tipoSolicitud = $(this).val();

            if(tipoSolicitud==2){
                $("#fechaEstimadaRetorno").prop("required",true);
                $("#fechaEstimadaRetorno").prop("disabled",false);
                $("#agenciaSolicitud").prop("disabled",false);
                $("#agenciaSolicitud").prop("required",true);
            }else{
                $("#fechaEstimadaRetorno").prop("required",false);
                $("#fechaEstimadaRetorno").prop("disabled",true);
                $("#agenciaSolicitud").prop("disabled",true);
                $("#agenciaSolicitud").prop("required",false);
            }

        });
    });


    $(document).on('click', '.btnOpcVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleSolicitudVehiculo = $(this).attr("data-iddetalleSolicitud");
        var vin= $(this).attr("data-vin");
        DeleteVehiculo(vin,iddetalleSolicitudVehiculo);
    });

    function DeleteVehiculo(vin,iddetalleSolicitudVehiculo)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/DeleteVehiculo")?>",
            data: {iddetalleSolicitudVehiculo:iddetalleSolicitudVehiculo,vin:vin},
            beforeSend: function() {
                Preloader("Procesando Peticion...");
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

    function DeleteGeneralVehiculo()
    {
        var idsolicitudVehiculo = $("#idsolicitudVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/DeleteDetailCreate")?>",
            data: {idsolicitudVehiculo:idsolicitudVehiculo},
            beforeSend: function() {
                Preloader("Procesando Peticion...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    Notificacion(dato.status,dato.title,dato.message);
                    DetailCreate();
                }
            },
            error: function(xhr) {

            }
        });
    }




    $(document).ready(function() {
        $('#tipoSolicitud').change(function() {
            var tipoSolicitud = $(this).val(); // Obtiene el valor seleccionado
            if(tipoSolicitud==3){
                $("#fechaEstimadaRetorno").attr("required",true);
            }else{
                $("#fechaEstimadaRetorno").attr("required",false);
            }
        });
    });

    $(document).ready(function() {
        $('#origenVin').change(function() {
            var origenVin = $(this).val();
            var checkUbicacionGeneral = 2;
            SelectVin(origenVin,checkUbicacionGeneral);
        });
    });


    $(document).ready(function() {
        $('#checkOrigen').change(function() {
            Preloader("Marcando...");
            if ($(this).is(':checked')) {
                // Mostrar confirmación antes de continuar
                if (confirm("Este proceso eliminará el cuerpo de la solicitud")) {
                    ClosePreloader();
                    $("#checkUbicacionGeneral").html(2);
                    $("#checkUbicacionGeneral").val(2);
                    DeleteGeneralVehiculo()
                    SelectVin('',2);
                    $(".inputTraslados").attr("disabled", false);
                    $('#origenVin').val('');
                } else {
                    // Desmarcar el checkbox si se cancela
                    $(this).prop('checked', false);
                    ClosePreloader();
                }
            } else {
                if (confirm("Este proceso eliminará el cuerpo de la solicitud")) {
                    ClosePreloader();
                    $("#checkUbicacionGeneral").html(1);
                    $("#checkUbicacionGeneral").val(1);
                    DeleteGeneralVehiculo()
                    SelectVin('',1);
                    $(".inputTraslados").attr("disabled", true);
                    $('#origenVin').val('');
                } else {
                    // Desmarcar el checkbox si se cancela
                    $(this).prop('checked', true);
                    ClosePreloader();
                }
            }
        });
    });

    function SelectVin(idorigen,checkUbicacionGeneral)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/SelectVinPermitido")?>",
            data: {idorigen:idorigen,checkUbicacionGeneral:checkUbicacionGeneral},
            beforeSend: function() {
                Preloader("Cargando Vista...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#selectVehiculo").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnCreateRecep', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateRecepciona();
    });

    $(document).on('click', '#btnCreateCusto', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateCustodia();
    });

    function DetailCreate()
    {
        var idsolicitudVehiculo = $("#idsolicitudVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/DetailCreate")?>",
            data: {idsolicitudVehiculo:idsolicitudVehiculo},
            beforeSend: function() {
                Preloader("Cargando Vista...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
               $("#tbodyVinsSoli").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function CreateRecepciona()
    {
        var idsolicitudVehiculo = $("#idsolicitudVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/CreateRecepciona")?>",
            data: {idsolicitudVehiculo:idsolicitudVehiculo},
            beforeSend: function() {
                Preloader("Cargando Vista...");
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

    function CreateCustodia()
    {
        var idsolicitudVehiculo = $("#idsolicitudVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/CreateCustodia")?>",
            data: {idsolicitudVehiculo:idsolicitudVehiculo},
            beforeSend: function() {
                Preloader("Cargando Vista...");
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

    $(document).on('click', '#btnAgregarVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        AgregarVin();
    });

    function AgregarVin()
    {
        var idsolicitudVehiculo = $("#idsolicitudVehiculo").val();
        var checkOrigenDestino = $("#checkUbicacionGeneral").val();
        var origen = $("#origenVin").val();
        var destino = $("#destinoVin").val();
        var vin = $("#selectVehiculo").val();
        var idtipoSolicitud = $("#tipoSolicitud").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/SolicitarVehiculo/CreateViewEdit/CreateVin")?>",
            data: {
                idsolicitudVehiculo:idsolicitudVehiculo,
                checkOrigenDestino:checkOrigenDestino,
                idtipoSolicitud:idtipoSolicitud,
                origen:origen,
                destino:destino,
                vin:vin},
            beforeSend: function() {
                Preloader("Cargando Vista...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }

            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    $("#formStorageSol").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Registrando Solicitud...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    var idestadoSolicitud = ''
                    DetailIndex(idestadoSolicitud);
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