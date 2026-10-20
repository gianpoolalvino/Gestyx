<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappModel extends Model
{

    public function DetainIndex($filtro)
    {
        $builder = $this->db->table("sessionwhatsapp");
        if ($filtro != '') {
            $builder->where($filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewWhatsapp($filtro)
    {
        $builder = $this->db->table("sessionwhatsapp");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function AgentesWhatsapp($filtro)
    {
        $builder = $this->db->table("vw_agentes_whatsapp");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function AgentesLibres()
    {
        $builder = $this->db->table("vw_agente_libre");
        return $builder->get()->getResultArray();
    }

    public function DeleteAgentWhatsapp($filtro)
    {
        $builder=$this->db->table("agentewhatsapp");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageAgente($insert)
    {
        $builder=$this->db->table("agentewhatsapp");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function Storage($insert)
    {
        $builder=$this->db->table("sessionwhatsapp");
        $builder->insert($insert);
        return $this->db->insertID();
    }
}