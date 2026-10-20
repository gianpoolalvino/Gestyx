<?php

namespace App\Models;

use CodeIgniter\Model;

class TimeLineModel extends Model
{
    public function ExisteEvento($filtro)
    {
        $builder = $this->db->table("timelineevento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}