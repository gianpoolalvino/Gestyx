<?php

namespace App\Models;

use CodeIgniter\Model;

class CampanhaModel extends Model
{
    public function ViewCampanha($filtro)
    {
        $builder=$this->db->table("campanha");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function Campanhas()
    {
        $builder=$this->db->table("campanha");
        return $builder->get()->getResultArray();
    }

    public function StorageVehiculo($store)
    {
        $builder=$this->db->table("campanhavin");
        $builder->insert($store);
        return $this->db->insertID();
    }

    public function EstadoCampanha()
    {
        $builder=$this->db->table("estadocampanha");
        return $builder->get()->getResultArray();
    }

    public function ViewVinCampanha($filtro)
    {
        $builder=$this->db->table("campanhavin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageCampanha($campanha)
    {
        $builder=$this->db->table("campanha");
        $builder->insert($campanha);
        return $this->db->insertID();
    }

    public function UpdateVehiculo($filtro,$update)
    {
        $builder=$this->db->table("campanhavin");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexRevisionFiltro($campanha,$tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("revisioncampanhavin");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($campanha!=''){
            $builder->where(["idcampanha"=>$campanha]);
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");
        return $builder->get()->getResultArray();
    }

    public function DetailIndexRevision($campanha,$tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("revisioncampanhavin");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($campanha!=''){
            $builder->where(["idcampanha"=>$campanha]);
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }
    public function CountDetailRevision($campanha,$tipoFiltro,$filtro)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("revisioncampanhavin");
        $builder->select("count(vin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($campanha!=''){
            $builder->where(["idcampanha"=>$campanha]);
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }

        return $builder->get()->getResultArray();
    }

    public function DetailIndex($tipoFiltro,$filtro,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("vw_campanhavin");
        // Filtrar por el código de agencia desde la sesión
        $builder->whereIn('codigoAgencia', session("codigoAgencia"));
        // Filtrar por el tipo y valor del filtro si no están vacíos
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Ordenar por el campo urgente (descendente)
        $builder->orderBy("vin","desc");
        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailIndex_old($tipoFiltro,$filtro)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vw_campanhavin");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");

        return $builder->get()->getResultArray();
    }

    public function CountRegistro($tipoFiltro,$filtro)
    {
        $builder = $this->db->table("vw_campanhavin");

        // Verificar que la sesión de codigoAgencia está configurada
        $codigoAgencia = session("codigoAgencia");
        if (!$codigoAgencia) {
            return 0;  // Si no existe, devolver 0 o lanzar un error
        }
        $builder->whereIn('codigoAgencia', $codigoAgencia);
        // Aplicar el filtro si el tipoFiltro no está vacío
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Obtener el número total de registros
        return $builder->countAllResults();
    }

    public function CountDetail($tipoFiltro,$filtro)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vw_campanhavin");
        $builder->select("count(vin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));

        return $builder->get()->getResultArray();
    }
}