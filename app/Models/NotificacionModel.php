<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificacionModel extends Model
{
    public function DetailNotificacion()
    {
        $builder = $this->db->table("loggeneral as lg");
        $builder->select("CONCAT(IFNULL(us.nombres,''),' ',IFNULL(us.primerApellido,''),' ',IFNULL(us.segundoApellido,'')) as nombreUsuario,
                                lg.vin,
                                lg.eventoRealizado,
                                lg.eventoNuevo,
                                lg.fechaHoraEvento");
        $builder->join("usuario as us","us.idusuario = lg.idusuario");
        $builder->limit(10);
        $builder->orderBy("lg.fechaHoraEvento","desc");
        return $builder->get()->getResultArray();
    }
}