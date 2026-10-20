<script>
    $("#dropzone").dropzone({ url: "<?php echo base_url("resource/plugin/phoenixv2/assets/img/icons/file.png")?>" });
    $(document).on('click', '#btnCloseModalUpload', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ModalUploadResource.hide();
    });

    $("#formUploadResource").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {

            },
            success: function (data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    DetailImage();
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>