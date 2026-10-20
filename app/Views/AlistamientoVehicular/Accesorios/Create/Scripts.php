<script>
    $(document).on('click', '.btnOpcionAccesorio', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idequipamientoVin = $(this).attr("data-idequipamiento");
        var vin= $(this).attr("data-vin");
        EquipamientoView(vin,idequipamientoVin);
    });

    $(document).on('click', '#btnVerificar', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $("#vinPedido").val();
        var numeroPedido = $("#numeroPedido").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Confirmacion/SinCotizacion/SaveEditDelete/ValidarCotizacion")?>",
            data: {vin:vin,numeroPedido:numeroPedido},
            beforeSend: function() {
                $("#panelResultPedido").fadeOut();
                $("#preloaderFooterModal").fadeIn();
                $("#btnProcesarAccess").attr("disabled",true);
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#preloaderFooterModal").fadeOut();
                $("#panelResultPedido").fadeIn();
                $("#panelResultPedido").html(dato.panel);
                if(dato.status=='success'){
                    $("#btnProcesarAccessC").prop("disabled",false);
                    $("#btnProcesarAccessC").attr("disabled",false);
                }
            },
            error: function(xhr) {

            }
        });
    });

    function EquipamientoView(vin,idequipamientoVin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Accesorios/CreateViewEdit/CreateAccesorio")?>",
            data: {vin:vin,idequipamientoVin:idequipamientoVin},
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
    }

    function PanelEquipamientoSimple(vin,idtipoEquipamiento)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Accesorios/CreateViewEdit/DetailCreate")?>",
            data: {
                vin:vin,idtipoEquipamiento:idtipoEquipamiento},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalAdicionales.hide();
                    if(idtipoEquipamiento!=1){
                        $("#tbodyEqCritico").html(dato.info);
                    }else{
                        $("#tbodyEqSimple").html(dato.info);
                    }
                }
            },
            error: function(xhr) {

            }
        });
    }

    $("#formSaveHoja").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    location.reload();
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader('Cargando Equipamiento...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    Notificacion(dato.status,dato.title,dato.message);
                    location.reload();
                    ModalInfoVehiculo.hide();
                    send('PDI-'+'<?=session("database")?>'+'-'+dato.vin+'-'+'<?=session("idusuario")?>');
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>