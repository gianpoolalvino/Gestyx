<?php

namespace App\Models;

use CodeIgniter\Model;

class PlacaModel extends Model
{
    public function Rotativas($filtro)
    {
        $builder=$this->db->table("placarotativa");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}