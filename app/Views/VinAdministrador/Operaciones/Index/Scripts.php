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

    $(document).on('click', '#btnOpcubica', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $("#vinUbicacion").val();
        ViewVinProceso(vin);
    });

    function ViewVinProceso(vin)
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