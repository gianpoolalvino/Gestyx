<script>
    $("#anho").change(function(){
        var anho = $("#anho").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/VendidosBono/Index/SelectYear")?>",
            data: {anho:anho},
            beforeSend: function() {
                Preloader("Cargando Data<br>No cierre la pagina");
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                   $("#mes").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
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
        var marca = $("#marca").val();
        var anho = $("#anho").val();
        var mes = $("#mes").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Comisiones/VendidosBono/Index/DetailIndex'); ?>",
            data: {start: start, countReg: countReg, total: total, marca: marca,page: page,anho:anho,mes:mes},  // Agregar 'page' a los datos
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
</script>