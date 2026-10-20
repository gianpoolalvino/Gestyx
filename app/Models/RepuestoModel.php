<?php

namespace App\Models;

use CodeIgniter\Model;

class RepuestoModel extends Model
{
    public function DetailIndex($tipoFiltro,$filtro,$limit, $start)
    {
        $this->db->simpleQuery("SET SESSION group_concat_max_len=99999999999999999");
        $builder = $this->db->table("detallerepuesto");
        $marcas = session("idmarca");
        if (is_array($marcas) && !empty($marcas)) {
            $builder->whereIn("idmarca", $marcas);
        }
        //$builder->whereIn("idmarca",session("idmarca"));
        $builder->where(["idestado"=> 1]);
        if ($tipoFiltro != "") {
            $builder->like($tipoFiltro, $filtro);
        }
        $builder->orderBy("idrepuesto", "desc");
        if ($tipoFiltro == "") {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountDetail($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("detallerepuesto");
        $builder->select("count(idrepuesto) as contadorTotal");
        //$builder->whereIn("idmarca",session("idmarca"));
        $builder->where(["idestado"=>1]);
        if($tipoFiltro!=""){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function View($filtro)
    {
        $builder=$this->db->table("repuesto");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectRepuesto($filtro)
    {
        $builder=$this->db->table("repuesto");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageRepuesto($repuesto)
    {
        $builder=$this->db->table("repuesto");
        $builder->insert($repuesto);
        return $this->db->insertID();
    }

    public function UpgradeRepuesto($filtro,$update)
    {
        $builder=$this->db->table("repuesto");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
}