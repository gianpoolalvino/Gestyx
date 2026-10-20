<script>


    function BienesTransportar(idguiaRemision)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/BienesTransportar")?>",
            data: {idguiaRemision:idguiaRemision},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelFormula").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function ViewDocRelacionado()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/DetailDocRelacionado")?>",
            data: {idguiaRemision:'<?=$idguiaRemision?>'},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyDetailDocRel").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }


    //Adicionales
    $(document).on('click', '#btnAddDoc', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateTD();
    });

    function CreateTD()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/CreateDocumentoRelacionado")?>",
            data: {idguiaRemision:'<?=$idguiaRemision?>'},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>