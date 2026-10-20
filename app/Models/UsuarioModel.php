<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    public function ListGerente()
    {
        $builder = $this->db->table("usuario");
        $builder->where(["gerente"=>1]);
        return $builder->get()->getResultArray();
    }

    public function getAllUsuarios()
    {
        $builder = $this->db->table("usuario");
        $builder->where(["idestadoUsuario"=>1]);
        return $builder->get()->getResultArray();
    }

    public function SearchIpValida($filtro)
    {
        $builder = $this->db->table("logingreso");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectTipoSolicitud()
    {
        $builder = $this->db->table("tiposolicitud");
        return $builder->get()->getResultArray();
    }

    public function DupliSedeUsuario($filtro)
    {
        $builder = $this->db->table("usuariosede");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DupliBodega($filtro)
    {
        $builder = $this->db->table("usuariobodega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DupliGrupUbi($filtro)
    {
        $builder = $this->db->table("usuariogrupoubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DupliRol($filtro)
    {
        $builder = $this->db->table("rol");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewUsuario($filtro)
    {
        $builder = $this->db->table("usuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectEmpresa()
    {
        $builder = $this->db->table("empresa");
        return $builder->get()->getResultArray();
    }

    public function SelectBodega($filtro,$idusuario)
    {
        $builder = $this->db->table("bodega as bg");
        if($filtro!=''){
            $builder->where($filtro);
        }
        $builder->where('NOT EXISTS (
            SELECT 1 
            FROM usuariobodega as sb 
            WHERE sb.idusuario = '.$idusuario.' AND sb.idbodega = bg.idbodega
        )');
        return $builder->get()->getResultArray();
    }

    public function SelectGrupoUbicacion($filtro,$idusuario)
    {
        $builder = $this->db->table("grupoubicacion as ub");
        if($filtro!=''){
            $builder->where($filtro);
        }
        $builder->where('NOT EXISTS (
            SELECT 1 
            FROM usuariogrupoubicacion as ubs 
            WHERE ubs.idusuario = '.$idusuario.' AND ubs.idgrupoUbicacion = ub.idgrupoUbicacion
        )');
        return $builder->get()->getResultArray();
    }

    public function DuplicateSolicitud($create)
    {
        $builder = $this->db->table("tiposolicitudusuario");
        $builder->where($create);
        return $builder->get()->getResultArray();
    }

    public function DestroyTipoSolicitud($filtro)
    {
        $builder=$this->db->table("tiposolicitudusuario");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailTipoSolicitud($filtro)
    {
        $builder = $this->db->table("vw_solicitudusuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageTipoSolicitud($create)
    {
        $builder=$this->db->table("tiposolicitudusuario");
        $builder->insert($create);
        return $this->db->insertID();
    }

    public function SelectAgencia($filtro,$idusuario)
    {
        $builder = $this->db->table("agencia as ag");
        if($filtro!=''){
            $builder->where($filtro);
        }
        $builder->where('NOT EXISTS (
            SELECT 1 
            FROM usuariosede as sd 
            WHERE sd.idusuario = '.$idusuario.' AND sd.idagencia = ag.idagencia
        )');
        return $builder->get()->getResultArray();
    }

    public function ListGrupoModulo($filtro,$idusuario)
    {
        $builder = $this->db->table("grupomodulo as gmd");
        if($filtro!=''){
            $builder->where($filtro);
        }
        $builder->where('NOT EXISTS (SELECT 1 FROM rol as rl WHERE rl.idgrupoModulo = gmd.idgrupoModulo AND rl.idusuario = '.$idusuario.')');
        return $builder->get()->getResultArray();
    }

    public function SelectModulo($filtro,$idusuario)
    {
        $builder = $this->db->table("modulo as md");
        if($filtro!=''){
            $builder->where($filtro);
        }
        $builder->where('NOT EXISTS (SELECT 1 FROM rol as rl WHERE rl.idmodulo = md.idmodulo AND rl.idusuario = '.$idusuario.')');
        return $builder->get()->getResultArray();
    }

    public function StorageUbicacion($insert)
    {
        $builder=$this->db->table("usuariogrupoubicacion");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function StorageBodega($insert)
    {
        $builder=$this->db->table("usuariobodega");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function StorageAgencia($insert)
    {
        $builder=$this->db->table("usuariosede");
        $builder->insert($insert);
        return $this->db->insertID();
    }


    public function Modulo($filtro)
    {
        $builder=$this->db->table("modulo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function BodegaUsuario($filtro)
    {
        $builder=$this->db->table("vw_usuariobodega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function AgenciaUsuario($filtro)
    {
        $builder=$this->db->table("vw_sedeusuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UbicacionUsuario($filtro)
    {
        $builder=$this->db->table("vw_ubicacionusuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewUserConfig($filtro)
    {
        $builder = $this->db->table("vw_usuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageUsuario($storage)
    {
        $builder=$this->db->table("usuario");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function GrupoModulo($filtro)
    {
        $builder = $this->db->table("vw_grupo_modulo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailIndexUsuario($filtro)
    {
        $builder = $this->db->table("vw_usuario");
        if($filtro!=''){
            $builder->like('nombres',$filtro);
            $builder->orLike('primerApellido',$filtro);
            $builder->orLike('segundoApellido',$filtro);
            $builder->orLike('email',$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailViewUsuario($tipoFiltro,$filtro)
    {
        $builder = $this->db->table("vw_usuario");
        if($tipoFiltro!=''){
            $builder->like($tipoFiltro,$filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DetailRegionUser($filtro)
    {
        $builder=$this->db->table("usuarioregion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailGrupoModulo($filtro)
    {
        $builder=$this->db->table("vw_detailgrupomodulo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageRol($insert)
    {
        $builder=$this->db->table("rol");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function ListRegion()
    {
        $builder=$this->db->table("region");
        return $builder->get()->getResultArray();
    }

    public function DestroyUbicacion($filtro)
    {
        $builder=$this->db->table("usuariogrupoubicacion");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }
    public function DestroyAgencia($filtro)
    {
        $builder=$this->db->table("usuariosede");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function DestroyBodega($filtro)
    {
        $builder=$this->db->table("usuariobodega");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function DestroyRol($filtro)
    {
        $builder=$this->db->table("rol");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectGrupoModulo($filter)
    {
        $builder=$this->db->table("grupomodulo");
        if($filter!=''){
            $builder->where($filter);
        }
        return $builder->get()->getResultArray();
    }

    public function ListModulo($filtro)
    {
        $builder=$this->db->table("modulo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateUsuario($filtro,$usuario)
    {
        $builder=$this->db->table("usuario");
        $builder->where($filtro);
        $builder->update($usuario);
        return $builder->get()->getResultArray();
    }

}