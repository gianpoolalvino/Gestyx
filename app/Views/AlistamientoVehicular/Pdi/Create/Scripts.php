<script>
    $(document).on('click', '.viewCameraActive', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idresultadoFormularioPdi = $(this).attr("data-idresultadoFormularioPdi");
        var vin = $(this).attr("data-vin");
        var idprocesoPdi = $(this).attr("data-idprocesoPdi");
        var idgrupoCheckListFormularioPdi = $(this).attr("data-idgrupoCheckListFormularioPdi");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("AlistamientoVehicular/Pdi/CreateViewEdit/ViewCamera")?>",
            data: {
                idresultadoFormularioPdi:idresultadoFormularioPdi,
                vin:vin,
                idprocesoPdi:idprocesoPdi,
                idgrupoCheckListFormularioPdi:idgrupoCheckListFormularioPdi,
            },
            beforeSend: function() {
                Preloader('Enviando datos....');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                    setTimeout(() => {
                        inicializarScanner();
                    }, 300); // puedes ajustar el tiempo si es necesario
                }
                Notificacion(dato.status,dato.title,dato.message);
                // 💡 Esperar un poco para que el HTML esté en el DOM

            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    });

</script>


<script>
    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Cargando PDI...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status, dato.title, dato.message);
                if (dato.status == "success") {
                    location.reload();
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

</script>
<?php if ($idtipoFormulario == 1) { ?>
    <script>
        $(document).on('click', '.navGrupoChecks', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var idgrupoCheckList = $(this).attr("data-idgrupoCheckList");
            var idprocesoPdi = $(this).attr("data-idprocesoPdi");
            var vin = $(this).attr("data-vin");
            PanelCheckList(idgrupoCheckList);
        });

        function PanelCheckList(idgrupoCheckList) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("AlistamientoVehicular/Pdi/CreateViewEdit/DetailCheckPdi")?>",
                data: {
                    idprocesoPdi: '<?=$idprocesoPdi?>',
                    idgrupoCheckList: idgrupoCheckList,
                    vin: '<?=$vin?>'
                },
                beforeSend: function () {

                },
                success: function (data) {
                    let dato = $.parseJSON(data);
                    if (dato.status == "success") {
                        $("#tbodyPanelPdi").html(dato.info);
                    }

                },
                error: function (xhr) {

                }
            });
        }


        $(document).ready(function() {
            $('input[name="inlineRadioOptions"]').change(function() {
                if ($(this).val() === "2") {
                    $('#panelObservacionBateria').show(); // Mostrar textarea
                    $("#observacionesBateria").prop("required",true);
                } else {
                    $('#panelObservacionBateria').hide(); // Ocultar textarea
                    $("#observacionesBateria").prop("required",false);
                }
            });
        });

        $(document).on('change', '.changeEstadoPdi', function() {
            let estadoCheckPdi = $(this).val();
            var idresultadoFormularioPdi = $(this).attr("data-idresultadoFormularioPdi");
            var idgrupoCheckListFormularioPdi = $(this).attr("data-idgrupoCheckListFormularioPdi");
            var idprocesoPdi = $(this).attr("data-idprocesoPdi");
            var vin = $(this).attr("data-vin");
            console.log('Nuevo estado seleccionado:', estadoCheckPdi, ' idresultado ', idresultadoFormularioPdi);

            if (estadoCheckPdi == 2) {
                VerificarCheckPdi(idresultadoFormularioPdi, idgrupoCheckListFormularioPdi, idprocesoPdi, vin);
            } else {
                SendCheckPdi(idresultadoFormularioPdi, idgrupoCheckListFormularioPdi, idprocesoPdi, vin, estadoCheckPdi);
            }
        });

        $(document).on('click', '.btnEditProceso', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var idresultadoFormularioPdi = $(this).attr("data-idresultadoFormularioPdi");
            var idgrupoCheckListFormularioPdi = $(this).attr("data-idgrupoCheckListFormularioPdi");
            var idprocesoPdi = $(this).attr("data-idprocesoPdi");
            var vin = $(this).attr("data-vin");

            var estadoCheckPdi = $('#estadoCheckPdi'+idresultadoFormularioPdi).val();

            if(estadoCheckPdi==2){
                VerificarCheckPdi(idresultadoFormularioPdi,idgrupoCheckListFormularioPdi,idprocesoPdi,vin);
            }else{
                SendCheckPdi(idresultadoFormularioPdi,idgrupoCheckListFormularioPdi,idprocesoPdi,vin,estadoCheckPdi);
            }
        });

        function SendCheckPdi(idresultadoCheckListPdi,idgrupoCheckListFormularioPdi,idprocesoPdi,vin,estadoCheckPdi){
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("AlistamientoVehicular/Pdi/SaveEditDelete/StorageCheckPdi")?>",
                data: {idresultadoCheckListPdi:idresultadoCheckListPdi,idgrupoCheckListFormularioPdi:idgrupoCheckListFormularioPdi,idprocesoPdi:idprocesoPdi,vin:vin,estadoCheckPdi:estadoCheckPdi},
                beforeSend: function() {
                    Preloader('Enviando datos....');
                },
                success: function(data) {
                    let dato = $.parseJSON(data);
                    ClosePreloader();
                    Notificacion(dato.status,dato.title,dato.message);
                    if(dato.status=='success'){
                        ModalAdicionales.hide();
                        PanelCheckList(idgrupoCheckListFormularioPdi);
                    }
                },
                error: function(xhr) {
                    ClosePreloader();
                }
            });
        }



        function VerificarCheckPdi(idresultadoFormularioPdi,idgrupoCheckListFormularioPdi,idprocesoPdi,vin)
        {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("AlistamientoVehicular/Pdi/CreateViewEdit/ViewCheckPdi")?>",
                data: {idresultadoFormularioPdi:idresultadoFormularioPdi,idgrupoCheckListFormularioPdi:idgrupoCheckListFormularioPdi,idprocesoPdi:idprocesoPdi,vin:vin},
                beforeSend: function() {

                },
                success: function(data) {
                    let dato = $.parseJSON(data);
                    if(dato.status=="success"){
                        ModalAdicionales.show();
                        $("#BodyAdicionales").html(dato.info);
                    }

                },
                error: function(xhr) {

                }
            });
        }


        am4core.ready(function () {
// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end
            var chartMin = 0;
            var chartMax = 100;
            var data = {
                score: 20,
                gradingData: [
                    {
                        title: "Reserva",
                        color: "#ee1f25",
                        lowScore: 0,
                        highScore: 20
                    },
                    {
                        title: "1/4",
                        color: "#f04922",
                        lowScore: 20,
                        highScore: 40
                    },
                    {
                        title: "2/4",
                        color: "#fdae19",
                        lowScore: 40,
                        highScore: 60
                    },
                    {
                        title: "3/4",
                        color: "#f3eb0c",
                        lowScore: 60,
                        highScore: 80
                    },
                    {
                        title: "4/4",
                        color: "#139816",
                        lowScore: 80,
                        highScore: 100
                    },
                ]
            };

            function lookUpGrade(lookupScore, grades) {
                // Only change code below this line
                for (var i = 0; i < grades.length; i++) {
                    if (
                        grades[i].lowScore < lookupScore &&
                        grades[i].highScore >= lookupScore
                    ) {
                        return grades[i];
                    }
                }
                return null;
            }

            am4core.addLicense("ch-custom-attribution");

            var chart = am4core.create("chartdiv", am4charts.GaugeChart);
            chart.hiddenState.properties.opacity = 0;
            chart.fontSize = 11;
            chart.innerRadius = am4core.percent(80);
            chart.resizable = true;

            var axis = chart.xAxes.push(new am4charts.ValueAxis());
            axis.min = chartMin;
            axis.max = chartMax;
            axis.strictMinMax = true;
            axis.renderer.radius = am4core.percent(80);
            axis.renderer.inside = true;
            axis.renderer.line.strokeOpacity = 0.1;
            axis.renderer.ticks.template.disabled = false;
            axis.renderer.ticks.template.strokeOpacity = 1;
            axis.renderer.ticks.template.strokeWidth = 0.5;
            axis.renderer.ticks.template.length = 5;
            axis.renderer.grid.template.disabled = true;
            axis.renderer.labels.template.radius = am4core.percent(15);
            axis.renderer.labels.template.fontSize = "1em";

            var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
            axis2.min = chartMin;
            axis2.max = chartMax;
            axis2.strictMinMax = true;
            axis2.renderer.labels.template.disabled = true;
            axis2.renderer.ticks.template.disabled = true;
            axis2.renderer.grid.template.disabled = false;
            axis2.renderer.grid.template.opacity = 0.5;
            axis2.renderer.labels.template.bent = true;
            axis2.renderer.labels.template.fill = am4core.color("#000");
            axis2.renderer.labels.template.fontWeight = "bold";
            axis2.renderer.labels.template.fillOpacity = 1;

            for (let grading of data.gradingData) {
                var range = axis2.axisRanges.create();
                range.axisFill.fill = am4core.color(grading.color);
                range.axisFill.fillOpacity = 1;
                range.axisFill.zIndex = -1;
                range.value = grading.lowScore > chartMin ? grading.lowScore : chartMin;
                range.endValue = grading.highScore < chartMax ? grading.highScore : chartMax;
                range.grid.strokeOpacity = 0;
                range.stroke = am4core.color(grading.color).lighten(-0.1);
                range.label.inside = true;
                range.label.text = grading.title.toUpperCase();
                range.label.inside = true;
                range.label.location = 0.5;
                range.label.inside = true;
                range.label.radius = am4core.percent(10);
                range.label.paddingBottom = -5; // ~half font size
                range.label.fontSize = "10px";
            }

            var matchingGrade = lookUpGrade(data.score, data.gradingData);

            var label = chart.radarContainer.createChild(am4core.Label);
            label.isMeasured = false;
            label.fontSize = "2em";
            label.x = am4core.percent(50);
            label.paddingBottom = 25;
            label.horizontalCenter = "middle";
            label.verticalCenter = "bottom";

            label.text = data.score.toFixed(1);

            label.fill = am4core.color(matchingGrade.color);

            var label2 = chart.radarContainer.createChild(am4core.Label);
            label2.isMeasured = false;
            label2.fontSize = "1.5em";
            label2.horizontalCenter = "middle";
            label2.verticalCenter = "bottom";
            label2.text = matchingGrade.title.toUpperCase();
            label2.fill = am4core.color(matchingGrade.color);

            var hand = chart.hands.push(new am4charts.ClockHand());
            hand.axis = axis2;
            hand.innerRadius = am4core.percent(55);
            hand.startWidth = 8;
            hand.pin.disabled = true;
            hand.value = data.score;
            hand.fill = am4core.color("#444");
            hand.stroke = am4core.color("#000");

            hand.events.on("positionchanged", function () {
                label.text = axis2.positionToValue(hand.currentPosition).toFixed(1);
                var value2 = axis.positionToValue(hand.currentPosition);
                var matchingGrade = lookUpGrade(axis.positionToValue(hand.currentPosition), data.gradingData);
                label2.text = matchingGrade.title.toUpperCase();
                label2.fill = am4core.color(matchingGrade.color);
                label2.stroke = am4core.color(matchingGrade.color);
                label.fill = am4core.color(matchingGrade.color);
            })

            $('#nivelGasolina').change(function() {
                var value = parseInt($(this).val());
                //  alert(value);
                hand.showValue(value, 1000, am4core.ease.cubicOut);
                data.score = value; // Actualiza el score
                matchingGrade = lookUpGrade(data.score, data.gradingData); // Busca el nuevo grado
                label.fill = am4core.color(matchingGrade.color); // Actualiza el color de la etiqueta
            });


        }); // end am4core.ready()
    </script>
<?php } ?>
