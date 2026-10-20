<?php

namespace App\Models;

use CodeIgniter\Model;

class EncuestaModel extends Model
{
    public function DetailEncuesta($filtro)
    {
        $builder = $this->db->table("detailencuesta");
        $builder->where($filtro);
        $builder->orderBy("fecha", "desc");
        return $builder->get()->getResultArray();
    }
}