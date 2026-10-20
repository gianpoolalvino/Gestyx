<script>
    $(document).ready(function() {
        $('.checkTipoDestino').change(function() {
            var tipoDestino = $(this).val();
            TipoDestinatario(tipoDestino)
        });
    });

    $(document).on('change', '.checkEstablecimientoAnexoDest', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var establecimientoAnexo = $(this).val();
        EstablecimientoAnexoDestino(establecimientoAnexo)
    });



    $(document).on('click', '#btnSaveDestT', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        GuardarOtroDestino()
    });

    function GuardarOtroDestino()
    {
        var tipoDestino = $("#inputTipoDestino").val();
        var rucTerceroDestino = $("#rucTerceroDest").val();
        var departamentoDestino=$("#departamentoDestino").val();
        var provinciaDestino=$("#provinciaDestino").val();
        var distritoDestino=$("#distritoDestino").val();
        var direccionDestino=$("#direccionDestino").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveDestino")?>",
            data: {
                tipoDestino:tipoDestino,idguiaRemision:'<?php echo $idguiaRemision?>',rucTerceroDestino:rucTerceroDestino,idempresa:'<?=$idempresa?>',
                departamentoDestino:departamentoDestino,provinciaDestino:provinciaDestino,distritoDestino:distritoDestino,direccionDestino:direccionDestino
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                //  $("#tbodyEstablecimiento").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
                $("#tbodyDireccionDestino").html(dato.info);
                if(dato.tipoOrigen==2){
                    $("#panelRucTerceroDest").css("display","block");
                }else{
                    $("#panelRucTerceroDest").css("display","none");
                }
            },
            error: function(xhr) {

            }
        });
    }


    function EstablecimientoAnexoDestino(establecimientoAnexo)
    {
        var tipoDestino = $("#inputTipoDestino").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveDestino")?>",
            data: {
                tipoDestino:tipoDestino,idguiaRemision:'<?php echo $idguiaRemision?>',establecimientoAnexo:establecimientoAnexo,idempresa:'<?=$idempresa?>',
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                //  $("#tbodyEstablecimiento").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
                $("#tbodyDireccionDestino").html(dato.info);
                if(dato.tipoOrigen==2){
                    $("#panelRucTerceroDest").css("display","block");
                }else{
                    $("#panelRucTerceroDest").css("display","none");
                }
            },
            error: function(xhr) {

            }
        });
    }


    function TipoDestinatario(tipoDestino)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/ChangeDestino")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>',tipoDestino:tipoDestino,idempresa:'<?=$idempresa?>'
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyEstablecimientoDest").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
                $("#inputTipoDestino").html(dato.tipoDestino);
                $("#inputTipoDestino").val(dato.tipoDestino);
                if(dato.tipoDestino==2){
                    $("#panelRucTerceroDest").css("display","block");
                }else{
                    $("#panelRucTerceroDest").css("display","none");
                }
            },
            error: function(xhr) {

            }
        });
    }


    $(document).ready(function() {
        // Delegar el evento a un contenedor existente
        $(document).on('change', '#departamentoDestino', function() {
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
                $("#provinciaDestino").html(dato.info);
                $("#distritoDestino").html(dato.distrito);
            },
            error: function(xhr) {

            }
        });
    }


    $(document).ready(function() {
        // Delegar el evento a un contenedor existente
        $(document).on('change', '#provinciaDestino', function() {
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
                $("#distritoDestino").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>