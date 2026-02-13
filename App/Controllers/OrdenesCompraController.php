<?php
    include_once  "App/Models/OrdenesCompra.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";   
    include_once "App/Controllers/UsuarioController.php";

    class OrdenesCompraController {
        // Atributos
        private $Modelo_OrdenesCompra;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Contactos;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_OrdenesCompra = new OrdenesCompra();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
            $this->Controller_Usuarios = new UsuarioController();
        }
        // Métodos
        public function AutorizarSolicitudCompra($ID_Solicitud, $Estados, $Firma, $ID_Autoriza, $NombreCreo, $Numero_Orden){ 
            $FechaAutoriza = date("d/m/Y");
            $resultado = $this->Modelo_OrdenesCompra->AutorizarSolicitudCompra($ID_Solicitud, $ID_Autoriza, $Firma, $FechaAutoriza);

            if ($resultado > 0) {

                if (is_array($Estados)) {
                    foreach ($Estados as $ID_Detalle => $Estado) {
                        $this->Modelo_OrdenesCompra->ActualizarEstadoDetalleSolicitud($ID_Detalle, $Estado);
                    }
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

        public function BuscarDestinatarios(){
            header('Content-Type: application/json; charset=utf-8');
            $Q = $_GET['q'] ?? '';
            if (strlen($Q) < 2) {
                echo json_encode([]);
                exit;
            }
            $Resultados = $this->Modelo_OrdenesCompra->BuscarDestinatarios($Q);
            echo json_encode($Resultados);
            exit;
        }

        public function ContarSolicitudesPorCentro($ID_Centro) {
            $Resultado = $this->Modelo_OrdenesCompra->ContarSolicitudesPorCentro($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function DetallesTempSolicitudCompra($ID_Usuario) {
            return $this->Modelo_OrdenesCompra->DetallesTempSolicitudCompra($ID_Usuario);
        }

        public function EliminarSolicitudTemp($ID_Usuario, $ID) {
            return $this->Modelo_OrdenesCompra->EliminarSolicitudTemp($ID_Usuario, $ID);
        }

        public function EnviarCorreos($ID_Solicitud, $ID_Correos, $Asunto1, $Mensaje, $Link){
            $Destinatarios = $this->Modelo_OrdenesCompra->ObtenerCorreos($ID_Correos);
        
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 

            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "http://localhost/OUTKARGO/OrdenesCompra/AutorizarSolicitud?ID=$ID_Solicitud";
            }else {
                $AceptarSolicitud = "https://outkargo.com.co/OrdenesCompra/AutorizarSolicitud?ID=$ID_Solicitud/";
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
                $mail->Subject = $Asunto1;
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
                        <p>' . nl2br(htmlspecialchars($Mensaje)) . '</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Solicitud_' . $ID_Solicitud . '.pdf</strong>
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
                        window.location.href = 'InicioSolicitud';
                    </script>";
                exit;
            }
            catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        public function InsertarSolicitudCompra($ID_Usuario, $ID_Centro, $Firma_Solicita, $Fecha_Solicitud, $Nombre_Ingresa, $Descripcion) {

            $UltimoNumero = $this->Modelo_OrdenesCompra->ObtenerNumeroFormularioSolicitud();
            if ($UltimoNumero) {
                $Numero = str_pad(intval($UltimoNumero) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $Numero = "000001";
            }

            $Estado = "PENDIENTE";
            $Mensaje = "Solicitud de compra #" . $Numero;

            if ($ID = $this->Modelo_OrdenesCompra->InsertarSolicitudCompra($Numero, $ID_Usuario, $ID_Centro, $Firma_Solicita, $Fecha_Solicitud, $Descripcion, $Estado)) {

                $ID_Solicitud = $ID;
                $this->Modelo_OrdenesCompra->DetallesSolicitusCompra($ID_Solicitud);

                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = null;
                $Creo = 'registro';
                $Frase = $Nombre_Ingresa . ' Creó la solicitud de compra #' . $Numero;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario2, $Creo, $Frase);

                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

                <form id='formCorreo' method='POST' action='Correo'>
                    <input type='hidden' name='ID_Solicitud' value='{$ID_Solicitud}'>
                    <input type='hidden' name='Numero' value='{$Numero}'>
                    <input type='hidden' name='Mensaje' value=\"" . htmlspecialchars($Mensaje, ENT_QUOTES) . "\">
                </form>

                <script>
                    Swal.fire({
                        title: '¡Solicitud Creada Correctamente!',
                        text: 'La solicitud ha sido creada con éxito. Número: {$Numero}',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formCorreo').submit();
                        }
                    });
                </script>";
            }
            else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo crear la solicitud.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                </script>";
            }
        }

        public function InsertarSolicitudTemp($Cantidad, $Descripcion, $Medidas, $Precio_Unitario, $Precio_Total, $ID_Usuario) {
            return $this->Modelo_OrdenesCompra->InsertarSolicitudTemp($Cantidad, $Descripcion, $Medidas, $Precio_Unitario, $Precio_Total, $ID_Usuario);
        }

        public function leerSolicitudesCompra($ID_Centro) {
            if ($this->Modelo_OrdenesCompra->leerSolicitudesCompra($ID_Centro)) {
                $Resultado = $this->Modelo_OrdenesCompra->leerSolicitudesCompra($ID_Centro);
                return $Resultado;
            }
        }

        public function MostrarDetallesSolicitud($ID){
            $Filas = $this->Modelo_OrdenesCompra->MostrarDetallesSolicitud($ID);
            return $Filas;

        }

        public function TraerOverhauling() {
            return $this->Modelo_OrdenesCompra->TraerOverhauling();
        }

        public function VerSolicitud($ID){
            $DataSolicitud = $this->Modelo_OrdenesCompra->VerSolicitud($ID);
            return $DataSolicitud;
        }

    }
       
?>