<script>
    function DetailIndexConcepto()
    {
        var idreglaComisionVentaVehiculo = $("#idreglaComision").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/ReglaComision/CreateViewEdit/DetailIndexConcepto")?>",
            data: {idreglaComisionVentaVehiculo:idreglaComisionVentaVehiculo},
            beforeSend: function() {
                Preloader("Buscando Datos<br>No cierre la pagina");
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                $("#tbodyConcepto").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function DetailIndexCategoria()
    {
        var idreglaComisionVentaVehiculo = $("#idreglaComision").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/ReglaComision/CreateViewEdit/DetailIndexCategoria")?>",
            data: {idreglaComisionVentaVehiculo:idreglaComisionVentaVehiculo},
            beforeSend: function() {
                Preloader("Buscando Datos<br>No cierre la pagina");
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                $("#tbodyCategoria").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnTrashCat', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcategoriaBono = $(this).attr("data-idcategoriaBono");
        // Mostrar un cuadro de confirmación
        var confirmacion = window.confirm("¿Estás seguro de que deseas eliminar este concepto?");

        if (confirmacion) {
            // Si el usuario hace clic en Aceptar, se ejecuta el código AJAX
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Comisiones/ReglaComision/SaveEditDelete/DeleteCategoria")?>",
                data: {idcategoriaBono:idcategoriaBono},
                beforeSend: function() {
                    Preloader("Buscando Datos<br>No cierre la pagina");
                },
                success: function(data) {
                    let dato = $.parseJSON(data);
                    ClosePreloader();
                    DetailIndexCategoria();
                    Notificacion(dato.status, dato.title, dato.message);
                },
                error: function(xhr) {
                    // Manejar error aquí si es necesario
                }
            });
        } else {
            // Si el usuario hace clic en Cancelar, no se hace nada
            console.log("Operación cancelada");
        }
    });

    $(document).on('click', '.btnTrash', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idconceptoRegla = $(this).attr("data-idconceptoRegla");
        // Mostrar un cuadro de confirmación
        var confirmacion = window.confirm("¿Estás seguro de que deseas eliminar este concepto?");

        if (confirmacion) {
            // Si el usuario hace clic en Aceptar, se ejecuta el código AJAX
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Comisiones/ReglaComision/SaveEditDelete/DeleteConcepto")?>",
                data: {idconceptoRegla:idconceptoRegla},
                beforeSend: function() {
                    Preloader("Buscando Datos<br>No cierre la pagina");
                },
                success: function(data) {
                    let dato = $.parseJSON(data);
                    ClosePreloader();
                    DetailIndexConcepto();
                    Notificacion(dato.status, dato.title, dato.message);
                },
                error: function(xhr) {
                    // Manejar error aquí si es necesario
                }
            });
        } else {
            // Si el usuario hace clic en Cancelar, no se hace nada
            console.log("Operación cancelada");
        }
    });



    $(document).on('click', '#BtnAddCategoriaRe', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idreglaComisionCategoria = $("#idreglaComisionCategoria").val();
        var categoriaRegla = $("#categoriaRegla").val();
        var condicionCategoria = $("#condicionCategoria").val();
        var porcentajeCategoria = $("#porcentajeCategoria").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/ReglaComision/SaveEditDelete/SaveCategoria")?>",
            data: {
                idreglaComisionCategoria:idreglaComisionCategoria,
                categoriaRegla:categoriaRegla,
                condicionCategoria:condicionCategoria,
                porcentajeCategoria:porcentajeCategoria
            },
            beforeSend: function() {
                Preloader("Buscando Datos<br>No cierre la pagina");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                DetailIndexCategoria();
                Notificacion(dato.status, dato.title, dato.message);
            },
            error: function(xhr) {
                // Manejar error aquí si es necesario
            }
        });
    });

    $(document).on('click', '.btnTrashCat', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcategoriaBono = $(this).attr("data-idcategoriaBono");
        // Mostrar un cuadro de confirmación
        var confirmacion = window.confirm("¿Estás seguro de que deseas eliminar este concepto?");

        if (confirmacion) {
            // Si el usuario hace clic en Aceptar, se ejecuta el código AJAX
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Comisiones/ReglaComision/SaveEditDelete/DeleteCategoria")?>",
                data: {idcategoriaBono:idcategoriaBono},
                beforeSend: function() {
                    Preloader("Buscando Datos<br>No cierre la pagina");
                },
                success: function(data) {
                    let dato = $.parseJSON(data);
                    ClosePreloader();
                    DetailIndexCategoria();
                    Notificacion(dato.status, dato.title, dato.message);
                },
                error: function(xhr) {
                    // Manejar error aquí si es necesario
                }
            });
        } else {
            // Si el usuario hace clic en Cancelar, no se hace nada
            console.log("Operación cancelada");
        }
    });


    $("#formSaveRegla").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Almacenando Regla de Comision<br>No Cierres la ventana ni refresques la pagina, hasta que finalice el proceso");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>