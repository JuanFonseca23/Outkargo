<?php

    include_once  "App/Models/Usuario.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";     
    include_once "App/Controllers/ContactosController.php";  

    class UsuarioController {
        // Atributos
        private $Modelo_Usuario;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Contactos;

        // Constructor
        public function __construct() {
            $this->Modelo_Usuario = new Usuario();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
            $this->Controller_Contactos = new ContactosController();
        }

        // Métodos
        public function IniciarSesion($Documento, $Clave) {
            $resultado = $this->Modelo_Usuario->VerificarCredenciales($Documento, $Clave); //Enviar datos al modelo            
            if ($resultado) {
                $Creo = 'iniciosesion';
                $Frase = $resultado['Nombre1'].' Ingreso a la plataforma';
                $ID_Usuario2 = null;
                $ID_Usuario1 = $resultado['ID'];
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                $redirectUrl = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'Panel/Menu'; // URL por defecto
                echo "                
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Iniciando sesión',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = '$redirectUrl';
                        }
                    });
                </script>";
            } else {
                echo "                
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al iniciar sesión',
                        icon: 'error'
                    });
                </script>";
            }
        }

        public function CerrarSesion(){
            session_start();
            $Creo = 'cerrarsesion';
            $Frase = $_SESSION['Nombre1'].' Salio de la plataforma';
            $ID_Usuario2 = null;
            $ID_Usuario1 = $_SESSION['ID'];
            $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
            session_destroy();
            echo "          
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Cerrando sesión',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    didClose: () => {
                        window.location.href = '../IniciarSesion';
                    }
                });
            </script>";
        }

        public function Leer(){
            if ($this->Modelo_Usuario->Leer()) {
                $Resultado = $this->Modelo_Usuario->Leer();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function Informe(){
            if ($this->Modelo_Usuario->Informe()) {
                $Resultado = $this->Modelo_Usuario->Informe();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function InformeInactivos(){
            if ($this->Modelo_Usuario->InformeInactivos()) {
                $Resultado = $this->Modelo_Usuario->InformeInactivos();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ContarUsuariosActivos(){
            if ($this->Modelo_Usuario->ContarUsuariosActivos()) {
                $Resultado = $this->Modelo_Usuario->ContarUsuariosActivos();
                return $Resultado;
            }
            else {
                return 0;
            }
        }

        public function RegistrarUsuario($ID_Usuario1, $NombreCreo,$ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $Foto, $Telefono, $Correo, $Direccion, $No_Carnet ,$Fecha_Nacimiento , $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno, $NombreContacto, $TelefonoContacto) {
            $uploadDir = 'App/Views/Upload/Img/Perfil/';
            $NombreFoto = $Documento . '.png';
            $uploadFile = $uploadDir . $NombreFoto;    
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (isset($Foto) && $Foto['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $Foto['tmp_name'];
                $fileName = $Foto['name'];
                $fileSize = $Foto['size'];
                $fileType = $Foto['type'];
                $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
                if (in_array($fileType, $allowedTypes)) {
                    move_uploaded_file($fileTmpPath, $uploadFile);
                }
            }
            $Clave = $this->GenerarPassword(8);
            $ClaveEncriptada = password_hash($Clave, PASSWORD_DEFAULT);
            
             // Convertir todos los campos a mayúsculas
            $Nombre1 = strtoupper($Nombre1);
            $Nombre2 = strtoupper($Nombre2);
            $Apellido1 = strtoupper($Apellido1);
            $Apellido2 = strtoupper($Apellido2);
            $NombreCompleto = strtoupper(trim($Nombre1." ".$Nombre2." ".$Apellido1." ".$Apellido2));
            $RH = strtoupper($RH);
            $EPS = strtoupper($EPS);
            $AFP = strtoupper($AFP);
            $ARL = strtoupper($ARL);
            $NombreContacto = strtoupper($NombreContacto);
            $Estado = 0;            
            $Fecha_Creado = date("Y-m-d");        
            if ($ID_Usuario = $this->Modelo_Usuario->RegistrarUsuario($ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $ClaveEncriptada, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $NombreCompleto, $NombreFoto, $Telefono, $Correo, $Direccion, $Estado, $No_Carnet, $Fecha_Creado, $Fecha_Nacimiento , $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno)) {
                $this->GenerarCorreo($Correo, $Documento, $NombreCompleto, $Clave, $ID_Usuario);
                $Creo = 'creo';
                $Frase = $NombreCreo.' Creó el usuario de '.$Nombre1;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase);
                $Frase2 = $NombreCreo.' Creó un contacto de '.$Nombre1;
                $EstadoContacto = 1;
                $this->Controller_Contactos->RegistrarContacto($ID_Usuario1, $NombreCreo, $Nombre1, $ID_Usuario, $NombreContacto, $TelefonoContacto, $EstadoContacto, $Fecha_Creado);
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Usuario creado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                            }
                        });
                    </script>
                ";
            } else {
                echo "
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error al crear el usuario',
                            icon: 'error',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    </script>
                ";
            }            
        }
        
        public function DesactivarUsuario($ID_Usuario1, $NombreCreo,$ID_Usuario,$Nombre1) {
            if ($Resultado = $this->Modelo_Usuario->DesactivarUsuario($ID_Usuario)){

                $Creo = 'elimino';
                $Frase = $NombreCreo.' Elimino el usuario de '.$Nombre1;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase);
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Usuario Eliminado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                            }
                        });
                    </script>
                ";
                return true;
            }else{
                echo "
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Usuario No pudo ser Eliminado',
                            icon: 'Error',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                            }
                        });
                    </script>
                ";
                return false;
            }
            
        }

        public function ActivacionCuenta($Estado, $ID_Usuario,$Nombre1) {
            if ($Resultado = $this->Modelo_Usuario->ActivacionCuenta($Estado, $ID_Usuario)) {
                $Creo = 'autentico';
                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = null;
                $Frase = $Nombre1.' Se autentico';
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                return $Resultado;
            } else {
                return false;
            }   
        }
        
        private function GenerarPassword($length) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[random_int(0, strlen($characters) - 1)];
            }        
            return $password;
        }        
        
        private function GenerarCorreo ($Correo,$Tipo_Documento, $NombreCompleto, $password, $ID_Usuario) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; // O $_SERVER['HTTP_HOST']
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarCuenta = "http://localhost/Outkargo2/ActivarCuenta?ID=$ID_Usuario";
            }else {
                $AceptarCuenta = "https://Outkargo.com.co/ActivarCuenta?ID=$ID_Usuario/";
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
                $mail->addAddress($Correo, $NombreCompleto);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Activación de Cuenta';
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
                            <h1>OUTKARGOAPP</h1>
                        </div>
                        <div class="content">
                            <p>Hola, <strong class="highlight">' . htmlspecialchars($NombreCompleto) . '</strong>,</p>
                            <p>Tu cuenta ha sido creada exitosamente. Aquí tienes tus datos de acceso:</p>
                            <p><strong class="highlight">Usuario:</strong> ' . htmlspecialchars($Tipo_Documento) . '</p>
                            <p><strong class="highlight">Contraseña:</strong> ' . htmlspecialchars($password) . '</p>
                            <p>Para activar tu cuenta debes dar click aqui en el siguiente botón:</p>
                            <a href="'.$AceptarCuenta.'" class="button">Activar mi cuenta</a>
                            <p>&nbsp;</p> 
                            <p>Saludos,<br>El equipo de OUTKARGOAPP.</p>
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

        public function Mostrar($ID){
            if ($this->Modelo_Usuario->Mostrar($ID)) {
                return $this->Modelo_Usuario->Mostrar($ID);
            }else{
                return false;
            }
        }
        
        public function Editar($ID_Usuario1, $NombreCreo, $ID, $ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $Foto, $Telefono, $Correo, $Direccion, $No_Carnet, $Fecha_Nacimiento, $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno) {
            $uploadDir = 'App/Views/Upload/Img/Perfil/';
            $NombreFoto = $Documento . '.png';
            $uploadFile = $uploadDir . $NombreFoto;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (isset($Foto) && $Foto['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $Foto['tmp_name'];
                $fileType = $Foto['type'];
        
                $allowedTypes = ['image/png', 'image/jpeg', 'image/gif', 'image/jpg'];
                if (in_array($fileType, $allowedTypes)) {
                    if (file_exists($uploadFile)) { 
                        unlink($uploadFile);
                    }
                    move_uploaded_file($fileTmpPath, $uploadFile);
                }
            }
            $NombreCompleto = trim($Nombre1 . " " . $Nombre2 . " " . $Apellido1 . " " . $Apellido2);
            $Fecha_Editado = date("Y-m-d"); 
            $DataUsuario = $this->Mostrar($ID);  
            if ($this->Modelo_Usuario->Editar($ID, $ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $NombreCompleto, $NombreFoto, $Telefono, $Correo, $Direccion, $No_Carnet, $Fecha_Nacimiento, $Fecha_Editado, $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno)) {
                $Creo = 'modifico';
                $Frase = $NombreCreo . ' Modifico el usuario de ' . $Nombre1;
                $ID_Actividad = $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID, $Creo, $Frase);
                if ($DataUsuario['Nombre1'] != $Nombre1) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Nombre1", $DataUsuario['Nombre1'], $Nombre1);
                }
                if ($DataUsuario['Nombre2'] != $Nombre2) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Nombre2", $DataUsuario['Nombre2'], $Nombre2);
                }
                if ($DataUsuario['Apellido1'] != $Apellido1) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Apellido1", $DataUsuario['Apellido1'], $Apellido1);
                }
                if ($DataUsuario['Apellido2'] != $Apellido2) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Apellido2", $DataUsuario['Apellido2'], $Apellido2);
                }
                if ($DataUsuario['Tipo_Documento'] != $Tipo_Documento) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Tipo_Documento", $DataUsuario['Tipo_Documento'], $Tipo_Documento);
                }
                if ($DataUsuario['Documento'] != $Documento) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Documento", $DataUsuario['Documento'], $Documento);
                }
                if ($DataUsuario['Fecha_Nacimiento'] != $Fecha_Nacimiento) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Fecha_Nacimiento", $DataUsuario['Fecha_Nacimiento'], $Fecha_Nacimiento);
                }
                if ($DataUsuario['Telefono'] != $Telefono) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Telefono", $DataUsuario['Telefono'], $Telefono);
                }
                if ($DataUsuario['Foto'] != $NombreFoto) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Foto", $DataUsuario['Foto'], $NombreFoto);
                }
                if ($DataUsuario['Correo'] != $Correo) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Correo", $DataUsuario['Correo'], $Correo);
                }
                if ($DataUsuario['Direccion'] != $Direccion) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Direccion", $DataUsuario['Direccion'], $Direccion);
                }
                if ($DataUsuario['No_Carnet'] != $No_Carnet) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - No_Carnet", $DataUsuario['No_Carnet'], $No_Carnet);
                }
                if ($DataUsuario['RH'] != $RH) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - RH", $DataUsuario['RH'], $RH);
                }
                if ($DataUsuario['EPS'] != $EPS) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - EPS", $DataUsuario['EPS'], $EPS);
                }
                if ($DataUsuario['AFP'] != $AFP) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - AFP", $DataUsuario['AFP'], $AFP);
                }
                if ($DataUsuario['ARL'] != $ARL) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - ARL", $DataUsuario['ARL'], $ARL);
                }
                if ($DataUsuario['Sexo'] != $Sexo) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Sexo", $DataUsuario['Sexo'], $Sexo);
                }
                if ($DataUsuario['Municipio'] != $Municipio) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Municipio", $DataUsuario['Municipio'], $Municipio);
                }
                if ($DataUsuario['Area'] != $Area) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Area", $DataUsuario['Area'], $Area);
                }
                if ($DataUsuario['Turno'] != $Turno) {
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "usuario - Turno", $DataUsuario['Turno'], $Turno); 
                }
            echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Usuario Editado exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'Inicio';
                        }
                    });
                </script>";
            } else {
                // Notificación de error
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al editar el usuario',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>";
            }
        }

        public function EditarC($ID_Usuario1, $NombreCreo,$ID, $RH, $EPS,$ARL){
            $DataUsuario = $this->Mostrar($ID);     
            $Nombre1 = $DataUsuario["Nombre1"];
            if ($this->Modelo_Usuario->EditarC( $ID, $RH, $EPS, $ARL)){
                $Creo = 'modificocarnet';
                $Frase = $NombreCreo.' Modifico el carnet de '.$Nombre1;
                $ID_Actividad = $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID,$Creo,$Frase);
                if ($DataUsuario['RH'] != $RH) {
                    $NombreTabla = "usuario - RH";
                    $ValorAntiguo = $DataUsuario['RH'];
                    $ValorNuevo = $RH;
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad,$NombreTabla,$ValorAntiguo,$ValorNuevo);
                }
                if ($DataUsuario['EPS'] != $EPS) {
                    $NombreTabla = "usuario - EPS";
                    $ValorAntiguo = $DataUsuario['EPS'];
                    $ValorNuevo = $EPS;
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad,$NombreTabla,$ValorAntiguo,$ValorNuevo);
                }
                if ($DataUsuario['ARL'] != $ARL) {
                    $NombreTabla = "usuario - ARL";
                    $ValorAntiguo = $DataUsuario['ARL'];
                    $ValorNuevo = $ARL;
                    $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad,$NombreTabla,$ValorAntiguo,$ValorNuevo);
                }
                
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Usuario Editado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                            window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                            }
                        });
                    </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al editar el usuario',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>";
            }          
        }
        
        public function LeerE(){
            if ($this->Modelo_Usuario->LeerE()) {
                $Resultado = $this->Modelo_Usuario->LeerE();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function obtenerSupervisor() {
            if ($this->Modelo_Usuario->obtenerSupervisor()) {
                $Resultado = $this->Modelo_Usuario->obtenerSupervisor();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function obtenerSistemas() {
            if ($this->Modelo_Usuario->obtenerSistemas()) {
                $Resultado = $this->Modelo_Usuario->obtenerSistemas();
                return $Resultado;
            }
            else {
                return false;
            }
        }
        
        public function ContarUsuariosInactivos(){
            if ($this->Modelo_Usuario->ContarUsuariosInactivos()) {
                $Resultado = $this->Modelo_Usuario->ContarUsuariosInactivos();
                return $Resultado;
            }
            else {
                return 0;
            }
        }

        public function ActivarUsuario($ID_Usuario1, $NombreCreo,$ID_Usuario,$Nombre1) {
            if ($Resultado = $this->Modelo_Usuario->ActivarUsuario($ID_Usuario)){

                $Creo = 'activo';
                $Frase = $NombreCreo.' Activo el usuario de '.$Nombre1;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase);
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Usuario Activado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                            }
                        });
                    </script>
                ";
                return true;
            }else{
                echo "
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Usuario No pudo ser Activado',
                            icon: 'Error',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                            }
                        });
                    </script>
                ";
                return false;
            }
            
        }
            
        public function CalcularEdad($Fecha){
            $fechaNacimiento=new DateTime($Fecha);
            $hoy=new DateTime();
            $edad = $hoy->diff($fechaNacimiento)->y;
            echo $edad;       
        }       
        
        public function ListaMunicipios(){
            $api_url = "https://api-colombia.com/api/v1/Department";
            $response = file_get_contents($api_url);
            return $response;            
        }

        public function BuscarPersonaDocumento($No_Documento){
            if ($this->Modelo_Usuario->BuscarPersonaDocumento($No_Documento)) {
                return $this->Modelo_Usuario->BuscarPersonaDocumento($No_Documento);
            }else{
                return false;
            }
        }
    }
?>
