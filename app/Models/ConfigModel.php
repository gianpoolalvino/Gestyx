<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{

    public function StorageGrupoUbicacion($storage)
    {
        $builder=$this->db->table("grupoubicacion");
        $builder->insert($storage);
        return $this->db->insertID();
    }
    public function UpdateGrupoUbicacion($filtroUpdate,$update)
    {
        $builder=$this->db->table("grupoubicacion");
        $builder->where($filtroUpdate);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
    public function ViewGrupoUbicacion($filtro)
    {
        $builder=$this->db->table("grupoubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function DestroyBoxUbicacion($filtro)
    {
        $builder=$this->db->table("boxubicacion");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }
    public function DestroyUbicacion($filtro)
    {
        $builder=$this->db->table("ubicacion");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }
    public function StorageBoxUbicacion($storage)
    {
        $builder=$this->db->table("boxubicacion");
        $builder->insert($storage);
        return $this->db->insertID();
    }


    public function StorageUbicacion($storage)
    {
        $builder=$this->db->table("ubicacion");
        $builder->insert($storage);
        return $this->db->insertID();
    }
    public function MultipleProcedimiento($filtro)
    {
        $tipo = $filtro['tipo'] ?? null;
        $nombre = $filtro['nombre'] ?? null;
        $idgrupoUbicacion = $filtro['idgrupoUbicacion'] ?? null;
        $idubicacion = $filtro['idubicacion'] ?? null;
        $idboxUbicacion = $filtro['idboxUbicacion'] ?? null;

        $sql = "CALL sp_listarUbicacionesoBox(?,?,?,?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$tipo,$nombre,$idgrupoUbicacion,$idubicacion,$idboxUbicacion]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function UpdateUbicacion($filtro,$update)
    {
        $builder=$this->db->table("ubicacion");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function UpdateBoxUbicacion($filtro,$update)
    {
        $builder=$this->db->table("boxubicacion");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }
}