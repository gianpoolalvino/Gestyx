<script>
    $(document).on('click', '#btnTrasladoMasivo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateTrasladoMasivo();
    });

    function CreateTrasladoMasivo()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/GestionarVehiculos/Index/CreateTrasladoMasivo")?>",
            data: {},
            beforeSend: function() {
                Preloader("Iniciando Interfaz...")
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnCreateExcel', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DescargarExcelVendidos();
    });

    function DescargarExcelVendidos()
    {
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        var estadoVehiculo = $("#selectTipo").val();
        var fecha = $("#fecha").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/GestionarVehiculos/Index/DetailIndexExcel")?>",
            data: {tipoFiltr: tipoFiltr, filtro: filtro,estadoVehiculo:estadoVehiculo,fecha:fecha},
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

    $(document).ready(function() {
        // Detectar doble clic en las filas del tbody
        $("#tbodyGestionar").on("dblclick", "tr", function() {
            // Acción que quieres realizar al hacer doble clic
            var vin = $(this).attr('data-vin');
            var idsolicitudVin=$(this).attr('data-idsolicitudVin');

            window.location.href = "<?php echo base_url("SolicitudVin/VinSolicitud/")?>"+vin+'/'+idsolicitudVin;
            // Ejemplo de acción: Añadir una clase a la fila seleccionada
            $(this).toggleClass('selected-row');  // Cambia la clase para resaltar la fila seleccionada
        });
    });

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndexFilt();
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
        var estadoVehiculo = $("#selectTipo").val();
        var fecha = $("#fecha").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('SolicitudVin/GestionarVehiculos/Index/DetailIndex'); ?>",
            data: {estadoVehiculo:estadoVehiculo,start: start, countReg: countReg, total: total, tipoFiltr: tipoFiltr, filtro: filtro,fecha:fecha, page: page},  // Agregar 'page' a los datos
            beforeSend: function() {
                Preloader("Cargado Datos...")  // Mostrar el indicador de carga
            },
            success: function(data) {
                var dato = $.parseJSON(data);
                ClosePreloader();
                // Actualizar el cuerpo de la tabla
                $("#tbodyGestionar").html(dato.tbody);

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