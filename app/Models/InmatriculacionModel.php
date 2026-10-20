<?php

namespace App\Models;

use CodeIgniter\Model;

class InmatriculacionModel extends Model
{

    public function SelectTipoCarroceria()
    {
        $builder=$this->db->table("tipocarroceria");
        return $builder->get()->getResultArray();
    }
    public function SelectTipoTramite()
    {
        $builder=$this->db->table("tipotramite");
        return $builder->get()->getResultArray();
    }

    public function ViewTramite($filtro)
    {
        $builder=$this->db->table("tramite");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function SelectTipoCombustible()
    {
        $builder=$this->db->table("tipocombustible");
        return $builder->get()->getResultArray();
    }

    public function UpdateTramite($filtro,$update)
    {
        $builder=$this->db->table("tramite");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
    public function DestroyTramite($filtro)
    {
        $builder=$this->db->table("tramite");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageTramite($storage)
    {
        $builder=$this->db->table("tramite");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function SelectTipoVehiculo()
    {
        $builder=$this->db->table("tipovehiculo");
        return $builder->get()->getResultArray();
    }
    public function SelectCiudadPlaca()
    {
        $builder=$this->db->table("ciudadplaca");
        return $builder->get()->getResultArray();
    }

    public function StorageCiudadPlaca($storage)
    {
        $builder=$this->db->table("ciudadplaca");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function CiudadPlacaId($filtro)
    {
        $builder=$this->db->table("ciudadplaca");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function CountPlacaRotativa($estadoPlaca,$tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vw_placa_rotativa");
        $builder->select("count(placa) as contador");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        if($estadoPlaca!=''){
            $builder->where(["idestadoPlaca"=>$estadoPlaca]);
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function VehiculosSinPlaca($search)
    {
        $builder=$this->db->table("vw_vehiculos_sin_placa");
        $builder->like("vin",$search);
        $builder->orLike("marca",$search);
        $builder->orLike("modelo",$search);
        $builder->orLike("color",$search);
        $builder->orLike("nombreCliente",$search);
        $builder->orLike("documentoCliente",$search);
        return $builder->get()->getResultArray();
    }

    public function ViewPlacaRotativa($filtro)
    {
        $builder=$this->db->table("vw_placa_rotativa");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DuplicatePlacaRotativa($filtro)
    {
        $builder=$this->db->table("placarotativa");
        $builder->select("count(placa) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexPlacaRotativa($estadoPlaca,$tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vw_placa_rotativa");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        if($estadoPlaca!=''){
            $builder->where(["idestadoPlaca"=>$estadoPlaca]);
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        if($limit=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function StoragePlacaRotativa($storage)
    {
        $builder=$this->db->table("placarotativa");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function DuplicatePlacaRotattiva($filtro)
    {
        $builder=$this->db->table("vw_placa_rotativa");
        $builder->select("count(placa) as contador");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageObservacion($storage)
    {
        $builder=$this->db->table("observaciontituloplaca");
        $builder->insert($storage);
        return $this->db->insertID();
    }
    public function DetailIndexSinExpediente($tipoFiltro, $filtro,$estadoVin, $limit, $start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vinsinexpediente");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("idvin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndexTitulo($tipoFiltro, $filtro,$estadoVin, $limit, $start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vintitulo");
       // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("idvin","desc");
        /*
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        */
        return $builder->get()->getResultArray();
    }

    public function DeleteEvento($filtroEventoDelete)
    {
        $builder=$this->db->table("timelineevento");
        $builder->delete($filtroEventoDelete);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexTituloPlaca($tipoFiltro, $filtro,$estadoVin,$fechaInicio,$fechaFin)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vintituloplacav2");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin,"fechaPlaca>="=>$fechaInicio,"fechaPlaca<="=>$fechaFin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("idvin","desc");
        return $builder->get()->getResultArray();
    }

    public function DuplicateTituloPlaca($filtro)
    {
        $builder=$this->db->table("timelineevento");
        $builder->select("count(vin) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewRegistroInmatriculacion($filtro)
    {
        $builder=$this->db->table("registroinmatriculacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CountIndexTituloPlaca($tipoFiltro,$filtro,$estadoVin,$fechaInicio,$fechaFin)
    {
        $builder=$this->db->table("vintituloplacav2");
        $builder->select("count(vin) as contadorTotal");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin,"fechaPlaca>="=>$fechaInicio,"fechaPlaca<="=>$fechaFin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function SelectVinsTacha($vin,$titulo)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vinplaca");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($vin!=''){
            $builder->like('vin',$vin);
        }
        if($titulo!=''){
            $builder->orLike('numeroTitulo',$titulo);
        }
        $builder->orderBy("idvin","desc");
        return $builder->get()->getResultArray();
    }

    public function DetailIndexSinPlaca($tipoFiltro, $filtro,$estadoVin, $limit, $start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vinplaca");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("idvin","desc");

        return $builder->get()->getResultArray();
    }

    public function CountDetailSinPlaca($tipoFiltro,$filtro,$estadoVin)
    {
        $builder=$this->db->table("vinplaca");
        $builder->select("count(vin) as contadorTotal");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function UpdateTitulo($filtro,$update)
    {
        $builder=$this->db->table("timelineevento");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function CountDetailSinTitulo($tipoFiltro,$filtro,$estadoVin)
    {
        $builder=$this->db->table("vintitulo");
        $builder->select("count(vin) as contadorTotal");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function CountDetailSinExpediente($tipoFiltro,$filtro,$estadoVin)
    {
        $builder=$this->db->table("vinsinexpediente");
        $builder->select("count(vin) as contadorTotal");
        // $builder->orWhereIn('codigoBodega',session("codigoBodega"));
        $builder->where(["idestadoVin"=>$estadoVin]);
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function StorageExpediente($expediente)
    {
        $builder=$this->db->table("timelineevento");
        $builder->insert($expediente);
        return $this->db->insertID();
    }

}