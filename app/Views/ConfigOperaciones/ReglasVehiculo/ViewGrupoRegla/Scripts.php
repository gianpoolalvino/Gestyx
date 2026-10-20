<script>
    function DetalleReglas()
    {
        var idgrupoRegla = $("#idgrupoReglaVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/DetailRegla")?>",
            data: {idgrupoRegla:idgrupoRegla},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();

                $("#tbodyTareRe").html(dato.info);

            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>