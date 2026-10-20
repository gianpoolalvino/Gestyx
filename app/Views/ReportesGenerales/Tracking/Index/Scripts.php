<script>
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndexFilt();
    });


    function DetailIndexFilt()
    {
        var fechaInicio=$("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var tipoFiltro = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ReportesGenerales/Tracking/DetailIndex")?>",
            data: {fechaInicio:fechaInicio,fechaFin:fechaFin,tipoFiltro:tipoFiltro,filtro:filtro},
            beforeSend: function() {
                $("#tbodyAlistamiento").html('');
                $("#cargarData").fadeIn();
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.tbody);
                $("#cargarData").fadeOut();
                Notificacion(dato.status, dato.title, dato.message);
            },
            error: function(xhr) {

            }
        });
    }
</script>