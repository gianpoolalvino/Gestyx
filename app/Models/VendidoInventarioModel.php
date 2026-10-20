<?php

namespace App\Models;

use CodeIgniter\Model;

class VendidoInventarioModel extends Model
{
    public function DetailIndex($tipoFiltro, $filtro)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');

        // Definir los códigos de agencia y bodega
        $codigosAgencia = session("codigoAgencia");
        $codigosBodega = session("codigoBodega");

        // Primer intento de búsqueda usando ambos filtros
        $builder = $this->db->table("vendidosinventario");
        $builder->whereIn('codigoBodega', $codigosBodega);
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        $result = $builder->get()->getResultArray();
        // Si no hay resultados, buscar solo con codigoAgencia
        if (empty($result)) {
            $builder = $this->db->table("vendidosinventario");
            $builder->whereIn('codigoAgencia', $codigosAgencia);
            if ($tipoFiltro != '') {
                $builder->like($tipoFiltro, $filtro);
            }
            $result = $builder->get()->getResultArray();
        }
        return $result;
    }
}