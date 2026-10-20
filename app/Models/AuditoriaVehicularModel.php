<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditoriaVehicularModel extends Model
{
    public function DetailEventosRealizados($filtro)
    {
        $builder=$this->db->table("vw_evento_auditoria_vehiculo");
        $builder->where($filtro);
        $builder->whereIn('idestadoEvento',[1,2]);
        return $builder->get()->getResultArray();
    }

    public function VinNovedadRecepcion($vin)
    {
        $sql = "CALL ObtenerDetalleRecepcionPorVin(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function GrupoCalidad()
    {
        $builder=$this->db->table("grupocheckcalidad");
        return $builder->get()->getResultArray();
    }

    public function ControlCalidadReporte($vin)
    {
        $sql = "CALL sp_ObtenerCheckCalidadPorProceso(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function VinNovedadIngreso($vin)
    {
        $sql = "CALL ObtenerObservacionesIngresoPorVinSinImg(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function EventosGenerales($vin)
    {
        $sql = "CALL sp_obtener_timeline_por_vin(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function AccesoriosAuditoria($filtro)
    {
        $builder=$this->db->table("vw_equipamiento_auditoria");
        $builder->where($filtro);
      //  $builder->whereIn('idestadoEvento',[1,2]);
        return $builder->get()->getResultArray();
    }

    public function DetailTrasladoAuditoria($filtro)
    {
        $builder=$this->db->table("vw_auditoria_traslado");
        $builder->where($filtro);
        //  $builder->whereIn('idestadoEvento',[1,2]);
        $builder->orderBy("fechaTraslado","asc");
        return $builder->get()->getResultArray();
    }

    public function DetailEventosEliminados($filtro)
    {
        $builder=$this->db->table("vw_evento_auditoria_vehiculo");
        $builder->where($filtro);
        $builder->whereIn('idestadoEvento',[3]);
        return $builder->get()->getResultArray();
    }
}