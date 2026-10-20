<script>
    $(document).on('click', '#btnAddEquipamiento', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idexhibicionVin= $("#idexhibicionVin").val();
        var vinExhibicion=$("#vinExhibicion").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inventario/CreateViewEdit/CreateEquipamiento")?>",
            data: {idexhibicionVin:idexhibicionVin,vinExhibicion:vinExhibicion},
            beforeSend: function() {
                Preloader("Cargando Vista...")
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
    });

    $(document).on('click', '.btndeleteEq', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idequipamientoVin= $(this).attr("data-idequipamiento");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inventario/CreateViewEdit/DeleteEquipamiento")?>",
            data: {idequipamientoVin:idequipamientoVin},
            beforeSend: function() {
                Preloader("Cargando Vista...")
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
    });

    $("#formExhibicionVin").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Guardando Cambios...")
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    ModalInfoVehiculo.hide();
                    location.reload();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    function DetailCreateExhibicion()
    {
        var idexhibicionVin = $("#idexhibicionVin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inventario/CreateViewEdit/DetailCreateExhibicion")?>",
            data: {idexhibicionVin:idexhibicionVin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyEquipamientoExhibicion").html(dato.info);
            },
            error: function(xhr) {
            }
        });
    }
</script>