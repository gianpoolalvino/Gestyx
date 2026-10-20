<script>
    $(document).ready(function () {
        // ... otros listeners globales ...
        $('#ModalAdicionales').on('hidden.bs.modal', function () {
            if (scanner) {
                scanner.stop().catch(() => {});
            }
        });
    });
    // Requiere: una sola vez
    let scanner = null;
    let cameras = [];

    function inicializarScanner() {
        const video = document.getElementById('preview');
        const select = document.getElementById('camerasSelect');

        if (!video || !select) {
            console.warn("No se encontró video o select en el DOM del modal");
            return;
        }

        if (scanner) {
            scanner.stop().catch(() => {});
        }

        scanner = new Instascan.Scanner({ video: video });

        Instascan.Camera.getCameras().then(function (foundCameras) {
            cameras = foundCameras;
            select.innerHTML = "";

            if (cameras.length > 0) {
                cameras.forEach(function (camera, index) {
                    const option = document.createElement('option');
                    option.value = index;
                    option.text = camera.name || `Cámara ${index + 1}`;
                    select.appendChild(option);
                });

                select.onchange = () => {
                    const idx = parseInt(select.value);
                    if (!isNaN(idx)) {
                        scanner.start(cameras[idx]).catch(e => console.error("Error al iniciar cámara:", e));
                    }
                };

                select.value = "0";
                select.dispatchEvent(new Event("change"));
            } else {
                console.error("No se encontraron cámaras.");
            }
        }).catch(e => console.error("Error al obtener cámaras:", e));
    }
</script>
<script>
    var cont =$("#countReg").val();
    var rango =$("#totalRegistros").val();


    $(document).on('change', '#tipoFiltro', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var tipoFiltro = $("#tipoFiltro").val();
        if(tipoFiltro!=''){

        }
    } );

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

    $(document).on('click', '.vinAccesorios', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var vin= $(this).attr("data-vin");

        if(opcion=="Proceso"){
            ViewVinProceso(vin)
        }
    });

    function VinInfo(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("InfoVin")?>",
            data: {vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#panelVinInfo").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function ViewVinProceso(vin)
    {

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Pdi/CreateViewEdit/Create")?>",
            data: {vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
                if(dato.status=='success'){
                    VinInfo(vin);
                }
            },
            error: function(xhr) {

            }
        });
    }

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

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('AlistamientoVehicular/Pdi/Index/DetailIndex'); ?>",
            data: {start: start, countReg: countReg, total: total, tipoFiltr: tipoFiltr, filtro: filtro, page: page},  // Agregar 'page' a los datos
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


    function DetailIndexFiltold()
    {
        var start = $("#start").val();
        var countReg = 0;
        var total = $("#totalRegistros").val();
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Pdi/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro},
            beforeSend: function() {
                $("#cargarData").fadeIn();
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.tbody);
                $("#start").val(dato.start);
                $("#start").html(dato.start);
                $("#countReg").val(dato.countReg);
                $("#countReg").html(dato.countReg);
                $("#cargarData").fadeOut();
            },
            error: function(xhr) {

            }
        });
    }


    function DetailIndexScroll()
    {
        var start = $("#start").val();
        var countReg = $("#countReg").val();
        var total = $("#totalRegistros").val();
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Pdi/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").append(dato.tbody);
                $("#start").val(dato.start);
                $("#start").html(dato.start);
                $("#countReg").val(dato.countReg);
                $("#countReg").html(dato.countReg);

                if(dato.total==dato.countReg){
                    $("#cargarData").fadeOut();
                }
            },
            error: function(xhr) {

            }
        });
    }
</script>