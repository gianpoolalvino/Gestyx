<script>
    $(document).on('click', '#btnCreateRep', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/TipoCambio/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndexFilt();
    });

    function DetailIndexFilt()
    {
        var fechaInicio = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/TipoCambio/Index/DetailIndex")?>",
            data: {fechaInicio:fechaInicio,fechaFin:fechaFin},
            beforeSend: function() {
                Preloader("Espere un momento....<br>No cierres el Navegador... :)")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyAlistamiento").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>