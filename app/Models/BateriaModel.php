<?php

namespace App\Models;

use CodeIgniter\Model;

class BateriaModel extends Model
{
    public function StorageBateria($bateria)
    {
        $builder=$this->db->table("bateriatest");
        $builder->insert($bateria);
        $idequipamiento=$this->db->insertID();
        return $idequipamiento;
    }

    public function ViewEstado($filtro)
    {
        $builder = $this->db->table("vw_test_bateria_detail");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailRegistroTest($tipoFiltro,$filtro,$fechaInicio,$fechaFin,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("vw_detail_registro_bateria");
        $builder->whereIn('idgrupoUbicacion', session("codigoGrupoUbicacion"));
        $builder->where(['fechaTest>='=>$fechaInicio,'fechaTest<='=>$fechaFin]);
        // Filtrar por el código de agencia desde la sesión
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailIndex($idubicacion,$estadoAlerta,$tipoFiltro,$filtro,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("vw_test_bateria_detail");
        $builder->whereIn('idgrupoUbicacion', session("codigoGrupoUbicacion"));
        // Filtrar por el código de agencia desde la sesión
        if($idubicacion!=''){
            $builder->where(["idubicacion"=>$idubicacion]);
        }
        if($estadoAlerta!=0){
            $builder->where(["estadoAlerta"=>$estadoAlerta]);
        }
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function CountRegistros($idubicacion,$tipoFiltro,$filtro,$estadoTest)
    {
        $builder = $this->db->table("vw_test_bateria_detail");
        $builder->select("count(vin) as contador");
        // Filtrar por el código de agencia desde la sesión
        $builder->whereIn('idgrupoUbicacion', session("codigoGrupoUbicacion"));
        if($idubicacion!=''){
            $builder->where(["idubicacion"=>$idubicacion]);
        }
        $builder->where(["estadoAlerta"=>$estadoTest]);
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailIndexV2($tipo,$tipoFiltro,$filtro,$limit,$start)
    {
        $sql = "CALL Sp_con_test_y_sin_test_bateria(?,?,?,?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$tipo,$tipoFiltro,$filtro,$limit,$start]);
        return $query->getResultArray(); // Devuelve un array con los resultados
    }


    public function CalcularProximoTest($vin,$fechaTest)
    {
        $sql = "CALL CalcularFechaSiguienteTestBateria(?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin,$fechaTest]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function VerificarTest($filtro)
    {
        $builder=$this->db->table("vinbateria");
        $builder->select("count(vin) as contador");
        $builder->where($filtro);
        $builder->limit(1);
        return $builder->get()->getResultArray();
    }

    public function ViewTestBateria($filtro)
    {
        $builder=$this->db->table("vinbateria");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewVinTestBateria($filtro)
    {
        $builder=$this->db->table('vwvinbateriatest');
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateBateria($filtro,$update)
    {
        $builder=$this->db->table("bateriatest");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
}