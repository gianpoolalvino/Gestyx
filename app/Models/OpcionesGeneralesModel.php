<?php

namespace App\Models;

use CodeIgniter\Model;

class OpcionesGeneralesModel extends Model
{
    public function EventosAnteriores($filtro)
    {
        $builder=$this->db->table("eventoretorno");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function EventoUpdate($filtroVin,$filtroEvento,$update)
    {
        $builder=$this->db->table("timelineevento");
        $builder->where($filtroVin);
        $builder->whereIn("ideventoActual",$filtroEvento);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DesactivarEquipamiento($tipoEquipamiento,$updateEquipamiento)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->where($tipoEquipamiento);
        $builder->update($updateEquipamiento);
        return $builder->get()->getResultArray();
    }

    public function EquipamientoInstalado($filtro)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->select("count(idequipamientoVin) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}