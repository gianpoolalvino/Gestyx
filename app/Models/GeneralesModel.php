<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralesModel extends Model
{
    public function SearchResponsable($filtro)
    {
        $builder=$this->db->table("responsabledemo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectBodega()
    {
        $builder=$this->db->table("bodega");
        return $builder->get()->getResultArray();
    }

    public function SelectEmpresa()
    {
        $builder=$this->db->table("empresa");
        return $builder->get()->getResultArray();
    }

    public function SelectCondiciones()
    {
        $builder=$this->db->table("condicionregla");
        return $builder->get()->getResultArray();
    }

    public function DetailIndexHistorySincronizacion($filtro)
    {
        $builder=$this->db->table("sincronizacionrealizada");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CamposParaReglaEntregado($filtro)
    {
        $builder=$this->db->table("campovehiculo");
        if($filtro!=""){
            $builder->where($filtro);
        }

        return $builder->get()->getResultArray();
    }

    public function SelectProcesoVehiculo()
    {
        $builder=$this->db->table("tipoaplicagruporegla");
        return $builder->get()->getResultArray();
    }

    public function SelectGrupoUbicacion($filtro)
    {
        $builder=$this->db->table("grupoubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectUbicacionGrupo($filtro)
    {
        $builder=$this->db->table("ubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function RequeridoSalida()
    {
        $builder=$this->db->table("requisitosalida");
        return $builder->get()->getResultArray();
    }

    public function CentroCosto()
    {
        $builder=$this->db->table("centrocosto");
     //   $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function Mes()
    {
        $builder=$this->db->table("mes");
        return $builder->get()->getResultArray();
    }

    public function SelectMes($mesAct)
    {
        $builder=$this->db->table("mes");
        if($mesAct!=''){
            $builder->where(["codigoMes<="=>$mesAct]);
        }
        return $builder->get()->getResultArray();
    }

    public function Anho()
    {
        $builder=$this->db->table("anho");
        return $builder->get()->getResultArray();
    }

    public function StorageResponsable($responsable)
    {
        $builder=$this->db->table("responsabledemo");
        $builder->insert($responsable);
        return $this->db->insertID();
    }

    public function UbicacionGrupoUbicacion()
    {
        $builder=$this->db->table("ubicacion");
        $builder->whereIn('idgrupoUbicacion', session("codigoGrupoUbicacion"));
        return $builder->get()->getResultArray();
    }

    public function SelectAgencia()
    {
        $builder=$this->db->table("agencia");
        return $builder->get()->getResultArray();
    }

    public function Taller($filtro)
    {
        $builder=$this->db->table("taller");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectAgenciaActivaCotizador(){
        return $this->db->table('agencia a')
        ->select('a.idagencia, a.descripcion, e.descripcion as empresa')
        ->join('empresa e', 'e.idempresa = a.idempresa', 'left')
        ->where('a.is_active_cotizador', 1)
        ->get()
        ->getResultArray();
    }

    public function SelectAgenciaEmp()
    {
        $builder=$this->db->table("vw_select_agencia_empresa");
        return $builder->get()->getResultArray();
    }

    public function SelectUbicacion()
    {
        $builder=$this->db->table("ubicacion");
        return $builder->get()->getResultArray();
    }

    public function Agencia($filtro)
    {
        $builder=$this->db->table("agencia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }


    public function FiltroSesion($filtro)
    {
        $builder=$this->db->table("filtrosesion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function FiltroModulo($filtro)
    {
        $builder=$this->db->table("filtromodulo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageFiltro($storage)
    {
        $builder=$this->db->table("filtrosesion");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function UpdateFiltro($filtro,$update)
    {
        $builder=$this->db->table("filtrosesion");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
}