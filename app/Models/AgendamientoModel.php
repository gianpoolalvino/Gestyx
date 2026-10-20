<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendamientoModel extends Model
{
    public function HorarioAgendamiento($filtro)
    {
        $builder=$this->db->table("horariosvigentes");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewCitaEntrega($filtro)
    {
        $builder=$this->db->table("citasagendado");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }


    public function DetailCitaMisAgendados($tipoFiltro,$filtro,$limit,$start,$idusuario)
    {
        $builder=$this->db->table("citasagendado");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["idasesorEntrega"=>$idusuario]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");
        if($tipoFiltro=='') {
            $builder->limit($limit, $start);
        }
        return $builder->get()->getResultArray();
    }

    public function CountRegMisAgendados($tipoFiltro,$filtro,$idusuario)
    {
        $builder=$this->db->table("citasagendado");
        $builder->select("count(vin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->where(["idasesorEntrega"=>$idusuario]);
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailCitaAgendadoExcel($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("citasagendado");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailCitaAgendado($tipoFiltro,$filtro,$limit,$start)
    {
        $builder=$this->db->table("citasagendado");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        $builder->orderBy("vin","desc");

        return $builder->get()->getResultArray();
    }

    public function CitaEntregaVin($vin)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL getCitaEntrega(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function CountRegAgendado($tipoFiltro,$filtro)
    {
        $builder=$this->db->table("citasagendado");
        $builder->select("count(vin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function SelectAgencia()
    {
        $builder=$this->db->table("agencia");
        return $builder->get()->getResultArray();
    }

    public function AgenciaAsesor($filtro)
    {
        $builder=$this->db->table("asesorentrega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdatePlacaRotativa($filtro,$placa)
    {
        $builder=$this->db->table("placarotativa");
        $builder->where($filtro);
        $builder->update($placa);
        return $builder->get()->getResultArray();
    }

    public function DetailListosParaAgendar($tipoFiltro,$filtro,$limit,$start,$tipoCartera)
    {
        $builder=$this->db->table("listosparaagendar");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoCartera==1){
            $builder->where(["liberado"=>1]);
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

    public function CountRegListosParaAgendar($tipoFiltro,$filtro,$tipoCartera)
    {
        $builder=$this->db->table("listosparaagendar");
        $builder->select("count(vin) as contadorTotal");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        if($tipoCartera==1){
            $builder->where(["liberado"=>1]);
        }
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function UpdateHorarioAsesor($filtro,$horario)
    {
        $builder=$this->db->table("horarioasesor");
        $builder->where($filtro);
        $builder->update($horario);
        return $builder->get()->getResultArray();
    }

    public function AsesorRegionEntrega($filtro)
    {
        $builder=$this->db->table("asesorentrega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function HorarioDisponibleAsesor($filtro)
    {
        $builder=$this->db->table("horariodisponibleasesor");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function HorarioAsesor($filtro)
    {
        $builder=$this->db->table("horarioasesor");
        $builder->where($filtro);
        $builder->orderBy("horaAgenda","asc");
        return $builder->get()->getResultArray();
    }

    public function CountHorarioAsesor($filtro)
    {
        $builder=$this->db->table("horarioasesor");
        $builder->select("count(idhorarioAsesor) as contador");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function PlacaRotativa($filtro)
    {
        $builder=$this->db->table("placarotativa");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function HorariosAsesor($filtro)
    {
        $builder=$this->db->table("agendaasesorv2");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function HorarioAsesorVer5($params)
    {
        // Extraer los valores del array
        $fecha = isset($params['fecha']) ? $params['fecha'] : null;
        $idasesor = isset($params['idasesor']) ? $params['idasesor'] : null;
        $idtipoDia = isset($params['idtipoDia']) ? $params['idtipoDia'] : null;
        $hora=isset($params["horaAgenda"]) ? $params['horaAgenda'] : '';

        $builder = $this->db->table("horariosvigentes as hr");
        $builder->select("hr.iddiaHorarioAgendamiento,
                                hr.idtipoDia,
                                hr.descripcion,
                                hr.numeroDia,
                                hr.nombre,
                                hr.estado,
                                hr.hora as horaAgenda");
        // Subconsulta como string
        $subquery = $this->db->table('vw_horario_asesor as hs')
            ->select('*')
            ->where('hr.hora >= hs.horaAgendaInicio')
            ->where('hr.hora <= DATE_SUB(hs.horaAgendaFin, INTERVAL 30 MINUTE)')
            ->where('hs.fecha', $fecha)
            ->where('hs.idasesor', $idasesor)
            ->getCompiledSelect(); // Compila la subconsulta

        // Aplicar la condición NOT EXISTS usando whereRaw
        $builder->where("NOT EXISTS ($subquery)");
        if($hora!=''){
            $builder->where(["hr.hora>"=>$hora]);
        }


        // Condición adicional
        if ($idtipoDia !== null) {
            $builder->where('hr.idtipoDia', $idtipoDia);
        }

        return $builder->get()->getResultArray();
    }
    public function StorageHorarioGeneralAsesor($insert)
    {
        $builder=$this->db->table("horarioasesor");
        $builder->insert($insert);
        $idequipamiento=$this->db->insertID();
        return $idequipamiento;
    }

    public function AsesorEntrega()
    {
        $builder=$this->db->table("usuario");
        $builder->where(["idtipoUsuario"=>3,"estadoUsuario"=>1]);
        return $builder->get()->getResultArray();
    }

    public function HorariosOcupados($filtro)
    {
        $builder=$this->db->table("vw_horario_asesor");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function AsesorEntregaNew()
    {
        $builder=$this->db->table("asesorentrega");
        $builder->distinct("idusuario,nombreAsesor,ordenAgenda");
        $builder->select("idusuario,nombreAsesor,ordenAgenda");
        $builder->orderBy("ordenAgenda","asc");
        return $builder->get()->getResultArray();
    }
}