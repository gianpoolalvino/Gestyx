<?php

namespace App\Models;

use CodeIgniter\Model;

class GuiaModel extends Model
{
    public function Empresa()
    {
        $builder=$this->db->table("empresa");
        return $builder->get()->getResultArray();
    }

    public function SelectEmpresa($filtro)
    {
        $builder=$this->db->table("empresa");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewGuiaOrigenDestino($filtroGuia)
    {
        $builder=$this->db->table("vw_guiaremision_visual");
        $builder->where($filtroGuia);
        return $builder->get()->getResultArray();
    }

    public function UnidadMedidaPesoBruto()
    {
        $builder=$this->db->table("unidadpesobruto");

        return $builder->get()->getResultArray();
    }

    public function TipoDocumentoChofer()
    {
        $builder=$this->db->table("tipodocumento");
        return $builder->get()->getResultArray();
    }

    public function RazonSocial($filtro)
    {
        $builder=$this->db->table("empresa");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageGuia($guiaRemision)
    {
        $builder=$this->db->table("guiaremision");
        $builder->insert($guiaRemision);
        return $this->db->insertID();
    }

    public function Departamento()
    {
        $builder=$this->db->table("departamento");
        return $builder->get()->getResultArray();
    }

    public function Provincia($filtro)
    {
        $builder=$this->db->table("provincia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function Distrito($filtro)
    {
        $builder=$this->db->table("distrito");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageDestinatario($filtroGuia,$destinatario)
    {
        $builder=$this->db->table("guiaremision");
        $builder->where($filtroGuia);
        $builder->update($destinatario);
        return $builder->get()->getResultArray();
    }

    public function GuiaRemision($filtro)
    {
        $builder=$this->db->table("vw_cabecera_guia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function TipoDocumentiIdentidad()
    {
        $builder=$this->db->table("tipodocumento");
        return $builder->get()->getResultArray();
    }

    public function UltimoNumeracion($filtro)
    {
        $builder=$this->db->table("guiaremision");
        $builder->limit(1);
        $builder->orderBy("numero","desc");
        return $builder->get()->getResultArray();
    }

    public function TipoDocumentoRel()
    {
        $builder=$this->db->table("tipodocumentorelacionadoguia");
        return $builder->get()->getResultArray();
    }

    public function DestroyGuia($filtro)
    {
        $builder = $this->db->table("guiaremision");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function DeleteVinGuia($filtro)
    {
        $builder = $this->db->table("detalleguiaremision");
        $builder->where($filtro);
        return $builder->delete();
    }

    public function DetailVinGuia($filtro)
    {
        $builder=$this->db->table("detallevinguia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function StorageDocumentoRelacionado($documentoRelacionado)
    {
        $builder=$this->db->table("documentorelacionadoguia");
        $builder->insert($documentoRelacionado);
        return $this->db->insertID();
    }

    public function UpdateGuiaRemision($filtro,$update)
    {
        $builder=$this->db->table("guiaremision");
        $builder->where($filtro);
        $builder->update($update);
        return $builder->get()->getResultArray();
    }

    public function UnidadMedida()
    {
        $builder=$this->db->table("unidadmedida");
        return $builder->get()->getResultArray();
    }

    public function StorageDetalleGuiaRemision($detalle)
    {
        $builder=$this->db->table("detalleguiaremision");
        $builder->insert($detalle);
        return $this->db->insertID();
    }

    public function DetailDocRelacionado($filtro)
    {
        $builder=$this->db->table("vw_documento_relacionado_guia");
        $builder->where($filtro);
        return $builder->get()->getResultArray();
    }

    public function ViewGuia($filtroGuia)
    {
        $builder=$this->db->table("guiaremision");
        $builder->where($filtroGuia);
        return $builder->get()->getResultArray();
    }

    public function EstablecimientoEmpresa($filtroEmp)
    {
        $builder=$this->db->table("vw_establecimiento_fisico");
        $builder->where($filtroEmp);
        return $builder->get()->getResultArray();
    }

    public function VinDisponibleGuia($filtro)
    {
        $builder=$this->db->table("vw_vin_disponible_guia");
        $builder->whereIn('codigoAgencia',session("codigoAgencia"));
        $builder->orWhereIn("codigoBodega",session("codigoBodega"));
        if($filtro!=''){
            $builder->where($filtro);
        }
        return $builder->get()->getResultArray();
    }

    public function DestroyDocumentoRelacionadoGuia($filtro)
    {
        $builder=$this->db->table("documentorelacionadoguia");
        $builder->delete($filtro);
        return $builder->get()->getResultArray();
    }

    public function MotivoTraslado()
    {
        $builder=$this->db->table("motivotrasladoguia");
        return $builder->get()->getResultArray();
    }
}