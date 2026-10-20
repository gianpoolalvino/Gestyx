<?php

namespace App\Models;

use CodeIgniter\Model;

class TrasladoModel extends Model
{

    public function SelectVin($filtro)
    {
        $builder=$this->db->table("vw_select_vin_traslado");
        if($filtro!=''){
            $builder->where($filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailTransportista(){
        $builder=$this->db->table("transportista");
        return $builder->get()->getResultArray();
    }

    public function DestroyTransportista($filtroTransportista){
        $builder=$this->db->table("transportista");
        $builder->where($filtroTransportista);
        return $builder->delete();
    }

    public function StorageTransportista($storage)
    {
        $builder=$this->db->table("transportista");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function VerificationBox($filtro)
    {
        $builder=$this->db->table("boxubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageBoxUbicacion($storage)
    {
        $builder=$this->db->table("boxubicacion");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function TrasladoVin($filtro)
    {
        $builder=$this->db->table("trasladovin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewTrasladoVin($filtro)
    {
        $builder=$this->db->table('viewtrasladovin');
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectGrupoUbicacion()
    {
        $builder=$this->db->table("vw_grupoubicacion_empresa");
        return $builder->get()->getResultArray();
    }

    public function ObtenerUltimaUbicacion($vin)
    {
        $sql = "CALL sp_ObtenerUbicacionFinal(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function EstadoTrasladoVin($vin)
    {
        $sql = "CALL getVinEstadoTraslado(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function StorageNovedadCheck($iddetalleEnvioTaller,$idtipoNovedad,$comentario,$fecha,$hora,$idestadoNovedad)
    {
        $query = "CALL actualizarEstadoYObtenerNovedades(?,?,?,?,?,?)";
        // Ejecutar el procedimiento
        $result = $this->db->query($query, [$iddetalleEnvioTaller,$idtipoNovedad,$comentario,$fecha,$hora,$idestadoNovedad]);
        // Si la ejecución es exitosa, devolvemos true, de lo contrario, false
        if ($result) {
            return true; // Puede devolver algún resultado si es necesario
        } else {
            return false; // Si hubo un error, retornamos false
        }
    }

    public function ObtenerNovedadPorTipo($idtipoNoevad,$vin,$idtraslado,$iddetalleTaller)
    {
        $sql = "CALL obtenerObservacionPorTipoNovedad(?,?,?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$idtipoNoevad,$vin,$idtraslado,$iddetalleTaller]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function DetalleNovedadesTaller($vin,$idestadoNovedad,$idtraslado)
    {
        $sql = "CALL GetNovedadesEnviadasTallerVin(?,?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin,$idestadoNovedad,$idtraslado]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function DetailGrupoUbicacion($filtro)
    {
        $builder=$this->db->table('vw_grupo_ubicacion_detail');
        if($filtro!=''){
            $builder->like('empresa',$filtro);
            $builder->orlike('grupoUbicacion',$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function BoxOcupado($idboxUbicacion)
    {
        $sql = "CALL sp_box_vines_asignados(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$idboxUbicacion]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function DetailCambioUbicacion($tipoFiltro,$filtro,$estadoVin,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("ubicacionvin");
      //  $builder->whereIn('codigoBodega',session("codigoBodega"));
        if($estadoVin!=''){
            $builder->where(["idestadoVin"=>$estadoVin]);
        }
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

    public function ViewFullTrUbicacion($filtro)
    {
        $builder=$this->db->table("vw_traslado_ubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewFull($filtro)
    {
        $builder=$this->db->table("vw_traslado_vin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function BoxUbicacion($filtro)
    {
        $builder=$this->db->table("vw_select_box");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailCambioAgencia($tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder = $this->db->table("vinagencia");

        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, '%' . $filtro . '%');
        }

        $builder->groupStart()
            ->whereIn('codigoAgencia', session("codigoAgencia"))
            ->orWhereIn('codigoAgenciaOrigen', session("codigoAgencia"))
            ->orWhereIn('codigoAgenciaDestino', session("codigoAgencia"))
            ->groupEnd();

        $builder->orderBy("idvin", "desc");

        if ($tipoFiltro == '') {
            $builder->limit($limit, $start);
        }

        $query = $builder->get();
      //  echo $this->db->getLastQuery(); // Para depurar la consulta
        return $query->getResultArray();
    }

    public function UpdateTraslado($filtro,$updateTras)
    {
        $builder=$this->db->table("trasladovin");
        $builder->where($filtro);
        $builder->update($updateTras);
        return $builder->get()->getResultArray();
    }

    public function TrasladoFullIdUbi($filtro)
    {
        $builder=$this->db->table("trasladovin");
        $builder->where($filtro);
        $builder->orderBy("idtrasladoVin","desc");
        $builder->limit(1);
        return $builder->get()->getResultArray();
    }

    public function TrasladoId($filtro)
    {
        $builder=$this->db->table("trasladovin as tr");
        $builder->select("tr.idtrasladoVin,
                                tr.vin,
                                ao.codigoAgencia as codigoAgenciaOrigen,
                                ao.descripcion as agenciaOrigen,
                                ad.codigoAgencia as codigoAgenciaDestino,
                                ad.descripcion as agenciaDestino,
                                tr.idtipoTraslado");
        $builder->where($filtro);
        $builder->join("agencia as ao","tr.codigoAgenciaOrigen = ao.codigoAgencia");
        $builder->join("agencia as ad","tr.codigoAgenciaDestino = ad.codigoAgencia");
        $builder->orderBy("tr.idtrasladoVin","desc");
        $builder->limit(1);
        return $builder->get()->getResultArray();
    }

    public function CountCambioUbicacion($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("ubicacionvin");
        $builder->select("count(idvin) as contadorTotal");
     //   $builder->whereIn('codigoBodega',session("codigoBodega"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function CountCambioAgencia($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vinagencia");
        $builder->select("count(idvin) as contadorTotal");
      //  $builder->whereIn('codigoBodegaActual',session("codigoBodega"));
     //   $builder->orWhereIn('codigoBodegaAnterior',session("codigoBodega"));
        $builder->groupStart()
            ->whereIn('codigoAgencia', session("codigoAgencia"))
            ->orWhereIn('codigoAgenciaOrigen', session("codigoAgencia"))
            ->orWhereIn('codigoAgenciaDestino', session("codigoAgencia"))
            ->groupEnd();
     //   $builder->orWhereIn('codigoAgenciaAnterior',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro, '%' . $filtro . '%');
        }
        return $builder->get()->getResultArray();
    }

    public function DetalleEnvioTraslado($filtro)
    {
        $builder=$this->db->table("detalleenviovin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetalleRecepcion($filtro)
    {
        $builder=$this->db->table("detallerecepcionvin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CountObsRecep($filtro)
    {
        $builder=$this->db->table('detallerecepcionvin');
        $builder->select('count(iddetalleRecepcionVin) as contador');
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DeleteDetalleEnvio($filtro)
    {
        $builder=$this->db->table("detalleenviovin");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function UpdateDetailEnviovin($filtro,$update)
    {
        $builder=$this->db->table("detalleenviovin");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DeleteDetalleRecepcion($filtro)
    {
        $builder=$this->db->table("detallerecepcionvin");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function StorageObservacionRecepcion($storage)
    {
        $builder=$this->db->table("detallerecepcionvin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageObservacionEnvio($storage)
    {
        $builder=$this->db->table("detalleenviovin");
        $builder->insert($storage);
        return $this->db->insertID();
    }



    public function SelectAgencia()
    {
        $builder=$this->db->table("agencia");
        return $builder->get()->getResultArray();
    }

    public function AgenciaDatos($filtro)
    {
        $builder=$this->db->table("agencia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectUbicacion()
    {
        $builder=$this->db->table("ubicacion");
        return $builder->get()->getResultArray();
    }

    public function SelectUbicacionGrupo($filtro)
    {
        $builder=$this->db->table("ubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageTraslado($traslado)
    {
        $builder=$this->db->table("trasladovin");
        $builder->insert($traslado);
        return $this->db->insertID();
    }
}