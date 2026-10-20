<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuloModel extends Model
{
    public function SubModuloold($filtro)
    {
        $builder=$this->db->table("vw_submodulodetail");
        $builder->where($filtro);
      //  $builder->where(["estado"=>1]);
        return $builder->get()->getResultArray();
    }

    public function SubModulo($idusuario,$idmodulo)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL ObtenerSubModulosPorUsuario(?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$idusuario,$idmodulo]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }



    public function SaveSubModuloUsuario($filtro)
    {
        $builder=$this->db->table("usuariosubmodulo");
        $builder->insert($filtro);
        return $this->db->insertID();
    }

    public function DestroySubModuloUsuario($filtro)
    {
        $builder = $this->db->table("usuariosubmodulo");
        $builder->where($filtro);
        return $builder->delete();
    }
}