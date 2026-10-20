<script>
    $(".checkVin").change(function() {
        var idcheck = $(this).attr("data-id");
        if (this.checked) {
            $("#cantidadEq"+idcheck).attr("readonly",false);
            $("#cantidadEq"+idcheck).val(1);
            $("#equipadoDemo"+idcheck).val(1);
            $("#equipadoDemo"+idcheck).html(1);
        }else{
            $("#cantidadEq"+idcheck).val('');
            $("#equipadoDemo"+idcheck).val(0);
            $("#equipadoDemo"+idcheck).html(0);
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
                    Comodato(dato.idasignarDemo,dato.vin);
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    function Comodato(idasignarDemo,vin)
    {
        let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;
        window.open('<?php echo base_url("ControlDemos/Pdf/EntregaDemo?idasignarDemo=")?>'+idasignarDemo+'&vin='+vin, 'Comodato',params);
        CheckList(idasignarDemo,vin);
    }

    function CheckList(idasignarDemo,vin)
    {
        let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000`;
        window.open('<?php echo base_url("ControlDemos/Pdf/CheckListEntrega?idasignarDemo=")?>'+idasignarDemo+'&vin='+vin, 'Check List Entrega',params);
        location.reload();
        ModalInfoVehiculo.hide();
    }
</script>