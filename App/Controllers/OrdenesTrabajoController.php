<?php
    include_once  "App/Models/OrdenesTrabajo.php";
    include_once  "App/Models/OrdenesCompra.php";
    include_once  "App/Models/Productos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";   
    include_once "App/Controllers/UsuarioController.php";

    class OrdenesTrabajoController {
        // Atributos
        private $Modelo_OrdenesTrabajo;
        private $Modelo_OrdenesCompra;
        private $Modelo_Inventario;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Contactos;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_OrdenesTrabajo = new OrdenesTrabajo();
            $this->Modelo_OrdenesCompra = new OrdenesCompra();
            $this->Modelo_Inventario = new Productos(); 
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
            $this->Controller_Usuarios = new UsuarioController();
        }

        public function ActualizarOrden($ID_Trabajo, $ID_Detalle, $DescripcionT, $Tipo_Trabajo, $Estado_Trabajo){

            $actualizoDescripcion = $this->Modelo_OrdenesTrabajo->ActualizarOrden($ID_Detalle, $DescripcionT);

            if ($actualizoDescripcion) {
                $actualizoEstado = $this->Modelo_OrdenesTrabajo->ActualizarEstado($ID_Trabajo, $Estado_Trabajo, $Tipo_Trabajo);
                if ($actualizoEstado) {
                    return true;   
                } else {
                    return false;  
                }
            } else {
                return false;     
            }
        }

        public function AutorizarOrdenTrabajo($ID_Autoriza, $ID_Solicitud, $Firma, $Numero_Orden,$Comentarios, $Estados, $NombreCreo){
            $Fecha_Autorizacion = date("d/m/Y");
            $Estado_Trabajo = 1;
            if($this->Modelo_OrdenesTrabajo->AutorizarOrdenTrabajo( $ID_Solicitud, $Firma, $Comentarios, $Fecha_Autorizacion, $Estado_Trabajo)){
                foreach ($Estados as $ID_Detalle => $Estado) {
                    $this->Modelo_OrdenesTrabajo->ActualizarEstadoDetalle($ID_Detalle,$Estado);
                }
                
                $ID_Usuario1 = $ID_Autoriza;
                $ID_Usuario2 = null;
                $Creo = 'autorizo';
                $Frase = $NombreCreo . ' Autorizó la solicitud de compra #' . $Numero_Orden;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario2, $Creo, $Frase);
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'La solicitud ha sido revisada correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'InicioSolicitud';
                        }
                    });
                </script>";
            }else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo revisar la solicitud.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                </script>";
            }
        }

        public function BuscarBateria(){
            header('Content-Type: application/json; charset=utf-8');
            $Q = $_GET['q'] ?? '';
            if (strlen($Q) < 2) {
                echo json_encode([]);
                exit;
            }
            $Resultados = $this->Modelo_OrdenesTrabajo->BuscarBateria($Q);
            echo json_encode($Resultados);
            exit;
        }

        public function BuscarCargadores(){
            header('Content-Type: application/json; charset=utf-8');
            $Q = $_GET['q'] ?? '';
            if (strlen($Q) < 2) {
                echo json_encode([]);
                exit;
            }
            $Resultados = $this->Modelo_OrdenesTrabajo->BuscarCargadores($Q);
            echo json_encode($Resultados);
            exit;
        }

        public function BuscarInsumos(){
            header('Content-Type: application/json; charset=utf-8');
            $Q = $_GET['q'] ?? '';
            if (strlen($Q) < 2) {
                echo json_encode([]);
                exit;
            }
            $Resultados = $this->Modelo_OrdenesTrabajo->BuscarInsumos($Q);
            echo json_encode($Resultados);
            exit;
        }
        
        public function BuscarMontacargas(){
            header('Content-Type: application/json; charset=utf-8');
            $Q = $_GET['q'] ?? '';
            if (strlen($Q) < 2) {
                echo json_encode([]);
                exit;
            }
            $Resultados = $this->Modelo_OrdenesTrabajo->BuscarMontacargas($Q);
            echo json_encode($Resultados);
            exit;
        }

        public function BuscarTecnicos(){
            header('Content-Type: application/json; charset=utf-8');
            $Q = $_GET['q'] ?? '';
            if (strlen($Q) < 2) {
                echo json_encode([]);
                exit;
            }
            $Resultados = $this->Modelo_OrdenesTrabajo->BuscarTecnicos($Q);
            echo json_encode($Resultados);
            exit;
        }

        public function CambiarEstadoOrden($ID_Orden, $Estado){
            $Resultado = $this->Modelo_OrdenesTrabajo->CambiarEstadoOrden($ID_Orden, $Estado);
            if($Resultado){
                return True;
            }else{
                return False;
            }
        }

        public function CambiarFecha($ID_Orden, $Fecha, $Fecha_FinO){
            $Resultado = $this->Modelo_OrdenesTrabajo->CambiarFecha($ID_Orden, $Fecha, $Fecha_FinO);
            if($Resultado){
                return True;
            }else{
                return False;
            }
        }

        public function ContarOrdenesPorCentro($ID_Centro) {
            $Resultado = $this->Modelo_OrdenesTrabajo->ContarOrdenesPorCentro($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarSolicitudesPorCentro($ID_Centro) {
            $Resultado = $this->Modelo_OrdenesTrabajo->ContarSolicitudesPorCentro($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function EliminarDetalleInsumoTemp($ID_Orden, $ID_Insumo){
            if($this->Modelo_OrdenesTrabajo->EliminarDetalleInsumoTemp($ID_Orden, $ID_Insumo)){
                return true; 
            }else{
                return false; 
            }
        }

        public function EnviarCorreo($ID_Solicitud, $Correo_Supervisor, $Nombre_Supervisor, $CodigoSolicitud){
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME'];
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "http://localhost/OUTKARGO/OrdenesTrabajo/AutorizarSolicitudT?ID=$ID_Solicitud";
                $Link = "http://localhost/OUTKARGO/OrdenesTrabajo/VerSolicitud?ID=$ID_Solicitud";
            }else {
                $AceptarSolicitud = "https://outkargo.com.co/OrdenesTrabajo/AutorizarSolicitudT?ID=$ID_Solicitud/";
                $Link = "https://outkargo.com.co/OrdenesTrabajo/VerSolicitud?ID=$ID_Solicitud";
            }
            try{
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
                $mail->Subject = 'Autorizar Solictud de Orden de Trabajo #' . $CodigoSolicitud;
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
                        <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" />
                        <h1>OUTKARGO</h1>
                    </div>

                    <div class="content">
                        <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Supervisor) . '</strong>,</p>
                        <p>se ha creado la solicitud de orden de trabajo #<strong class="highlight">' . htmlspecialchars($CodigoSolicitud) . '</strong></strong>,</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Orden' . $ID_Solicitud . '.pdf</strong>
                                </td>
                                <td align="right" style="padding:12px;">
                                    <a href="' . $Link . '" target="_blank"
                                        style="background:#ff5000; color:#ffffff; padding:8px 14px;
                                            border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <a href="' . $AceptarSolicitud . '" target="_blank"
                            style="background:#007BFF; color:#ffffff; padding:8px 14px; border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                            Autorizar Solicitud </a>
                    </div>

                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                    </div>

                </div>
                </body>
                </html>';
                $mail->send();
                echo "
                    <script>
                        window.location.href = 'InicioOrden';
                    </script>";
                exit;
            }
            catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        public function EnviarCorreo1($ID_Orden, $ID_Verifica, $Numero){
            $Destinatario = $this->Modelo_OrdenesTrabajo->ObtenerCorreo($ID_Verifica);
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME'];
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "http://localhost/OUTKARGO/OrdenesTrabajo/AutorizarOrden?ID=$ID_Orden";
                $Link = "http://localhost/OUTKARGO/OrdenesTrabajo/VerOrden?ID=$ID_Orden";
            }else {
                $AceptarSolicitud = "https://outkargo.com.co/OrdenesTrabajo/AutorizarOrden?ID=$ID_Orden/";
                $Link = "https://outkargo.com.co/OrdenesTrabajo/VerOrden?ID=$ID_Orden";
            }
            try{
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
                $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                 
                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->addAddress($Destinatario['Correo'], $Destinatario['NombreCompleto']);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Autorizar Orden de Trabajo #' . $Numero;
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
                        <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" />
                        <h1>OUTKARGO</h1>
                    </div>

                    <div class="content">
                        <p>Buen Dia, <strong class="highlight">' . $Destinatario['NombreCompleto'] . '</strong>,</p>
                        <p>se ha finalizado la orden de trabajo #<strong class="highlight">' . htmlspecialchars($Numero) . '</strong></strong>,</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Orden' . $ID_Orden . '.pdf</strong>
                                </td>
                                <td align="right" style="padding:12px;">
                                    <a href="' . $Link . '" target="_blank"
                                        style="background:#ff5000; color:#ffffff; padding:8px 14px;
                                            border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <a href="' . $AceptarSolicitud . '" target="_blank"
                            style="background:#007BFF; color:#ffffff; padding:8px 14px; border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                            Autorizar Orden </a>
                    </div>

                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                    </div>

                </div>
                </body>
                </html>';
                $mail->send();
                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }

        public function EnviarCorreo2($ID_Salida, $NombreEntrega, $CorreoEntrega, $No_Formulario){
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME'];
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "http://localhost/OUTKARGO/Productos/FirmarEntrega?ID=$ID_Salida&No_Formulario=$No_Formulario";
                $Link = "http://localhost/OUTKARGO/Productos/VerSalida?ID=$ID_Salida";
            }else {
                $AceptarSolicitud = "https://outkargo.com.co/Productos/FirmarEntrega?ID=$ID_Salida&No_Formulario=$No_Formulario/";
                $Link = "https://outkargo.com.co/Productos/VerSalida?ID=$ID_Salida";
            }
            try{
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
                $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                 
                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->addAddress($CorreoEntrega, $NombreEntrega);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Salida de insumos #' . $No_Formulario;
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
                        <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" />
                        <h1>OUTKARGO</h1>
                    </div>

                    <div class="content">
                        <p>Buen Dia, <strong class="highlight">' . htmlspecialchars(string: $NombreEntrega) . '</strong>,</p>
                        <p>Se ha realizado la salida de repuestos e insumos #<strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong></strong>,</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Salida' . $ID_Salida . '.pdf</strong>
                                </td>
                                <td align="right" style="padding:12px;">
                                    <a href="' . $Link . '" target="_blank"
                                        style="background:#ff5000; color:#ffffff; padding:8px 14px;
                                            border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <a href="' . $AceptarSolicitud . '" target="_blank"
                            style="background:#007BFF; color:#ffffff; padding:8px 14px; border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                            Autorizar Salida </a>
                    </div>

                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                    </div>

                </div>
                </body>
                </html>';
                $mail->send();
                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }

        public function EnviarCorreo3($ID_Salida, $NombreSupervisor, $CorreoSupervisor, $No_Formulario, $DocumentoSupervisor){
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME'];
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "http://localhost/OUTKARGO/Productos/FirmaSupervisorSalida?Documento=$DocumentoSupervisor&Salida=$ID_Salida&No_Formulario=$No_Formulario";
                $Link = "http://localhost/OUTKARGO/Productos/VerSalida?ID=$ID_Salida";
            }else {
                $AceptarSolicitud = "https://Outkargo.com.co/Productos/FirmaSupervisorSalida?Documento=$DocumentoSupervisor&Salida=$ID_Salida&No_Formulario=$No_Formulario/";
                $Link = "https://outkargo.com.co/Productos/VerSalida?ID=$ID_Salida";
            }
            try{
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
                $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                 
                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->addAddress($CorreoSupervisor, $NombreSupervisor);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Autorizar Salida de insumos #' . $No_Formulario;
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
                        <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" />
                        <h1>OUTKARGO</h1>
                    </div>

                    <div class="content">
                        <p>Buen Dia, <strong class="highlight">' . htmlspecialchars(string: $NombreSupervisor) . '</strong>,</p>
                        <p>Se ha realizado la salida de repuestos e insumos #<strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong></strong>,</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Salida' . $ID_Salida . '.pdf</strong>
                                </td>
                                <td align="right" style="padding:12px;">
                                    <a href="' . $Link . '" target="_blank"
                                        style="background:#ff5000; color:#ffffff; padding:8px 14px;
                                            border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <a href="' . $AceptarSolicitud . '" target="_blank"
                            style="background:#007BFF; color:#ffffff; padding:8px 14px; border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                            Autorizar Salida </a>
                    </div>

                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                    </div>

                </div>
                </body>
                </html>';
                $mail->send();
                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }

        public function EnviarCorreos($ID_Orden, $NuevoCodigo, $ID_Tecnicos){
            $Destinatarios = $this->Modelo_OrdenesCompra->ObtenerCorreos($ID_Tecnicos);
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME'];
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "http://localhost/OUTKARGO/OrdenesTrabajo/RealizarOrden?ID=$ID_Orden";
                $Link = "http://localhost/OUTKARGO/OrdenesTrabajo/VerOrden?ID=$ID_Orden";
            }else {
                $AceptarSolicitud = "https://outkargo.com.co/OrdenesTrabajo/RealizarOrden?ID=$ID_Orden/";
                $Link = "https://outkargo.com.co/OrdenesTrabajo/VerOrden?ID=$ID_Orden";
            }
            try{
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
                $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                if (empty($Destinatarios)) {
                    throw new Exception('No se encontraron destinatarios.');
                }

                foreach ($Destinatarios as $Destinatario) {
                    $mail->addAddress($Destinatario['Correo'], $Destinatario['NombreCompleto']);
                }
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Asignacion Orden de Trabajo #' . $NuevoCodigo;
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
                        <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" />
                        <h1>OUTKARGO</h1>
                    </div>
                    
                    <div class="content">
                        <p>Buen Dia</p>
                        <p>se ha creado la orden de trabajo #<strong class="highlight">' . htmlspecialchars($NuevoCodigo) . '</strong></strong>,</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Solicitud_' . $NuevoCodigo . '.pdf</strong>
                                </td>
                                <td align="right" style="padding:12px;">
                                    <a href="' . $Link . '" target="_blank"
                                        style="background:#ff5000; color:#ffffff; padding:8px 14px;
                                            border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <a href="' . $AceptarSolicitud . '" target="_blank"
                            style="background:#007BFF; color:#ffffff; padding:8px 14px; border-radius:4px; text-decoration:none; font-size:14px; display:inline-block;">
                            Realizar Orden </a>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
                    </div>

                </div>
                </body>
                </html>';
                $mail->send();
                echo "
                    <script>
                        window.location.href = 'InicioSolicitud';
                    </script>";
                exit;
            }
            catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        public function FirmarOrden($ID_Orden, $ID_Mecanicos, $FirmasMecanicos, $Estado_Trabajo, $ID_Centro, $ID_Verifica, $Numero){
            $totalFirmas = count($FirmasMecanicos);
            $firmasGuardadas = 0;
            $FechaInicio = Null;
            $FechaFirma = date("d/m/Y");
            $EstadoFirmaMecanico = 1;
            foreach ($FirmasMecanicos as $Mecanico => $Firma) {
                if (!empty($Firma)) {
                    $ID_Mecanico = $ID_Mecanicos[$Mecanico];
                    $Resultado = $this->Modelo_OrdenesTrabajo->FirmarOrden($ID_Orden, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
                    if ($Resultado) {
                        $firmasGuardadas++;
                    }
                }
            }
    
            if ($firmasGuardadas === $totalFirmas && $totalFirmas > 0) {
                $this->Modelo_OrdenesTrabajo->CambiarEstadoOrden($ID_Orden, $Estado_Trabajo);
                $this->Modelo_OrdenesTrabajo->CambiarFecha($ID_Orden, $FechaInicio, $FechaFirma);
                $Ultimo_Formulario= $this->Modelo_Inventario->ObtenerNumeroFormularioSalida();
                if ($Ultimo_Formulario) {
                    $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
                } else {
                    $No_Formulario = '000001';
                }
                $Usuarios = $this->Modelo_OrdenesTrabajo->BuscarUsuario();
                $ID_Usuario = Null;
                $ID_Supervisor = Null;

                foreach ($Usuarios AS $Usuario){
                    if ((int)$Usuario['Cargo'] === 2){
                        $ID_Usuario = $Usuario['ID_Usuario'];
                        $NombreEntrega = $Usuario['Nombre'];
                        $CorreoEntrega = $Usuario['Correo'];
                    }

                    if ((int)$Usuario['Cargo'] === 11){
                        $ID_Supervisor = $Usuario['ID_Usuario'];
                        $NombreSupervisor = $Usuario['Nombre'];
                        $CorreoSupervisor = $Usuario['Correo'];
                        $DocumentoSupervisor = $Usuario['Documento'];
                    }
                }

                if (!$ID_Usuario || !$ID_Supervisor){
                    return false; 
                }
                $Estado = 2;
                $Firma_Estado_Salida = 2;
                $ID_Destino = $ID_Centro;
                $Mecanico = null;
                $FirmaRecibe = null;

                foreach ($FirmasMecanicos as $Indice => $Firma) {
                    if (!empty($Firma)) {
                        $Mecanico = $ID_Mecanicos[$Indice];
                        $FirmaRecibe = $Firma;
                        break;
                    }
                }

                $Firma_Usuario = NULL;
                $Tipo_Origen = 'Orden de trabajo';
                $Fecha_Recibe = date("d/m/Y");

                if (!$Mecanico || !$FirmaRecibe){
                    return false;
                }

                if($ID=$this->Modelo_Inventario->FirmarSalida($ID_Usuario, $Mecanico, $ID_Supervisor, $ID_Centro, $ID_Destino, $ID_Orden, $No_Formulario, $Tipo_Origen, $FechaFirma, $Fecha_Recibe, $Estado, $Firma_Usuario, $FirmaRecibe, $Firma_Estado_Salida, $EstadoFirmaMecanico)){
                    $ID_Salida = $ID;
                    //Traemos Insumos temp
                    $DataInsumoTemp = $this->VerDetalleInsumoTemp($ID_Orden);
                    foreach($DataInsumoTemp as $Insumo){
                        $ID_Insumo = $Insumo['ID_Producto'];
                        $Cantidad_Solicitadad = $Insumo['Cantidad'];
                        $Productos = $this->Modelo_Inventario->ObtenerProductosPEPS($ID_Insumo, $ID_Centro);
                        foreach($Productos as $Producto){
                            if($Cantidad_Solicitadad <=0) break;
                            $Disponible = $Producto['Cantidad'];
                            $Usar = min($Disponible, $Cantidad_Solicitadad);

                            //Descontamos de Inventario
                            $this->Modelo_Inventario->DescontarInventario($Producto['ID'], $Usar, $ID_Centro);
                        
                            //Registramos los Detalles
                            $this->Modelo_Inventario->RegistrarDetalleSalida($Mecanico, $ID_Salida, $ID_Insumo, $Usar, $Producto['N_Factura'], $Producto['N_Lote'], $Producto['valor_unitario']);
                            $Cantidad_Solicitadad -= $Usar;
                        }

                        if ($Cantidad_Solicitadad > 0){
                            return false; 
                        }

                        if($this->Modelo_OrdenesTrabajo->RegistrarDetalleInsumo($ID_Orden, $ID_Insumo, $Insumo['Cantidad'], $Insumo['Medida'])){
                            $this->Modelo_OrdenesTrabajo->EliminarDetalleInsumoTemp($ID_Orden, $Insumo['ID']);
                        }
                    }

                    $this->EnviarCorreo1($ID_Orden, $ID_Verifica, $Numero);
                    $this->EnviarCorreo2($ID_Salida, $NombreEntrega, $CorreoEntrega, $No_Formulario);
                    $this->EnviarCorreo3($ID_Salida, $NombreSupervisor, $CorreoSupervisor, $No_Formulario, $DocumentoSupervisor);

                    $ID_Usuario1 = $Mecanico;
                    $ID_Usuario2 = Null;
                    $Creo = 'finalizo';
                    $Frase = 'Se completo la orden de trabajo: '.$ID_Orden;
                    $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);

                    return true;
                }else{
                    return false;
                }    
            } else {
                return false;
            }
        }

        public function FirmarOrdenVerificada($ID_Orden, $ID_Verifica, $Estado_Trabajo, $FirmaVerifica, $Numero, $Nombre){
            $FechaFirma = date("d/m/Y");
            $Estado_Firma_Trabajo = 1;
            if($this->Modelo_OrdenesTrabajo->VerficarOrden($ID_Orden, $ID_Verifica, $Estado_Trabajo, $FirmaVerifica, $Estado_Firma_Trabajo)){
                $ID_Usuario1 = $ID_Verifica;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre. 'Se completo la orden de trabajo: # '.$Numero;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                return true;
            }else{
                return false;
            }  
        }

        public function InsertarDetalleInsumoTemp($ID_Orden, $ID_Insumo, $Cantidad, $Medida, $ID_Usuario){
            $Conversiones = [
                "1/4" => 0.25,
                "1/2" => 0.5,
                "3/4" => 0.75,
            ];
            $CantidadF = isset($Conversiones[$Medida]) ? $Cantidad * $Conversiones[$Medida] : $Cantidad;
            if($this->Modelo_OrdenesTrabajo->InsertarDetalleInsumoTemp($ID_Orden, $ID_Insumo, $CantidadF, $Medida, $ID_Usuario)){
                return true; 
            }else{
                return false; 
            }
        }

        public function leerOrdenesTrabajo($ID_Centro){
            if ($this->Modelo_OrdenesTrabajo->leerOrdenesTrabajo($ID_Centro)) {
                $Resultado = $this->Modelo_OrdenesTrabajo->leerOrdenesTrabajo($ID_Centro);
                return $Resultado;
            }
        }

        public function leerSolicitudesTrabajo($ID_Centro) {
            if ($this->Modelo_OrdenesTrabajo->leerSolicitudesTrabajo($ID_Centro)) {
                $Resultado = $this->Modelo_OrdenesTrabajo->leerSolicitudesTrabajo($ID_Centro);
                return $Resultado;
            }
        }

         public function MostrarDetallesSolicitud($ID){
            $Filas = $this->Modelo_OrdenesTrabajo->MostrarDetallesSolicitud($ID);
            return $Filas;

        }

        public function ObtenerTrabajos(){
            header('Content-Type: application/json; charset=utf-8');
            $ID = $_GET['id'];
            $Tipo_Trabajo = $_GET['tipo'];
            if ($Tipo_Trabajo === 'Repuesto') {
                $Resultados = $this->Modelo_OrdenesTrabajo->ObtenerTrabajosRepuestos($ID);

            }else{
                $Resultados = $this->Modelo_OrdenesTrabajo->ObtenerTrabajos($Tipo_Trabajo, $ID);
            }

            echo json_encode($Resultados);
        }

        public function PausarOrden($ID_Orden, $ID_Usuario, $Estado_Trabajo, $DescripcionT){
            if($this->Modelo_OrdenesTrabajo->RegistrarPausa($ID_Orden, $ID_Usuario, $DescripcionT)){
                $Resultado = $this->Modelo_OrdenesTrabajo->CambiarEstadoOrden($ID_Orden, $Estado_Trabajo);
                if($Resultado){
                    return True;
                }else{
                    return False;
                }
            }
        }

        public function RegistrarOrdenTrabajo ($ID_Usuario, $NombreCreo, $Tipo_Trabajo, $Prioridad, $ID_Tecnicos, $Centro_Trabajo, $Fecha_InicioF, $Fecha_FinF, $Trabajos){
            $Fecha_Generado = date("d/m/Y");
            $EstadoFirmaVerifica = 0;
            $Estado_Orden = 'Pendiente';
            $ultimoCodigo = $this->Modelo_OrdenesTrabajo->ObtenerUltimoCodigoOrden();
            if($ultimoCodigo){
                $NuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            }else{
                $NuevoCodigo = '000001';
            }
            if($ID = $this->Modelo_OrdenesTrabajo->RegistrarOrdenTrabajo($ID_Usuario, $Centro_Trabajo, $NuevoCodigo, $Prioridad, $Fecha_Generado, $Fecha_InicioF, $Fecha_FinF, $EstadoFirmaVerifica, $Estado_Orden, $Tipo_Trabajo)){
                $ID_Orden = $ID;
                if (is_array($Trabajos)) {
                    foreach ($Trabajos as $trabajo) {
                        if (!isset($trabajo['id'])) { continue;}
                        $ID_Trabajo = (int)$trabajo['id'];
                        $this->Modelo_OrdenesTrabajo->RegistrarDetalleOrden($ID_Orden, $ID_Trabajo);
                    }
                }
                if (!empty($ID_Tecnicos)) {
                    for ($i = 0; $i < count($ID_Tecnicos); $i++) {
                        $ID_Tecnico = $ID_Tecnicos[$i];
                        $this->Modelo_OrdenesTrabajo->RegistrarTecnicoOrden($ID_Orden, $ID_Tecnico, $EstadoFirmaVerifica);
                    }
                }
                
                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $NombreCreo.' Creó la solicitud de orden de trabajo con ID: '.$ID_Orden;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                $this->EnviarCorreos($ID_Orden, $NuevoCodigo,  $ID_Tecnicos);
                return $ID_Orden;
            }
        }

        public function RegistarSolicitud($ID_Solicitante, $ID_Centro, $ID_Supervisor, $Correo_Supervisor, $Nombre_Supervisor, $Firma_Solicitante, $NombreCreo, $TiposEquipo, $Cantidades, $Productos, $Descripciones){
            $Fecha_Solicitud = date("d/m/Y");
            $EstadoFirmaSupervisor = 0;
            $EstadoTrabajo = 0;
            $ultimoCodigo = $this->Modelo_OrdenesTrabajo->ObtenerUltimoCodigoDiagnostico();
            if ($ultimoCodigo) {
               $nuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $nuevoCodigo = '000001';
            }
            if($ID = $this->Modelo_OrdenesTrabajo->RegistarSolicitud($ID_Solicitante, $ID_Supervisor, $ID_Centro, $nuevoCodigo, $Fecha_Solicitud, $EstadoFirmaSupervisor, $Firma_Solicitante, $EstadoTrabajo)){
                $ID_Solicitud = $ID;

                for ($i = 0; $i < count($Productos); $i++) {
                    $ID_Producto = $Productos[$i];
                    $Cantidad = empty($Cantidades[$i]) ? null : $Cantidades[$i];
                    $Descripcion = $Descripciones[$i];
                    $TipoEquipo = $TiposEquipo[$i];
                    $this->Modelo_OrdenesTrabajo->RegistrarDetalleSolicitud($ID_Solicitud, $ID_Producto, $Cantidad, $TipoEquipo, $Descripcion, $EstadoTrabajo);
                }

                $this->EnviarCorreo($ID_Solicitud, $Correo_Supervisor, $Nombre_Supervisor, $nuevoCodigo);

                $ID_Usuario1 = $ID_Solicitante;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $NombreCreo.' Creó la solicitud de orden de trabajo con ID: '.$ID_Solicitud;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                return $ID_Solicitud;
            }
                
        }

        public function TraerSolicitud() {
            return $this->Modelo_OrdenesTrabajo->TraerSolicitud();
        }

        public function TraerSupervisores() {
            $Resultado = $this->Modelo_OrdenesTrabajo->TraerSupervisores();
            return $Resultado;
        }

        public function VerDetallesInsumosOrden($ID){
            $DataInsumos = $this->Modelo_OrdenesTrabajo->VerDetallesInsumosOrden($ID);
            return $DataInsumos;
        }

        public function VerDetalleInsumoTemp($ID){
            $DataInsumoTemp = $this->Modelo_OrdenesTrabajo->VerDetalleInsumoTemp($ID);
            return $DataInsumoTemp;
        }

        public function VerDetallesOrden($ID, $Tipo){
            $DataOrdenDetalles = $this->Modelo_OrdenesTrabajo->VerDetallesOrden($ID, $Tipo);
            return $DataOrdenDetalles;
        }

        public function VerMecanicos($ID){
            $DataMecanicos = $this->Modelo_OrdenesTrabajo->VerMecanicos($ID);
            return $DataMecanicos;
        }

        public function VerMontacargas($ID){
            $DataMontacargas = $this->Modelo_OrdenesTrabajo->VerMontacargas($ID);
            return $DataMontacargas;
        }

        public function VerOrden($ID){
            $DataOrden = $this->Modelo_OrdenesTrabajo->VerOrden($ID);
            return $DataOrden;
        }

        public function VerSolicitud($ID){
            $DataSolicitud = $this->Modelo_OrdenesTrabajo->VerSolicitud($ID);
            return $DataSolicitud;
        }

    }
       
?>
