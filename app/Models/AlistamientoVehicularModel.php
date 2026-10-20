<?php

namespace App\Models;

use CodeIgniter\Model;

class AlistamientoVehicularModel extends Model
{
    public function EquipamientoVin($vin)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->where(["vin"=>$vin,'eliminado'=>null]);
        return $builder->get()->getResultArray();
    }

    public function NivelCombustible()
    {
        $builder=$this->db->table("nivelcombustible");
        return $builder->get()->getResultArray();
    }

    public function FormularioPdi()
    {
        $builder=$this->db->table("checklistformulariopdi");
        return $builder->get()->getResultArray();
    }

    public function ViewProcesoPdi($filtro)
    {
        $builder=$this->db->table("resultadoformulariopdi");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewProcedimientoPdi($filtro)
    {
        $builder=$this->db->table("procesopdi");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateCheckListPdi($filtro,$update)
    {
        $builder=$this->db->table("resultadoformulariopdi");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function UpdateProcesoPdi($filtroProce,$updateProce)
    {
        $builder=$this->db->table("procesopdi");
        $builder->where($filtroProce);
        $builder->update($updateProce);
        return $builder->get()->getResultArray();
    }


    public function GrupoCheckListPdi()
    {
        $builder=$this->db->table("grupochecklistformulariopdi");
        return $builder->get()->getResultArray();
    }

    public function DetailProcedimientoPdi($filtro)
    {
        $builder=$this->db->table("vw_checkdetailpdi");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageProcedimientoPdi($storage)
    {
        $builder=$this->db->table("procesopdi");
        $builder->insert($storage);
        return $this->db->insertID();
    }
    public function StorageDetalleProcesoPdi($storage)
    {
        $builder=$this->db->table("resultadoformulariopdi");
        $builder->insert($storage);
        return $this->db->insertID();
    }
    public function EquipamientoVinNew($vin,$idtipoEquipamiento)
    {
        $builder=$this->db->table("equipamientovin as eq");
        $builder->select("* ,
                                (SELECT count(idtimeLineEvento) FROM timelineevento where vin=eq.vin and idestadoEvento in (1,2) and ideventoActual = 5 and idequipamientoVin = eq.idequipamientoVin) as eventoGps,
                                (SELECT count(idtimeLineEvento) FROM timelineevento where vin=eq.vin and idestadoEvento in (1,2) and ideventoActual = 10 and idequipamientoVin = eq.idequipamientoVin) as eventoGas,
	                            (SELECT count(idtimeLineEvento) FROM timelineevento where vin=eq.vin and idestadoEvento in (1,2) and ideventoActual = 29 and idequipamientoVin = eq.idequipamientoVin) as eventoLamina");
        if($idtipoEquipamiento!=''){
            if($idtipoEquipamiento==1){
                $builder->where(["eq.vin"=>$vin,'eq.idtipoEquipamiento'=>1,'eq.eliminado'=>null]);
            }else{
                $builder->where(["eq.vin"=>$vin,'eq.idtipoEquipamiento!='=>1,'eq.eliminado'=>null]);
            }
        }else{
            $builder->where(["eq.vin"=>$vin,'eq.eliminado'=>null]);
        }
        return $builder->get()->getResultArray();
    }

    public function ViewEquipamiento($filtro)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function EquipamientoAdd($insert)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->insert($insert);
        $idequipamiento=$this->db->insertID();
        return $idequipamiento;
    }

    public function ViewVin($vin)
    {
        $builder=$this->db->table("vin");
        $builder->where(["vin"=>$vin]);
        return $builder->get()->getResultArray();
    }

    public function ProveedorGas()
    {
        $builder=$this->db->table("proveedorgas");
        return $builder->get()->getResultArray();
    }

    public function ProveedorLavado()
    {
        $builder=$this->db->table("proveedorlavado");
        return $builder->get()->getResultArray();
    }





    public function DetailIndexCall($filtroPrinci,$tipoFiltro,$filtro,$saldo,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->select("vin.*,(SELECT GROUP_CONCAT(DISTINCT equi.idequipamientoVin,'##',equi.cantidad,'##',equi.idestadoEquipamiento,'##',equi.equipamiento SEPARATOR '@@') FROM equipamientovin as equi where equi.vin = vin.vin and equi.eliminado is null) as equipamiento");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where($filtroPrinci);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        if($saldo!=''){
            if($saldo=='pagados'){
                $builder->where(['saldoPendiente'=>0]);
            }else{
                $builder->where(['saldoPendiente>'=>0]);
            }
        }
        $builder->whereNotIn("vin.idestadoVin",[3]);
        $builder->orderBy("urgente","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountRegistroCall($filtroPrinci,$tipoFiltro,$filtro,$saldo)
    {
        $builder=$this->db->table("vin");
        $builder->select("count(idvin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where($filtroPrinci);
        $builder->whereNotIn("vin.idestadoVin",[3]);
        if($saldo!=''){
            if($saldo=='pagados'){
                $builder->where(['saldoPendiente'=>0]);
            }else{
                $builder->where(['saldoPendiente>'=>0]);
            }
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndexExcel($idevento,$tipoFiltro, $filtro)
    {
// Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->select("vin.*,ev.descripcion as estadoVin,ubi.descripcion as ubicacionActual,(SELECT GROUP_CONCAT(DISTINCT equi.idequipamientoVin,'##',equi.cantidad,'##',equi.idestadoEquipamiento,'##',equi.equipamiento SEPARATOR '@@') FROM equipamientovin as equi where equi.vin = vin.vin and equi.eliminado is null) as equipamiento");
        $builder->join("ubicacion as ubi","ubi.idubicacion = vin.idubicacion","LEFT");
        $builder->join("estadovin as ev","ev.idestadoVin = vin.idestadoVin","LEFT");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["vin.ideventoActual"=>$idevento]);
        $builder->whereNotIn("vin.idestadoVin",[3]);
        // Filtrar por el código de agencia desde la sesión
        $builder->whereIn('codigoAgencia', session("codigoAgencia"));
        // Filtrar por el tipo y valor del filtro si no están vacíos
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Ordenar por el campo urgente (descendente)
        $builder->orderBy("urgente", "desc");
        // Ejecutar la consulta y devolver los resultados
        return $builder->get()->getResultArray();
    }

    public function DetailCalidad($tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vincalidad");
        $builder->whereIn('codigoAgencia', session("codigoAgencia"));
        $builder->whereNotIn("idestadoVin",[3]);
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

    public function CountCalidad($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vincalidad");
        $builder->select("count(idvin) as contadorTotal");
        $codigoAgencia = session("codigoAgencia");
        if (!$codigoAgencia) {
            return 0;  // Si no existe, devolver 0 o lanzar un error
        }
        $builder->whereNotIn("idestadoVin",[3]);
        // Aplicar el filtro si el tipoFiltro no está vacío
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Obtener el número total de registros
        return $builder->countAllResults();
    }

    public function DetailCalidadold($tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vincalidad");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("urgente","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }
    public function CountCalidadold($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vincalidad");
        $builder->select("count(idvin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailIndexV2($idevento,$tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->select("vin.*,ev.descripcion as estadoVin,ubi.descripcion as ubicacionActual");
        $builder->join("ubicacion as ubi","ubi.idubicacion = vin.idubicacion","LEFT");
        $builder->join("estadovin as ev","ev.idestadoVin = vin.idestadoVin","LEFT");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["ideventoActual"=>$idevento]);
        $builder->whereNotIn("vin.idestadoVin",[3]);
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

    public function DetailIndex($idevento,$tipoFiltro,$filtro,$limit,$start)
    {
        // Ajustar el tamaño del grupo de concatenación, si es necesario
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->select("vin.*,ev.descripcion as estadoVin,ubi.descripcion as ubicacionActual,(SELECT GROUP_CONCAT(DISTINCT equi.idequipamientoVin,'##',equi.cantidad,'##',equi.idestadoEquipamiento,'##',equi.equipamiento SEPARATOR '@@') FROM equipamientovin as equi where equi.vin = vin.vin and equi.eliminado is null) as equipamiento");
        $builder->join("ubicacion as ubi","ubi.idubicacion = vin.idubicacion","LEFT");
        $builder->join("estadovin as ev","ev.idestadoVin = vin.idestadoVin","LEFT");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["vin.ideventoActual"=>$idevento]);
        $builder->whereNotIn("vin.idestadoVin",[3]);

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

    public function DetailIndexold($idevento,$tipoFiltro,$filtro,$limit,$start)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vin");
        $builder->select("vin.*,ev.descripcion as estadoVin,ubi.descripcion as ubicacionActual,(SELECT GROUP_CONCAT(DISTINCT equi.idequipamientoVin,'##',equi.cantidad,'##',equi.idestadoEquipamiento,'##',equi.equipamiento SEPARATOR '@@') FROM equipamientovin as equi where equi.vin = vin.vin and equi.eliminado is null) as equipamiento");
        $builder->join("ubicacion as ubi","ubi.idubicacion = vin.idubicacion","LEFT");
        $builder->join("estadovin as ev","ev.idestadoVin = vin.idestadoVin","LEFT");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["vin.ideventoActual"=>$idevento]);
        $builder->whereNotIn("vin.idestadoVin",[3]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("urgente","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }


    public function UpdateVinAccesorio($filtroVin,$updateVin)
    {
        $builder=$this->db->table("vin");
        $builder->where($filtroVin);
        $builder->update($updateVin);
        return $builder->get()->getResultArray();
    }

    public function UpdateEquipamiento($filtroEquipamiento,$update)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->where($filtroEquipamiento);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function InsertEquipamiento($insertEquipamiento)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->insert($insertEquipamiento);
        return $this->db->insertID();
    }

    public function DeleteEquipamiento($filtroDelete)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->delete($filtroDelete);
        return $builder->get()->getResultArray();
    }

    public function InsertEvento($insertEvento)
    {
        $builder=$this->db->table("timelineevento");
        $builder->insert($insertEvento);
        return $this->db->insertID();
    }

    public function ProcesoAccesorioEquipamiento($filtroUpdate,$equipamiento)
    {
        $builder=$this->db->table("equipamientovin");
        $builder->where($filtroUpdate);
        $builder->update($equipamiento);
        return $builder->get()->getResultArray();
    }

    public function CountRegistro($idevento,$tipoFiltro,$filtro)
    {
        $builder = $this->db->table("vin");

        // Verificar que la sesión de codigoAgencia está configurada
        $codigoAgencia = session("codigoAgencia");
        if (!$codigoAgencia) {
            return 0;  // Si no existe, devolver 0 o lanzar un error
        }
        $builder->whereIn('codigoAgencia', $codigoAgencia);
        $builder->where(["ideventoActual"=>$idevento]);
        $builder->whereNotIn("idestadoVin",[3]);
        // Aplicar el filtro si el tipoFiltro no está vacío
        if ($tipoFiltro != '') {
            $builder->like($tipoFiltro, $filtro);
        }
        // Obtener el número total de registros
        return $builder->countAllResults();
    }

    public function CountRegistroold($idevento,$tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vin");
        $builder->select("count(idvin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["ideventoActual"=>$idevento]);
        $builder->whereNotIn("idestadoVin",[3]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }
    public function CountRegistroV2($idevento,$tipoFiltro,$filtro)
    {
        $builder=$this->db->table("vin");
        $builder->select("count(idvin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["ideventoActual"=>$idevento]);
        $builder->whereNotIn("vin.idestadoVin",[3]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function TipoCampoLavado()
    {
        $builder=$this->db->table("campolavado");
        return $builder->get()->getResultArray();
    }

    public function CopyCampoLavado($insertEvento)
    {
        $builder=$this->db->table("detallelavado");
        $builder->insert($insertEvento);
        return $this->db->insertID();
    }

    public function TipoProcesoEvento($filtro)
    {
        $builder=$this->db->table("evento");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailLavadoVin($filtro)
    {
        $builder=$this->db->table("detaillavadovin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateLavadoVin($filtro,$update)
    {
        $builder=$this->db->table("detallelavado");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

}