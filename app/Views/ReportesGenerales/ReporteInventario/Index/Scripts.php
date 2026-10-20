<script>
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });

    $(document).on('click', '#btnCreateExcel', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DescargarExcelInventario();
    });

    function DescargarExcelInventario()
    {
        var ubicacion=$("#ubicacion").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ReportesGenerales/ReporteInventario/DetailIndexExcel")?>",
            data: {filtro:filtro,ubicacion:ubicacion},
            beforeSend: function() {
                Preloader("Creando Excel...")
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                if(dato.status!='success'){
                    Notificacion(dato.status,dato.title,dato.message);
                }else{
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    function DetailIndex()
    {
        var ubicacion=$("#ubicacion").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ReportesGenerales/ReporteInventario/DetailIndex")?>",
            data: {filtro:filtro,ubicacion:ubicacion},
            beforeSend: function() {
                $("#tbodyReporte").html('');
                Preloader('Realizando consulta y cargando datos....');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status==='success'){
                    $("#tbodyReporte").html(dato.info);
                }

                Notificacion(dato.status, dato.title, dato.message);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>