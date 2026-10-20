<script>
    //funcion que muestra las condiciones de las reglas
    function DetailCreateRegla()
    {
        var idreglaVehiculo = $("#idreglaVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/DetailCondiciones")?>",
            data: {
                idreglaVehiculo:idreglaVehiculo,
            },
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyTare").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }


</script>