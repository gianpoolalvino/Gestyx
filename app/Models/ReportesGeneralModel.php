<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportesGeneralModel extends Model
{
    public function Ubicacion()
    {
        $builder=$this->db->table("ubicacion");
        return $builder->get()->getResultArray();
    }

    public function DetailInventario($ubicacion,$filtro)
    {
        $builder=$this->db->table("vw_reporte_inventario");
        if($ubicacion!=''){
            $builder->where(['idubicacion'=>$ubicacion]);
        }
        if($filtro!=''){
            $builder->where(['vin'=>$filtro]);
        }
        return $builder->get()->getResultArray();
    }
    public function DetailIndexTraslado($filtro)
    {
        $builder=$this->db->table("vw_reporte_traslado_vin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function TrackingVehicular($tipofiltro,$filt,$rango)
    {
        $builder=$this->db->table("trackingvehicularreporte");
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filt);
        }
        $builder->where($rango);
        return $builder->get()->getResultArray();
    }

    public function TituloPlaca($tipofiltro,$filtro,$rango)
    {
        $builder=$this->db->table("reportetituloplaca");
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filtro);
        }
        $builder->where($rango);
        return $builder->get()->getResultArray();
    }

    public function ReportePdi($tipofiltro,$filtro,$rango)
    {
        $builder=$this->db->table("vw_reporte_evento_pdi");
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filtro);
        }
        $builder->where($rango);
        return $builder->get()->getResultArray();
    }

    public function ReporteAccesorios($tipofiltro,$filtro,$rango)
    {
        $builder=$this->db->table("vw_reporte_evento_accesorios");
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filtro);
        }
        $builder->where($rango);
        return $builder->get()->getResultArray();
    }

    public function ReporteRepsol($tipofiltro,$filtro,$rango)
    {
        $builder=$this->db->table("vw_reporte_repsol");
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filtro);
        }
        $builder->where($rango);
        return $builder->get()->getResultArray();
    }
}