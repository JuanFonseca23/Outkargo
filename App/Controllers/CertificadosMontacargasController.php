<?php
    include_once  "App/Models/Usuario.php";
    include_once  "App/Models/CertificadosMontacargas.php";
    date_default_timezone_set('America/Bogota');
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";    
    class CertificadosMontacargasController {
        // Atributos
        private $Modelo_Certificados_Montacargas;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;

        // Constructor
        public function __construct() {
            $this->Modelo_Certificados_Montacargas = new CertificadosMontacargas();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        public function Certificados_Montacargas($ID_Usuario){
            if ($DataMontacargas = $this->Modelo_Certificados_Montacargas->Certificados_Montacargas($ID_Usuario)) {
                return $DataMontacargas;
            }else{
                return false;
            }
        }

        public function IngresarCertificados($ID_Usuario1, $NombreCreo, $ID, $Nombre, $Fecha_Realizado, $Fecha_Vencimiento, $Documento, $NombreUsuario, $DocumentoUsuario) {
            $uploadDir = 'App/Views/Upload/Documents/CertificadosMontacargas/';
            $Fecha_Creado = date("Y-m-d");
            $ID_Generado = $this->Modelo_Certificados_Montacargas->IngresarCertificados($ID, $Nombre, $Fecha_Realizado, $Fecha_Vencimiento, '', $Fecha_Creado);
        
            // Renombra el documento usando el DocumentoUsuario y el ID generado
            $NombreDocumento = trim($DocumentoUsuario . "_" . $ID_Generado) . '.pdf'; 
            $uploadFile = $uploadDir . $NombreDocumento;
        
            // Crear el directorio si no existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            if (isset($Documento) && $Documento['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $Documento['tmp_name'];
                $fileType = $Documento['type'];
                
                if ($fileType === 'application/pdf') {
                    if (move_uploaded_file($fileTmpPath, $uploadFile)) {
                        if ($this->Modelo_Certificados_Montacargas->ActualizarNombreDocumento($ID_Generado, $NombreDocumento)) {
                            $ID_Usuario =$ID;
                            $Creo = 'ingreso';
                            $Frase = $NombreCreo . ' ingresó el certificado de ' . $NombreUsuario;
                            $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo, $Frase);
                            echo " 
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Éxito!',
                                    text: 'Certificado ingresado correctamente',
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
                                    text: 'Error al Ingresar el certificado',
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