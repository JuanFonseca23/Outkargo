<?php
    include_once  "App/Models/Usuario.php";
    include_once  "App/Models/Comparendos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";    

    class ComparendosController {
        // Atributos
        private $Modelo_Comparendos;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;

        // Constructor
        public function __construct() {
            $this->Modelo_Comparendos = new Comparendos();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        public function Mostrar($ID){
            if ($this->Modelo_Comparendos->Mostrar($ID)) {
                return $this->Modelo_Comparendos->Mostrar($ID);
            }else{
                return false;
            }
        }

        public function Comparendos($ID_Usuario){
            if ($DataComparendos = $this->Modelo_Comparendos->Comparendos($ID_Usuario)) {
                return $DataComparendos;
            }else{
                return false;
            }
        }

        public function IngresarComparendos($ID_Usuario1, $NombreCreo, $ID, $Nombre, $Fecha_Realizado, $Documento, $Fecha_Pagado, $NombreUsuario, $DocumentoUsuario) {
            $uploadDir = 'App/Views/Upload/Documents/Comparendos/';
            $Fecha_Creado = date("Y-m-d");
            if (empty ($Fecha_Pagado)){
                $Estado="Por Pagar";
            }
            else {
                $Estado="Pagado";
            }
            $ID_Generado = $this->Modelo_Comparendos->IngresarComparendos($ID, $Nombre, $Fecha_Realizado, $Estado, '', $Fecha_Creado, $Fecha_Pagado);
        
            if ($Estado === "Por Pagar"){
                $NombreDocumento = trim($DocumentoUsuario . "_" . $ID_Generado) . '.pdf'; 
                $uploadFile = $uploadDir . $NombreDocumento;
            }
            else {
                $NombreDocumento = trim($DocumentoUsuario . "_" . $Estado . "_" . $ID_Generado) . '.pdf'; 
                $uploadFile = $uploadDir . $NombreDocumento;
            }
                
        
            // Crear el directorio si no existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            if (isset($Documento) && $Documento['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $Documento['tmp_name'];
                $fileType = $Documento['type'];
                
                if ($fileType === 'application/pdf') {
                    if (move_uploaded_file($fileTmpPath, $uploadFile)) {
                        if ($this->Modelo_Comparendos->ActualizarNombreDocumento($ID_Generado, $NombreDocumento)) {
                            $ID_Usuario =$ID;
                            $Creo = 'ingreso';
                            $Frase = $NombreCreo . ' ingresó el comparendo de ' . $NombreUsuario;
                            $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo, $Frase);
                            echo " 
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Éxito!',
                                    text: 'Comparendo ingresado correctamente',
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didClose: () => {
                                        window.location.href = 'Ver?ID=".$ID."'; // Redirige a la página 'Inicio' después de 2 segundos
                                    }
                                });
                            </script>";
                        } else {
                            echo "
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error al Ingresar el comparendo',
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            </script>";
                        }
                    } 
                } 
            }
        }      

        public function Editar($ID_Usuario1, $NombreCreo, $ID, $Nombre, $Fecha_Realizado, $Documento, $Fecha_Pagado, $ID_Usuario,$NombreUsuario, $DocumentoUsuario) {
            $Fecha_Creado = date("Y-m-d");
            $Estado = empty($Fecha_Pagado) ?"Por Pagar"  : "Pagado";
            $DataComparendos = $this->Mostrar($ID);
            // Actualizar los datos del comparendo
            if ($this->Modelo_Comparendos->Editar($ID, $Nombre, $Fecha_Realizado, $Estado, '', $Fecha_Creado, $Fecha_Pagado)) {
                if (isset($Documento) && $Documento['error'] == UPLOAD_ERR_OK) {
                    $uploadDir = 'App/Views/Upload/Documents/Comparendos/';
                    $NombreDocumento = trim($DocumentoUsuario . "_" . $Estado . "_" . $ID) . '.pdf';
                    $uploadFile = $uploadDir . $NombreDocumento;
                    
                    // Crear el directorio si no existe
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $fileTmpPath = $Documento['tmp_name'];
                    $fileType = $Documento['type'];

                    if ($fileType === 'application/pdf') {
                        if (move_uploaded_file($fileTmpPath, $uploadFile)) {
                            $this->Modelo_Comparendos->ActualizarNombreDocumento($ID, $NombreDocumento);
                            $Creo = 'actualizó';
                            $Frase = $NombreCreo . ' actualizó el comparendo de ' . $NombreUsuario;
                            $ID_Actividad= $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo, $Frase);
                            
                            if ($DataComparendos['Nombre'] != $Nombre) {
                                $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "comparendos - Nombre", $DataComparendos['Nombre'], $Nombre);
                            }
                            if ($DataComparendos['Fecha_Realizado'] != $Fecha_Realizado) {
                                $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "comparendos - Fecha_Realizado", $DataComparendos['Fecha_Realizado'], $Fecha_Realizado);
                            }
                            if ($DataComparendos['Estado'] != $Estado) {
                                $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "comparendos - Estado", $DataComparendos['Estado'], $Estado);
                            }
                            if ($DataComparendos['Fecha_Creado'] != $Fecha_Creado) {
                                $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "comparendos - Fecha_Creado", $DataComparendos['Fecha_Creado'], $Fecha_Creado);
                            }
                            if ($DataComparendos['Fecha_Pagado'] != $Fecha_Pagado) {
                                $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "comparendos - Fecha_Pagado", $DataComparendos['Fecha_Pagado'], $Fecha_Pagado);
                            }
                            if ($DataComparendos['Documento'] != $NombreDocumento) {
                                $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "comparendos - Documento", $DataComparendos['Documento'], $NombreDocumento);
                            }
                            echo " 
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Éxito!',
                                    text: 'Comparendo ingresado correctamente',
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didClose: () => {
                                        window.location.href = 'Ver?ID=".$ID_Usuario."'; // Redirige a la página 'Inicio' después de 2 segundos
                                    }
                                });
                            </script>";
                        } else {
                            echo "
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error al Ingresar el comparendo',
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            </script>";
                        }
                    } 
                } 
            }
        }  
        
    }
?>