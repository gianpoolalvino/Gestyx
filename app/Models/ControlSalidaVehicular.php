<?php

namespace App\Models;

use CodeIgniter\Model;

class ControlSalidaVehicular extends Model
{
    public function DetailIndex($tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->select("*");
        $builder->where(["liberado"=>2,'idestadoVin'=>2]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin.idvin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountRegistro($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vin");
        $builder->select("count(idvin) as contadorTotal");
        $builder->where(["liberado"=>2,'idestadoVin'=>2]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndexReport($tipoFiltro,$filtro,$fechaInicio,$fechaFin,$limit,$start)
    {
        $builder=$this->db->table("vin as vn");
        $builder->select("vn.vin,
                                vn.marca,
                                vn.modelo,
                                vn.color,
                                vn.agencia,
                                vn.familia,
                                vn.documentoCliente,
                                vn.nombreCliente,
                                vn.numeroFactura,
                                vn.saldoPendiente,
                                vn.numeroPedido,
                                te.fechaFin as fechaEvento,
                                us.nombres,
                                us.primerApellido,
                                us.segundoApellido");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->join("timelineevento as te","te.vin = vn.vin");
        $builder->join("evento as evn","evn.idevento = te.ideventoActual");
        $builder->join("usuario as us","us.idusuario = te.idusuariofinaliza");
        $builder->where(["te.ideventoActual"=>9,"te.idestadoEvento"=>2]);
        $builder->where(["te.fechaFin>="=>$fechaInicio,"te.fechaFin<="=>$fechaFin]);
        $builder->orderBy("vn.idvin","desc");
        if($tipoFiltro=='') {
          //  $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountRegistroReport($tipoFiltro,$filtro,$fechaInicio,$fechaFin)
    {
        $builder=$this->db->table("vin as vn");
        $builder->select("count(vn.idvin) as contadorTotal");
        $builder->join("timelineevento as te","te.vin = vn.vin");
        $builder->join("evento as evn","evn.idevento = te.ideventoActual");
        $builder->join("usuario as us","us.idusuario = te.idusuariofinaliza");
        $builder->where(["te.ideventoActual"=>9,"te.idestadoEvento"=>2]);
        $builder->where(["te.fechaFin>="=>$fechaInicio,"te.fechaFin<="=>$fechaFin]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

}