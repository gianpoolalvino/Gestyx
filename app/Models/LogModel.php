<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    public function Savelog($storageLog)
    {
        $builder = $this->db->table("logscarga");
        $builder->insert($storageLog);
        return $this->db->insertID();
    }
}