<script>
    $(document).on('click', '#btnCreateCampanha', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/AplicacionCampanha/CreateViewEdit/CreateCampanha")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    });
</script>