<script>
    $(document).on('click', '.btnVerRegistro', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idbateriaTest = $(this).attr('data-idbateriaTest');
        var vin = $(this).attr('data-vin');
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('TestBateria/RegistroTestBateria/CreateViewEdit/ViewTest'); ?>",
            data: {idbateriaTest:idbateriaTest,vin:vin},  // Agregar 'page' a los datos
            beforeSend: function() {
                Preloader("Cargado Vista...")  // Mostrar el indicador de carga
            },
            success: function(data) {
                var dato = $.parseJSON(data);
                ClosePreloader();
                ModalOpcionesAdicionales.show();
                $('#BodyOpcionesAdicionales').html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
                console.error("Error en la solicitud AJAX.");
            }
        });
    });
</script>
<script>
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndexFilt();
    });

    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        location.reload();
    });

    function changePage(page) {
        // Establecer el valor del 'start' para el nuevo número de página
        $("#start").val((page - 1) * 20);  // Ajustar el valor de `start` según la página seleccionada
        DetailIndexFilt(page);  // Llamar la función para actualizar los datos de la tabla y la paginación
    }
    // Función para cargar los datos
    function DetailIndexFilt(page = 1) {
        var start = $("#start").val();  // Establecer el inicio según el valor de la página seleccionada
        var countReg = 0;
        var total = $("#totalRegistros").val();  // Total de registros
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('TestBateria/RegistroTestBateria/Index/DetailIndex'); ?>",
            data: {start: start, countReg: countReg, total: total, tipoFiltr: tipoFiltr, filtro: filtro, page: page,fechaInicio:fechaInicio,fechaFin:fechaFin},  // Agregar 'page' a los datos
            beforeSend: function() {
                Preloader("Cargado Datos...")  // Mostrar el indicador de carga
            },
            success: function(data) {
                var dato = $.parseJSON(data);
                ClosePreloader();
                // Actualizar el cuerpo de la tabla
                $("#tbodyAlistamiento").html(dato.tbody);
                // Actualizar la paginación
                $("#pagination").html(dato.paginationHtml);  // Actualizar el HTML de la paginación
                // Actualizar el total de registros
                $("#totalRegistros").val(dato.total);
                $("#cargarData").fadeOut();  // Ocultar el indicador de carga
            },
            error: function(xhr) {
                ClosePreloader();
                console.error("Error en la solicitud AJAX.");
            }
        });
    }

    // Cargar los datos iniciales
    $(document).ready(function() {
        DetailIndexFilt(1);  // Llamamos a la función con la página inicial (1)
    });


    $(document).on('click', '.btnBateria', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $(this).attr("data-vin");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inventario/CreateViewEdit/CreateBateria")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });
</script>
<script>
    $(document).on('click', '#btnCreateExcel', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DescargarExcelVendidos();
    });

    function DescargarExcelVendidos()
    {
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("TestBateria/RegistroTestBateria/Index/DetailIndexExcel")?>",
            data: {tipoFiltr: tipoFiltr, filtro: filtro,fechaInicio:fechaInicio,fechaFin:fechaFin},
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
</script>