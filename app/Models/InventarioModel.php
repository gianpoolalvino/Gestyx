<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{

    public function DetailIndex($tipoFiltro,$filtro,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("inventario");
        // Filtrar por el código de agencia desde la sesión
        $builder->whereIn('codigoBodega', session("codigoBodega"));
        // Filtrar por el tipo y valor del filtro si no están vacíos
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Ordenar por el campo urgente (descendente)
        $builder->orderBy("idvin", "desc");

        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailIndex_old($tipoFiltro, $filtro, $limit, $start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder = $this->db->table("inventario");
        $builder->whereIn("codigoBodega",session("codigoBodega"));
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        $builder->orderBy("idvin", "desc");
        if ($tipoFiltro == '') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountDetail($tipoFiltro,$filtro)
    {
        $builder = $this->db->table("inventario");

        // Verificar que la sesión de codigoAgencia está configurada
        $codigoAgencia = session("codigoBodega");
        if (!$codigoAgencia) {
            return 0;  // Si no existe, devolver 0 o lanzar un error
        }
        $builder->whereIn("codigoBodega",$codigoAgencia);
        // Aplicar el filtro si el tipoFiltro no está vacío
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Obtener el número total de registros
        return $builder->countAllResults();
    }

    public function CountDetail_old($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("inventario");
        $builder->select("count(vin) as contadorTotal");
        $builder->whereIn("codigoBodega",session("codigoBodega"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewInfoVin($filtro)
    {
        $builder=$this->db->table("infovininventario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}