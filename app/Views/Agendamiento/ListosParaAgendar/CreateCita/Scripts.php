<script>
    $("#idagencias").on( "change", function() {
        var idagencia = $("#idagencias").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/ListosParaAgendar/CreateViewEdit/AsesorEntrega")?>",
            data: {idagencia:idagencia},
            beforeSend: function() {
                Preloader("Cargando Asesores...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    ClosePreloader();
                    $("#asesores").attr("disabled",false);
                    $("#asesores").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    } );

    $("#asesores").on( "change", function() {
        var idasesor = $("#asesores").val();
        var fecha = $("#fechaCita").val();
        var tipoHora = 1;
        var hora = '';
        HorariosDisponibles(tipoHora,fecha,idasesor,hora);
    } );

    $("#horaInicio").on( "change", function() {
        var idasesor = $("#asesores").val();
        var fecha = $("#fechaCita").val();
        var tipoHora = 2;
        var hora = $("#horaInicio").val();
        HorariosDisponibles(tipoHora,fecha,idasesor,hora);
    } );


    $('#fechaCita').on('change', function() {
        var idasesor = $("#asesores").val();
        var fecha = $("#fechaCita").val();
        var tipoHora = 1;
        var hora = '';
        HorariosDisponibles(tipoHora,fecha,idasesor,hora);
    });

    function HorariosDisponibles(tipoHora,fechaCita,idasesor,hora)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/ListosParaAgendar/CreateViewEdit/HorarioDisponibleAsesor")?>",
            data: {tipoHora:tipoHora,fechaCita:fechaCita,idasesor:idasesor,hora:hora},
            beforeSend: function() {
                Preloader("Cargando Horarios...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    if(tipoHora==1){
                        $("#horaInicio").attr("disabled",false);
                        $("#horaFin").attr("disabled",false);
                        $("#horaInicio").html(dato.info);
                        var horaIn = $("#horaInicio").val();
                        HorariosDisponibles(2,fechaCita,idasesor,horaIn);
                    }else{
                        $(".checkTipoPlaca").attr("disabled",false);
                        $("#horaFin").attr("disabled",false);
                        $("#horaFin").html(dato.info);
                    }
                }
            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    $('.checkTipoPlaca').on('change', function() {
        var idtipoPlaca=$(this).attr("data-idcheck");
        $("#checkTipoPlaca").val(idtipoPlaca);
        $("#checkTipoPlaca").html(idtipoPlaca);
        if(idtipoPlaca==1){
            $("#placaRota").css("display","block");
            PlacaRotativa();
            $("#placaAgendaRotativa").attr("required",true);
        }else{
            $("#placaRota").css("display","none");
            $("#placaAgendaRotativa").attr("required",false);
        }
    });

    function PlacaRotativa()
    {
        var idagenciaAgenda = $("#idagencias").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/CalendarioCita/CreateViewEdit/PlacaRotativa")?>",
            data: {
                idagenciaAgenda:idagenciaAgenda
            },
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#placaAgendaRotativa").attr("disabled",false);
                    $("#placaAgendaRotativa").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Guardando Cita...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
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