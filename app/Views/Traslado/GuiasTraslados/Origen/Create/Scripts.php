<script>
    $(document).ready(function() {
        $('.checkTipoOrigen').change(function() {
            var tipoOrigen = $(this).val();
            TipoDestinatario(tipoOrigen)
        });
    });

    $(document).on('change', '.checkEstablecimientoAnexo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var establecimientoAnexo = $(this).val();
        EstablecimientoAnexo(establecimientoAnexo)
    });



    $(document).on('click', '#btnSaveOrigT', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        GuardarOtroOrigen()
    });

    function GuardarOtroOrigen()
    {
        var tipoOrigen = $("#inputTipoOrigen").val();
        var rucTercero = $("#rucTercero").val();
        var departamentoOrigen=$("#departamentoOrigen").val();
        var provinciaOrigen=$("#provinciaOrigen").val();
        var distritoOrigen=$("#distritoOrigen").val();
        var direccionOrigen=$("#direccionOrigen").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveOrigen")?>",
            data: {
                tipoOrigen:tipoOrigen,idguiaRemision:'<?php echo $idguiaRemision?>',rucTercero:rucTercero,idempresa:'<?=$idempresa?>',
                departamentoOrigen:departamentoOrigen,provinciaOrigen:provinciaOrigen,distritoOrigen:distritoOrigen,direccionOrigen:direccionOrigen
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                //  $("#tbodyEstablecimiento").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
                $("#tbodyDireccionOrigen").html(dato.info);
                if(dato.tipoOrigen==2){
                    $("#panelRucTercero").css("display","block");
                }else{
                    $("#panelRucTercero").css("display","none");
                }
            },
            error: function(xhr) {

            }
        });
    }


    function EstablecimientoAnexo(establecimientoAnexo)
    {
        var tipoOrigen = $("#inputTipoOrigen").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveOrigen")?>",
            data: {
                tipoOrigen:tipoOrigen,idguiaRemision:'<?php echo $idguiaRemision?>',establecimientoAnexo:establecimientoAnexo,idempresa:'<?=$idempresa?>',
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
              //  $("#tbodyEstablecimiento").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
                $("#tbodyDireccionOrigen").html(dato.info);
                if(dato.tipoOrigen==2){
                    $("#panelRucTercero").css("display","block");
                }else{
                    $("#panelRucTercero").css("display","none");
                }
            },
            error: function(xhr) {

            }
        });
    }


    function TipoDestinatario(tipoOrigen)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/ChangeOrigen")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>',tipoOrigen:tipoOrigen,idempresa:'<?=$idempresa?>'
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyEstablecimiento").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
                $("#inputTipoOrigen").html(dato.tipoOrigen);
                $("#inputTipoOrigen").val(dato.tipoOrigen);
                if(dato.tipoOrigen==2){
                    $("#panelRucTercero").css("display","block");
                }else{
                    $("#panelRucTercero").css("display","none");
                }
            },
            error: function(xhr) {

            }
        });
    }


    $(document).ready(function() {
        // Delegar el evento a un contenedor existente
        $(document).on('change', '#departamentoOrigen', function() {
            var ubigeoDepartamento = $(this).val();
            Provincia(ubigeoDepartamento);
        });
    });

    function Provincia(ubigeoDepartamento)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/Provincia")?>",
            data: {
                ubigeoDepartamento:ubigeoDepartamento
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#provinciaOrigen").html(dato.info);
                $("#distritoOrigen").html(dato.distrito);
            },
            error: function(xhr) {

            }
        });
    }


    $(document).ready(function() {
        // Delegar el evento a un contenedor existente
        $(document).on('change', '#provinciaOrigen', function() {
            var ubigeoProvincia = $(this).val();
            Distrito(ubigeoProvincia);
        });
    });

    function Distrito(ubigeoProvincia)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/Distrito")?>",
            data: {
                ubigeoProvincia:ubigeoProvincia
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#distritoOrigen").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>