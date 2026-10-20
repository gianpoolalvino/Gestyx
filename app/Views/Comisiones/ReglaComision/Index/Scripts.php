<script>
    $(document).on('click', '#btnNuevaRegla', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/ReglaComision/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
                Preloader("Buscando Datos<br>No cierre la pagina");
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    });
</script>
<script>

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });

    function DetailIndex()
    {
        var idmarca = $("#marcas").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/ReglaComision/Index/DetailIndex")?>",
            data: {idmarca:idmarca},
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
    $(document).on('click', '#btnAddConcept', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idreglaComisionVentaVehiculo = $("#idreglaComision").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Comisiones/ReglaComision/CreateViewEdit/CreateConcepto")?>",
            data: {idreglaComisionVentaVehiculo:idreglaComisionVentaVehiculo},
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