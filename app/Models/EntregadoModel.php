<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadoModel extends Model
{
    public function DetailIndex($tipoFiltro,$filtro,$limit,$start,$fechaIn,$fechaOut)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vinentregado");
        $builder->where(["fechaEntrega>="=>$fechaIn,"fechaEntrega<="=>$fechaOut]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("fechaEntrega","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndexExcel($tipoFiltro,$filtro,$fechaIn,$fechaOut)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vinentregado");
        $builder->where(["fechaEntrega>="=>$fechaIn,"fechaEntrega<="=>$fechaOut]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("fechaEntrega","desc");
        return $builder->get()->getResultArray();
    }

    public function CountDetail($tipoFiltro,$filtro,$fechaIn,$fechaOut)
    {
        $builder=$this->db->table("vinentregado");
        $builder->select("count(idvin) as contadorTotal");
        $builder->where(["fechaEntrega>="=>$fechaIn,"fechaEntrega<="=>$fechaOut]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }
}