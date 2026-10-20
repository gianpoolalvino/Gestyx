<?php

namespace App\Models;

use CodeIgniter\Model;

class ControlDemosModel extends Model
{
    public function DetailIndex($tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->where(["codigoBodega"=>"0202","liberacionDemo"=>null,'idtipoVin'=>1]);
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
        $builder->where(["codigoBodega"=>"0202","liberacionDemo"=>null,'idtipoVin'=>1]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewDemoLiberado($idliberacionDemo)
    {
        $builder=$this->db->table("infodemo");
        $builder->where(["idliberacionDemo"=>$idliberacionDemo]);
        return $builder->get()->getResultArray();
    }

    public function DetailAgendadosDemo($tipoFiltro,$filtro,$limit,$start)
    {
        $builder=$this->db->table("vinasignados");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountAsignados($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vinasignadodemoid");
        $builder->select("count(vin) as contadorTotal");

        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function StorageCheckList($storage)
    {
        $builder=$this->db->table("checklistdemo");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageDetailCheckList($storageDetail)
    {
        $builder=$this->db->table("detallechecklistdemo");
        $builder->insert($storageDetail);
        return $this->db->insertID();
    }

    public function InventarioDemo()
    {
        $builder=$this->db->table("inventariodemo");
        $builder->orderBy("idinventarioDemo","asc");
        return $builder->get()->getResultArray();
    }

    public function CheckListDemo($filtro)
    {
        $builder=$this->db->table("checklistvin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailCheckListDemo($filtro)
    {
        $builder=$this->db->table("detallechecklistvin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CheckListRetorno($filtroCheck)
    {
        $builder=$this->db->table("checklistdemo");
        $builder->where($filtroCheck);
        return $builder->get()->getResultArray();
    }

    public function UpdateCheckList($filtroUpCheck,$checkList)
    {
        $builder=$this->db->table("checklistdemo");
        $builder->where($filtroUpCheck);
        $builder->update($checkList);
        return $builder->get()->getResultArray();
    }



    public function DetailResourceDemo($filtro)
    {
        $builder=$this->db->table("resourceasignaciondemo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageResourceCheckList($storage)
    {
        $builder=$this->db->table("resourceasignaciondemo");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function DetailAsignados($tipoFiltro,$filtro,$limit,$start)
    {
        $builder=$this->db->table("vinasignadodemoid");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewDemoAsignado($filtro)
    {
        $builder=$this->db->table("vinviewasignadoid");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DeleteResource($deleteRes)
    {
        $builder=$this->db->table("resourceasignaciondemo");
        $builder->delete($deleteRes);
        return $builder->get()->getResultArray();
    }

    public function ServicioSugerido()
    {
        $builder=$this->db->table("serviciosugerido");
        return $builder->get()->getResultArray();
    }

    public function ViewDemoAsignadoPdf($filtro)
    {
        $builder=$this->db->table("viewvinliberadoid");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CountAgendadosDemo($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vinasignados");
        $builder->select("count(vin) as contadorTotal");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function StorageControlDemo($liberacion)
    {
        $builder=$this->db->table("liberaciondemo");
        $builder->insert($liberacion);
        return $this->db->insertID();
    }

    public function StorageSerivicioSugerido($service)
    {
        $builder=$this->db->table("serviciosugeridochecklist");
        $builder->insert($service);
        return $this->db->insertID();
    }

    public function DetailServicioSugeridoCheck($idcheckList)
    {
        $builder=$this->db->table("serviciosugeridochecklist AS scl");
        $builder->select('scl.estadoServicio,
                                scl.idservicioSugerido AS idPrincipal,
                                sg.descripcion AS principal,
                                    (
                                SELECT
                                    scl4.estadoServicio 
                                FROM
                                    serviciosugeridochecklist AS scl4
                                    INNER JOIN serviciosugerido AS sg4 ON sg4.idservicioSugerido = scl4.idservicioSugerido 
                                WHERE
                                    sg4.idservicioSugerido = sg.columnaAdjunta and scl4.idcheckListDemo = '.$idcheckList.'
                                ) AS estadoServicio2,
                                (
                                SELECT
                                    scl2.idservicioSugerido 
                                FROM
                                    serviciosugeridochecklist AS scl2
                                    INNER JOIN serviciosugerido AS sg2 ON sg2.idservicioSugerido = scl2.idservicioSugerido 
                                WHERE
                                    sg2.idservicioSugerido = sg.columnaAdjunta and scl2.idcheckListDemo = '.$idcheckList.'
                                ) AS idSecundario,
                                    (
                                SELECT
                                    sg3.descripcion 
                                FROM
                                    serviciosugeridochecklist AS scl3
                                    INNER JOIN serviciosugerido AS sg3 ON sg3.idservicioSugerido = scl3.idservicioSugerido 
                                WHERE
                                    sg3.idservicioSugerido = sg.columnaAdjunta and scl3.idcheckListDemo = '.$idcheckList.'
                                ) AS secundario');
        $builder->where(["sg.columnaPrincipal"=>1,"scl.idcheckListDemo"=>$idcheckList]);
        $builder->join("serviciosugerido AS sg","sg.idservicioSugerido = scl.idservicioSugerido");
        return $builder->get()->getResultArray();
    }

    public function StorageAsignacionDemo($asignacion)
    {
        $builder=$this->db->table("asignaciondemo");
        $builder->insert($asignacion);
        return $this->db->insertID();
    }

    public function UpdateLiberacionDemo($filtroUp,$update)
    {
        $builder=$this->db->table("liberaciondemo");
        $builder->where($filtroUp);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function UpdateAsignacionDemo($filtro,$update)
    {
        $builder=$this->db->table("asignaciondemo");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }



    public function TipoDemo()
    {
        $builder=$this->db->table("tipodemo");
        return $builder->get()->getResultArray();
    }

    public function DetailIndexLiberado($tipoFiltro,$filtro,$limit,$start)
    {
        $builder=$this->db->table("vinliberadosdemo");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("idvin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewLiberado($filtro)
    {
        $builder=$this->db->table("vinliberadosdemo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function Hora()
    {
        $builder=$this->db->table("hora");
        return $builder->get()->getResultArray();
    }

    public function CountRegistroLiberado($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vinliberadosdemo");
        $builder->select("count(vin) as contadorTotal");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }
}