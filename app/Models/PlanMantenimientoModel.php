<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanMantenimientoModel extends Model
{
    public function StoragePlan($planmantenimiento)
    {
        $builder=$this->db->table("planmantenimientofamilia");
        $builder->insert($planmantenimiento);
        return $this->db->insertID();
    }

    public function VerificarDetailPlan($filtro)
    {
        $builder=$this->db->table("detalleplanmantenimiento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function KilometrajeMantenimiento()
    {
        $builder=$this->db->table("kilometrajemantenimiento");
        return $builder->get()->getResultArray();
    }

    public function ViewKilometraje($filtro)
    {
        $builder=$this->db->table("kilometrajemantenimiento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageDetallePlanMantenimiento($storage)
    {
        $builder=$this->db->table("detalleplanmantenimiento");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function ViewPlanMantenimiento($filtro)
    {
        $builder=$this->db->table("planmantenimiento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewPlanMantenimientoFull($filtro)
    {
        $builder=$this->db->table("viewplanmantenimiento");
        $builder->where($filtro);
        $builder->orderBy("CAST(kilometraje AS UNSIGNED)","ASC");
        return $builder->get()->getResultArray();
    }

    public function ViewDetalleMantenimiento($filtro)
    {
        $builder=$this->db->table("viewdetalleplanmantenimiento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StoragePlanMantenimiento($planMantenimiento)
    {
        $builder=$this->db->table("planmantenimiento");
        $builder->insert($planMantenimiento);
        return $this->db->insertID();
    }

    public function StoragePlanDetalle($storage)
    {
        $builder=$this->db->table("detalleplanmantenimientofamilia");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function ViewPlanFam($filtro)
    {
        $builder=$this->db->table("viewplanfam");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetalleCargaPlanMto($filtro)
    {
        $builder=$this->db->table("vw_carga_detplanmantenimiento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetalleCargaPlanMtoUnico($filtro)
    {
        $builder=$this->db->table("vw_carga_detalle_plan_mto");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CabeceraMasivaCargaRepuesto($filtro)
    {
        $builder=$this->db->table("vw_cargamasivacopararepuesto");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CabeceraMasivaPlan($filtro)
    {
        $builder=$this->db->table("vw_cabeceramasiva_planmto");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailCargaMasivaPlanMtoSql($filtro)
    {
        $builder=$this->db->table("vw_cargamasiva_detplafam");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DeleteDetailPlanMantenimiento($filtro)
    {
        $builder=$this->db->table("detalleplanmantenimiento");
        $builder->where($filtro);
        $builder->delete();
        return $builder->get()->getResultArray();
    }

    public function UpgradePlanMantenimiento($filtro,$update)
    {
        $builder=$this->db->table("planmantenimiento");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DeleteDetailFamilia($filtro)
    {
        $builder=$this->db->table("detalleplanmantenimientofamilia");
        $builder->where($filtro);
        $builder->delete();
        return $builder->get()->getResultArray();
    }

    public function DeletePlanMto($filtro)
    {
        $builder=$this->db->table("planmantenimiento");
        $builder->where($filtro);
        $builder->delete();
        return $builder->get()->getResultArray();
    }

    public function UpgradePlanFamilia($filtro,$update)
    {
        $builder=$this->db->table("planmantenimientofamilia");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function PlanMantenimientoMasivoView($idplanMantenimientoFamilia){
        $builder=$this->db->table("planmantenimiento");
        $builder->where(['idplanMantenimientoFamilia'=>$idplanMantenimientoFamilia]);
        return $builder->get()->getResultArray();
    }

    public function DeleteMasivoDetailMto($idplanMantenimiento)
    {
        $builder = $this->db->table("detalleplanmantenimiento");
        $builder->where(['idplanMantenimiento'=> $idplanMantenimiento]);
        $builder->delete();
        return $builder->get()->getResultArray();
    }

    public function DuplicateNot($filtro)
    {
        $builder=$this->db->table("detalleplanmantenimiento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }


    public function DetailViewPlanFam($filtro)
    {
        $builder=$this->db->table("detalleviewplanfam");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}