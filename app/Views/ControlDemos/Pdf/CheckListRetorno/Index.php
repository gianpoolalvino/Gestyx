<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        table, td, th {
            border: 1px solid;
        }
        td,th{
            padding-left:3px;
            padding-right:1px;
            padding-top:1px;
            padding-bottom:1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        body {
            margin-top: 0.5cm !important;
            margin-left: 50px !important;
            margin-right: 50px !important;
            margin-bottom: 40px !important;
            padding: 0px 0px 0px 0px !important;
        }
        .fuente{
            font-family:Roboto, 'Open Sans', Lato, 'Helvetica Neue', Arial, sans-serif !important;
            font-size:9pt
        }
        .fontSm{
            font-size: 14px;
        }
    </style>
    <title><?php echo $nombreFile ?></title>
</head>
<body>
<table style="width: 100%;border:1px solid">
    <tr>
        <td style="border:0px">
            <img style="width:100%" src="<?php echo base_url("resource/img/logoAutoniza.png")?>">
        </td>
        <td style="text-align:center;width:60%;border:0px">
            <strong class="fuente">PRESTAMO DE VEHICULO - DEVOLUCION DEL CLIENTE</strong>
        </td>
        <td style="border:0px"></td>
    </tr>
</table>
<div style="height: 10px"></div>
<table style="width: 100%;border:0px;margin:0px !important;padding:0px !important">
    <tr style="border: 0px;margin:0px !important;padding:0px !important">
        <td style="border:0px;width:50%;margin:0px !important;padding:0px !important">
            <table style="width: 100%">
                <tr>
                    <td style="width:20%"><span class="fuente">Chasis: </span></td>
                    <td style="width:30%"><span class="fuente"><?php echo $checkList[0]["vin"]?></span></td>
                </tr>
                <tr>
                    <td style="width:20%"><span class="fuente">Cliente: </span></td>
                    <td style="width:30%"><span class="fuente"><?php echo $checkList[0]["nombreResponsable"]?></span></td>
                </tr>
                <tr>
                    <td style="width:20%"><span class="fuente">Fecha y Hora: </span></td>
                    <td style="width:30%"><span class="fuente"><?php echo $checkList[0]["fecha"]." ".$checkList[0]["hora"]?></span></td>
                </tr>
                <tr>
                    <td style="width:20%"><span class="fuente">Inspector: </span></td>
                    <td style="width:30%"><span class="fuente"><?php echo $checkList[0]["inspector"]?></span></td>
                </tr>
                <tr>
                    <td style="width:20%"><span class="fuente">Gasolina: </span></td>
                    <td style="width:30%"><span class="fuente"><?php echo ($checkList[0]["gasolinaEntrega"]==1)?'Si':'No'?></span></td>
                </tr>
                <tr>
                    <td style="width:20%"><span class="fuente">Km Devolucion: </span></td>
                    <td style="width:30%"><span class="fuente"><?php echo $checkList[0]["kilometrajeEntrega"]?></span></td>
                </tr>
            </table>
        </td>
        <td style="border:0px;width:50%;margin:0px !important;padding:0px !important">
            <table style="width: 100%">
                <tr>
                    <td colspan="2" style="text-align:center"><span class="fuente">SERVICIOS SUGERIDOS</span></td>
                </tr>
                <?php foreach($servicioSugerido as $sg){?>
                    <tr>
                        <td><span class="fuente">(<?php echo ($sg["estadoServicio"]==1)?'Si':''?>)&nbsp;<?php echo $sg["principal"]?></span></td>
                        <td>
                            <?php if(!is_null($sg["estadoServicio2"])){?>
                            <span class="fuente">(<?php echo ($sg["estadoServicio2"]==1)?'Si':''?>)&nbsp;<?php echo $sg["secundario"]?></span>
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
            </table>
        </td>
    </tr>
</table>

<div style="height: 10px"></div>
<?php
$contador=1;
foreach($detailCheckList as $dcdm){
    $contador++;
}
$count=$contador-3;
?>
<table style="width: 100%">
    <tr>
        <td colspan="3" style="width:50%;text-align:center">
            <strong class="fuente">DETALLE DEL INVENTARIO</strong>
        </td>
        <td style="width:50%;text-align:center">
            <strong class="fuente">DIAGRAMA DEL ESTADO</strong>
        </td>
    </tr>
    <tr>
        <td style="width:5%;text-align:center">
            <strong class="fuente">V</strong>
        </td>
        <td style="width:5%;text-align:center">
            <strong class="fuente">X</strong>
        </td>
        <td>
            <strong class="fuente">DETALLE</strong>
        </td>
        <td style="text-align:center" rowspan="<?php echo $count?>">
            <img style="width:90%" src="<?php echo base_url("resource/img/diagramaVehiculo.png")?>">
        </td>
    </tr>
    <?php
    $cnt=0;
    foreach($detailCheckList as $dcdm){
        $cnt++;
        ?>
        <tr>
            <td style="text-align:center"><span class="fuente"><?php echo ($dcdm["estadoEquipamiento"]==1)?'Si':''?></span></td>
            <td style="text-align:center"><span class="fuente"><?php echo ($dcdm["estadoEquipamiento"]!=1)?'':''?></td>
            <td><span class="fuente"><?php echo $dcdm["descripcion"]?></span></td>
            <?php if($cnt>=$count){?>
                <td style="border:0px;text-align:center">

                </td>
            <?php }?>
        </tr>
    <?php }?>
</table>
<div style="height: 10px"></div>
<table style="width: 100%">
    <tr>
        <td style="text-align:center"><strong class="fuente">OBSERVACIONES EN LA DEVOLUCION</strong></td>
    </tr>
    <tr>
        <td style="height:80px;vertical-align:top">
            <span class="fuente"><?php echo $checkList[0]["observaciones"]?></span>
        </td>
    </tr>
</table><div style="height: 60px"></div>
<table style="width: 100%;;border:0px">
    <tr style="border: 0px">
        <td style="height:120px;border: 0px">
            <hr>
            <span class="fuente">CONFORMIDAD DEL CLIENTE</span><br>
            <span class="fuente" style="font-size: 14px"><?php echo $checkList[0]["nombreResponsable"]?></span>
        </td>
        <td style="width:15%;border: 0px"></td>
        <td style="height:120px;border: 0px">
            <hr>
            <span class="fuente">INSPECTOR</span><br>
            <span class="fuente" style="font-size: 14px"><?php echo $checkList[0]["inspector"]?></span>
        </td>
    </tr>
</table>
</body>
</html>