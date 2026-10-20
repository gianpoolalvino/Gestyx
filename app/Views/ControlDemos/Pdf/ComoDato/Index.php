<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 3cm !important;
            margin-left: 70px !important;
            margin-right: 70px !important;
            margin-bottom: 40px !important;
            padding: 0px 0px 0px 0px !important;
        }
        .fuente{
            font-family:Roboto, 'Open Sans', Lato, 'Helvetica Neue', Arial, sans-serif !important;
            font-size:10pt
        }
        .fontSm{
            font-size: 14px;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 40px;
            right: 40px;
            height: 3cm;
        }
        footer {
            position: fixed;
            bottom: -42px;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>
    <title><?php echo $nombreFile ?></title>
</head>
<body>
<header>
    <table style="width:100%">
        <tr>
            <td>
                <img style="width:65%" src="<?php echo base_url("resource/img/logoAutoniza.png")?>">
            </td>
            <td style="text-align: right">
                <img style="width:70%" src="<?php echo base_url("resource/img/logoChevrolet.png")?>">
            </td>
            <td style="text-align: right">
                <img style="width:50%" src="<?php echo base_url("resource/img/logoIsuzu.png")?>">
            </td>
        </tr>
    </table>
</header>
<table style="width:100%">
    <tr>
        <td style="text-align: center"><h3 class="fuente">
                CONTRATO DE COMODATO DE VEHÍCULO
            </h3></td>
    </tr>
</table>
<?php
date_default_timezone_set("America/Lima");
$dia=date("d");
$me=date("m");
$ye=date("Y");
$fechaInicio=$infoAsignarDemo[0]["fechaEntrega"];
$mesEntrega=explode("-",$fechaInicio);
$yearEnt=$mesEntrega[0];
$diaEnt=$mesEntrega[2];
$mesEnt=$mesEntrega[1];

$fechaFin=$infoAsignarDemo[0]["fechaRetorno"];
$mesRetorn=explode("-",$fechaFin);
$yearReto=$mesEntrega[0];
$diaReto=$mesEntrega[2];
$mesReto=$mesEntrega[1];

$descrEnt='';
$descrRet='';
$descrHoy='';
foreach($mes as $ms){
    if($ms["codigoMes"]==$mesReto){
        $descrRet=$ms["nombreMes"];
    }

    if($ms["codigoMes"]==$mesEnt){
        $descrEnt=$ms["nombreMes"];
    }

    if($ms["codigoMes"]==$me){
        $descrHoy=$ms["nombreMes"];
    }
}
?>
<div style="width:100%; text-align:justify">
            <span class="fuente">
                <strong>AUTONIZA S.A.C.</strong>, identificado con RUC N°20601762219, debidamente
                representada por la señora Libia Achury Torres, identificada con C.E.
                N°001488731, tal y como consta en la Partida N° 13786147 del Libro de Personas
                Jurídicas de Lima, domiciliado en la Av. República de Panamá N°4141, distrito de
                Surquillo, Provincia y Departamento de Lima, a quien adelante se le denominará
                <strong>“EL COMODANTE”</strong>; y de la otra parte <?php echo $infoAsignarDemo[0]["nombreResponsable"]?>., con DNI N° <?php echo $infoAsignarDemo[0]["documentoResponsable"]?>, con domiciliado en <?php echo $infoAsignarDemo[0]["direccionResponsable"]?>, a
                quien adelante se le denominará <strong>“EL COMODATARIO”</strong> celebran el siguiente
                <strong>CONTRATO DE COMODATO</strong>, en los términos y condiciones siguientes:<br><br>
                <strong>CLÁUSULA PRIMERA Objeto. – EL COMODANTE </strong>es propietaria del vehículo
                <strong>MARCA:</strong> <?php echo $infoAsignarDemo[0]["marca"]?>, <strong>MODELO:</strong> <?php echo $infoAsignarDemo[0]["familia"]?>, <strong>COLOR:</strong> <?php echo $infoAsignarDemo[0]["color"]?> <strong>PLACA:</strong> <?php echo $infoAsignarDemo[0]["placa"]?> <strong>NUMERO DE VIN:</strong> <?php echo $infoAsignarDemo[0]["vin"]?>
                <strong>AÑO MODELO:</strong> <?php echo $infoAsignarDemo[0]["anhoModelo"]?>.<br><br>
                <strong>CLAUSULA SEGUNDA. - Uso autorizado.</strong> – El COMODATARIO podrá utilizar el
                bien descrito en el punto primero, única y exclusivamente para prueba de este, y
                comprobar su buen funcionamiento.<br><br>
                Queda prohibido el uso del vehículo con otra finalidad, que no sea la descrita en la
                cláusula segunda del presente contrato.<br><br>
                <strong>CLÁUSULA TERCERA. Obligaciones de EL COMODATARIO.</strong> – El comodatario
                además de las obligaciones establecidas por ley, se obliga en especial a las
                siguientes:<br><br>
                1. Cuidar y mantener el vehículo en el estado en que este fue entregado.<br><br>
                2. Restituir el vehículo en su totalidad o de manera parcial, en caso este haya
                sufrido daños o desperfectos, mientras que se haya estado usando.<br><br>

                3. Utilizar el bien entregado en comodato conforme al uso legítimo autorizado en la
                cláusula segunda de este contrato.<br><br>
                4. Suscribir con EL COMODANTE la respectiva acta de entrega del bien, a fin de
                que éste se cerciore de que el vehículo ha sido entregado en las mismas
                condiciones, así como también que las piezas internas del mismo sean las mismas
                en el momento en que se entregó.<br><br>
                5. El COMODATARIO asumirá la totalidad responsabilidad de cualquier acción de
                tipo legal que pudiere dirigirse contra EL COMODANTE como propietario del
                vehículo, incluyendo la indemnización de daños y perjuicios, producto de un
                accidente de tránsito/ siniestro que ocurra mientas EL COMODANTE hace uso del
                bien.<br><br>
                <strong>CLÁUSULA CUARTA. - Duración y perfeccionamiento.</strong> – Este Comodato
                tiene una duración de 03 días, contabilizándose desde el día <?php echo $diaEnt?> de <?php echo $descrEnt?> de
                <?php echo $yearEnt?> desde las <?php echo $infoAsignarDemo[0]["horaEntrega"]?> horas, hasta el día <?php echo $diaReto?> de <?php echo $descrRet?> de <?php echo $yearReto?>, hasta las <?php echo $infoAsignarDemo[0]["horaRetorno"]?>
                horas.<br><br>
                <strong>CLÁUSULA QUINTA. – Restitución</strong>– Terminado el plazo señalado en la cláusula cuarta del presente contrato, el COMODATARIO se obliga a restituir a EL COMODANTE el bien materia del contrato dentro del plazo estipulado.<br><br>
                <strong>CLÁUSULA SEXTA. – Estado del bien.</strong> – En este momento, en el que se firma
                este acto y se entrega materialmente el bien, éste se encuentra en perfecto estado
                para su uso.<br><br>
                En este mismo acto, se dejará constancia por medio de un Acta, del estado del
                bien entregado; del mismo modo, se describirán las piezas internas del vehículo.<br><br>
                <strong>CLÁUSULA SÉPTIMA. - Obligaciones Del Comodante</strong> EL COMODANTE será el responsable de proporcionar el combustible necesario
                durante la ejecución del presente contrato.<br><br>

                Del mismo modo, será obligación de EL COMODANTE designar a un personal,
                para que acompañe a EL COMODATARIO en hacer el recorrido respectivo, para
                la<br><br>
                <strong>CLÁUSULA OCTAVA. - Cesión:</strong> – El COMODATARIO no podrá ceder total ni
                parcialmente el presente contrato de comodato a persona natural o jurídica
                alguna.<br><br>
                <strong>CLÁUSULA NOVENA. - Cláusula penal.</strong> – Si el COMODATARIO incumpliere
                cualquier obligación que está a su cargo y dicho incumplimiento ocasionare la
                pérdida total o daño parcial del bien, deberá pagar a EL COMODANTE los valores
                correspondientes al valor comercial en caso de pérdida total, o a la reparación del
                bien para ponerlo nuevamente en el estado que se encontraba cuando se le
                entregó.<br><br>
                Asimismo, en caso de ocurrir cualquier tipo accidente, EL COMODATARIO se
                obliga a interponer la denuncia policial respectiva e informar de manera inmediata
                a EL COMODANTE, a fin de que este último pueda iniciar las acciones legales
                correspondientes contra quienes corresponda<br><br>

                En Lima, al <?php echo $dia?> día del mes de <?php echo $descrHoy?> de <?php echo $ye?>.<br><br><br><br>
            </span>
</div>
<table style="width: 100%;">
    <tr>
        <td style="height:240px">
            <hr>
            <span class="fuente">EL COMODATARIO</span><br>
            <span class="fuente" style="font-size: 14px"><?php echo $infoAsignarDemo[0]["nombreResponsable"]?></span>
        </td>
        <td style="width:15%"></td>
        <td style="height:240px">
            <hr>
            <span class="fuente">EL COMODANTE</span><br>
            <span class="fuente" style="font-size: 14px">LIBIA ACHURY</span>
        </td>
    </tr>
</table>
</body>
</html>