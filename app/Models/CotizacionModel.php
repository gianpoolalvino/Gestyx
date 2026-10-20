<?php

namespace App\Models;

use CodeIgniter\Model;

class CotizacionModel extends Model
{
    public function NumeroCotizacion($filtro)
    {
        $builder=$this->db->table("cotizacion");
        $builder->select("count(numero) as numeroCotizacion");
        $builder->where($filtro);
        $builder->orderBy("numero","desc");
        return $builder->get()->getResultArray();
    }

    public function Cliente($filtro)
    {
        $builder=$this->db->table("vw_cliente");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewCotizacion($filtro)
    {
        $builder=$this->db->table("viewdetallecotizacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewDetalleCotizacion($filtro)
    {
        $builder=$this->db->table("viewdetallecotizacioncab");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageCotizacion($storage)
    {
        $builder=$this->db->table("cotizacion");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function UpgradeCotizacion($filtroCot,$updateCot)
    {
        $builder=$this->db->table("cotizacion");
        $builder->where($filtroCot);
        $builder->update($updateCot);
        return $builder->get()->getResultArray();
    }

    public function StorageDetalleCotizacion($storage)
    {
        $builder=$this->db->table("detallecotizacion");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function DetailIndex($filtro)
    {
        $builder=$this->db->table("viewdetallecotizacion");
        $builder->where($filtro);
        $builder->orderBy("numero","desc");
        return $builder->get()->getResultArray();
    }
}