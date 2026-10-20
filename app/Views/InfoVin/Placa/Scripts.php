<script>
    $('.checkTipoPlaca').on('change', function() {
       var idtipoPlaca=$(this).attr("data-idcheck");
        $("#checkTipoPlaca").val(idtipoPlaca);
        $("#checkTipoPlaca").html(idtipoPlaca);
       if(idtipoPlaca==1){
            $("#placaRota").css("display","block");
            $("#placaAgendaRotativa").attr("required",false);
       }else{
           $("#placaRota").css("display","none");
           $("#placaAgendaRotativa").attr("required",false);
       }
    });

    $('#agenciaAgenda').on('change', function() {
        var idagenciaAgenda = $("#agenciaAgenda").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/CalendarioCita/CreateViewEdit/PlacaRotativa")?>",
            data: {idagenciaAgenda:idagenciaAgenda},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#placaAgendaRotativa").html(dato.placas);
            },
            error: function(xhr) {

            }
        });
    });
</script>