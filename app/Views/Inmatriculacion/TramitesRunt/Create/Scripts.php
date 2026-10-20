<script>

    $("#formTramitePaso2").bind("submit", function () {
        var idtramite = $("#idtramite").val();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Procesando tramite...<br>No cierre la ventana de grabado");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                CapacidadBlindaje(idtramite)
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
    $("#formTramitePaso1").bind("submit", function () {
        var idtramite = $("#idtramite").val();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Procesando tramite...<br>No cierre la ventana de grabado");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                LineaCombustible(idtramite);
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    function LineaCombustible(idtramite)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/TramitesRunt/CreateViewEdit/LineaCombustible")?>",
            data: {
                idtramite:idtramite
            },
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelFormulario").html(dato.info)
            },
            error: function(xhr) {

            }
        });
    }

    function CapacidadBlindaje(idtramite)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/TramitesRunt/CreateViewEdit/CapacidadBlindaje")?>",
            data: {
                idtramite:idtramite
            },
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelFormulario").html(dato.info)
            },
            error: function(xhr) {

            }
        });
    }
</script>

<script>
    $(document).on('click', '#btnAtrasp1', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idtramite = $("#idtramite").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/TramitesRunt/CreateViewEdit/OrganismoPlaca")?>",
            data: {
                idtramite:idtramite
            },
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelFormulario").html(dato.info)
            },
            error: function(xhr) {

            }
        });
    });
    $(document).on('click', '#btnAtrasp2', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idtramite = $("#idtramite").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/TramitesRunt/CreateViewEdit/LineaCombustible")?>",
            data: {
                idtramite:idtramite
            },
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelFormulario").html(dato.info)
            },
            error: function(xhr) {

            }
        });
    });

</script>