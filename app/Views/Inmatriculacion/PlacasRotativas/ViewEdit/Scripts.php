<script>
    $('#selectVinPlaca').select2({
        tags: true,
        dropdownParent: $('#ModalAdicionales'),
    });
</script>

<script>
    $(document).ready(function() {
        $('#vinVehicular').on('input', function () {
            let query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: '<?php echo base_url("Inmatriculacion/PlacasRotativas/CreateViewEdit/SelectVin")?>',
                    method: 'POST',
                    data: {query: query},
                    success: function (data) {
                        let dato = $.parseJSON(data);
                        $('#result').html(dato.info);
                    }
                });
            } else {
                $('#result').empty();
            }
        });

        // Manejo de selección
        $(document).on('click', '.result-item', function () {
            var vin = $(this).attr("data-vin");
            $('#vinVehicular').val($(this).text());
            $('#result').empty();

        });


        // Cerrar el cuadro de resultados al hacer clic fuera
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#search').length && !$(event.target).closest('#result').length) {
                $('#result').empty();
            }
        });
    });
</script>