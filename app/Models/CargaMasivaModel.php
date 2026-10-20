<?php

namespace App\Models;

use CodeIgniter\Model;

class CargaMasivaModel extends Model
{
    public function EventoRealizados($filtro)
    {
        $builder = $this->db->table("timelineevento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DeleteCargaMasivaPlanes($filtro)
    {
        $builder=$this->db->table("cargamasivadetalleplanmantenimiento");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageCargaMasivaPlanMto($stor)
    {
        $builder=$this->db->table("cargamasivadetalleplanmantenimiento");
        $builder->insert($stor);
        return $this->db->insertID();
    }

    public function SelectModeloCargaMasiva($filtro)
    {
        $builder = $this->db->table("vw_modelo_carga_masiva");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageCargaMasiva($stor)
    {
        $builder=$this->db->table("cargamasiva");
        $builder->insert($stor);
        return $this->db->insertID();
    }

    public function StorageDetailCargaMasiva($stor)
    {
        $builder=$this->db->table("detallecargamasiva");
        $builder->insert($stor);
        return $this->db->insertID();
    }

    public function DetailCargaMasiva($filtro)
    {
        $builder = $this->db->table("detallecargamasiva");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}