<script>
    $(document).on('click', '.navTabGrupoCalidad', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idgrupoCheckCC = $(this).attr("data-idgrupoCheckCC");
        var idprocesoCalidad = $(this).attr("data-idprocesoCalidad");
        PanelCheckList(idgrupoCheckCC);
    });

    function PanelEquipamientoList()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/ControlCalidad/CreateViewEdit/DetailCreateEquipamientoCalidad")?>",
            data: {
                idprocesoCalidad:'<?=$idprocesoCalidad?>',
                vin:'<?php echo $vin?>'},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    $("#tbodyEquipamientoCalidad").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    }

    function PanelCheckList(idgrupoCheckCC)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/ControlCalidad/CreateViewEdit/DetailCreateCheckCalidad")?>",
            data: {
                idgrupoCheckCC:idgrupoCheckCC,
                idprocesoCalidad:'<?=$idprocesoCalidad?>',
                vin:'<?php echo $vin?>'},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    $("#panelChecksList").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    }


    $(document).on('click', '.btnEditEquipamiento', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idequipamientoCalidad = $(this).attr("data-idequipamientoCalidad");
        var vin = $(this).attr("data-vin");
        VerificarEquipamiento(idequipamientoCalidad,vin);
    });

    $(document).on('click', '.btnEditProceso', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcheckCalidad = $(this).attr("data-iddetalleCheck");
        var vin = $(this).attr("data-vin");
            VerificarCheckCalidad(idcheckCalidad,vin);
    });

    function VerificarEquipamiento(idequipamientoCalidad,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/ControlCalidad/CreateViewEdit/CreateEquipamiento")?>",
            data: {idequipamientoCalidad:idequipamientoCalidad,vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnAddCalidad', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idgrupoCalidad = $(this).attr("data-idgrupoCalidad");
        var vin = $(this).attr("data-vin");
        CreateCheckCalidad(idgrupoCalidad,vin);
    });

    function CreateCheckCalidad(idgrupoCalidad,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/ControlCalidad/CreateViewEdit/CreateCheckCalidadDinamico")?>",
            data: {idgrupoCalidad:idgrupoCalidad,vin:vin,idprocesoCalidad:'<?=$idprocesoCalidad?>'},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }



    function VerificarCheckCalidad(idcheckCalidad,vin)
    {
        var ruta;
        if('<?=$tipoProceso?>'==1){
            ruta="<?php echo base_url("AlistamientoVehicular/ControlCalidad/CreateViewEdit/CreateCheckCalidad")?>";
        }else{
            ruta="<?php echo base_url("AlistamientoVehicular/ControlCalidad/CreateViewEdit/UpdateCheckCalidad")?>";
        }
        $.ajax({
            type: 'POST',
            url:ruta,
            data: {idcheckCalidad:idcheckCalidad,vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $("#formSaveCalidad").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader('Cargando Datos...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    location.reload();
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>