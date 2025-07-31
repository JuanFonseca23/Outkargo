<?php
date_default_timezone_set('America/Bogota');
include_once  "App/Models/Pagina.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once "vendor/autoload.php";
class PaginaController
{
    // Atributos
    private $Modelo_Pagina;
    //Conatructor
    public function __construct() {
        $this->Modelo_Pagina = new Pagina();
    }
    // Métodos
    public function Fecha()
    {
        $Dia = date("d");
        $Ano = date("Y");
        $Mes = date("m");
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
        $MesNombre = $meses[$Mes] ?? 'Desconocido';
        return [
            'Dia' => $Dia,
            'Ano' => $Ano,
            'Mes' => $MesNombre
        ];
    }

    public function Ubicacion()
    {
        $access_key = "09058e58af5291efa0bdcb136ef8cdb1";

        function getClientIP()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                return $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        $ip = getClientIP();
        $url = "http://api.ipapi.com/api/{$ip}?access_key={$access_key}";
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            $Pais = "Desconocido";
            $Ciudad = "Desconocida";
        } else {
            $data = json_decode($response, true);
            $Pais = $data['country_name'] ?? 'Desconocido';
            $Ciudad = $data['city'] ?? 'Desconocida';
        }
        return [
            'Pais' => $Pais,
            'Ciudad' => $Ciudad
        ];
    }

    public function verificarConexion()
    {
        $url = "https://www.google.com";
        $context = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => 'Accept-language: en\r\n' .
                    'Connection: close\r\n',
            ]
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === FALSE) {
            $error = error_get_last()['message'] ?? 'Unknown error';
            echo "Invalid URL: $error";
        } else {
            echo 'connection_ok';
        }
    }

    public function ValidarSession()
    {
        session_start();
        if (!isset($_SESSION['ID'])) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'No Autenticado',
                        text: 'Debe iniciar sesión para continuar.',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(function() {
                        window.location.href = '../IniciarSesion';
                    });
                };
            </script>";
            exit();
        }
    }

    public function ValidarSiExisteSession()
    {
        session_start();
        if (isset($_SESSION['ID'])) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Ingresando',
                    text: 'Bienvenido nuevamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    timer: 2000,
                    timerProgressBar: true
                }).then(function() {
                    window.location.href = 'Panel/Menu';
                });
            </script>";
            exit();
        }
    }

    public function EnviarContacto($Nombre, $Email, $Mensaje){
        $mail = new PHPMailer(true);
        $isLocal = false;
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com ';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mensajes@jhskargo.com'; // Tu usuario SMTP
            $mail->Password   = 'd&3mePMN'; // Tu contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('mensajes@jhskargo.com', 'JHSKARGO');
            $mail->addAddress($Email, $Nombre);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Registro Contacto';
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
                            <img src="https://img.icons8.com/ios/50/ffffff/fork-lift.png" alt="fork-lift"/>
                            <h1>JHS KARGO</h1>
                        </div>
                        <div class="content">
                            <p>Hola, <strong class="highlight">' . htmlspecialchars($Nombre) . '</strong>,</p>
                            <p>Hemos recibido tu mensaje correctamente :</p>
                            <p><strong class="highlight">Mensaje:</strong> ' . htmlspecialchars($Mensaje) . '</p>
                            <p>&nbsp;</p> 
                            <p>Saludos,<br>El equipo de JHSKARGO.</p>
                        </div>
                        <div class="footer">
                            <p>&copy; ' . date("Y") . ' JHSKARGO. Derechos reservados.</p>
                        </div>
                    </div>
                </body>
                </html>';
            $mail->send();
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Mensaje enviado',
                        text: 'Gracias por contactarnos, te responderemos pronto.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(function() {
                        window.location.href = 'Inicio';
                    });
                </script>";
        } catch (Exception $e) {
            echo "Error al enviar el mensaje: " . $e->getMessage();
            // echo "
            //     <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            //     <script>
            //         Swal.fire({
            //             title: 'Error',
            //             text: 'No se pudo enviar el mensaje. Intenta nuevamente.',
            //             icon: 'error',
            //             confirmButtonText: 'Inicio'
            //         });
            //     </script>";
        }
    }

    public function ListarBlog($Cantidad){
        $DataBlog = $this->Modelo_Pagina->ListarBlog($Cantidad);
        if ($DataBlog) {
            return $DataBlog;
        } else {
            return false;
        }
    }

    public function ObtenerNombrePersona($ID){
        $DataPersona = $this->Modelo_Pagina->ObtenerNombrePersona($ID);
        if ($DataPersona) {
            $NombrePersona = $DataPersona['Nombre1'] . " " . $DataPersona['Apellido1'];
            return$NombrePersona;
        } else {
            return false;
        }
    }

    public function TransformarFecha($Fecha){
        list($dia, $mes, $ano) = explode('/', $Fecha);
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
        $mesNombre = $meses[$mes] ?? 'Desconocido';
        return "{$dia} {$mesNombre} {$ano}";
    }

    public function LimitarContenido($Texto, $Limite = 100){
        if (strlen($Texto) > $Limite) {
            return substr($Texto, 0, $Limite) . "...";
        } else {
            return $Texto;
        }
    }

    public function TraerInformacionBlog($ID){
        $DataBlog = $this->Modelo_Pagina->TraerInformacionBlog($ID);
        if ($DataBlog) {
            return $DataBlog;
        } else {
            return false;
        }
    }

    public function CrearComentario($ID, $Nombre, $Correo, $Comentario){
        $ID_Blog = $ID;
        $Tipo_Comentario = "Principal";
        $Nombre = $Nombre;
        $Correo = $Correo;
        $Comentario = $Comentario;
        $Fecha = date("d/m/Y");
        $Estado = "1";
        $DataComentario = $this->Modelo_Pagina->CrearComentario($ID_Blog, $Tipo_Comentario, $Nombre, $Correo, $Comentario, $Fecha, $Estado);
        if ($DataComentario) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Registrado',
                    text: 'El comentario fue registrado.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    timer: 2000,
                    timerProgressBar: true
                }).then(function() {
                    window.location.href = 'Blog?Contenido=$ID_Blog';
                });
            </script>";
        } else {
            return false;
        }
    }
}
