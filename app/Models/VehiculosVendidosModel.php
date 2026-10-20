<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculosVendidosModel extends Model
{


    public function DetailIndex($tipoFiltro,$filtro,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("vw_vehiculo_vendido");

        /*var_dump(session('codigoAgencia'));
        exit;*/


        // Solucion a un error donde la agencia es 0 o no hay agencias
        //$agencias = session('codigoAgencia');

        /*if (!empty($agencias)) {
            $builder->whereIn('codigoAgencia', $agencias);
        } else {
            $builder->where('1 = 0');
        }*/

        // Filtrar por el código de agencia desde la sesión
        $builder->whereIn('codigoAgencia', session("codigoAgencia"));
        // Filtrar por el tipo y valor del filtro si no están vacíos
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Ordenar por el campo urgente (descendente)
        $builder->orderBy("urgente", "desc");
        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailIndex_old($tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vw_vehiculo_vendido");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("urgente","desc");
      //  if($tipoFiltro=='') {
      //      $builder->limit($limit, $start);
    //    }
        return $builder->get()->getResultArray();
    }

    public function CountRegistro($tipoFiltro,$filtro)
    {
        $builder = $this->db->table("vw_vehiculo_vendido");

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
}