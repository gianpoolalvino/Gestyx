<script>
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });

    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        location.reload();
    });

    function DetailIndex()
    {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/ReporteEncuestaAppTaller/Index/DetailIndex")?>",
            data: {fechaInicio:fechaInicio,fechaFin:fechaFin},
            beforeSend: function() {
                $("#cargarData").fadeIn();
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.tbody);
            },
            error: function(xhr) {

            }
        });
    }
</script>