<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessModel extends Model
{
    public function UserExist($search)
    {
        $builder = $this->db->table("usuariosexistentes");
        $builder->where($search);
        return $builder->get()->getResultArray();
    }

    public function ValidadorAccess($filtro)
    {
        $builder = $this->db->table("vwvalidadoruser");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ValidarAccessSubModulo($filtro)
    {
        $builder = $this->db->table("usuariosubmodulo");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function NavBarRol($idusuario,$tipoAccess)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL getModuloDataByUser(?, ?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$idusuario, $tipoAccess]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function NavBar($idusuario='')
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("navbar");
        $builder->where(["idusuario"=>$idusuario]);
        return $builder->get()->getResultArray();
    }

    public function AgenciaRolNew($filtro)
    {
        $builder=$this->db->table("vw_sedeusuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function AgenciaRol($filtro)
    {
        $builder=$this->db->table("rolagencia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function GrupoUbicacionRol($filtro)
    {
        $builder=$this->db->table("usuariogrupoubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function MarcaRol($filtro)
    {
        $builder=$this->db->table("usuariomarca");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function BodegaRolNew($filtro)
    {
        $builder=$this->db->table("vw_usuariobodega");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function BodegaRol($filtro)
    {
        $builder=$this->db->table("bodegausuario");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}