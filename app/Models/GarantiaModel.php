<?php

namespace App\Models;

use CodeIgniter\Model;

class GarantiaModel extends Model
{
    public function TipoReporte()
    {
        $builder=$this->db->table("tiporeportegarantia");
        return $builder->get()->getResultArray();
    }
}