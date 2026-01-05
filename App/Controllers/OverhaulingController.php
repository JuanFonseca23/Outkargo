<?php
    include_once  "App/Models/Overhauling.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";   
    include_once "App/Controllers/UsuarioController.php";

    class OverhaulingController {
        // Atributos
        private $Modelo_Overhauling;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Contactos;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_Overhauling = new Overhauling();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
            $this->Controller_Usuarios = new UsuarioController();
        }

        public function BuscarPersona($No_Documento) {
            $datausuario = $this->Controller_Usuarios->BuscarPersonaDocumento($No_Documento);     
            if ($datausuario) {               
                return $datausuario;   
            }else {
                return false;
            }
        }

        public function ContarDiagnosticos($ID_Centro){
            $Resultado = $this->Modelo_Overhauling->ContarDiagnosticos($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function DataImagenesM($ID){
            $DataImagenesM = $this->Modelo_Overhauling->DataImagenesM($ID);
            return $DataImagenesM;
        }

        public function FirmarDiagnostico ($ID_Diagnostico, $Firmas) {
            $totalFirmas = count($Firmas);
            $firmasGuardadas = 0;
            $FechaFirma = date("d/m/Y");
            $EstadoFirmaMecanico = 1;
            foreach ($Firmas as $ID_Mecanico => $Firma) {
                if (!empty($Firma)) {
                    $Resultado = $this->Modelo_Overhauling->FirmarDiagnostico($ID_Diagnostico, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
                    if ($Resultado) {
                        $firmasGuardadas++;
                    }
                }
            }
            if ($firmasGuardadas === $totalFirmas && $totalFirmas > 0) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Inicial';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }

        }

        public function FirmarOverhaulingSupervisor ($ID_Mantenimiento, $Firma) {
            $EstadoFirmaSupervisor = 1;
            $FechaFirma = date("d/m/Y");
            if ($this->Modelo_Overhauling->FirmarOverhaulingSupervisor($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor)) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El Diagnostico ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Inicial';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }
        }

        private function GenerarCorreo ($Correo_Supervisor, $Nombre_Supervisor, $ID_Diagnostico, $nuevoCodigo) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $FirmarMantenimiento = "localhost/Outkargo2/Overhauling/FirmaDiagnosticoS?ID=$ID_Diagnostico";
            }else {
                $FirmarMantenimiento = "https://Outkargo.com.co/Overhauling/FirmaDiagnosticoS?ID=$ID_Diagnostico";
            }
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
                $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->addAddress($Correo_Supervisor, $Nombre_Supervisor);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Autorizar Mantenemiento Preventivo';
                $mail->Body    = $mail->Body = '
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            color: #333;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            width: 100%;
                            padding: 20px;
                            background-color: #f4f4f4;
                        }
                        .header {
                            background-color: #ff5000;
                            color: #fff;
                            padding: 10px;
                            text-align: center;
                            border-radius: 8px 8px 0 0;
                        }
                        .header img {
                            vertical-align: middle;
                            width: 50px;
                            height: 50px;
                        }
                        .header h1 {
                            display: inline;
                            margin: 0;
                            font-size: 24px;
                        }
                        .content {
                            padding: 20px;
                            background-color: #fff;
                            border-radius: 0 0 8px 8px;
                            box-shadow: 0 0 10px rgba(0,0,0,0.1);
                            max-width: 600px;
                            margin: 0 auto;
                        }
                        .content p {
                            margin: 0 0 10px;
                        }
                        .highlight {
                            color: #ff5000;
                            font-weight: bold;
                        }
                        .button {
                            display: inline-block;
                            background-color: #007BFF;
                            color: #ffffff;
                            padding: 10px 20px;
                            font-size: 16px;
                            border-radius: 5px;
                            text-decoration: none;
                            margin-top: 10px;
                            text-align: center;
                        }
                        .button:hover {
                            background-color: #0056b3;
                        }
                        .footer {
                            text-align: center;
                            font-size: 14px;
                            color: #888;
                            padding: 10px;
                        }
                        .footer a {
                            color: #ff5000;
                            text-decoration: none;
                        }
                        .link {
                            color: #ff5000;
                            text-decoration: none;
                            font-size: 14px;
                        }
                        .link:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" alt="POS Terminal"/>
                            <h1>OUTKARGO</h1>
                        </div>
                        <div class="content">
                            <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Supervisor) . '</strong>,</p>
                            <p>se ha creado el Diagnostico Inicial #<strong class="highlight">' . htmlspecialchars($nuevoCodigo) . '</strong></strong>,</p>
                            <p>Para autorizar de clic en el siguente boton:</p>
                            <a href="'.$FirmarMantenimiento.'" class="button">Autorizar Mantenimiento</a>
                        </div>
                        <div class="footer">
                            <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                        </div>
                    </div>
                </body>
                </html>';
                $mail->send();
            }
            catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        public function LeerDiagnosticos($ID_Centro){
            if ($this->Modelo_Overhauling->LeerDiagnosticos($ID_Centro)) {
                $Resultado = $this->Modelo_Overhauling->LeerDiagnosticos($ID_Centro);
                return $Resultado;
            }
        }

        public function ObtenerDiagnostico ($ID) {
            $DataMantenimiento = $this->Modelo_Overhauling->ObtenerDiagnostico($ID);
            return $DataMantenimiento;
        }

        public function ObtenerTecnicosOverhauling ($ID) {
            $Tecnicos = $this->Modelo_Overhauling->ObtenerTecnicosOverhauling($ID);
            return $Tecnicos;
        }

        public function RegistrarDiagnosticoInicial($ID_Usuario, $ID_Centro, $TipoMontacargas, $ID_Supervisor, $Correo_Supervisor, $Nombre_Supervisor, $Tecnicos, $ClaseH, $LongitudH, $Voltaje, $Horometro, $Serie, $Modelo, $Marca,
                                                    $Criterio_1, $Criterio_2, $Criterio_3, $Criterio_4, $Criterio_5, $Criterio_6, $Criterio_7, $Criterio_8, $Criterio_9, $Criterio_10, $Criterio_11, $Criterio_12, $Criterio_13, 
                                                    $Criterio_14, $Criterio_15, $Criterio_16, $Criterio_17, $Criterio_18, $Criterio_19, $Criterio_20, $Criterio_21, $Criterio_22, $Criterio_23, $Criterio_24, $Criterio_25, $Criterio_26, 
                                                    $Criterio_27, $Criterio_28, $Criterio_29, $Criterio_30, $Criterio_31, $Criterio_32, $Criterio_33, $Criterio_34, $Criterio_35, $Criterio_36, $Criterio_37, $Criterio_38, $Criterio_39, 
                                                    $Criterio_40, $Criterio_41, $Criterio_42, $Criterio_43, $Criterio_44, $Criterio_45, $Criterio_46, $Criterio_47, $Criterio_48, $Criterio_49, $Criterio_50, $Criterio_51, $Criterio_52, 
                                                    $Criterio_53, $Criterio_54, $Criterio_55, $Criterio_56, $Criterio_57, $Criterio_58, $Criterio_59, $Criterio_60, $Criterio_61, $Criterio_62, $Criterio_63, $Criterio_64, $Criterio_65, 
                                                    $Criterio_66, $Criterio_67, $Criterio_68, $Criterio_69, $Criterio_70, $Criterio_71, $Criterio_72, $Criterio_73, $Criterio_74, $Criterio_75, $Criterio_76, $Criterio_77, $Criterio_78, 
                                                    $Criterio_79, $Criterio_80, $Criterio_81, $Criterio_82, $Criterio_83, $Criterio_84, $Criterio_85, $Criterio_86, $Criterio_87, $Criterio_88, $Criterio_89, $Criterio_90, $Criterio_91, 
                                                    $Criterio_92, $Criterio_93, $Criterio_94, $Criterio_95, $Criterio_96, $Criterio_97, $Criterio_98, $Criterio_99, $Criterio_100, $Criterio_101, $Criterio_102, $Criterio_103, $Criterio_104, 
                                                    $Criterio_105, $Criterio_106, $Criterio_107, $Criterio_108, $Criterio_109, $Criterio_110, $Criterio_111, $Criterio_112, $Criterio_113, $Criterio_114, $Criterio_115, $Criterio_116, $Criterio_117, 
                                                    $Criterio_118, $Criterio_119, $Criterio_120, $Criterio_121, $Criterio_122, $Criterio_123, $Criterio_124, $Criterio_125, $Criterio_126, $Criterio_127, $Criterio_128, $Criterio_129, $Criterio_130, $Criterio_131,
                                                    $Bateria, $Electrico, $Traccion, $Frenos, $Direccion, $Hidraulico, $Mastil, $CarroPorta, $Lubricacion, $Horquillas, $Chasis, $Ruedas, $Luces, $Aditamientos, $Cargador, $Revision, $Auxiliares, $Suspension, $Pantografo, 
                                                    $Motor, $Refrigeracion, $Combustion, $Transmision, $Caja, $Componentes, $Ausencia, $Revisiones, $Funcionamiento, $Correas, $Unidad, $Panel, $Pintura, $trabajos, $NombreCreo) {
            $FechaCreado = date("d/m/Y");
            $EstadoFirmaSupervisor = 0;
            $EstadoFirmaMecanico = 0;
            $Estado_Trabajo = 'Pendiente';
            $ultimoCodigo = $this->Modelo_Overhauling->ObtenerUltimoCodigoDiagnostico();
            if ($ultimoCodigo) {
               $nuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);

            } else {
                $nuevoCodigo = '000001';
            }
            if($ID = $this->Modelo_Overhauling->RegistrarDiagnosticoInicial($nuevoCodigo, $ID_Centro, $ID_Supervisor, $TipoMontacargas, $FechaCreado, $EstadoFirmaSupervisor)){
                $ID_Diagnostico = $ID;
                if (!in_array($ID_Usuario, $Tecnicos)) { array_unshift($Tecnicos, $ID_Usuario); }
                foreach ($Tecnicos as $ID_Tecnico) {
                    $this->Modelo_Overhauling->RegistrarDiagnosticoTecnico($ID_Diagnostico, $ID_Tecnico, $EstadoFirmaMecanico);
                }
                foreach ($trabajos as $trabajo) {
                    $Seccion        = $trabajo['seccion'] === 'Pintura1' ? 'Pintura' : $trabajo['seccion'];
                    $Criterio       = $trabajo['criterioLabel'];
                    $Tipo           = $trabajo['tipo'];
                    $Descripcion    = $trabajo['descripcion'];
                    $this->Modelo_Overhauling->RegistrarTrabajoOverhauling($ID_Diagnostico, $Seccion, $Criterio, $Tipo, $Descripcion, $Estado_Trabajo);
                }
                $this->Modelo_Overhauling->RegistrarDetallesOverhauling($ID_Diagnostico, $Serie, $Modelo, $Marca, $ClaseH, $LongitudH, $Horometro, $Voltaje,
                                                                        $Criterio_1, $Criterio_2, $Criterio_3, $Criterio_4, $Criterio_5, $Criterio_6, $Criterio_7, $Criterio_8, $Criterio_9, $Criterio_10,
                                                                        $Criterio_11, $Criterio_12, $Criterio_13, $Criterio_14, $Criterio_15, $Criterio_16, $Criterio_17, $Criterio_18, $Criterio_19, $Criterio_20,
                                                                        $Criterio_21, $Criterio_22, $Criterio_23, $Criterio_24, $Criterio_25, $Criterio_26, $Criterio_27, $Criterio_28, $Criterio_29, $Criterio_30,
                                                                        $Criterio_31, $Criterio_32, $Criterio_33, $Criterio_34, $Criterio_35, $Criterio_36, $Criterio_37, $Criterio_38, $Criterio_39, $Criterio_40,
                                                                        $Criterio_41, $Criterio_42, $Criterio_43, $Criterio_44, $Criterio_45, $Criterio_46, $Criterio_47, $Criterio_48, $Criterio_49, $Criterio_50,
                                                                        $Criterio_51, $Criterio_52, $Criterio_53, $Criterio_54, $Criterio_55, $Criterio_56, $Criterio_57, $Criterio_58, $Criterio_59, $Criterio_60,
                                                                        $Criterio_61, $Criterio_62, $Criterio_63, $Criterio_64, $Criterio_65, $Criterio_66, $Criterio_67, $Criterio_68, $Criterio_69, $Criterio_70,
                                                                        $Criterio_71, $Criterio_72, $Criterio_73, $Criterio_74, $Criterio_75, $Criterio_76, $Criterio_77, $Criterio_78, $Criterio_79, $Criterio_80,
                                                                        $Criterio_81, $Criterio_82, $Criterio_83, $Criterio_84, $Criterio_85, $Criterio_86, $Criterio_87, $Criterio_88, $Criterio_89, $Criterio_90,
                                                                        $Criterio_91, $Criterio_92, $Criterio_93, $Criterio_94, $Criterio_95, $Criterio_96, $Criterio_97, $Criterio_98, $Criterio_99, $Criterio_100,
                                                                        $Criterio_101, $Criterio_102, $Criterio_103, $Criterio_104, $Criterio_105, $Criterio_106, $Criterio_107, $Criterio_108, $Criterio_109, $Criterio_110,
                                                                        $Criterio_111, $Criterio_112, $Criterio_113, $Criterio_114, $Criterio_115, $Criterio_116, $Criterio_117, $Criterio_118, $Criterio_119, $Criterio_120,
                                                                        $Criterio_121, $Criterio_122, $Criterio_123, $Criterio_124, $Criterio_125, $Criterio_126, $Criterio_127, $Criterio_128, $Criterio_129, $Criterio_130, $Criterio_131);
                $this->RegistrarOverhaulingEvidencia($ID_Diagnostico, $Bateria, $Electrico, $Traccion, $Frenos, $Direccion, $Hidraulico, $Mastil, $CarroPorta, $Lubricacion, $Horquillas, $Chasis, $Ruedas, $Luces, $Aditamientos, $Cargador, $Revision, $Auxiliares, $Suspension, $Pantografo,
                                                     $Motor, $Refrigeracion, $Combustion, $Transmision, $Caja, $Componentes, $Ausencia, $Revisiones, $Funcionamiento, $Correas, $Unidad, $Panel, $Pintura);
                $this->GenerarCorreo($Correo_Supervisor, $Nombre_Supervisor, $ID_Diagnostico, $nuevoCodigo);
                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $NombreCreo.' Creó el mantenimiento preventivo del montacargas con ID: '.$ID_Diagnostico;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                return $ID_Diagnostico;
            }else{
                return false;
            }
        }

        public function RegistrarOverhaulingEvidencia($ID_Diagnostico, $Bateria, $Electrico, $Traccion, $Frenos, $Direccion, $Hidraulico, $Mastil, $CarroPorta, $Lubricacion, $Horquillas, $Chasis, $Ruedas, $Luces, $Aditamientos, $Cargador, 
                                                      $Revision, $Auxiliares, $Suspension, $Pantografo, $Motor, $Refrigeracion, $Combustion, $Transmision, $Caja, $Componentes, $Ausencia, $Revisiones, $Funcionamiento, $Correas, $Unidad, $Panel, $Pintura) {
            $uploadDir = 'App/Views/Upload/Img/Overhauling/DiagnosticoI/'; 
            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // ⚙️ Función reutilizable para evitar repetir código
            $subirArchivos = function($Categoria, $archivos) use ($ID_Diagnostico, $uploadDir, $allowedTypes){
                $contador = 1;
                if(empty($archivos['name'][0])) return; // No hay archivos
                foreach ($archivos['tmp_name'] as $key => $tmp_name) {
                    $fileType = $archivos['type'][$key];
                    if (in_array($fileType, $allowedTypes)) {
                        $extension = pathinfo($archivos['name'][$key], PATHINFO_EXTENSION);
                        $NombreFoto  = "Diagnostico{$ID_Diagnostico}_{$Categoria}{$contador}." . $extension;
                        $uploadFile = $uploadDir . $NombreFoto;

                        if (move_uploaded_file($tmp_name, $uploadFile)) {
                            $this->Modelo_Overhauling->RegistrarOverhaulingEvidencia($ID_Diagnostico, $Categoria, $uploadFile);
                            $contador++;
                        } else {
                            // Error al mover el archivo
                            echo "❌ Error al cargar la imagen: $uploadFile<br>";
                        }
                    }else {
                        echo "⚠️ Tipo de archivo no permitido: {$archivos['name'][$key]}<br>";
                    }
                }

            };

            $subirArchivos('Bateria', $Bateria);
            $subirArchivos('Electrico', $Electrico);
            $subirArchivos('Traccion', $Traccion);
            $subirArchivos('Frenos', $Frenos);
            $subirArchivos('Direccion', $Direccion);
            $subirArchivos('Hidraulico', $Hidraulico);
            $subirArchivos('Mastil', $Mastil);
            $subirArchivos('CarroPorta', $CarroPorta);
            $subirArchivos('Lubricacion', $Lubricacion);
            $subirArchivos('Horquillas', $Horquillas);
            $subirArchivos('Chasis', $Chasis);
            $subirArchivos('Ruedas', $Ruedas);
            $subirArchivos('Luces', $Luces);
            $subirArchivos('Aditamientos', $Aditamientos);
            $subirArchivos('Cargador', $Cargador);
            $subirArchivos('Revision', $Revision);
            $subirArchivos('Auxiliares', $Auxiliares);
            $subirArchivos('Suspension', $Suspension);
            $subirArchivos('Pantografo', $Pantografo);
            $subirArchivos('Motor', $Motor);
            $subirArchivos('Refrigeracion', $Refrigeracion);
            $subirArchivos('Combustion', $Combustion);
            $subirArchivos('Transmision', $Transmision);
            $subirArchivos('Caja', $Caja);
            $subirArchivos('Componentes', $Componentes);
            $subirArchivos('Ausencia', $Ausencia);
            $subirArchivos('Revisiones', $Revisiones);
            $subirArchivos('Funcionamiento', $Funcionamiento);
            $subirArchivos('Correas', $Correas);    
            $subirArchivos('Unidad', $Unidad);
            $subirArchivos('Panel', $Panel);
            $subirArchivos('Pintura', $Pintura);         
        }

        public function TraerSupervisores() {
            $Resultado = $this->Modelo_Overhauling->TraerSupervisores();
            return $Resultado;
        }  
        
        public function VerDetalleD($ID){
            $VerDetalleD = $this->Modelo_Overhauling->VerDetalleD($ID);
            return $VerDetalleD;
        }

        public function VerDetalleTrabajos($ID){
            $VerDetalleTrabajos = $this->Modelo_Overhauling->VerDetalleTrabajos($ID);
            return $VerDetalleTrabajos;
        }
        
        public function VerMecanicos($ID){
            $DataMecanicos = $this->Modelo_Overhauling->VerMecanicos($ID);
            return $DataMecanicos;
        }

        public function VerOverhauling($ID){
            $DataOverhauling = $this->Modelo_Overhauling->VerOverhauling($ID);
            return $DataOverhauling;
        }
    }
       
?>
