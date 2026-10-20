<script>

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });
    function DetailIndex()
    {
        var estadoComision=$("#estadoComision").val();
        var fechaInicio=$("#fechaInicio").val();
        var fechaFin=$("#fechaFin").val();
        var tipoFiltro = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/PagoComisiones/Index/DetailIndex")?>",
            data: {estadoComision:estadoComision,fechaInicio:fechaInicio,fechaFin:fechaFin,tipoFiltro:tipoFiltro,filtro:filtro},
            beforeSend: function() {
               Preloader("Buscando Datos<br>No cierre la pagina");
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    $("#tbodyAlistamiento").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    $(document).on('click', '#btnExcelUpload', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/PagoComisiones/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
                Preloader("Buscando Datos<br>No cierre la pagina");
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    });
</script>