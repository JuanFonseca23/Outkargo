<?php
    include_once  "App/Models/Tickets.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";   
    include_once "App/Controllers/UsuarioController.php";

    class TicketsController {
        // Atributos
        private $Modelo_Tickets;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_Tickets = new Tickets();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
            $this->Controller_Usuarios = new UsuarioController();
        }

        public function Leer(){
            if ($this->Modelo_Tickets->Leer()) {
                $Resultado = $this->Modelo_Tickets->Leer();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerS($ID){
            if ($this->Modelo_Tickets->LeerS($ID)) {
                $Resultado = $this->Modelo_Tickets->LeerS($ID);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ObtenerUsuarios($ID_Excluir){
            if ($this->Modelo_Tickets->ObtenerUsuarios($ID_Excluir)) {
                $Resultado = $this->Modelo_Tickets->ObtenerUsuarios($ID_Excluir);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ObtenerDescripcionTicket($ID_Ticket){
            if ($this->Modelo_Tickets->ObtenerDescripcionTicket($ID_Ticket)) {
                $Resultado = $this->Modelo_Tickets->ObtenerDescripcionTicket($ID_Ticket);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ObtenerTicket($ID_Ticket){
            if ($this->Modelo_Tickets->ObtenerTicket($ID_Ticket)) {
                $Resultado = $this->Modelo_Tickets->ObtenerTicket($ID_Ticket);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function Obtenermensajes($ID_Ticket){
            if ($this->Modelo_Tickets->Obtenermensajes($ID_Ticket)) {
                $Resultado = $this->Modelo_Tickets->Obtenermensajes($ID_Ticket);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ObtenerDatos($ID_Ticket){
            if ($this->Modelo_Tickets->ObtenerDatos($ID_Ticket)) {
                $Resultado = $this->Modelo_Tickets->ObtenerDatos($ID_Ticket);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ObetenerEstadoEncuesta($ID_Usuario){
            $Resultado = $this->Modelo_Tickets->ObetenerEstadoEncuesta($ID_Usuario);
            if ($Resultado) {
                return $Resultado;
            } else {
                return false;
            }
        }

        public function ObetenerResultadosEncuesta($ID_Ticket){
            $Resultado = $this->Modelo_Tickets->ObetenerResultadosEncuesta($ID_Ticket);
            if ($Resultado) {
                return $Resultado; 
            } else {
                return false; 
            }
        }

        public function RegistrarTicket($ID_Solicitante, $NombreCompleto, $Centro, $Tipo, $Descripcion, $Evidencia_Fotografica, $correos, $Nombre1) {
            $Hora = date('H:i:s');
            $Estado = 0;    
            $Fecha_Creado = date("d/m/Y");
            $Estado_Aceptacion = 0;  
            $Estado_Encuesta = 0;  
            $ID_Ticket = $this->Modelo_Tickets->RegistrarTicket($ID_Solicitante, $Tipo, $Descripcion, $Estado, $Fecha_Creado, $Hora, $Estado_Aceptacion, $Estado_Encuesta);
            $Creo = 'creo';
            $ID_Usuario1 = $ID_Solicitante;
            $ID_Usuario = Null;
            $NombreCreo = $Nombre1;
                $Frase = $NombreCreo.' Creó el ticket con el codigó #'.$ID_Ticket.'.Tipo ' .$Tipo;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
            if (!$ID_Ticket) {
                echo 
                "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al registrar el ticket',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>";
                return;
            }
        
            $ID_Usuario = $ID_Solicitante;
            $this->RegistrarTicketEvidencias($ID_Ticket, $ID_Usuario, $Evidencia_Fotografica);
            $this->GenerarCorreos($correos, $ID_Ticket, $NombreCompleto, $Tipo, $Centro);
            
            echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Ticket registrado exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'VerTicket'; 
                        }
                    });
                </script>";
        }
                    
        public function RegistrarTicketEvidencias($ID_Ticket, $ID_Usuario, $Evidencia_Fotografica) {
            $uploadDir = 'App/Views/Upload/Img/Tickets/Evidencias/'; 
            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
            $contador = 1;
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            foreach ($Evidencia_Fotografica['tmp_name'] as $key => $tmpName) {
                $fileType = $Evidencia_Fotografica['type'][$key];
                if (in_array($fileType, $allowedTypes)) {
                    $extension = pathinfo($Evidencia_Fotografica['name'][$key], PATHINFO_EXTENSION); 
                    $NombreFoto = "Ticket{$ID_Ticket}_Evidencia{$contador}." . $extension; 
                    $uploadFile = $uploadDir . $NombreFoto; 
        
                    if (move_uploaded_file($tmpName, $uploadFile)) {
                        // Guarda la ruta en la base de datos
                        $ID_Detalle_Ticket = NULL;
                        $this->Modelo_Tickets->RegistrarTicketEvidencia($ID_Ticket, $ID_Usuario, $ID_Detalle_Ticket, $uploadFile);
                        $contador++;
                    } else {
                        echo "Error al cargar la imagen: $NombreFoto";
                    }
                } else {
                    echo "Tipo de archivo no permitido para {$Evidencia_Fotografica['name'][$key]}";
                }
            }
        }

        public function AceptarTicket ($ID_Ticket, $ID_Gestiona, $Nombre1){
            $Estado = 1; 
            $Estado_Aceptacion = 1;
            $this->Modelo_Tickets-> AceptarTicket($ID_Ticket, $ID_Gestiona, $Estado,$Estado_Aceptacion);
            $Creo = 'acepto';
            $ID_Usuario1 = $ID_Gestiona;
            $ID_Usuario = Null;
            $NombreCreo = $Nombre1;
                $Frase = $NombreCreo.' Acepto el ticket con el codigó #'.$ID_Ticket;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
            echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Ticket aceptado exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'VerTicketA'; 
                        }
                    });
                </script>";
        }

        public function RegistrarEncuesta($ID_Ticket, $ID_Evalua, $ID_Evaluado, $Respuesta_1, $Comentario_Respuesta_1, $Comentario, $Nombre1){
            $Estado_Encuesta = 1;
            if($this->Modelo_Tickets->RegistrarEncuesta($ID_Ticket, $ID_Evalua, $ID_Evaluado, $Respuesta_1, $Comentario_Respuesta_1, $Comentario)){
                $this->Modelo_Tickets->ActualizarEstado_Encuesta($ID_Ticket, $Estado_Encuesta);
                $Creo = 'realizo';
                $ID_Usuario1 = $ID_Evalua;
                $ID_Usuario = Null;
                $NombreCreo = $Nombre1;
                    $Frase = $NombreCreo.' Realizo la encuesta de sastifaccion del Ticket #'.$ID_Ticket;
                    $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Ticket aceptado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'VerTicket'; 
                            }
                        });
                    </script>";
            }
            
        }

        public function TransferirTicket ($ID_Ticket, $ID_Gestiona, $ID_Transfiere, $Nombre, $Nombre1){
            $this->Modelo_Tickets-> TransferirTicket($ID_Ticket, $ID_Gestiona);
            $Creo = 'transfirio';
            $ID_Usuario1 = $ID_Transfiere;
            $ID_Usuario = $ID_Gestiona;
            $NombreTransfirio = $Nombre;
            $NombreRecibio = $Nombre1;
            $Frase = $NombreTransfirio.' Transfirio el ticket con el codigó #'.$ID_Ticket.'.Al Usuario ' .$NombreRecibio;
            $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
            echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'El Ticket ha sido transferido exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'VerTicketA'; 
                        }
                    });
                </script>";
        }

        public function FinalizarTicket($ID_Ticket, $ID_Gestiona, $Nombre1, $Correo, $NombreCompleto){
            $Estado = 2; 
            $Fecha_Finalizado = date("d/m/Y");
            if($this->Modelo_Tickets-> FinalizarTicket($ID_Ticket,  $Estado, $Fecha_Finalizado)){
                $this->GenerarCorreosEncuestas($Correo, $ID_Ticket, $NombreCompleto, $ID_Gestiona);
                $Creo = 'finalizo';
                $ID_Usuario1 = $ID_Gestiona;
                $ID_Usuario = Null;
                $NombreCreo = $Nombre1;
                    $Frase = $NombreCreo.' Finalizo el ticket con el codigó #'.$ID_Ticket;
                    $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Ticket se ha cerrado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'VerTicketA'; 
                            }
                        });
                    </script>";
            }
        }
        
        private function GenerarCorreos($correos, $ID_Ticket, $NombreCompleto, $Tipo, $Centro) {
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
                $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
        
                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Se Ha generado un Nuevo Ticket';
        
                // Contenido del correo en HTML
                $mail->Body = '
                <html>
                <head>
                    <style>
                        /* Estilo del correo */
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
                        .footer {
                            text-align: center;
                            font-size: 14px;
                            color: #888;
                            padding: 10px;
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
                            <p>El Usuario: <strong class="highlight">' . htmlspecialchars($NombreCompleto) . '</strong>,</p>
                            <p>Del Centro de Trabajo: <strong class="highlight">' . htmlspecialchars($Centro) . '</strong>,</p>
                            <p>ha generado un nuevo ticket con el código: <strong class="highlight">' . htmlspecialchars($ID_Ticket) . '</strong> de tipo: <strong class="highlight">' . htmlspecialchars($Tipo) . '</strong>.</p>
                            <p>Ingresa a la plataforma para poder dar solución.</p>
                        </div>
                        <div class="footer">
                            <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                        </div>
                    </div>
                </body>
                </html>';
        
                // Añadir destinatarios
                foreach ($correos as $correo) {
                    $mail->addAddress($correo); 
                }
        
                // Enviar el correo
                $mail->send();
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        
        private function GenerarCorreosEncuestas($Correo, $ID_Ticket, $NombreCompleto, $ID_Gestiona) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $ResolverEncuesta = "localhost/Outkargo2/Tickets/Encuesta?ID=$ID_Ticket&ID_Gestiona=$ID_Gestiona";
            }else {
                $ResolverEncuesta = "https://Outkargo.com.co/Tickets/Encuesta?ID=$ID_Ticket&ID_Gestiona=$ID_Gestiona/";
            }
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; 
                $mail->Password   = 'B=7WtN;p'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
        
                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->addAddress($Correo, $NombreCompleto);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Se ha resuelto el Ticket #' . $ID_Ticket .'';
                $mail->Body = '
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
                            <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($NombreCompleto) . '</strong>,</p>
                            <p>El ticket con el numero: <strong class="highlight">' . htmlspecialchars($ID_Ticket) . '</strong> Fue finalizado con exito</p>
                            <p>Resuelve la siguiente encuesta de sastifaccion dando clic en el siguente boton:</p>
                            <a href="'.$ResolverEncuesta.'" class="button">Resolver Encuesta</a>
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

        public function sendMessage($id_ticket, $id_remitente, $id_destinatario, $mensaje, $Evidencia_Fotografica) {
            $ID_Detalle_Ticket = $this->Modelo_Tickets->sendMessage($id_ticket, $id_remitente, $id_destinatario, $mensaje);
            $ID_Usuario = $id_remitente;
            $this->RegistrarTicketEvidenciasMensajes($id_ticket, $ID_Usuario, $ID_Detalle_Ticket, $Evidencia_Fotografica);
        }
    
        public function getMessages($id_ticket) {
            return $this->Modelo_Tickets->getMessages($id_ticket);
        }

        public function RegistrarTicketEvidenciasMensajes($id_ticket, $ID_Usuario, $ID_Detalle_Ticket, $Evidencia_Fotografica) {
            $uploadDir = 'App/Views/Upload/Img/Tickets/Evidencias/'; 
            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
            $contador = 1;
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            foreach ($Evidencia_Fotografica['tmp_name'] as $key => $tmpName) {
                $fileType = $Evidencia_Fotografica['type'][$key];
                if (in_array($fileType, $allowedTypes)) {
                    $extension = pathinfo($Evidencia_Fotografica['name'][$key], PATHINFO_EXTENSION); 
                    $NombreFoto = "Ticket{$id_ticket}_Mensaje{$ID_Detalle_Ticket}_Evidencia{$contador}." . $extension; 
                    $uploadFile = $uploadDir . $NombreFoto; 
        
                    if (move_uploaded_file($tmpName, $uploadFile)) {
                        // Guarda la ruta en la base de datos
                        $this->Modelo_Tickets->RegistrarTicketEvidencia($id_ticket, $ID_Usuario, $ID_Detalle_Ticket, $uploadFile);
                        $contador++;
                    } else {
                        echo "Error al cargar la imagen: $NombreFoto";
                    }
                } else {
                    echo "Tipo de archivo no permitido para {$Evidencia_Fotografica['name'][$key]}";
                }
            }
        }

    }
?>
