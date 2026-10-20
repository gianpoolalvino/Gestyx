<?php

namespace App\Models;

use CodeIgniter\Model;

class ReglasModel extends Model
{
    public function StorageReglaEntrega($storage)
    {
        $builder=$this->db->table("reglaentrega");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function UpdateGrupoRegla($filtro,$update)
    {
        $builder=$this->db->table("gruporegla");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexGrupoRegla($filtro)
    {
        $builder=$this->db->table("vw_grupo_reglas");
        if($filtro!=""){
            $builder->like("nombreGrupo",$filtro);
            $builder->orLike("tipoAplicacion",$filtro);
            $builder->orLike("usuario",$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewGrupoRegla($filtro)
    {
        $builder=$this->db->table("vw_grupo_reglas");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageGrupoRegla($storage)
    {
        $builder=$this->db->table("gruporegla");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function DestroyReglaEntrega($storage)
    {
        $builder=$this->db->table("reglaentrega");
        $builder->where($storage);
        $builder->delete();
        return $builder->get()->getResultArray();
    }

    public function DetailIndex($filtro)
    {
        $builder=$this->db->table("vw_regla_entrega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailCondicionesRegla($filtro)
    {
        $builder=$this->db->table("detallereglaentrega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageCondicional($storage)
    {
        $builder=$this->db->table("detallereglaentrega");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function UpdateRegla($filtro,$update)
    {
        $builder=$this->db->table("reglaentrega");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DestroyCondicion($filtro)
    {
        $builder=$this->db->table("detallereglaentrega");
        $builder->where($filtro);
        $builder->delete();
        return $builder->get()->getResultArray();
    }

    public function DetailRegla($filtro)
    {
        $builder=$this->db->table("vw_regla_entrega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}