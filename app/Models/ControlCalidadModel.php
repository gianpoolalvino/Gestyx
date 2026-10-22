<?php

namespace App\Models;

use CodeIgniter\Model;

class ControlCalidadModel extends Model
{
    public function VerificarEquipamiento($filtro)
    {
        $builder=$this->db->table("equipamientocalidad");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageProcesoCalidad($storage)
    {
        $builder=$this->db->table("procesocalidad");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function ViewProcesoCalidad($filtro)
    {
        $builder=$this->db->table("procesocalidad");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CopyDetailFormCalidad()
    {
        $builder=$this->db->table("checkcalidaditem as cci");
        $builder->select("cci.idcheckCalidadItem,
                                cci.descripcion as checklist,
                                cci.idgrupocheckCalidad,
                                cci.idcheckCalidad");
        $builder->where(['cc.idestadoCheck'=>1,'cci.mostrar'=>1]);
        $builder->join("checkcalidad as cc","cc.idcheckCalidad = cci.idcheckCalidad");
        return $builder->get()->getResultArray();
    }

    public function StorageDetalleCalidad($storage)
    {
        $builder=$this->db->table("detallechecklistcalidad");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function EstadoCheckCalidad()
    {
        $builder=$this->db->table("estadocheckcalidad");
        return $builder->get()->getResultArray();
    }

    public function UpdateReporteCalidad($filtro,$reporteCalidad)
    {
        $builder=$this->db->table("procesocalidad");
        $builder->where($filtro);
        $builder->update($reporteCalidad);
        return $builder->get()->getResultArray();
    }
    //aqui me quede
    public function StorageLogCheckCalidad($storageCheck)
    {
        $builder=$this->db->table("logdetallechecklistcalidad");
        $builder->insert($storageCheck);
        return $this->db->insertID();
    }

    public function StorageLogEquipamientoCalidad($storageEquipamiento)
    {
        $builder=$this->db->table("logdetalleequipamientocalidad");
        $builder->insert($storageEquipamiento);
        return $this->db->insertID();
    }

    public function GrupoCheckCC()
    {
        $builder=$this->db->table("grupocheckcc");
        return $builder->get()->getResultArray();
    }

    public function DetalleCheckCalidad($filtro)
    {
        $builder=$this->db->table("checkviewecalidad");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function UpdateEquipamientoCalidad($filtro,$equipamiento)
    {
        $builder=$this->db->table("detalleequipamientocalidad");
        $builder->where($filtro);
        return $builder->update($equipamiento);
    }

    public function UpdateDetalleCheckCalidad($filtroCheck,$checkCalidad)
    {
        $builder=$this->db->table("detallechecklistcalidad");
        $builder->where($filtroCheck);
        return $builder->update($checkCalidad);
    }

    public function UpdateDetalleCheckCalidadv2($idcheckCalidad, $checkCalidad)
    {
        // Preparar la llamada al procedimiento almacenado
        $query = "CALL UpdateCheckCalidadProc(
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Pasamos los parámetros que ya están en el controlador
        $params = [
            $idcheckCalidad, // idcheckCalidad
            $checkCalidad[0],                   // estado
            $checkCalidad[1],              // comentarios
            $checkCalidad[2],                    // fecha
            $checkCalidad[3],                     // hora
            isset($checkCalidad[4]) ? $checkCalidad[4] : null, // rutaImagen
            isset($checkCalidad[5]) ? $checkCalidad[5] : null, // idtipoCarga
            isset($checkCalidad[6]) ? $checkCalidad[6] : null, // nombreImagen
            isset($checkCalidad[7]) ? $checkCalidad[7] : null, // tipoImagen
            isset($checkCalidad[8]) ? $checkCalidad[8] : null, // fechaCarga
            isset($checkCalidad[9]) ? $checkCalidad[9] : null // horaCarga
        ];
        // Ejecutar el procedimiento
        $result = $this->db->query($query, $params);
        // Si la ejecución es exitosa, devolvemos true, de lo contrario, false
        if ($result) {
            return true; // Puede devolver algún resultado si es necesario
        } else {
            return false; // Si hubo un error, retornamos false
        }
    }

    public function StorageDetalleCheckCalidad($checkCalidad)
    {
        $builder=$this->db->table("detallechecklistcalidad");
        $builder->insert($checkCalidad);
        return $this->db->insertID();
    }

    public function StorageEquipamientoCalidad($insert)
    {
        $builder=$this->db->table("detalleequipamientocalidad");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function EquipamientoCalidad($filtro)
    {
        $builder=$this->db->table("equipamientocalidaddet");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function CheckListCalidad($filtro)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("detalleprocesocalidadview");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function TipoCheckCalidad()
    {
        $builder=$this->db->table("checkcalidad");
        return $builder->get()->getResultArray();
    }

    public function CheckListCalidadDinamico($filtro)
    {
        $this->db->simpleQuery('SET SESSION group_concat_max_len=99999999999999999');
        $builder=$this->db->table("vw_detalleprocesocalidad_dinamico");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
}