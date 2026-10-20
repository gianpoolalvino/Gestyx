
<script>
    $(document).on('click', '#btnAddDiagrama', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idliberacionDemo = $("#idliberacionVin").val();
        var idasignarDemo = $("#idasignarDemo").val();
        var idcheckListRetorno = $("#idcheckListRetorno").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ControlDemos/DemosAsignados/CreateViewEdit/CreateDiagrama")?>",
            data: {idliberacionDemo:idliberacionDemo,idasignarDemo:idasignarDemo,idcheckListRetorno:idcheckListRetorno},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalDiagramaVehiculo.show();
                $("#BodyDiagramaVehiculo").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnuploadResource', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idliberacionDemo = $("#idliberacionVin").val();
        var idasignarDemo = $("#idasignarDemo").val();
        var idcheckListRetorno = $("#idcheckListRetorno").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ControlDemos/DemosAsignados/CreateViewEdit/UploadResource")?>",
            data: {idliberacionDemo:idliberacionDemo,idasignarDemo:idasignarDemo,idcheckListRetorno:idcheckListRetorno},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalUploadResource.show();
                $("#bodyuploadResource").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });

    $(".checkSerVin").change(function() {
        var idcheck = $(this).attr("data-id");
        if (this.checked) {
            $("#checkService"+idcheck).val(1);
            $("#checkService"+idcheck).html(1);
        }else{
            $("#checkService"+idcheck).val(0);
            $("#checkService"+idcheck).html(0);
        }
    });

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

    function DeleteResource(idresourceAsignacionDemo)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ControlDemos/DemosAsignados/CreateViewEdit/DeleteResource")?>",
            data: {idresourceAsignacionDemo:idresourceAsignacionDemo},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalUploadResource.hide();
                if(dato.status=='success'){
                    DetailImage();
                }
            },
            error: function(xhr) {

            }
        });
    }


    function DetailImage()
    {
        var idcheckListDemo = $("#idcheckListRetornoImg").val();
        var idasignarDemo = $("#idasignarDemoRetorImg").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ControlDemos/DemosAsignados/CreateViewEdit/DetailImageCheckList")?>",
            data: {idcheckListDemo:idcheckListDemo,idasignarDemo:idasignarDemo},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="success"){
                    ModalUploadResource.hide();
                    $("#panelResourceAsignacion").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

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
                    CheckList(dato.idasignarDemo,dato.vin);
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    function CheckList(idasignarDemo,vin) {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");
        var w = 1060;
        var h = 624;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        form.method = "POST";
        form.id = "formCreateCMPjs";
        form.action = "<?php echo base_url("ControlDemos/Pdf/CheckListRetorno")?>";
        form.target = "print_popup";
        element1.value=idasignarDemo;
        element1.hidden=true;
        element1.name="idasignarDemo";
        element2.value=vin;
        element2.hidden=true;
        element2.name="vin";
        form.appendChild(element1);
        form.appendChild(element2);
        document.body.appendChild(form);
        form.submit(window.open('about:blank','print_popup','width=' + w + ', height=' + h + ', top=' + top + ', left=' + left));
        $("#formCreateCMPjs").remove();
        location.reload();
        ModalInfoVehiculo.hide();
    }

</script>