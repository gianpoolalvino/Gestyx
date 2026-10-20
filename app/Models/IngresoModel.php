<?php

namespace App\Models;

use CodeIgniter\Model;

class IngresoModel extends Model
{
    public function ViewPanelDuaf($filtro)
    {
        $builder = $this->db->table("duafingreso");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }
    public function SelectVinPendiente()
    {
        $builder = $this->db->table("vinpendienteingreso");
        return $builder->get()->getResultArray();
    }

    public function SelectVinIngreso()
    {
        $builder = $this->db->table('vw_ingreso_vin_detail');
        return $builder->get()->getResultArray();

    }

    public function ResultadoEquipamiento($filtro)
    {
        $builder = $this->db->table("vw_checkequipamientoingreso");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }


    public function ViewIngresoVin($filtroIngreso)
    {
        $vin = $filtroIngreso['vin'] ?? null;
        $idingresoVin = $filtroIngreso['idingresoVin'] ?? null;
        $sql = "CALL sp_vin_ingreso_view(?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin,$idingresoVin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function DetailReporteIngresoExcelFecha($vinFilt)
    {
        $builder=$this->db->table("vw_reporte_ingreso_vin");
        $builder->whereIn('vin',$vinFilt);
        return $builder->get()->getResultArray();
    }

    public function DeleteReporteTemporal($filtro)
    {
        $builder = $this->db->table("detallereporteingresovin");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function DetailReporteTemporal($filtro)
    {
        $builder=$this->db->table("detallereporteingresovin");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function DetailReporteIngresoExcel($vinFilt)
    {
        $builder=$this->db->table("vw_reporte_picking");
        $builder->whereIn('vin',$vinFilt);
        return $builder->get()->getResultArray();
    }

    public function StorageVinReporte($insert)
    {
        $builder=$this->db->table("detallereporteingresovin");
        $builder->insert($insert);
        return $this->db->insertID();
    }

    public function CheckFormularioEquipamiento()
    {
        $builder=$this->db->table("checkingresovin");
        return $builder->get()->getResultArray();
    }

    public function DetailVinIngresados()
    {
        $builder = $this->db->table('vw_ingreso_vin');
        return $builder->get()->getResultArray();
    }

    public function DetailAddReporte($filtro)
    {
        $builder = $this->db->table('vw_ingreso_vin_detail');
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }


    public function DetailIngresoVin($tipoFiltros, $filtro, $selectAvanzado, $tipoSelectAvanzado, $searchAvanzado,$filtroFechas)
    {
        // Utilizar el Query Builder
        $builder = $this->db->table('vw_ingreso_vin_detail');
        // Aplicar filtros avanzados
        if($selectAvanzado!=''){
            foreach ($selectAvanzado as $index => $rowSelects) {
                foreach ($rowSelects as $i => $selectValue) {
                    if (!empty($selectValue) && !empty($searchAvanzado[$index][$i])) {
                        $tipo = $tipoSelectAvanzado[$index][$i];
                        $searchValue = $searchAvanzado[$index][$i];
                        switch ($tipo) {
                            case 'igual':
                                $builder->where($selectValue, $searchValue);
                                break;
                            case 'diferente':
                                $builder->notLike($selectValue, $searchValue);
                                break;
                            case 'like':
                                $builder->like($selectValue, $searchValue);
                                break;
                            case 'orlike':
                                $builder->orlike($selectValue, $searchValue);
                                break;
                        }
                    }
                }
            }
        }
        // Aplicar filtros adicionales
        if($filtro!=''){
            $builder->groupStart(); // Inicio del grupo de condiciones
            foreach ($tipoFiltros as $tf) {
                $builder->orLike($tf['campo'], $filtro);
            }
            $builder->groupEnd(); // Fin del grupo de condiciones
        }
        $builder->where($filtroFechas);
        // Ejecutar la consulta y devolver resultados
        return $builder->get()->getResultArray();
    }

    public function UploadImagenVehiculo($filtro,$update)
    {
        $builder=$this->db->table("detalleingresovehiculoimagen");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function SelectTipoDanho()
    {
        $builder=$this->db->table("tipodanhovin");
        return $builder->get()->getResultArray();
    }

    public function SelectNivelDanho()
    {
        $builder=$this->db->table("severidaddanhovin");
        return $builder->get()->getResultArray();
    }

    public function SelectAreaDanho()
    {
        $builder=$this->db->table("areadanhovin");
        return $builder->get()->getResultArray();
    }

    public function SelectReparacion()
    {
        $builder=$this->db->table("reparacionvin");
        return $builder->get()->getResultArray();
    }

    public function SelectSubAreaDanho()
    {
        $builder=$this->db->table("subareadanhovin");
        return $builder->get()->getResultArray();
    }

    public function DetailIngresoVin_old($tipoFiltros,$filtro,$selectAvanzado,$tipoSelectAvanzado,$searchAvanzado)
    {
        $builder=$this->db->table("vw_ingreso_vin");
        if($selectAvanzado!=''){
            foreach ($selectAvanzado as $index => $rowSelects) {
                foreach ($rowSelects as $i => $selectValue) {
                    if (!empty($selectValue) && !empty($searchAvanzado[$index][$i])) {
                        $tipo = $tipoSelectAvanzado[$index][$i];
                        $searchValue = $searchAvanzado[$index][$i];
                        if($tipo=='igual'){
                            $builder->where([$selectValue=>$searchValue]);
                        }else if($tipo=='diferente'){
                            $builder->notLike($selectValue,$searchValue);
                        }else if($tipo=='like'){
                            $builder->like($selectValue,$searchValue);
                        }
                    }
                }
            }
        }
        if($filtro!=''){
            foreach($tipoFiltros as $tf){
                $builder->orLike($tf["campo"],$filtro);
            }
        }
        return $builder->get()->getResultArray();
    }

    public function CheckImagenIngreso()
    {
        $builder = $this->db->table('checkimageningresovin');
        return $builder->get()->getResultArray();
    }

    public function FormularioImagen($filtroImgen)
    {
        $vin = $filtroImgen['vin'] ?? null;
        $idingresoVin = $filtroImgen['idingresoVin'] ?? null;
        $sql = "CALL sp_imagen_ingreso_vin(?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin,$idingresoVin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function StorageObservaciones($storage)
    {
        $builder=$this->db->table("observacioningresovin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageDuaf($storage)
    {
        $builder=$this->db->table("duafingreso");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function DetailIndexCreado($filtro)
    {
        $builder=$this->db->table("creavinsinerp");
        if($filtro!='') {
            $builder->where($filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function UpgradeObservacion($filtro,$update)
    {
        $builder=$this->db->table("observacioningresovin");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function DeleteDuaf($filtrodelet)
    {
        $builder = $this->db->table("duafingreso");
        $builder->where($filtrodelet);
        return $builder->delete();
    }

    public function DestroyObservacion($filtro)
    {
        $builder = $this->db->table("observacioningresovin");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function DetailPanelObservaciones($filtro)
    {
        $vin = $filtro['vin'] ?? null;
        $idingresoVin = $filtro['idingresoVin'] ?? null;
        $idobservacionIngresoVin = $filtro['idobservacionIngresoVin'] ?? null;
        $sql = "CALL sp_observacion_ingreso_sin_img(?,?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin,$idingresoVin,$idobservacionIngresoVin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function ObservacionesVin($filtro)
    {
        $vin = $filtro['vin'] ?? null;
        $idingresoVin = $filtro['idingresoVin'] ?? null;
        $idobservacionIngresoVin = $filtro['idobservacionIngresoVin'] ?? null;
        $sql = "CALL sp_observacion_ingreso(?,?,?)";  // Llamada al procedimiento almacenado
        // Ejecutamos la consulta
        $query = $this->db->query($sql, [$vin,$idingresoVin,$idobservacionIngresoVin]);
        // Obtenemos los resultados de la consulta
        return $query->getResultArray(); // Devuelve un array con los resultados
    }

    public function StorageImagenIngreso($storage)
    {
        $builder=$this->db->table("detalleingresovehiculoimagen");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageIngreso($storage)
    {
        $builder=$this->db->table("ingresovin");
        $builder->insert($storage);
        return $this->db->insertID();
    }

    public function StorageCheckEquipamiento($storage)
    {
        $builder=$this->db->table("detalleingresovin");
        $builder->insert($storage);
        return $this->db->insertID();
    }
}