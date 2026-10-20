<?php

namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model
{
    public function UpdateEvento($filtroEvento,$updateEvento)
    {
        $builder=$this->db->table("timelineevento");
        $builder->where($filtroEvento);
        $builder->update($updateEvento);
        return $builder->get()->getResultArray();
    }

    public function OrdenEvento($filtro)
    {
        $builder=$this->db->table("evento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageEvento($storage)
    {
        $builder=$this->db->table("timelineevento");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function ViewEvento($filtro)
    {
        $builder=$this->db->table("evento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ContadorVerificarEvento($filtro)
    {
        $builder=$this->db->table("timelineevento");
        $builder->select("count(vin) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewEventoVin($filtro)
    {
        $builder=$this->db->table("timelineevento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DuplicatedEvento($filtro)
    {
        $builder=$this->db->table("timelineevento");
        $builder->select("count(idtimelineEvento) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SearchCampanhaEvento($filtro)
    {
        $builder=$this->db->table("timelineevento as tle");
        $builder->select("count(tle.idtimeLineEvento) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}