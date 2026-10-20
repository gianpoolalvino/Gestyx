<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipamientoAdicionalModel extends Model
{

    public function UpdateEquipamiento($filtroEquipamiento,$update)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->where($filtroEquipamiento);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DetailIndex($idevento,$tipofiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder = $this->db->table("vinequipamientoadicional");
        $builder->where(["ideventoActual"=>$idevento]);
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filtro);
        }
        $builder->orderBy("vin","desc");
        if($tipofiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountRegistro($idevento,$tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vinequipamientoadicional");
        $builder->select("count(vin) as contadorTotal");
        $builder->where(["ideventoActual"=>$idevento]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }
}