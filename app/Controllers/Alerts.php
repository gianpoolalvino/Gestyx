<?php

namespace App\Controllers;

use App\Models\AccessModel;
use App\Models\SessionModel;

class Alerts extends BaseController
{
    public function LogOutRemoto()
    {
        $dato=[
            'title'=>$_POST["title"],
            'message'=>$_POST["message"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Alerts/LogOutRemoto/Index",$dato).view("Alerts/LogOutRemoto/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}