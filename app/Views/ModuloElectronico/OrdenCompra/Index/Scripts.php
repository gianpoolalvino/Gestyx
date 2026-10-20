<script>
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndexFilt();
    });
    function DetailIndexFilt()
    {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var tipoOc = $("#tipoOc").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ModuloElectronico/OrdenCompra/Index/DetailIndex")?>",
            data: {fechaInicio:fechaInicio,fechaFin:fechaFin,tipoOc:tipoOc},
            beforeSend: function() {
                Preloader("Cargando Datos....<br>No cierre la ventana");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyAlistamiento").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>