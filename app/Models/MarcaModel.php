<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcaModel extends Model
{
    public function SelectMarca()
    {
        $builder=$this->db->table("marca");
        return $builder->get()->getResultArray();
    }

    public function ViewMarca($filtro)
    {
        $builder=$this->db->table("marca");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

}