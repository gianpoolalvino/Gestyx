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
    $('#selectVehiculo').select2({
        dropdownParent: $('#ModalInfoVehiculo .modal-body')
    });



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

    $(document).on('click', '#duaf-tab', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $("#idingresoVinPrin").val();
        var vin = $("#vinIngresoPrin").val();
        PanelDuaf(idingresoVin,vin);
    });

    $(document).on('click', '#observacion-tab', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $("#idingresoVinPrin").val();
        var vin = $("#vinIngresoPrin").val();
        PanelObservaciones(idingresoVin,vin);
    });

    function PanelDuaf(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/PanelDuaf")?>",
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