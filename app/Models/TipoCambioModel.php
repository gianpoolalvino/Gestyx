<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoCambioModel extends Model
{
    public function DetailIndex($filtro)
    {
        $builder=$this->db->table("detalletipocambio");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function CambioDia($filtro)
    {
        $builder=$this->db->table("tipocambio");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageTipoCambio($tipoCambio)
    {
        $builder=$this->db->table("tipocambio");
        $builder->insert($tipoCambio);
        return $this->db->insertID();
    }
}