<?php

namespace App\Controllers\ExcelExport;
use App\Controllers\BaseController;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Index extends BaseController
{
    public function ExportAgendados()
    {
        $agendamiento=New AgendamientoModel();

        $tipoFiltro=$_POST["tipoFiltro"];
        $filtro=$_POST["filtro"];
        $detail=$agendamiento->DetailCitaAgendadoExcel($tipoFiltro,$filtro);

        $spread=New Spreadsheet();
        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Agendados")
            ->setKeywords('PHPSpreadsheet');
        $sheet=$spread->getActiveSheet();
        $sheet->setTitle("Reporte Agendados");
        $encabezado=[
            'Vin',
            'Cliente',
            'Marca',
            'Modelo',
            'Color',
            'Agencia',
            'Asesor de Entrega',
            'Fecha Cita',
            'Hora Cita',
            'Placa'
        ];

        $sheet->fromArray($encabezado,null,'A1');
        $numeroDeFila=2;

        $spread->getActiveSheet()->getColumnDimension("A")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("B")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("C")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("D")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("E")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("F")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("G")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("H")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("I")->getAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension("J")->getAutoSize(true);

        foreach($detail as $dt){

        }


    }
}