<script>
    $(document).on('click', '#btnModalClose', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ModalAdicionales.hide();
    });

    $(document).on('click', '.btnAddTacha', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $(this).attr("data-vin");
        var titulo = $(this).attr("data-title");

        $("#tituloSearchTacha").val(titulo);
        $("#vinSearchTacha").val(vin);
        $("#comentarioAdv").attr("readonly",false);
        $("#btnProccessTacha").prop("disabled",false);

        ModalAdicionales.hide();
    });


</script>