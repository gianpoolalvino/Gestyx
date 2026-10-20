<?php

namespace App\Models;

use CodeIgniter\Model;

class CitaModel extends Model
{
    public function SaveCita($insert)
    {
        $builder=$this->db->table("citaentrega");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function ViewCitaEntrega($filtro)
    {
        $builder=$this->db->table("viewcitaentrega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateCita($filtro,$update)
    {
        $builder=$this->db->table("citaentrega");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
}