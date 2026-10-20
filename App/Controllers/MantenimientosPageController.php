<?php
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/MantenimientosController.php";

/**
 * Prepara los datos de las páginas de mantenimientos y delega su presentación
 * a las vistas. Las rutas y acciones existentes continúan sin cambios.
 */
class MantenimientosPageController {
    private MantenimientosController $mantenimientosController;
    private CentroDeTrabajoController $centrosController;

    public function __construct() {
        $this->mantenimientosController = new MantenimientosController();
        $this->centrosController = new CentroDeTrabajoController();
    }

    public function preventivos(): void {
        include_once "App/Views/Templates/Mantenimiento/Preventivos/CriteriosMantenimientos.php";
        $criteriosJSON = json_encode($Criterios, JSON_UNESCAPED_UNICODE);

        $MantenimientosController = $this->mantenimientosController;
        $CentrosDeTrabajo = $this->centrosController;
        $ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
        $DataSupervisores = $MantenimientosController->TraerSupervisores();
        $Mantenimientos = $MantenimientosController->LeerMantenimientos();
        $NoMantenimientos = $MantenimientosController->ContarMantenimientos();

        date_default_timezone_set('America/Bogota');
        $horaFormateada = date('H:i');
        $baseUrl = $this->obtenerBaseUrl();

        include "App/Views/Templates/Mantenimiento/Preventivos/InicioPreventivo.php";
    }

    public function correctivos(): void {
        $MantenimientosController = $this->mantenimientosController;
        $CentrosDeTrabajo = $this->centrosController;
        $ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
        $DataSupervisores = $MantenimientosController->TraerSupervisores();
        $Mantenimientos = $MantenimientosController->LeerMantenimientosCorrectivos();
        $NoMantenimientos = $MantenimientosController->ContarMantenimientosCorrectivos();

        date_default_timezone_set('America/Bogota');
        $horaFormateada = date('H:i');
        $baseUrl = $this->obtenerBaseUrl();

        include "App/Views/Templates/Mantenimiento/Correctivos/InicioCorrectivos.php";
    }

    private function obtenerBaseUrl(): string {
        return isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost'
            ? 'http://localhost/OUTKARGO/'
            : 'https://outkargo.com.co/';
    }
}
?>
