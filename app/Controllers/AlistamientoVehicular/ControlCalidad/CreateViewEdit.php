<?php

namespace App\Controllers\AlistamientoVehicular\ControlCalidad;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;

class CreateViewEdit extends BaseController
{

    public function CreateEquipamiento()
    {
        $idequipamientoCalidad=$_POST["idequipamientoCalidad"];
        $controlCalidad=New ControlCalidadModel();

        $filtro=[
            'iddetalleEquipamientoCalidad'=>$idequipamientoCalidad
        ];

        $dats=[
            'idequipamientoCalidad'=>$idequipamientoCalidad,
            'equipamientoCalidad'=>$controlCalidad->EquipamientoCalidad($filtro),
            'estadoCheckCalidad'=>$controlCalidad->EstadoCheckCalidad(),
            'vin'=>$_POST["vin"]
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/CreateEquipamiento/Index",$dats).view("AlistamientoVehicular/ControlCalidad/CreateEquipamiento/Scripts")
        ];

        echo json_encode($dato);
    }

    public function UpdateCheckCalidad()
    {
        $idcheckCalidad=$_POST["idcheckCalidad"];
        $controlCalidad=New ControlCalidadModel();

        $filtro=[
            'iddetalleCheckListCalidad'=>$idcheckCalidad
        ];


        $dats=[
            'idcheckCalidad'=>$idcheckCalidad,
            'estadoCheckCalidad'=>$controlCalidad->EstadoCheckCalidad(),
            'checkCalidad'=>$controlCalidad->DetalleCheckCalidad($filtro),
            'vin'=>$_POST["vin"]
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/UpdateCheckCalidadDinamico/Index",$dats).view("AlistamientoVehicular/ControlCalidad/UpdateCheckCalidadDinamico/Scripts")
        ];
        echo json_encode($dato);
    }

    public function CreateCheckCalidad()
    {
        $idcheckCalidad=$_POST["idcheckCalidad"];
        $controlCalidad=New ControlCalidadModel();

        $filtro=[
            'iddetalleCheckListCalidad'=>$idcheckCalidad
        ];


        $dats=[
            'idcheckCalidad'=>$idcheckCalidad,
            'estadoCheckCalidad'=>$controlCalidad->EstadoCheckCalidad(),
            'checkCalidad'=>$controlCalidad->DetalleCheckCalidad($filtro),
            'vin'=>$_POST["vin"]
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/CreateCheckCalidad/Index",$dats).view("AlistamientoVehicular/ControlCalidad/CreateCheckCalidad/Scripts")
        ];
        echo json_encode($dato);
    }

    public function CreateCheckCalidadDinamico()
    {
        $idgrupoCalidad=$_POST["idgrupoCalidad"];
        $controlCalidad=New ControlCalidadModel();

        $dats=[
            'idgrupoCheckCalidad'=>$idgrupoCalidad,
            'estadoCheckCalidad'=>$controlCalidad->EstadoCheckCalidad(),
            'vin'=>$_POST["vin"],
            'idprocesoCalidad'=>$_POST["idprocesoCalidad"],
            'idgrupoCalidad'=>$idgrupoCalidad
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/CreateCheckCalidadDinamico/Index",$dats).view("AlistamientoVehicular/ControlCalidad/CreateCheckCalidadDinamico/Scripts")
        ];

        echo json_encode($dato);
    }

    public function CopyCreateForm($idprocesoCalidad='',$vin='',$idtipoProceso='')
    {
        $controlCalidad=New ControlCalidadModel();
        $alistamiento=New AlistamientoVehicularModel();

        $detailEquipamiento=$alistamiento->EquipamientoVin($vin);

        foreach($detailEquipamiento as $det){
            $idequipamientoVin=$det["idequipamientoVin"];
            $storaCEq=[
                'idprocesoCalidad'=>$idprocesoCalidad,
                'idequipamientoVin'=>$idequipamientoVin,
                'idestado'=>3
            ];
            $strEq=$controlCalidad->StorageEquipamientoCalidad($storaCEq);
        }
        if($idtipoProceso==1){
            $detailForm=$controlCalidad->CopyDetailFormCalidad();
            foreach($detailForm as $dt){
                $idcheckCalidadItem=$dt["idcheckCalidadItem"];
                $storage=[
                    'idcheckCalidadItem'=>$idcheckCalidadItem,
                    'estado'=>3,
                    'idgrupoCheckCalidad'=>$dt["idgrupocheckCalidad"],
                    'idprocesoCalidad'=>$idprocesoCalidad
                ];
                $stor=$controlCalidad->StorageDetalleCalidad($storage);
            }
        }
    }

