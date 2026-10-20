<script>



    $('#selectVehiculo').select2({
        dropdownParent: $('#ModalInfoVehiculo .modal-body')
    });

    $("#formIngreso").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Data....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    $("#procesarIngreso").attr("disabled",true);
                    $("#panelClose").css("display","none");
                    RecargaPanel(dato.idingresoVin,dato.vin);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });

    $("#selectVehiculo").change(function(){
        var vin = $("#selectVehiculo").val();

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/PanelPrincipal")?>",
            data: {vin:vin},
            beforeSend: function() {
                Preloader("Buscando Vehiculo...<br>No cambie de ventana... :)")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){

                    $("#panelVehiculoIngreso").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    });
</script>

