<?php

namespace App\Models;

use CodeIgniter\Model;

class VerificarEventoModel extends Model
{
    public function VerificarEventoCritico($filtro)
    {
        $builder=$this->db->table("timelineevento");
        $builder->select("count(idtimelineevento) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}