    public function DetailCreateEquipamientoCalidad()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $controlCalidad=new ControlCalidadModel();
        $agenciaProveedor=new AgenciaProveedorModel();
        $idprocesoCalidad=$_POST["idprocesoCalidad"];
        $vin=$_POST["vin"];

        $filter=[
            'idprocesoCalidad'=>$idprocesoCalidad
        ];

        $dats=[
            'equipamientoInstalado'=>$controlCalidad->EquipamientoCalidad($filter),
            'vin'=>$vin,
            'idprocesoCalidad'=>$idprocesoCalidad
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/DetailCreateEquipamientoCalidad/Index",$dats).view("AlistamientoVehicular/ControlCalidad/DetailCreateEquipamientoCalidad/Scripts")
        ];

        echo json_encode($dato);
        exit();

    }

    public function DetailCreateCheckCalidad()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $controlCalidad=new ControlCalidadModel();
        $agenciaProveedor=new AgenciaProveedorModel();

        $idgrupoPrincipal=$_POST["idgrupoCheckCC"];
        $idprocesoCalidad=$_POST["idprocesoCalidad"];

        $tipoCheck=$controlCalidad->TipoCheckCalidad();

        $filterGcc=[
            'idprocesoCalidad'=>$idprocesoCalidad,
            'idgrupoCheckCalidad'=>$idgrupoPrincipal
        ];
        $detail=[];
        if($tipoCheck[0]["idtipoCheckCalidad"]==1){
            $detail=$controlCalidad->CheckListCalidad($filterGcc);
        }else{
            $detail=$controlCalidad->CheckListCalidadDinamico($filterGcc);
        }

        $dats=[
            'detalleCalidad'=>$detail,
            'idgrupoCheckCalidad'=>$idgrupoPrincipal,
            'idprocesoCalidad'=>$idprocesoCalidad,
            'vin'=>$_POST["vin"],
            'tipoProceso'=>$tipoCheck[0]["idtipoCheckCalidad"]
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/DetailCreateCheckCalidad/Index",$dats).view("AlistamientoVehicular/ControlCalidad/DetailCreateCheckCalidad/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }

    public function Create()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $controlCalidad=new ControlCalidadModel();
        $agenciaProveedor=new AgenciaProveedorModel();

        $vin=$_POST["vin"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);

        $tipoCheck=$controlCalidad->TipoCheckCalidad();

        $insertCalidad=[
            'vin'=>$_POST["vin"],
            'idestadoProceso'=>1,
           // 'idusuario'=>session("idusuario")
        ];

        $calidad=$controlCalidad->ViewProcesoCalidad($insertCalidad);
        $idprocesoCalidad='';
        if($calidad){
            $idprocesoCalidad=$calidad[0]["idprocesoCalidad"];
        }else{
            $idprocesoCalidad=$controlCalidad->StorageProcesoCalidad($insertCalidad);

                $result = $this->CopyCreateForm($idprocesoCalidad, $vin,$tipoCheck[0]["idtipoCheckCalidad"]);

        }

        $filter=[
            'idprocesoCalidad'=>$idprocesoCalidad
        ];

        $grupoCheckCC=$controlCalidad->GrupoCheckCC();
        $contadorGcc=1;
        $idgrupoPrincipal='';
        foreach($grupoCheckCC as $gcc){
            if($contadorGcc==1){
                $idgrupoPrincipal=$gcc["idgrupoCheckCalidad"];
            }
            $contadorGcc++;
        }

        $filterGcc=[
            'idprocesoCalidad'=>$idprocesoCalidad,
            'idgrupoCheckCalidad'=>$idgrupoPrincipal
        ];
        $detail=[];
        if($tipoCheck[0]["idtipoCheckCalidad"]==1){
            $detail=$controlCalidad->CheckListCalidad($filterGcc);
        }else{
            $detail=$controlCalidad->CheckListCalidadDinamico($filterGcc);
        }


        $dats=[
            'equipamientoInstalado'=>$controlCalidad->EquipamientoCalidad($filter),
            'grupoCheckCC'=>$controlCalidad->GrupoCheckCC(),
            'detalleCalidad'=>$detail,
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'idgrupoCheckCalidad'=>$idgrupoPrincipal,
            'vin'=>$vin,
            'idprocesoCalidad'=>$idprocesoCalidad,
            'tipoProceso'=>$tipoCheck[0]["idtipoCheckCalidad"]
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/ControlCalidad/Create/Index",$dats).view("AlistamientoVehicular/ControlCalidad/Create/Scripts",$dats)
        ];

        echo json_encode($dato);
        exit();
    }
}