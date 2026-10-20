<?php

namespace App\Models;

use CodeIgniter\Model;

class ExhibicionModel extends Model
{
    public function DetailIndexExhibicion($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vehiculoenexhibicion");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndexPreparando($tipofiltro,$filtro)
    {
        $builder=$this->db->table("preparandoexhibicion");
        if($tipofiltro!=''){
            $builder->like($tipofiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }
    public function EventosRealizados($filtro)
    {
        $builder=$this->db->table("evento as ev");
        $builder->select("ev.idevento,
                                ev.descripcion as evento,
                                tle.fechaInicio,
                                tle.fechaFin,
                                tle.eventoActual as eventoRealizado,
                                tle.comentarios,
                                CONCAT(IFNULL(us.nombres,''),' ',IFNULL(us.primerApellido,''),' ',IFNULL(us.segundoApellido,'')) as usuarioEvento");
        $builder->join("timelineevento as tle","tle.ideventoActual = ev.idevento and tle.idestadoEvento = 2","LEFT");
        $builder->join("usuario as us","us.idusuario = tle.idusuariofinaliza","LEFT");
        $builder->whereIn("ev.idevento",[1,2,3,7]);
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function DetailIndex($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vin as vn");
        $builder->select("vn.*,
                                evn.idexhibicionVin,
                                evn.solicitante,
                                evn.fechaEstimadaEnvioExhibicion,
                                date_format( evn.fechaEstimadaEnvioExhibicion, '%d/%m/%Y' ) AS fechaEstimadaEnvio,
                                evn.fechaEstimadaRetornoExhibicion,
                                date_format( evn.fechaEstimadaRetornoExhibicion, '%d/%m/%Y' ) AS fechaEstimadaRetorno,
                                evn.agencia as agenciaSolicitante,
	                            (SELECT GROUP_CONCAT(DISTINCT equi.idequipamientoVin,'##',equi.cantidad,'##',equi.idestadoEquipamiento,'##',equi.equipamiento SEPARATOR '@@') FROM equipamientovin as equi where equi.vin = vn.vin and equi.idexhibicionVin = evn.idexhibicionVin and equi.eliminado is null) as equipamiento");
        $builder->join("timelineevento as tle","tle.vin = vn.vin and tle.idestadoEvento = 1 and tle.ideventoActual = 31");
        $builder->join("exhibicionvin as evn","evn.vin = vn.vin and evn.idestadoExhibicion = 2");
        $builder->where(["vn.idestadoVin"=>6]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }
    public function RegistroExhibicion($filtro)
    {
        $builder = $this->db->table("exhibicionvin");
        $builder->select("count(idexhibicionVin) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageExhibicion($storage)
    {
        $builder=$this->db->table("exhibicionvin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageEquipamientoExhibicion($storage)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function ViewExhibicion($filtro)
    {
        $builder = $this->db->table("exhibicionvin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewDetailEquipamiento($filtro)
    {
        $builder = $this->db->table("equipamientovin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateExhibicion($filtro,$update)
    {
        $builder=$this->db->table("exhibicionvin");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
}
