<?php
namespace App\Controllers\ConfigOperaciones\GrupoUbicacion;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;
use App\Models\ConfigModel;
use App\Models\EventoModel;
use App\Models\ReglasModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SaveEditDelete extends BaseController
{

    public function SaveGrupoUbicacion()
    {
        $db = \Config\Database::connect();
        $configModel = new ConfigModel();
        try {
            // Iniciar transacción
            $db->transBegin();

            $storage = [
                'descripcion' => $_POST['nombreGrupo'],
                'idempresa'   => $_POST['empresa'],
            ];

            $updateResult = $configModel->StorageGrupoUbicacion($storage);

            if (!$updateResult) {
                $db->transRollback();
                echo json_encode([
                    'status'  => 'danger',
                    'title'   => 'Error al crear',
                    'message' => 'No se pudo crear el grupo de ubicación.',
                ]);
                return;
            }

            $db->transCommit();
            echo json_encode([
                'status'  => 'success',
                'title'   => 'Creacion exitosa',
                'message' => 'Grupo de ubicación actualizado correctamente.',
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            echo json_encode([
                'status'  => 'danger',
                'title'   => 'Error inesperado',
                'message' => 'Ocurrió un error: ' . $e->getMessage(),
            ]);
        }
    }
    public function UploadGrupoUbicacion()
    {
        $db = \Config\Database::connect();
        $configModel = new ConfigModel();

        try {
            // Iniciar transacción
            $db->transBegin();

            $filtroUpdate = [
                'idgrupoUbicacion' => $_POST['idgrupoUbicacion'],
            ];

            $update = [
                'descripcion' => $_POST['nombreGrupo'],
                'idempresa'   => $_POST['empresa'],
            ];

            $updateResult = $configModel->UpdateGrupoUbicacion($filtroUpdate, $update);

            if (!$updateResult) {
                $db->transRollback();
                echo json_encode([
                    'status'  => 'danger',
                    'title'   => 'Error al actualizar',
                    'message' => 'No se pudo actualizar el grupo de ubicación.',
                ]);
                return;
            }

            $db->transCommit();
            echo json_encode([
                'status'  => 'success',
                'title'   => 'Actualización exitosa',
                'message' => 'Grupo de ubicación actualizado correctamente.',
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            echo json_encode([
                'status'  => 'danger',
                'title'   => 'Error inesperado',
                'message' => 'Ocurrió un error: ' . $e->getMessage(),
            ]);
        }
    }

    public function DeleteBoxUbicacion()
    {
        $configModel = new ConfigModel();
        $db = \Config\Database::connect(); // Conexión directa a la base de datos

        try {
            $idBoxUbicacion = $this->request->getPost('idboxUbicacion');

            // Validar el dato recibido
            if (empty($idBoxUbicacion)) {
                echo json_encode([
                    'status' => 'danger',
                    'title'  => 'ID Requerido',
                    'message' => 'El ID de BoxUbicacion es requerido.'
                ]);
            }

            // Iniciar transacción
            $db->transBegin();

            // Armar filtro
            $filtro = [
                'idboxUbicacion' => $idBoxUbicacion,
            ];

            $update=[
                'eliminado'=>1
            ];

            // Intentar eliminar
            $delete = $configModel->UpdateBoxUbicacion($filtro,$update);

            if (!$delete) {
                // Lanzar excepción si falla
                throw new \Exception('No se pudo eliminar el registro.');
            }

            // Commit si todo fue exitoso
            $db->transCommit();

            echo json_encode([
                'status' => 'success',
                'title'  => 'Eliminado',
                'message' => 'BoxUbicacion eliminado correctamente.'
            ]);

        } catch (\Throwable $e) {
            // Rollback si ocurre algún error
            $db->transRollback();

            echo json_encode([
                'status' => 'danger',
                'title'  => 'Error al eliminar',
                'message' => 'No se pudo eliminar el BoxUbicacion: ' . $e->getMessage()
            ]);
        }
    }

    public function DeleteUbicacion()
    {
        $configModel = new ConfigModel();
        $db = \Config\Database::connect();

        try {
            $idUbicacion = $this->request->getPost('idubicacion');

            // Validación del ID
            if (empty($idUbicacion)) {
                echo json_encode([
                    'status'  => 'error',
                    'title'   => 'ID Requerido',
                    'message' => 'El ID de Ubicación es obligatorio.'
                ]);
            }

            // Iniciar transacción
            $db->transBegin();

            $filtro = [
                'idubicacion' => $idUbicacion,
            ];

            $update=[
                'eliminado'=>1
            ];

            // Intentar eliminar
            $delete = $configModel->UpdateUbicacion($filtro,$update);

            if (!$delete) {
                throw new \Exception('No se pudo eliminar la ubicación.');
            }

            // Confirmar si todo salió bien
            $db->transCommit();

            echo json_encode([
                'status'  => 'success',
                'title'   => 'Ubicación eliminada',
                'message' => 'La ubicación ha sido eliminada correctamente.'
            ]);

        } catch (\Throwable $e) {
            // Deshacer cambios si hubo error
            $db->transRollback();

            echo json_encode([
                'status'  => 'error',
                'title'   => 'Error al eliminar',
                'message' => 'No se pudo eliminar la ubicación: ' . $e->getMessage()
            ]);
        }
    }

    public function SaveBoxUbicacion()
    {
        $configModel = new ConfigModel();
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $storage = [
                'descripcion'       => $this->request->getPost("nombreBox"),
                'tipoBox'=>$this->request->getPost("tipobox"),
                'idubicacion'  => $this->request->getPost("ubicacionBox")
            ];

            $result = $configModel->StorageBoxUbicacion($storage); // <-- debe retornar true si se graba correctamente

            if (!$result) {
                $db->transRollback();
                echo json_encode([
                    'status'  => 'error',
                    'title'   => 'Error al guardar',
                    'message' => 'No se pudo registrar el box.',
                    'errors'  => $configModel->errors() // errores de validación si los hay
                ]);
            }

            $db->transCommit();

            echo json_encode([
                'status'  => 'success',
                'title'   => 'Registro exitoso',
                'message' => 'El Box fue registrado correctamente.'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();

            echo json_encode([
                'status'  => 'error',
                'title'   => 'Excepción capturada',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ]);
        }
    }
    public function SaveUbicacion()
    {
        $configModel = new ConfigModel();
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $storage = [
                'descripcion'       => $this->request->getPost("nombreUbicacion"),
                'idgrupoUbicacion'  => $this->request->getPost("grupoUbicacion"),
                'autoRecepcion'     => $this->request->getPost("autoRecepcion") ? 1 : null,
                'visible'=>$this->request->getPost("visible") ? 1 : null,
            ];

            $result = $configModel->StorageUbicacion($storage); // <-- debe retornar true si se graba correctamente

            if (!$result) {
                $db->transRollback();
                echo json_encode([
                    'status'  => 'error',
                    'title'   => 'Error al guardar',
                    'message' => 'No se pudo registrar la ubicación.',
                    'errors'  => $configModel->errors() // errores de validación si los hay
                ]);
            }

            $db->transCommit();

            echo json_encode([
                'status'  => 'success',
                'title'   => 'Registro exitoso',
                'message' => 'La ubicación fue registrada correctamente.'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();

            echo json_encode([
                'status'  => 'error',
                'title'   => 'Excepción capturada',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ]);
        }
    }
    public function UpdateUbicacion()
    {
        $configModel = new ConfigModel();

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $filtroUpdate = [
                'idubicacion' => $this->request->getPost("idubicacion"),
            ];

            $updateUbicacion = [
                'descripcion'        => $this->request->getPost('nombreUbicacion'),
                'idgrupoUbicacion'   => $this->request->getPost("grupoUbicacion"),
                'autoRecepcion'      => $this->request->getPost("autoRecepcion") ? 1 : null,
                'visible'=>$this->request->getPost("visible") ? 1 : null,
            ];

            $result = $configModel->UpdateUbicacion($filtroUpdate, $updateUbicacion);

            if (!$result) {
                // Error en la actualización
                $db->transRollback();
                echo json_encode([
                    'status'  => 'error',
                    'title'   => 'Error al actualizar',
                    'message' => 'No se pudo actualizar la ubicación. Verifique los datos.',
                    'errors'  => $configModel->errors() // Muestra errores de validación si los hay
                ]);
            }

            // Todo correcto, guardar cambios
            $db->transCommit();

            echo json_encode([
                'status'  => 'success',
                'title'   => 'Actualización exitosa',
                'message' => 'La ubicación fue actualizada correctamente.'
            ]);

        } catch (\Exception $e) {
            // Captura de error no esperado
            $db->transRollback();
            echo json_encode([
                'status'  => 'error',
                'title'   => 'Excepción capturada',
                'message' => 'Error inesperado: ' . $e->getMessage()
            ]);
        }
    }

    public function UpdateBoxUbicacion()
    {
        $configModel = new ConfigModel();

        // Iniciar conexión y transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idBox = $this->request->getPost("idboxUbicacion");

            if (!$idBox) {
                // ID no enviado
                echo json_encode([
                    'status'  => 'error',
                    'title'   => 'Falta información',
                    'message' => 'El ID de boxUbicacion es obligatorio.'
                ]);
            }

            $filtroUpdate = ['idboxUbicacion' => $idBox];

            $update = [
                'descripcion' => $this->request->getPost('nombreBox'),
                'tipoBox'     => $this->request->getPost('tipobox'),
            ];

            // Ejecutar update personalizado
            $result = $configModel->UpdateBoxUbicacion($filtroUpdate, $update); // <-- asegúrate de que devuelve true/false

            if (!$result) {
                $db->transRollback();
                echo json_encode([
                    'status'  => 'error',
                    'title'   => 'Error al actualizar',
                    'message' => 'No se pudo actualizar el box de ubicación.',
                    'errors'  => $configModel->errors() // errores de validación si los hay
                ]);
            }

            $db->transCommit();
            echo json_encode([
                'status'  => 'success',
                'title'   => 'Actualizado correctamente',
                'message' => 'El box de ubicación fue actualizado con éxito.'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();

            echo json_encode([
                'status'  => 'error',
                'title'   => 'Excepción',
                'message' => 'Se produjo un error inesperado: ' . $e->getMessage()
            ]);
        }
    }

}