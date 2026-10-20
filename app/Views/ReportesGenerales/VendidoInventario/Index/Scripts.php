<script>
    $(document).ready(function () {
        DetailIndex()
    });

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });


    function DetailIndex()
    {
        var tipoFiltro = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ReportesGenerales/VendidoInventario/DetailIndex")?>",
            data: {tipoFiltro:tipoFiltro,filtro:filtro},
            beforeSend: function() {
                Preloader("No cierre el Navegador<br>Buscando Resultados");
                $("#tbodyAlistamiento").html('');
                $("#cargarData").fadeIn();
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.tbody);
                $("#cargarData").fadeOut();
                ClosePreloader();
                Notificacion(dato.status, dato.title, dato.message);
            },
            error: function(xhr) {

            }
        });
    }
</script>