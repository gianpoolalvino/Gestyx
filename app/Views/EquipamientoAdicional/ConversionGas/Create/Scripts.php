<script>
    $("#selectGas").on( "click", function() {
        var select = $("#selectGas").val();
        if(select==2){
            $("#proveedorGas").attr("required",true);
            $("#fechaInstalacionGas").attr("required",true);
        }else{
            $("#proveedorGas").attr("required",false);
            $("#fechaInstalacionGas").attr("required",false);
        }
    });


    $(".selectEquiVin").on( "click", function() {
        var select = $(this).attr("data-idequipamiento");
        var idequipamientoVin = $("#estadoEquip"+select).val();
        if(idequipamientoVin==2){
            $("#fechaInst"+select).attr("required",true);
        }else{
            $("#fechaInst"+select).attr("required",false);
        }
    });

    $("#estadoEquipamientoGps").on( "click", function() {
        var selectGps = $("#estadoEquipamientoGps").val();
        if(selectGps==2){
            $("#fechaInstalacionGps").attr("required",true);
        }else{
            $("#fechaInstalacionGps").attr("required",false);
        }
    });

    $("#formSave").bind("submit", function () {
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


</script>