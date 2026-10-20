<script>
    $(document).ready(function() {
        // Verificar si el SDK de Power BI está cargado correctamente
        console.log(powerbi);
        if (typeof powerbi !== 'undefined' && powerbi.models) {
            // Configuración para incrustar el reporte de Power BI
            var embedConfig = {
                type: 'report',  // Tipo de objeto: reporte
                tokenType: powerbi.models.tokenType.embed,  // Tipo de token: incrustación
                accessToken: '<?php echo $token?>',  // Tu token de incrustación generado por PHP
                embedUrl: 'https://app.powerbi.com/reportEmbed?reportId=6028eabd-1397-4b91-8434-7cba3558b7df&groupId=me&autoAuth=true&ctid=36b54355-3871-4240-b1ee-3e65eeeabb93',  // URL de incrustación del reporte
                id: '6028eabd-1397-4b91-8434-7cba3558b7df',  // ID del reporte
                permissions: powerbi.models.Permissions.All,  // Permisos
                settings: {
                    filterPaneEnabled: true,  // Mostrar panel de filtros
                    navContentPaneEnabled: true  // Mostrar panel de navegación
                }
            };

            // Usando jQuery para incrustar el reporte
            var $reportContainer = $('#reportContainer');
            powerbi.embed($reportContainer[0], embedConfig);  // Incrustar el reporte en el contenedor
        } else {
            console.error('El SDK de Power BI no se ha cargado correctamente.');
        }
    });
</script>