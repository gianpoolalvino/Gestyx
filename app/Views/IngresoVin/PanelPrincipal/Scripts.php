<script>
    $("#formEquipamientosVin").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Data....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    var idingresoVin = $("#idingresoVinPrin").val();
                    var vin = $("#vinIngresoPrin").val();
                    PanelEquipamiento(idingresoVin,vin)
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>
<script>
    $(document).ready(function() {
        // Evento cuando cambia la ubicación
        $('#selectUbicacion').on('change', function() {
            var idubicacion = $(this).val();
            // Realizar la solicitud AJAX
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
        });
    });

    $('#selectUbicacion').select2({
        dropdownParent: $('#ModalInfoVehiculo .modal-body')
    });

    $("#formIngreso").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Data....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    $("#procesarIngreso").attr("disabled",true);
                    $("#panelClose").css("display","none");
                    RecargaPanel(dato.idingresoVin,dato.vin);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });

    function RecargaPanel(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/PanelPrincipal")?>",
            data: {idingresoVin:idingresoVin,vin:vin},
            beforeSend: function() {
                Preloader("Buscando Vehiculo...<br>No cambie de ventana... :)")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    $("#panelVehiculoIngreso").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#imagen-tab', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $("#idingresoVinPrin").val();
        var vin = $("#vinIngresoPrin").val();
        PanelImagen(idingresoVin,vin);
    });

    $(document).on('click', '#ingreso-tab', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $("#idingresoVinPrin").val();
        var vin = $("#vinIngresoPrin").val();
        PanelEquipamiento(idingresoVin,vin);
    });

    $(document).on('click', '#observacion-tab', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $("#idingresoVinPrin").val();
        var vin = $("#vinIngresoPrin").val();
        PanelObservaciones(idingresoVin,vin);
    });

    function PanelObservaciones(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/PanelObservaciones")?>",
            data: {idingresoVin:idingresoVin,vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelPrincipalMultiple").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function PanelEquipamiento(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/PanelEquipamiento")?>",
            data: {idingresoVin:idingresoVin,vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelPrincipalMultiple").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }



    function PanelImagen(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/PanelImagenes")?>",
            data: {idingresoVin:idingresoVin,vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelPrincipalMultiple").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>