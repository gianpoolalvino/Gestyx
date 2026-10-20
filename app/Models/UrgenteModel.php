<?php

namespace App\Models;

use CodeIgniter\Model;

class UrgenteModel extends Model
{
    public function StorageUrgente($urgente)
    {
        $builder=$this->db->table("vinurgente");
        $builder->insert($urgente);
        return $this->db->insertID();
    }
}