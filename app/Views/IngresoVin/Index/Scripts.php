<script>

    $(document).on('click', '#btnCreateVehicle', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ScanerNuevo();
    });

    $(document).on('click', '#btnPanelCreado', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        PanelVehiculo();
    });

    function PanelVehiculo()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/Index/PanelCreado")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalPanelGeneral.show();
                    $("#BodyPanelGeneral").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    function ScanerNuevo()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/CreateVehiculo")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }



    $(document).on('click', '#btnPrintQr', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        GenerarQrs();
    });

    function GenerarQrs()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/CreateQrs")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnNewIngreso', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        NuevoIngreso();
    });
    var count=0;
    var contador=0;
    $(document).on('click', '#btnAddFiltroAvanced', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/Index/FiltrosAvanzados")?>",
            data: {count:count},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyFiltroAvanzado").append(dato.info);
                count++;
                contador++;
                $("#cantidadfiltroAvanzado").html(contador);
                $("#cantidadfiltroAvanzado").val(contador);
            },
            error: function(xhr) {

            }
        });
    });
    $(document).on('click', '.trashButtonFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idtrash = $(this).attr("data-idtrash");
        $('#filtroAvanced' + idtrash).remove();
        contador=contador-1;
        $("#cantidadfiltroAvanzado").html(contador);
        $("#cantidadfiltroAvanzado").val(contador);
    });


    $(document).on('click', '.btnViewQr', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $(this).attr('data-vin');
        ViewQrVin(vin);
    });

    function ViewQrVin(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/ViewQrVin")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function ReporteIngresos()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/CreateReporteExcel")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnReportExc', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ReporteIngresos();
    });

    function ReporteIngresos()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/CreateReporteExcel")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#brnAplicarFiltros', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });


    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $("#filtro").val('');
        DetailIndex();
    });

    function NuevoIngreso()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnViewIngreso', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $(this).attr("data-idingresoVin");
        var vin = $(this).attr("data-vin");
        ViewIngreso(idingresoVin,vin);
    });

    function ViewIngreso(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/ViewEdit")?>",
            data: {idingresoVin:idingresoVin,vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }


    $(document).on('click', '.checkFilt', function () {
        var idcampoFiltro = $(this).attr("data-idcampoFiltro");
        var estadoCampo='';
        if ($(this).is(':checked')) {
            estadoCampo =1;
        } else {
            estadoCampo =2;
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/Index/ModificarFiltro")?>",
            data: {idcampoFiltro:idcampoFiltro,estadoCampo:estadoCampo},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    DetailIndex();
                }
            },
            error: function(xhr) {

            }
        });
    });

    $(document).ready(function() {
        // Evento para el campo de entrada
        $('#filtro').on('keyup', function () {
            // Obtiene el texto del campo de búsqueda
            DetailIndex();
        });
    });

    $(document).ready(function() {
        // Detectar cambios en el campo de fecha de inicio
        $('#fechaInicio').change(function() {
            DetailIndex();
            // Aquí puedes agregar más acciones
        });

        // Detectar cambios en el campo de fecha de fin
        $('#fechaFin').change(function() {
            DetailIndex();
            // Aquí puedes agregar más acciones
        });
    });

    function DetailIndex()
    {
        var selects = [];
        var tipoSelects=[];
        var searchInputs = [];

        $('#tableFiltrosAvanzados tbody tr').each(function() {
            var row = $(this);
            var rowSelects = [];
            var rowTipoSelects = [];
            var rowSearchInputs = [];

            row.find('select[name="selectAvanzado[]"]').each(function() {
                var val = $(this).val();
                if (val) { // Solo agrega si el valor no está vacío
                    rowSelects.push(val);
                }
            });

            row.find('select[name="tipoSelectAvanzado[]"]').each(function() {
                var val = $(this).val();
                if (val) { // Solo agrega si el valor no está vacío
                    rowTipoSelects.push(val);
                }
            });

            row.find('input[name="searchAvanzado[]"]').each(function() {
                var val = $(this).val();
                if (val) { // Solo agrega si el valor no está vacío
                    rowSearchInputs.push(val);
                }
            });

            // Solo agrega la fila si al menos un valor está presente
            if (rowSearchInputs.length > 0) {
                selects.push(rowSelects);
                tipoSelects.push(rowTipoSelects);
                searchInputs.push(rowSearchInputs);
            }
        });

        var filtro = $("#filtro").val();
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin=$("#fechaFin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/Index/DetailIndex")?>",
            data: {filtro:filtro,
                    selectAvanzado: selects,
                    tipoSelectAvanzado: tipoSelects,
                    searchAvanzado: searchInputs,
                fechaInicio:fechaInicio,
                fechaFin:fechaFin},
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