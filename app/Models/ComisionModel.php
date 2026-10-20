<?php

namespace App\Models;

use CodeIgniter\Model;

class ComisionModel extends Model
{

    public function DetailCategoria($filtro)
    {
        $builder=$this->db->table("categoriabono");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function DestroyCategoria($filtro)
    {
        $builder = $this->db->table("categoriabono");
        $builder->where($filtro);
        return $builder->delete();
    }
    public function StorageCategoria($storage)
    {
        $builder=$this->db->table("categoriabono");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageBono($storgae)
    {
        $builder=$this->db->table("circularbono");
        $builder->insert($storgae);
        return $this->db->insertID();
    }

    public function StorageDetailBono($storgae)
    {
        $builder=$this->db->table("detallecircularbono");
        $builder->insert($storgae);
        return $this->db->insertID();
    }

    public function DetailIndexVendidosBono($marca,$limit,$start,$anho,$mes)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("vw_vendidos_bono");
        if ($marca != '') {
            $builder->like('idmarca', $marca);
        }
        $builder->where(['anhoFactura'=>$anho,'mesFactura'=>$mes]);
        // Ordenar por el campo urgente (descendente)
        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailIndexBono($marca,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("wv_detail_bono_activo");
        if ($marca != '') {
            $builder->like('idmarca', $marca);
        }
        // Ordenar por el campo urgente (descendente)

        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function UpdateDetailBonoCircular($filtroUp,$updateF)
    {
        $builder=$this->db->table("detallecircularbono");
        $builder->where($filtroUp);
        $builder->update($updateF);
        return $builder->get()->getResultArray();
    }
    public function DestroyRegla($filtro)
    {
        $builder = $this->db->table("reglacomisionventavehiculo");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function DestroyConcepto($filtro)
    {
        $builder = $this->db->table("detallereglacomisionventavehiculo");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function UpdateReglaComisionVenta($idregla,$regla)
    {
        $builder=$this->db->table("reglacomisionventavehiculo");
        $builder->where($idregla);
        $builder->update($regla);
        return $builder->get()->getResultArray();
    }

    public function UpdateVin($filtro,$update)
    {
        $builder=$this->db->table("vin");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexReglaComision($filtro)
    {
        $builder=$this->db->table("vw_detail_regla_comision");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailComision($estadoComision,$tipoFiltro,$fechaInicio,$fechaFin,$filtro)
    {
        $builder=$this->db->table("vin as vn");
        $builder->select("vn.*,cp.vendedor as asesorVenta,stv.descripcion as estadoVin,cp.totalComision");
        $builder->join("comisionpagada as cp","cp.vin = vn.vin","LEFT");
        $builder->join("estadovin as stv","stv.idestadoVin = vn.idestadoVin","LEFT");
        if($estadoComision==1){
            $builder->where(['vn.comisionPagada'=>1]);
        }else if($estadoComision==2){
            $builder->where(['vn.comisionPagada'=>null]);
        }
        $builder->whereIn("vn.idestadoVin",[2,3]);
        $builder->where(["vn.saldoPendiente"=>0,"vn.fechaFactura>="=>$fechaInicio,"vn.fechaFactura<="=>$fechaFin]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vn.fechaFactura","desc");
        return $builder->get()->getResultArray();
    }

    public function StorageRegla($storage)
    {
        $builder=$this->db->table("reglacomisionventavehiculo");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function SumaPorcentajeRegla($filtro)
    {
        $builder=$this->db->table("detallereglacomisionventavehiculo");
        $builder->select("sum(peso) as sumaTotal");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailReglaVentaVehiculo($filtro)
    {
        $builder=$this->db->table("detallereglacomisionventavehiculo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageConceptoRegla($storage)
    {
        $builder=$this->db->table("detallereglacomisionventavehiculo");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function SaveVin($storage)
    {
        $builder=$this->db->table("comisionpagada");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function ViewComision($filtro)
    {
        $builder=$this->db->table("comisionpagada");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}