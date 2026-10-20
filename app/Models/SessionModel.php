<?php
namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{
   public function SaveSessions($insert)
   {
       $builder=$this->db->table("sessions");
       $builder->insert($insert);
       return $this->db->insertID();
   }

   public function ViewSessionUser($filtro)
   {
       $builder=$this->db->table("sessions");
       $builder->where($filtro);
       return $builder->get()->getResultArray();
   }

   public function DestroySessions($filtro)
   {
       $builder=$this->db->table("sessions");
       $builder->delete($filtro);
       return $builder->get()->getResultArray();
   }
}