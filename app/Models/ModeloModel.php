<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloModel extends Model
{
    public function SelectModelo($filtro='')
    {
        $builder=$this->db->table("modelo");
        if($filtro!=''){
            $builder->where($filtro);
        }
        $builder->where(["estado"=>1]);
        return $builder->get()->getResultArray();
    }

    public function UpgradeModelo($filtro,$update)
    {
        $builder=$this->db->table("modelo");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function ViewModelo($filtro)
    {
        $builder=$this->db->table("detailmodelo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function StorageModelo($modelo)
    {
        $builder=$this->db->table("modelo");
        $builder->insert($modelo);
        return $this->db->insertID();
    }

    public function DetailIndex($tipoFiltro, $filtro, $limit, $start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder = $this->db->table("detailmodelo");
        $builder->where(["estado"=>1]);
        if ($tipoFiltro != '') {
            $builder->where(["idmarca"=>$tipoFiltro]);
            $builder->like("descripcion",$filtro);
        }
        $builder->orderBy("idmodelo", "desc");
        if ($tipoFiltro == '') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountDetail($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("detailmodelo");
        $builder->select("count(idmodelo) as contadorTotal");
        $builder->where(["estado"=>1]);
        if($tipoFiltro!=''){
            $builder->where(["idmarca"=>$tipoFiltro]);
            $builder->like("descripcion",$filtro);

        }
        return $builder->get()->getResultArray();
    }
}