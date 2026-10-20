<script>
    function CreateAgenda(idagenda,estadoAgenda,fecha,hora,idasesor)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/CalendarioCita/CreateViewEdit/CreateCita")?>",
            data: {idagenda:idagenda,estadoAgenda:estadoAgenda,fecha:fecha,hora:hora,idasesor:idasesor},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function EditAgenda(idagenda,idasesor,vin,idcita)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/CalendarioCita/CreateViewEdit/EditCita")?>",
            data: {idagenda:idagenda,idasesor:idasesor,vin:vin,idcita:idcita},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '.btnAddAgenda', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idagenda = $(this).attr("data-idAgenda");
        var estadoAgenda = $(this).attr("data-estadoAgenda");
        var fecha = $(this).attr("data-fecha");
        var hora = $(this).attr("data-hora");
        var idasesor = $(this).attr("data-idasesor");
        var vin = $(this).attr("data-vin");
        var idcita = $(this).attr("data-idcita");
        if(opcion=='CreateAgenda'){
            CreateAgenda(idagenda,estadoAgenda,fecha,hora,idasesor);
        }else if(opcion=='EditAgenda'){
            EditAgenda(idagenda,idasesor,vin,idcita);
        }


    });
</script>