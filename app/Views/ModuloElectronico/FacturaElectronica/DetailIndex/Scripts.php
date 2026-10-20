<script>
    $(document).on('click', '.btnOpc', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcpe=$(this).attr("data-idcpe");
        var numeroFactura=$(this).attr("data-numeroFactura");
        var opcion=$(this).attr("data-opcion");
        if(opcion=='download'){
            Download(idcpe,numeroFactura);
        }else if(opcion=='evento'){
            GenerarEvento(idcpe,numeroFactura);
        }
    });

    function Download(idcpe,numeroFactura)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ModuloElectronico/OpcionElectronica/Index/ViewDownload")?>",
            data: {idcpe:idcpe,numeroFactura:numeroFactura},
            beforeSend: function() {
                Preloader("Cargando Interface<br>No cierre la ventana....")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    function GenerarEvento(idcpe,numeroFactura)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ModuloElectronico/OpcionElectronica/Index/ViewEvento")?>",
            data: {idcpe:idcpe,numeroFactura:numeroFactura},
            beforeSend: function() {
             //   Preloader("Cargando Interface<br>No cierre la ventana....")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
              //  ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
                if(dato.status=='success'){

                }
            },
            error: function(xhr) {

            }
        });
    }
</script>