<script>
    $(document).on('click', '.btnUploadImage', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleIngresoVehiculoImagen = $(this).attr("data-idimagen");
        var vin = $(this).attr("data-VinImagen");
        ImageUpload(iddetalleIngresoVehiculoImagen,vin);
    });


    function ImageUpload(iddetalleIngresoVehiculoImagen,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/UploadImagen")?>",
            data: {iddetalleIngresoVehiculoImagen:iddetalleIngresoVehiculoImagen,vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }
</script>