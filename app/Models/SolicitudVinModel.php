<?php
namespace App\Models;

use CodeIgniter\Model;

class SolicitudVinModel extends Model
{
    public function TipoSolicitud()
    {
        $builder=$this->db->table("tiposolicitud");
        return $builder->get()->getResultArray();
    }

    public function StorageNovedad($storageSoli)
    {
        $builder=$this->db->table("novedadesdetallesolicitudvehiculo");
        $builder->insert($storageSoli);
        return $this->db->insertID();
    }

    public function ViewSolicitudFull($filtro)
    {
        $builder=$this->db->table("solicitudvehiculo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DestroyDetailCreate($filtro)
    {
        $builder=$this->db->table("detallesolicitudvehiculo");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function CountSolicitudes()
    {
        $builder=$this->db->table("solicitudvehiculo");
        $builder->select("count(idsolicitudVehiculo) as contador");
        $builder->whereIn('idestadoSolicitud',[1,2,3,4]);
        return $builder->get()->getResultArray();
    }

    public function UsuarioGestorSolicitud($filtro)
    {
        $builder=$this->db->table("usuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageSolicitud($storageSoli)
    {
        $builder=$this->db->table("solicitudvehiculo");
        $builder->insert($storageSoli);
        return $this->db->insertID();
    }

    public function DetailSolicitudVehiculo($filtro)
    {
        $builder=$this->db->table("vw_detalle_solicitud_vehiculo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexPrincipal($filtro,$searchVin)
    {
        $builder=$this->db->table("vw_solicitud_vehiculo_index");
        $builder->where($filtro);
        if($searchVin!=''){
            $builder->like("detalleVin",$searchVin);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndex($filtro)
    {
        $builder=$this->db->table("vw_solicitud_vehiculo_index");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageHistory($storage)
    {
        $builder=$this->db->table("historialsolicitudvehiculo");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function TotalSolicitudes($filtro)
    {
        $builder=$this->db->table("solicitudvehiculo AS sv");
        $builder->select("SUM(CASE WHEN sv.idestadoSolicitud = 1 THEN 1 ELSE 0 END) AS recibida,
                                SUM(CASE WHEN sv.idestadoSolicitud = 2 THEN 1 ELSE 0 END) AS vista,
                                SUM(CASE WHEN sv.idestadoSolicitud = 3 THEN 1 ELSE 0 END) AS realizada,
                                SUM(CASE WHEN sv.idestadoSolicitud = 4 THEN 1 ELSE 0 END) AS rechazada,
                                SUM(CASE WHEN sv.idestadoSolicitud IN (1, 2, 3, 4) THEN 1 ELSE 0 END) AS total");
        $builder->where($filtro);
        $builder->whereIn("sv.idestadoSolicitud",[1,2,3,4]);
        return $builder->get()->getResultArray();
    }

    public function StorageDetalleSolicitud($storageSoli)
    {
        $builder=$this->db->table("detallesolicitudvehiculo");
        $builder->insert($storageSoli);
        return $this->db->insertID();
    }

    public function UpdateSolicitudVehiculo($filtro,$update)
    {
        $builder=$this->db->table("solicitudvehiculo");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function ConfigSolicitud($filtro)
    {
        $builder=$this->db->table("configsolicitud");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateVins($filtro,$update)
    {
        $builder=$this->db->table("detallesolicitudvehiculo");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DestroyFiltroModulo($filtro)
    {
        $builder=$this->db->table("filtrosesion");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function StorageFiltro($filtros)
    {
        $builder = $this->db->table("filtrosesion");
        $ids = [];
        foreach ($filtros as $filtro) {
            if (!empty($filtro['campo']) && isset($filtro['valor'])) {
                $builder->insert($filtro);
                $ids[] = $this->db->insertID();
            }
        }
        return $ids; // Devuelve todos los IDs insertados
    }

    public function DetectarVinActual($vin)
    {
        $builder=$this->db->table("detallesolicitudvehiculo as dsvn");
        $builder->where(['dsvn.vin'=>$vin]);
        $builder->whereIn("dsvn.idestadoSolicitud",[1,2]);
        return $builder->get()->getResultArray();
    }

    public function SaveTrasladoMasivo($storageSoli)
    {
        $builder=$this->db->table("trasladomasivo");
        $builder->insert($storageSoli);
        return $this->db->insertID();
    }

    public function DetectarVehiculoDuplicado($filtroDupli)
    {
        $builder=$this->db->table("detallesolicitudvehiculo");
        $builder->where($filtroDupli);
        return $builder->get()->getResultArray();
    }

    public function OrigenTraslado()
    {
        $builder=$this->db->table("ubicacion");
        return $builder->get()->getResultArray();
    }

    public function DetailIndexGestion($estadoSolicitud,$tipoFiltro,$filtro,$hoy,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        // Crear un "builder" para la consulta
        $builder = $this->db->table("vw_gestion_solicitud_vehiculo");
        // Filtrar por el tipo y valor del filtro si no están vacíos
        if($estadoSolicitud!=''){
            $builder->where(['idestadoSolicitudVehiculo'=>$estadoSolicitud]);
        }else if($estadoSolicitud==''){
            $builder->where(["idestadoSolicitudVehiculo!="=>6]);
        }
        $builder->where(['fechaAtencion<='=>$hoy]);
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        $builder->orderBy("fechaAtencion","desc");
        // Aplicar el límite y el offset para la paginación
        if ($limit != '' && $start !== '') {
            $builder->limit($limit, $start);  // limit($limit, $start) es la paginación
        }
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function CheckNovedadId($vin,$idcabecera,$idnovedad,$idtipoNovedad)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL ObtenerNovedadPorIdTipo(?, ?, ?, ?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$idtipoNovedad,$vin,$idcabecera,$idnovedad]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function UpdateCheckNovedadId($idnovedad,$idcabeceraNovedad,$comentario,$fecha,$hora,$estado,$vin,$idtipoNovedad)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL actualizarEstadoNovedad(?, ?, ?, ?, ?, ?, ?, ?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$idnovedad,$idcabeceraNovedad,$comentario,$fecha,$hora,$estado,$vin,$idtipoNovedad]);
        // Obtenemos los resultados de la consulta
        // Si la ejecución es exitosa, devolvemos true, de lo contrario, false
        if ($query) {
            return true; // Puede devolver algún resultado si es necesario
        } else {
            return false; // Si hubo un error, retornamos false
        }
    }



    public function GestorVin($vin,$idsolicitudVehicular)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL sp_vin_gestion_solicitud(?, ?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin, $idsolicitudVehicular]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function DetailNovedades($vin,$idsolicitudVehicular)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL sp_buscar_novedades(?, ?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin, $idsolicitudVehicular]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function NovedadesVinStorage($vin,$idestadoSolicitud,$idtrasladoVin,$idsolicitudVin)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL GetNovedadesByVinStorageTaller(?, ?, ?, ?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin, $idestadoSolicitud,$idtrasladoVin,$idsolicitudVin]);
        // Si la ejecución es exitosa, devolvemos true, de lo contrario, false
        if ($query) {
            return true; // Puede devolver algún resultado si es necesario
        } else {
            return false; // Si hubo un error, retornamos false
        }
    }
}