<?php

namespace App\Models;

use CodeIgniter\Model;

class VinModel extends Model
{

    public function StorageVinCreadoModulo($storage)
    {
        $builder=$this->db->table("creavinsinerp");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageVinCreado($storage)
    {
        $builder=$this->db->table("vin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function SelectMarcaVehiculo($filtro)
    {
        $builder=$this->db->table('vin');
        $builder->select('codigoMarca, marca');
        $builder->DISTINCT();
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function SelectBodegaVehiculo($filtro)
    {
        $builder=$this->db->table('vin');
        $builder->select('codigoBodega,bodega');
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function MarcaVehiculo()
    {
        $builder=$this->db->table('vin');
        $builder->select('codigoMarca, marca');
        $builder->DISTINCT();
        return $builder->get()->getResultArray();
    }

    public function ModeloVehiculo($filtro)
    {
        $builder=$this->db->table('vin');
        $builder->select('codigoModelo, modelo');
        $builder->DISTINCT();
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ColorVehiculo($filtro)
    {
        $builder=$this->db->table('vin');
        $builder->select('codigoColor, color');
        $builder->DISTINCT();
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function VinPermitidosSolicitud($filtro)
    {
        $builder=$this->db->table("vin");
        $builder->whereIn('idestadoVin',[1,2,4,6]);
        if($filtro!=''){
            $builder->where($filtro);
        }
        return $builder->get()->getResultArray();
    }
    public function VinPermitidos($ubicacion)
    {
        $builder=$this->db->table("vinubicacion");
        $builder->whre(["ubicacionActual"=>$ubicacion]);
      //  $builder->whereIn('idestadoVin',[1,2,4]);
        return $builder->get()->getResultArray();
    }

    public function VinSelect($search)
    {
        $builder=$this->db->table("vw_select_vin_auditoria");
        $builder->like("vin",$search);
        $builder->orLike("marca",$search);
        $builder->orLike("modelo",$search);
        $builder->orLike("color",$search);
        return $builder->get()->getResultArray();
    }

    public function VinEventosRealizados($vin)
    {
        // SQL para llamar al procedimiento almacenado
        $sql = "CALL get_eventos_realizados(?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function VinDisponiblesAgenda()
    {
        $builder=$this->db->table("vinporagendar");
        return $builder->get()->getResultArray();
    }

    public function VinInfo($vin)
    {
        $builder=$this->db->table("vin");
        $builder->where(["vin"=>$vin]);
        return $builder->get()->getResultArray();
    }

    public function VinInfoMasivo($filtro,$idubicacion)
    {
        $builder=$this->db->table("vin");
        $builder->where(["idubicacion"=>$idubicacion]);
        $builder->whereIn("vin",$filtro);
        return $builder->get()->getResultArray();
    }

    public function VinValidoMasivo($filtro)
    {
        $builder=$this->db->table("vin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function VinUbicacion($filtro)
    {
        $builder=$this->db->table("vinubicacion");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function VinAgencia($filtro)
    {
        $builder=$this->db->table("vinagencia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageSeminuevo($storage)
    {
        $builder=$this->db->table("seminuevovin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function UpdateVin($filtroUpdate,$updateVin)
    {
        $builder=$this->db->table("vin");
        $builder->where($filtroUpdate);
        $builder->update($updateVin);
        return $builder->get()->getResultArray();
    }
}