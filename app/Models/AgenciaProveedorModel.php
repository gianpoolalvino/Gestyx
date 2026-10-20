<?php

namespace App\Models;

use CodeIgniter\Model;

class AgenciaProveedorModel extends Model
{
    public function ProveedorGas()
    {
        $builder=$this->db->table("proveedorgasregionv2");
        $builder->select("*");
        return $builder->get()->getResultArray();
    }
}