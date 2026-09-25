<?php
    include_once  "App/Models/Mantenimientos.php";
    include_once  "App/Models/OrdenesTrabajo.php";
    include_once  "App/Models/Productos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";
    include_once "App/Controllers/UsuarioController.php";     

    class MantenimientosController {
        // Atributos
        private $Modelo_Mantenimientos;
        private $Modelo_OrdenesTrabajo;
        private $Modelo_Inventario;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_Mantenimientos = new Mantenimientos();
            $this->Modelo_OrdenesTrabajo = new OrdenesTrabajo();
            $this->Modelo_Inventario = new Productos(); 
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Usuarios = new UsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        // Métodos
        public function ContarMantenimientos(){
            $Estado = 'COMPLETADO';
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientos($Estado);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarMantenimientosCorrectivos(){
            $Estado = 'COMPLETADO';
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientosCorrectivos($Estado);
            return $Resultado ? $Resultado : 0;
        }

        public function CrearMantenimientoBorrador($ID_Usuario, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Externo, $Operario_Externo, $TipoMontacargas, $TipoMantenimiento) {
            $Estado_Firma = 0;
            // $HoraInicio = date('H:i');
            $ultimoCodigo = $this->Modelo_Mantenimientos->ObtenerUltimoCodigoMantenimientoPreventivo();
            if($ultimoCodigo){
                $NuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            }else{
                $NuevoCodigo = '000001';
            }
            $ID_Mantenimiento = $this->Modelo_Mantenimientos->CrearMantenimientoBorrador($ID_Usuario, $NuevoCodigo, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Estado_Firma, $Externo, $Operario_Externo, $TipoMontacargas, $TipoMantenimiento);
            if ($ID_Mantenimiento) {
                $this->Modelo_Mantenimientos->RegistrarMantenimientoTecnico($ID_Mantenimiento, $ID_Usuario);
                $ID_Detalle = $this->Modelo_Mantenimientos->CrearDetalleMantenimientoBorrador($ID_Mantenimiento);
                $Detalles =$this->Modelo_Mantenimientos->ObtenerDatos($ID_Mantenimiento);
                return [$ID_Mantenimiento, $Detalles, $ID_Detalle];
            } else {
                throw new Exception("Error al crear el mantenimiento preventivo.");
            }
        }

        public function CrearMantenimientoCorrectivoBorrador($ID_Usuario, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Externo, $Operario_Externo) {
            $Estado_Firma = 0;
            // $HoraInicio = date('H:i');
            $ultimoCodigo = $this->Modelo_Mantenimientos->ObtenerUltimoCodigoMantenimientoCorrectivo();
            if($ultimoCodigo){
                $NuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            }else{
                $NuevoCodigo = '000001';
            }
            $ID_Mantenimiento = $this->Modelo_Mantenimientos->CrearMantenimientoCorrectivoBorrador($ID_Usuario, $NuevoCodigo, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Estado_Firma, $Externo, $Operario_Externo);
            if ($ID_Mantenimiento) {
                $this->Modelo_Mantenimientos->RegistrarMantenimientoCorrectivoTecnico($ID_Mantenimiento, $ID_Usuario);
                $Detalles = $this->Modelo_Mantenimientos->ObtenerDatosCorrectivos($ID_Mantenimiento);
                $Novedades = $this->Modelo_Mantenimientos->ObtenerNovedadesPendientes($ID_Montacargas);
                return [$ID_Mantenimiento, $Detalles, $Novedades];
            } else {
                throw new Exception("Error al crear el mantenimiento preventivo.");
            }
        }

        public function EliminarImagen($ID){
            return $this->Modelo_Mantenimientos->EliminarImagen($ID);
        }

        public function EliminarInsumo($ID_Mantenimiento, $ID_Insumo, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarInsumo($ID_Mantenimiento, $ID_Insumo, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarBorrador($ID, $Tipo_Mantenimiento){
            $Resultado = $this->Modelo_Mantenimientos->EliminarBorrador($ID, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarTecnico($ID_Mantenimiento, $ID_Tecnico) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarTecnico($ID_Mantenimiento, $ID_Tecnico);
            return $Resultado;
        }

        public function EliminarTecnicoCorrectivo($ID_Mantenimiento, $ID_Tecnico) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarTecnicoCorrectivo($ID_Mantenimiento, $ID_Tecnico);
            return $Resultado;
        }

        public function FinalizarMantenimiento($ID_Mantenimiento, $ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Horometro, $ID_Montacargas){
            $Estado = 'COMPLETADO';
            return $this->Modelo_Mantenimientos->FinalizarMantenimiento($ID_Mantenimiento, $ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Estado, $Horometro, $ID_Montacargas);
        }

        public function FirmarMantenimientoPreventivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado){
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoPreventivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado);
            return $Resultado;
        }

        public function FirmarMantenimientoPreventivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoPreventivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado);
            return $Resultado;
        }

        public function FirmarMantenimientoPreventivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoPreventivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado);
            return $Resultado;
            
        }

        public function FirmarMantenimientoPreventivoTecnicos($ID_Mantenimiento, $Firmas, $ID_Supervisor1, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas){
            $Fecha = date('Y-m-d');
            $Estado = 1;
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoPreventivoTecnicos($ID_Mantenimiento, $Firmas, $Fecha, $Estado);
            if ($Resultado){
                //Enviar correo
                $this->EnviarCorreo($ID_Mantenimiento, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas);
                return true;
            }
        }

        public function GuardarCriterio($ID_Detalle, $campo, $valor) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarCriterio($ID_Detalle, $campo, $valor);
            return $Resultado;
        }

        public function GuardarImagen($ID_Mantenimiento, $Categoria, $Archivo){
            return $this->Modelo_Mantenimientos->GuardarImagen($ID_Mantenimiento,$Categoria,$Archivo);
        }

        public function GuardarInsumos($ID_Mantenimiento, $Insumos, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarInsumos($ID_Mantenimiento, $Insumos, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function GuardarNovedades($ID_Mantenimiento, $Novedades, $ID_Montacargas, $Tipo_Mantenimiento) {
            $Estado = 'Pendiente';
            $FechaReporte = date('Y-m-d');
            $Resultado = $this->Modelo_Mantenimientos->GuardarNovedades($ID_Mantenimiento, $Novedades, $ID_Montacargas, $Estado, $FechaReporte, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function GuardarObservacion($ID_Detalle, $criterio, $observacion) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarObservacion($ID_Detalle, $criterio, $observacion);
            return $Resultado;
        }

        public function GuardarTecnicos($ID_Mantenimiento, $ID_Tecnicos) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarTecnicos($ID_Mantenimiento, $ID_Tecnicos);
            return $Resultado;
        }       

        public function GuardarTecnicosCorrectivo($ID_Mantenimiento, $ID_Tecnicos) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarTecnicosCorrectivo($ID_Mantenimiento, $ID_Tecnicos);
            return $Resultado;
        }     

        public function LeerMantenimientos(){
            $Estado = 'COMPLETADO';
            $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientos($Estado);
            return $Resultado ?: [];
        }

        public function LeerMantenimientosCorrectivos(){
            $Estado = 'COMPLETADO';
            $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientosCorrectivos($Estado);
            return $Resultado ?: [];
        }

        public function ObtenerInsumosMantenimiento($ID, $Tipo){
            $DataInsumosM = $this->Modelo_Mantenimientos->ObtenerInsumosMantenimiento($ID, $Tipo);
            return $DataInsumosM;
        }

        public function ObtenerMantenimientoCompleto($ID_Mantenimiento){
            return $this->Modelo_Mantenimientos->ObtenerMantenimientoCompleto($ID_Mantenimiento);
        }    
        
        public function ObtenerNovedadesMantenimiento($ID, $Tipo){
            $DataNovedadesM = $this->Modelo_Mantenimientos->ObtenerNovedadesMantenimiento($ID, $Tipo);
            return $DataNovedadesM;
        }

        public function TraerAreas($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerAreas($ID_Centro);
            return $Resultado;
        }

        public function TraerMontacargas($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerMontacargas($ID_Centro);
            return $Resultado;
        }

        public function TraerOperarios($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerOperarios($ID_Centro);
            return $Resultado;
        }

        public function TraerSupervisores() {
            $Resultado = $this->Modelo_Mantenimientos->TraerSupervisores();
            return $Resultado;
        }

        public function TraerTecnicos(){
            $Resultado = $this->Modelo_Mantenimientos->TraerTecnicos();
            return $Resultado;
        }

        public function VerificarBorrador($ID_Usuario){
            return $this->Modelo_Mantenimientos->VerificarBorrador($ID_Usuario);
        }

        public function VerDetalleM($ID){
            $DataDetalleM = $this->Modelo_Mantenimientos->VerDetalleM($ID);
            return $DataDetalleM;
        }

        public function VerImagenesM($ID){
            $DataImagenesM = $this->Modelo_Mantenimientos->VerImagenesM($ID);
            return $DataImagenesM;
        }

        public function VerInforme($tipoInforme, $centro, $fechaDesde, $fechaHasta, $montacargas, $tipoMantenimiento){
            if ($tipoInforme === "F_145"){
                $DataInforme = $this->Modelo_Mantenimientos->VerInformeF145($centro, $fechaDesde, $fechaHasta, $montacargas, $tipoMantenimiento);
                return $DataInforme;
            }
        }

        public function VerMantenimiento($ID){
            $DataMantenimiento = $this->Modelo_Mantenimientos->VerMantenimiento($ID);
            return $DataMantenimiento;
        }

        public function VerMecanicos($ID){
            $DataMecanicos = $this->Modelo_Mantenimientos->VerMecanicos($ID);
            return $DataMecanicos;
        }
        
        //Salidas
        public function RealizarSalidaMantenimiento($ID_Mantenimiento, $ID_Usuario, $NombreCreo, $ID_Centro, $FirmaSalida, $Mantenimiento, $Insumos){
            $Ultimo_Formulario= $this->Modelo_Inventario->ObtenerNumeroFormularioSalida();
            if ($Ultimo_Formulario) {
                $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $No_Formulario = '000001';
            }
            $Usuarios = $this->Modelo_OrdenesTrabajo->BuscarUsuario();
            $ID_UsuarioSalida = Null;
            $ID_SupervisorSalida = Null;

            foreach ($Usuarios AS $Usuario){
                if ((int)$Usuario['Cargo'] === 2){
                    $ID_UsuarioSalida = $Usuario['ID_Usuario'];
                    $NombreEntregaSalida = $Usuario['Nombre'];
                    $CorreoEntregaSalida = $Usuario['Correo'];
                }

                if ((int)$Usuario['Cargo'] === 11){
                    $ID_SupervisorSalida = $Usuario['ID_Usuario'];
                    $NombreSupervisorSalida = $Usuario['Nombre'];
                    $CorreoSupervisorSalida = $Usuario['Correo'];
                    $DocumentoSupervisorSalida = $Usuario['Documento'];
                }
            }
            if (!$ID_UsuarioSalida || !$ID_SupervisorSalida){
                return false; 
            }
            $Estado = 2;
            $Firma_Estado_Salida = 2;
            $ID_Destino = $ID_Centro;
            $Fecha_Recibe = date("d/m/Y");
            $EstadoFirmaMecanico = 1;
            if (!empty($Insumos)) {
                    if($ID=$this->Modelo_Mantenimientos->CrearSalida($ID_UsuarioSalida, $ID_Usuario, $ID_SupervisorSalida, $ID_Centro, $ID_Destino, $ID_Mantenimiento, $No_Formulario, $Mantenimiento, $Fecha_Recibe, $Estado, $FirmaSalida, $Firma_Estado_Salida, $EstadoFirmaMecanico)){
                        $ID_Salida = $ID;
                        $Observaciones = 'Insumo utilizado en '. $Mantenimiento ;
                        foreach ($Insumos as $Insumo) {
                                $ID_Insumo = $Insumo['id'] ?? null;
                                $Cantidad  = $Insumo['cantidad'] ?? null;
                                $Medida    = $Insumo['medida'] ?? null;

                                if (!$ID_Insumo || !$Cantidad || !$Medida) {
                                    continue;
                                }

                                $Conversiones = [
                                    "1/4" => 0.25,
                                    "1/2" => 0.5,
                                    "3/4" => 0.75,
                                ];

                                $Cantidad_Total = isset($Conversiones[$Medida]) ? $Cantidad * $Conversiones[$Medida] : $Cantidad;
                                $Cantidad_Pendiente = $Cantidad_Total;
                                $Productos = $this->Modelo_Inventario->ObtenerProductosPEPS($ID_Insumo, $ID_Centro);

                                foreach ($Productos as $Producto) {

                                    if ($Cantidad_Pendiente <= 0) {
                                        break;
                                    }

                                    $Disponible = $Producto['Cantidad'];
                                    $Usar = min($Disponible, $Cantidad_Pendiente);

                                    // Descontar inventario
                                    $this->Modelo_Inventario->DescontarInventario( $Producto['ID'], $Usar, $ID_Centro);

                                    // Registrar detalle salida
                                    $this->Modelo_Inventario->RegistrarDetalleSalida($ID_Usuario, $ID_Salida, $ID_Insumo, $Usar, $Producto['N_Factura'], $Producto['N_Lote'], $Producto['valor_unitario'], $Observaciones);
                                    $Cantidad_Pendiente -= $Usar;
                                }

                                if ($Cantidad_Pendiente > 0) {
                                    return false;
                                }
                        }
                        $this->EnviarCorreo2($ID_Salida, $NombreEntregaSalida, $CorreoEntregaSalida, $No_Formulario);
                        $this->EnviarCorreo3($ID_Salida, $NombreSupervisorSalida, $CorreoSupervisorSalida, $No_Formulario, $DocumentoSupervisorSalida);

                        $ID_Usuario1 = $ID_Usuario;
                        $ID_Usuario2 = Null;
                        $Creo = 'registro';
                        $Frase = $NombreCreo.' Creó un nuevo '.$Mantenimiento.' y realizó la salida de insumos #'.$No_Formulario;
                        $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                        return true;
                    }else{
                        return false;
                    }
            }
        }

        // Correo 
        public function EnviarCorreo($ID_Mantenimiento, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas){
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME'];
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSolicitud = "localhost/OUTKARGO/Mantenimiento/InicioPreventivo";
                $Link = "http://localhost/OUTKARGO/Mantenimiento/VerMantenimientoPreventivo_{$Tipo_Montacargas}_{$Tipo_Mantenimiento}?ID={$ID_Mantenimiento}";
            }else {
                $AceptarSolicitud = "https://Outkargo.com.co/Mantenimiento/InicioPreventivo/";
                $Link = "https://outkargo.com.co/Mantenimiento/VerMantenimientoPreventivo_{$Tipo_Montacargas}_{$Tipo_Mantenimiento}?ID={$ID_Mantenimiento}";
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
                $mail->addAddress($Correo_Supervisor1, $Nombre_Supervisor1,);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Nuevo Mantenimiento Preventivo Generado';
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
                        <p>Buen Dia, <strong class="highlight">' . $Nombre_Supervisor1 . '</strong>,</p>
                        <p>se ha generado un nuevo mantenimiento preventivo</p>
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="margin-top:15px;border:1px solid #dee2e6;
                                    border-radius:6px;background:#f8f9fa;">
                            <tr>
                                <td style="padding:12px;">
                                    <strong>Mantenimiento_Preventivo' . $ID_Mantenimiento . '.pdf</strong>
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
                            Verificar Mantenimiento </a>
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


        // public function LeerMantenimientos($ID_Centro, $Tipo){
        //     if ($this->Modelo_Mantenimientos->LeerMantenimientos($ID_Centro, $Tipo)) {
        //         $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientos($ID_Centro, $Tipo);
        //         return $Resultado;
        //     }
        // }

        

        public function ContarMantenimientosCorrectivoOrden($ID_Centro){
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientosCorrectivoOrden($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function LeerMantenimientosC($ID_Centro){
            if ($this->Modelo_Mantenimientos->LeerMantenimientosC($ID_Centro)) {
                $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientosC($ID_Centro);
                return $Resultado;
            }
        }

        public function LeerMantenimientosCorrectivosOrden($ID_Centro){
            if ($this->Modelo_Mantenimientos->LeerMantenimientosCorrectivosOrden($ID_Centro)) {
                $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientosCorrectivosOrden($ID_Centro);
                return $Resultado;
            }
        }
       

        public function VerMantenimientoC($ID){
            $DataMantenimiento = $this->Modelo_Mantenimientos->VerMantenimientoC($ID);
            return $DataMantenimiento;
        }

        public function VerMecanicosC($ID){
            $DataMecanicos = $this->Modelo_Mantenimientos->VerMecanicosC($ID);
            return $DataMecanicos;
        }

        public function VerDetalleMC($ID){
            $DataDetalleM = $this->Modelo_Mantenimientos->VerDetalleMC($ID);
            return $DataDetalleM;
        }

        public function DataImagenesMC($ID){

            $imagenes = $this->Modelo_Mantenimientos->DataImagenesMC($ID);

            $imagenesPorDetalle   = [];
            $imagenesPorCategoria = [];

            foreach ($imagenes as $img) {

                // Si tiene ID_Detalle → viene de Orden de Trabajo
                if ($img['ID_Detalle'] !== null && $img['ID_Detalle'] !== '') {

                    $imagenesPorDetalle[$img['ID_Detalle']][] = $img;

                } else {

                    // Si no tiene ID_Detalle → es propio del correctivo
                    $imagenesPorCategoria[$img['Categoria']][] = $img;
                }
            }

            return [
                'imagenesPorDetalle'   => $imagenesPorDetalle,
                'imagenesPorCategoria' => $imagenesPorCategoria
            ];
        }

        // public function ObtenerInsumosMantenimiento($DataDetalleM, $Tipo){
        //     // Mapeo de códigos a nombres
        //     $insumos = [
        //         'P-000119' => 'Agua para batería',
        //         'P-000054' => 'Grasa Wurth',
        //         'P-000120' => 'Aceite Hidráulico',
        //         'P-000210' => 'Valvulina',
        //         'P-000207' => 'Gasolina',
        //         'P-000053' => 'Lubricante Wurth',
        //         'P-000905' => 'Limpiador Wurth',
        //         'P-000994' => 'Limpiador Eléctrico',
        //         'P-000021' => 'Líquido de Frenos'
        //     ];

        //     $resultado = [];

        //     for ($i = 122; $i <= 130; $i++) {
        //         $campo = "Criterio_$i";

        //         if (!empty($DataDetalleM[$campo]) && $DataDetalleM[$campo] !== 'null|null|null') {
        //             $partes = explode('|', $DataDetalleM[$campo]);
                    
        //             if (count($partes) === 3) {
        //                 [$codigo, $cantidad, $medida] = $partes;
        //                 if (!empty($codigo) && !empty($cantidad) && $cantidad !== 'null') {
        //                     $nombre = $insumos[$codigo] ?? $codigo; 
        //                     $resultado[] = [
        //                         'nombre' => $nombre,
        //                         'cantidad' => $cantidad,
        //                         'medida' => $medida
        //                     ];
        //                 }
        //             }
        //         }
        //     }

        //     return $resultado;
        // }

        public function BuscarPersona($No_Documento) {
            $datausuario = $this->Controller_Usuarios->BuscarPersonaDocumento($No_Documento);     
            if ($datausuario) {               
                return $datausuario;   
            }else {
                return false;
            }
        }

        

        // public function RegistrarMantenimiento($ID_Usuario, $NombreCreo,$ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro,$ID_Supervisor,$Correo_Supervisor,$Nombre_Supervisor,$NumeroBateria,$NumeroControlador,$NumeroCargador,$Observaciones,$Longitudh,$Horometro,$HoraInicio,
        //                                        $Criterio_1,$Criterio_2,$Criterio_3,$Criterio_4,$Criterio_5,$Criterio_6,$Criterio_7,$Criterio_8,$Criterio_9,$Criterio_10,
        //                                        $Criterio_11,$Criterio_12,$Criterio_13,$Criterio_14,$Criterio_15,$Criterio_16,$Criterio_17,$Criterio_18,$Criterio_19,$Criterio_20,
        //                                        $Criterio_21,$Criterio_22,$Criterio_23,$Criterio_24,$Criterio_25,$Criterio_26,$Criterio_27,$Criterio_28,$Criterio_29,$Criterio_30,
        //                                        $Criterio_31,$Criterio_32,$Criterio_33,$Criterio_34,$Criterio_35,$Criterio_36,$Criterio_37,$Criterio_38,$Criterio_39,$Criterio_40,
        //                                        $Criterio_41,$Criterio_42,$Criterio_43,$Criterio_44,$Criterio_45,$Criterio_46,$Criterio_47,$Criterio_48,$Criterio_49,$Criterio_50,
        //                                        $Criterio_51,$Criterio_52,$Criterio_53,$Criterio_54,$Criterio_55,$Criterio_56,$Criterio_57,$Criterio_58,$Criterio_59,$Criterio_60,
        //                                        $Criterio_61,$Criterio_62,$Criterio_63,$Criterio_64,$Criterio_65,$Criterio_66,$Criterio_67,$Criterio_68,$Criterio_69,$Criterio_70,
        //                                        $Criterio_71,$Criterio_72,$Criterio_73,$Criterio_74,$Criterio_75,$Criterio_76,$Criterio_77,$Criterio_78,$Criterio_79,$Criterio_80,
        //                                        $Criterio_81,$Criterio_82,$Criterio_83,$Criterio_84,$Criterio_85,$Criterio_86,$Criterio_87,$Criterio_88,$Criterio_89,$Criterio_90,
        //                                        $Criterio_91,$Criterio_92,$Criterio_93,$Criterio_94,$Criterio_95,$Criterio_96,$Criterio_97,$Criterio_98,$Criterio_99,$Criterio_100,
        //                                        $Criterio_101,$Criterio_102,$Criterio_103,$Criterio_104,$Criterio_105,$Criterio_106,$Criterio_107,$Criterio_108,$Criterio_109,$Criterio_110,
        //                                        $Criterio_111,$Criterio_112,$Criterio_113,$Criterio_114,$Criterio_115,$Criterio_116,$Criterio_117,$Criterio_118,$Criterio_119,$Criterio_120,
        //                                        $Criterio_121,$Criterio_122,$Criterio_123,$Criterio_124,$Criterio_125,$Criterio_126,$Criterio_127,$Criterio_128,$Criterio_129,$Criterio_130,
        //                                        $Criterio_131,$Criterio_132,$Criterio_133,$Criterio_134,$Criterio_135,$Criterio_136,$Criterio_137,$Criterio_138,$Criterio_139,
        //                                        $Tecnicos,$Baterias,$Electricos,$Tracciones,$Frenos,$Direcciones,$Hidraulicos,$Mastiles,$Carros,$Aditamientos,$Horquillas,$Ruedas,$Chasis,$Luces,$Lubricaciones,$Cargadores,$Revisiones, $Caja, 
        //                                        $Auxiliares, $Pantografo, $Suspension, $Combustion, $Transmision, $Motor, $Refigeracion, $Componentes, $Ausencias, $Correas, $Panel, $Funcionamiento, $Tipo){
        //     $Horafinal = date('H:i');
        //     $FechaCreado = date("d/m/Y");
        //     $EstadoFirmaOperario = 0;
        //     $EstadoFirmaSupervisor = 0;
        //     if($ID = $this -> Modelo_Mantenimientos->RegistrarMantenimiento($ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro, $ID_Supervisor, $HoraInicio, $Horafinal,
        //                                                                     $FechaCreado, $EstadoFirmaOperario, $EstadoFirmaSupervisor, $Tipo)){
        //         $ID_Mantenimiento = $ID;
        //         if (!in_array($ID_Usuario, $Tecnicos)) { array_unshift($Tecnicos, $ID_Usuario); }
        //         foreach ($Tecnicos as $ID_Tecnico) {
        //             $this->Modelo_Mantenimientos->RegistrarMantenimientoTecnico($ID_Mantenimiento, $ID_Tecnico);
        //         }
        //         $this->Modelo_Mantenimientos->RegistrarDetallesMantenimiento($ID_Montacargas, $ID_Mantenimiento, $NumeroBateria, $NumeroControlador, $NumeroCargador, $Observaciones, $Longitudh, $Horometro, $Criterio_1, $Criterio_2, $Criterio_3, $Criterio_4, $Criterio_5, $Criterio_6, $Criterio_7, $Criterio_8, $Criterio_9, $Criterio_10, $Criterio_11, $Criterio_12, $Criterio_13,
        //                                               $Criterio_14, $Criterio_15, $Criterio_16, $Criterio_17, $Criterio_18, $Criterio_19, $Criterio_20, $Criterio_21, $Criterio_22, $Criterio_23, $Criterio_24, $Criterio_25, $Criterio_26, $Criterio_27, $Criterio_28, $Criterio_29, $Criterio_30, $Criterio_31, $Criterio_32, $Criterio_33,
        //                                               $Criterio_34, $Criterio_35, $Criterio_36, $Criterio_37, $Criterio_38, $Criterio_39, $Criterio_40, $Criterio_41, $Criterio_42, $Criterio_43, $Criterio_44, $Criterio_45, $Criterio_46, $Criterio_47, $Criterio_48, $Criterio_49, $Criterio_50, $Criterio_51, $Criterio_52, $Criterio_53,
        //                                               $Criterio_54, $Criterio_55, $Criterio_56, $Criterio_57, $Criterio_58, $Criterio_59, $Criterio_60, $Criterio_61, $Criterio_62, $Criterio_63, $Criterio_64, $Criterio_65, $Criterio_66, $Criterio_67, $Criterio_68, $Criterio_69, $Criterio_70, $Criterio_71, $Criterio_72, $Criterio_73,
        //                                               $Criterio_74, $Criterio_75, $Criterio_76, $Criterio_77, $Criterio_78, $Criterio_79, $Criterio_80, $Criterio_81, $Criterio_82, $Criterio_83, $Criterio_84, $Criterio_85, $Criterio_86, $Criterio_87, $Criterio_88, $Criterio_89, $Criterio_90, $Criterio_91, $Criterio_92, $Criterio_93,
        //                                               $Criterio_94, $Criterio_95, $Criterio_96, $Criterio_97, $Criterio_98, $Criterio_99, $Criterio_100, $Criterio_101, $Criterio_102, $Criterio_103, $Criterio_104, $Criterio_105, $Criterio_106, $Criterio_107, $Criterio_108, $Criterio_109, $Criterio_110, $Criterio_111, $Criterio_112,
        //                                               $Criterio_113, $Criterio_114, $Criterio_115, $Criterio_116, $Criterio_117, $Criterio_118, $Criterio_119, $Criterio_120, $Criterio_121, $Criterio_122, $Criterio_123, $Criterio_124, $Criterio_125, $Criterio_126, $Criterio_127, $Criterio_128, $Criterio_129, $Criterio_130,
        //                                               $Criterio_131,$Criterio_132,$Criterio_133,$Criterio_134,$Criterio_135,$Criterio_136,$Criterio_137,$Criterio_138,$Criterio_139);
        //         $this->RegistrarManteniminetosEvidencia($ID_Mantenimiento, $Baterias,$Electricos,$Tracciones,$Frenos,$Direcciones,$Hidraulicos,$Mastiles,$Carros,$Aditamientos,$Horquillas,$Ruedas,$Chasis,$Luces,$Lubricaciones,$Cargadores,$Revisiones, $Caja, $Auxiliares, $Pantografo, $Suspension, $Combustion, $Transmision, $Motor, $Refigeracion, $Componentes, $Ausencias, $Correas, $Panel, $Funcionamiento);
        //         $this->GenerarCorreo($Correo_Supervisor, $Nombre_Supervisor, $ID_Mantenimiento);
        //         $ID_Usuario1 = $ID_Usuario;
        //         $ID_Usuario2 = Null;
        //         $Creo = 'registro';
        //         $Frase = $NombreCreo.' Creó el mantenimiento preventivo del montacargas con ID: '.$ID_Montacargas;
        //         $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
        //         return $ID_Mantenimiento;
        //     }else{
        //         return false;
        //     }

        // }

        // public function RegistrarManteniminetosEvidencia ($ID_Mantenimiento, $Baterias, $Electricos, $Tracciones, $Frenos, $Direcciones, $Hidraulicos, $Mastiles, $Carros, $Aditamientos, $Horquillas, $Ruedas, $Chasis, $Luces, $Lubricaciones, $Cargadores, $Revisiones, $Caja, $Auxiliares, $Pantografo, $Suspension, $Combustion, $Transmision, $Motor, $Refigeracion, $Componentes, $Ausencias, $Correas, $Panel, $Funcionamiento){
        //     $uploadDir = 'App/Views/Upload/Img/Mantenimientos_Preventivos/'; 
        //     $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
        
        //     if (!is_dir($uploadDir)) {
        //         mkdir($uploadDir, 0755, true);
        //     }

        //     // ⚙️ Función reutilizable para evitar repetir código
        //     $subirArchivos = function($Categoria, $archivos) use ($ID_Mantenimiento, $uploadDir, $allowedTypes){
        //         $contador = 1;
        //         if(empty($archivos['name'][0])) return; // No hay archivos
        //         foreach ($archivos['tmp_name'] as $key => $tmp_name) {
        //             $fileType = $archivos['type'][$key];
        //             if (in_array($fileType, $allowedTypes)) {
        //                 $extension = pathinfo($archivos['name'][$key], PATHINFO_EXTENSION);
        //                 $NombreFoto  = "Mantenimiento{$ID_Mantenimiento}_{$Categoria}{$contador}." . $extension;
        //                 $uploadFile = $uploadDir . $NombreFoto;

        //                 if (move_uploaded_file($tmp_name, $uploadFile)) {
        //                     $this->Modelo_Mantenimientos->RegistrarMantenimientoEvidencia($ID_Mantenimiento, $Categoria, $uploadFile);
        //                     $contador++;
        //                 } else {
        //                     // Error al mover el archivo
        //                     echo "❌ Error al cargar la imagen: $uploadFile<br>";
        //                 }
        //             }else {
        //                 echo "⚠️ Tipo de archivo no permitido: {$archivos['name'][$key]}<br>";
        //             }
        //         }

        //     };

        //     $subirArchivos('bateria', $Baterias);
        //     $subirArchivos('electrico', $Electricos);
        //     $subirArchivos('traccion', $Tracciones);
        //     $subirArchivos('freno', $Frenos);
        //     $subirArchivos('direccion', $Direcciones);
        //     $subirArchivos('hidraulico', $Hidraulicos);
        //     $subirArchivos('mastil', $Mastiles);
        //     $subirArchivos('carro', $Carros);
        //     $subirArchivos('aditamento', $Aditamientos);
        //     $subirArchivos('horquilla', $Horquillas);
        //     $subirArchivos('rueda', $Ruedas);
        //     $subirArchivos('chasis', $Chasis);
        //     $subirArchivos('luces', $Luces);
        //     $subirArchivos('lubricacion', $Lubricaciones);
        //     $subirArchivos('cargador', $Cargadores);
        //     $subirArchivos('revision', $Revisiones);
        //     $subirArchivos('caja', $Caja);
        //     $subirArchivos('auxiliares', $Auxiliares);
        //     $subirArchivos('pantografo', $Pantografo);
        //     $subirArchivos('suspension', $Suspension);
        //     $subirArchivos('combustion', $Combustion);
        //     $subirArchivos('transmision', $Transmision);
        //     $subirArchivos('motor', $Motor);
        //     $subirArchivos('refigeracion', $Refigeracion);
        //     $subirArchivos('componentes', $Componentes);
        //     $subirArchivos('ausencias', $Ausencias);
        //     $subirArchivos('correas', $Correas);
        //     $subirArchivos('panel', $Panel);
        //     $subirArchivos('funcionamiento', $Funcionamiento);        
        // }

        // public function RegistrarMantenimientoCorrectivo ($ID_Usuario, $NombreCreo, $ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro,$ID_Supervisor,$Correo_Supervisor,$Nombre_Supervisor,$Horometro, $HoraInicio,
        //                                                    $Falla,$Reparacion,$Insumos,$Observaciones,$FechaCorrecion,$FallaC, $Pendiente,$Tecnicos,$ImgFalla,$ImgReparacion){
        //     $Horafinal = date('H:i');
        //     $FechaCreado = date("d/m/Y");
        //     $EstadoFirmaOperario = 0;
        //     $EstadoFirmaSupervisor = 0;
        //     $ultimoCodigo = $this->Modelo_Mantenimientos->ObtenerUltimoCodigoMantenimientoCorrectivo();
        //     if($ultimoCodigo){
        //         $NuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
        //     }else{
        //         $NuevoCodigo = '000001';
        //     }
        //     if($IDMantenimiento = $this -> Modelo_Mantenimientos->RegistrarMantenimientoCorrectivo($ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro, $ID_Supervisor, $HoraInicio, $Horafinal, $FechaCreado, $EstadoFirmaOperario, $EstadoFirmaSupervisor, $NuevoCodigo)){
        //         $ID_Mantenimiento = $IDMantenimiento;
        //         if (!in_array($ID_Usuario, $Tecnicos)) { array_unshift($Tecnicos, $ID_Usuario); }
        //         foreach ($Tecnicos as $ID_Tecnico) {
        //             $this->Modelo_Mantenimientos->RegistrarMantenimientoCorrectivoTecnico($ID_Mantenimiento, $ID_Tecnico);
        //         }
        //         $this->Modelo_Mantenimientos->RegistrarDetallesMantenimientoCorrectivo($ID_Montacargas, $ID_Mantenimiento, $Horometro, $Falla, $Reparacion, $Observaciones, $FechaCorrecion, $FallaC, $Pendiente);
        //         $this->RegistrarManteniminetosEvidenciaCorrectivo ($ID_Mantenimiento, $ImgFalla, $ImgReparacion);
        //         if($FallaC === 'no'){
        //             $Tipo_Trabajo = 'MantenimientoC';
        //             $Estado_Trabajo = 2;
        //             $this->Modelo_Mantenimientos->RegistrarTrabajoPendiente($ID_Mantenimiento, $Pendiente,$Tipo_Trabajo, $Estado_Trabajo);
        //         }
                
        //         $Ultimo_Formulario= $this->Modelo_Inventario->ObtenerNumeroFormularioSalida();
        //         if ($Ultimo_Formulario) {
        //             $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
        //         } else {
        //             $No_Formulario = '000001';
        //         }
        //         $Usuarios = $this->Modelo_OrdenesTrabajo->BuscarUsuario();
        //         $ID_UsuarioSalida = Null;
        //         $ID_SupervisorSalida = Null;

        //         foreach ($Usuarios AS $Usuario){
        //             if ((int)$Usuario['Cargo'] === 2){
        //                 $ID_UsuarioSalida = $Usuario['ID_Usuario'];
        //                 $NombreEntregaSalida = $Usuario['Nombre'];
        //                 $CorreoEntregaSalida = $Usuario['Correo'];
        //             }

        //             if ((int)$Usuario['Cargo'] === 11){
        //                 $ID_SupervisorSalida = $Usuario['ID_Usuario'];
        //                 $NombreSupervisorSalida = $Usuario['Nombre'];
        //                 $CorreoSupervisorSalida = $Usuario['Correo'];
        //                 $DocumentoSupervisorSalida = $Usuario['Documento'];
        //             }
        //         }

        //         if (!$ID_UsuarioSalida || !$ID_SupervisorSalida){
        //             return false; 
        //         }
        //         $Estado = 2;
        //         $Firma_Estado_Salida = 2;
        //         $ID_Destino = $ID_Centro;
        //         $Mecanico = null;
        //         $FirmaRecibe = null;
                
        //         foreach ($Tecnicos as $ID_Tecnico) {
        //             $Mecanico = $ID_Tecnico;
        //             break;
        //         }
                  
        //         $Firma_Usuario = NULL;
        //         $Tipo_Origen = 'Mantenimiento Correctivo';
        //         $Fecha_Recibe = date("d/m/Y");
        //         $EstadoFirmaMecanico = 0;

        //         if (!$Mecanico){
        //             return false;
        //         }

        //         if (!empty($Insumos)) {
        //             if($ID=$this->Modelo_Inventario->FirmarSalida($ID_UsuarioSalida, $Mecanico, $ID_SupervisorSalida, $ID_Centro, $ID_Destino, $ID_Mantenimiento, $No_Formulario, $Tipo_Origen, $FechaCreado, $Fecha_Recibe, $Estado, $Firma_Usuario, $FirmaRecibe, $Firma_Estado_Salida, $EstadoFirmaMecanico)){
        //                 $ID_Salida = $ID;
        //                 foreach ($Insumos as $Insumo) {

        //                         $ID_Insumo = $Insumo['id'] ?? null;
        //                         $Cantidad  = $Insumo['cantidad'] ?? null;
        //                         $Medida    = $Insumo['medida'] ?? null;

        //                         if (!$ID_Insumo || !$Cantidad || !$Medida) {
        //                             continue;
        //                         }

        //                         $Conversiones = [
        //                             "1/4" => 0.25,
        //                             "1/2" => 0.5,
        //                             "3/4" => 0.75,
        //                         ];

        //                         $Cantidad_Total = isset($Conversiones[$Medida]) ? $Cantidad * $Conversiones[$Medida] : $Cantidad;
        //                         $Cantidad_Pendiente = $Cantidad_Total;
        //                         $Productos = $this->Modelo_Inventario->ObtenerProductosPEPS($ID_Insumo, $ID_Centro);

        //                         foreach ($Productos as $Producto) {

        //                             if ($Cantidad_Pendiente <= 0) {
        //                                 break;
        //                             }

        //                             $Disponible = $Producto['Cantidad'];
        //                             $Usar = min($Disponible, $Cantidad_Pendiente);

        //                             // Descontar inventario
        //                             $this->Modelo_Inventario->DescontarInventario( $Producto['ID'], $Usar, $ID_Centro);

        //                             // Registrar detalle salida
        //                             $this->Modelo_Inventario->RegistrarDetalleSalida($Mecanico, $ID_Salida, $ID_Insumo, $Usar, $Producto['N_Factura'], $Producto['N_Lote'], $Producto['valor_unitario']);
        //                             $Cantidad_Pendiente -= $Usar;
        //                         }

        //                         if ($Cantidad_Pendiente > 0) {
        //                             return false;
        //                         }

        //                         $Tipo = 'MantenimientoCorrectivo';

        //                         $this->Modelo_OrdenesTrabajo->RegistrarMantenimientoInsumo($ID_Mantenimiento, $ID_Insumo, $Cantidad_Total, $Medida, $Tipo);
        //                 }

        //                 $this->EnviarCorreo1($ID_Mantenimiento, $ID_Supervisor, $NuevoCodigo);
        //                 $this->EnviarCorreo2($ID_Salida, $NombreEntregaSalida, $CorreoEntregaSalida, $No_Formulario);
        //                 $this->EnviarCorreo3($ID_Salida, $NombreSupervisorSalida, $CorreoSupervisorSalida, $No_Formulario, $DocumentoSupervisorSalida);

        //                 $ID_Usuario1 = $ID_Usuario;
        //                 $ID_Usuario2 = Null;
        //                 $Creo = 'registro';
        //                 $Frase = $NombreCreo.' Creó el mantenimiento correctivo del montacargas con ID: '.$ID_Montacargas;
        //                 $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
        //                 return [
        //                     'ID_Mantenimiento' => $ID_Mantenimiento,
        //                     'ID_Salida'        => $ID_Salida
        //                 ];
        //             }else{
        //                 return false;
        //             }
        //         }else{
        //                 $this->EnviarCorreo1($ID_Mantenimiento, $ID_Supervisor, $NuevoCodigo);

        //                 $ID_Usuario1 = $ID_Usuario;
        //                 $ID_Usuario2 = Null;
        //                 $Creo = 'registro';
        //                 $Frase = $NombreCreo.' Creó el mantenimiento correctivo del montacargas con ID: '.$ID_Montacargas;
        //                 $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
        //                 return [
        //                     'ID_Mantenimiento' => $ID_Mantenimiento,
        //                     'ID_Salida'        => null
        //                 ];
        //         }
                             
        //     }else{
        //         return false;
        //     }
        // }

        // public function RegistrarManteniminetosEvidenciaCorrectivo ($ID_Mantenimiento, $ImgFalla, $ImgReparacion){
        //     $uploadDir = 'App/Views/Upload/Img/Mantenimientos_Correctivos/'; 
        //     $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
        
        //     if (!is_dir($uploadDir)) {
        //         mkdir($uploadDir, 0755, true);
        //     }

        //     // ⚙️ Función reutilizable para evitar repetir código
        //     $subirArchivos = function($Categoria, $archivos) use ($ID_Mantenimiento, $uploadDir, $allowedTypes){
        //         $contador = 1;
        //         if(empty($archivos['name'][0])) return; // No hay archivos
        //         foreach ($archivos['tmp_name'] as $key => $tmp_name) {
        //             $fileType = $archivos['type'][$key];
        //             if (in_array($fileType, $allowedTypes)) {
        //                 $extension = pathinfo($archivos['name'][$key], PATHINFO_EXTENSION);
        //                 $NombreFoto  = "Mantenimiento{$ID_Mantenimiento}_{$Categoria}{$contador}." . $extension;
        //                 $uploadFile = $uploadDir . $NombreFoto;

        //                 if (move_uploaded_file($tmp_name, $uploadFile)) {
        //                     $this->Modelo_Mantenimientos->RegistrarMantenimientoCorrectivoEvidencia($ID_Mantenimiento, $Categoria, $uploadFile);
        //                     $contador++;
        //                 } else {
        //                     // Error al mover el archivo
        //                     echo "❌ Error al cargar la imagen: $uploadFile<br>";
        //                 }
        //             }else {
        //                 echo "⚠️ Tipo de archivo no permitido: {$archivos['name'][$key]}<br>";
        //             }
        //         }

        //     };

        //     $subirArchivos('falla', $ImgFalla);
        //     $subirArchivos('reparacion', $ImgReparacion);        
        // }

        // public function ObtenerTecnicosMantenimiento ($ID) {
        //     $Tecnicos = $this->Modelo_Mantenimientos->ObtenerTecnicosMantenimiento($ID);
        //     return $Tecnicos;
        // }

        // public function ObtenerMantenimiento ($ID) {
        //     $DataMantenimiento = $this->Modelo_Mantenimientos->ObtenerMantenimiento($ID);
        //     return $DataMantenimiento;
        // }

        // public function FirmarMantenimiento ($ID_Mantenimiento, $Firmas) {
        //     $totalFirmas = count($Firmas);
        //     $firmasGuardadas = 0;
        //     $FechaFirma = date("d/m/Y");
        //     $EstadoFirmaMecanico = 1;
        //     foreach ($Firmas as $ID_Mecanico => $Firma) {
        //         if (!empty($Firma)) {
        //             $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimiento($ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
        //             if ($Resultado) {
        //                 $firmasGuardadas++;
        //             }
        //         }
        //     }
        //     if ($firmasGuardadas === $totalFirmas && $totalFirmas > 0) {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: '¡Firmado Correctamente!',
        //                 text: 'El mantenimiento ha sido firmado correctamente.',
        //                 icon: 'success',
        //                 confirmButtonText: 'Continuar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'FirmaOperario?ID={$ID_Mantenimiento}';
        //                 }
        //             });
        //         </script>";
        //     } else {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
        //                 icon: 'error',
        //                 confirmButtonText: 'Aceptar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             });
        //         </script>";
        //     }

        // }

        // public function FirmarMantenimientoOperario ($ID_Mantenimiento, $Firma) {
        //     $EstadoFirmaOperario = 1;
        //     $FechaFirma = date("d/m/Y");
        //     if ($this->Modelo_Mantenimientos->FirmarMantenimientoOperario($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaOperario)) {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: '¡Firmado Correctamente!',
        //                 text: 'El mantenimiento ha sido firmado correctamente.',
        //                 icon: 'success',
        //                 confirmButtonText: 'Continuar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'Inicio';
        //                 }
        //             });
        //         </script>";
        //     } else {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
        //                 icon: 'error',
        //                 confirmButtonText: 'Aceptar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             });
        //         </script>";
        //     }
        // }
        
        // public function FirmarMantenimientoSupervisor ($ID_Mantenimiento, $Firma) {
        //     $EstadoFirmaSupervisor = 1;
        //     $FechaFirma = date("d/m/Y");
        //     if ($this->Modelo_Mantenimientos->FirmarMantenimientoSupervisor($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor)) {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: '¡Firmado Correctamente!',
        //                 text: 'El mantenimiento ha sido firmado correctamente.',
        //                 icon: 'success',
        //                 confirmButtonText: 'Continuar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'Inicio';
        //                 }
        //             });
        //         </script>";
        //     } else {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
        //                 icon: 'error',
        //                 confirmButtonText: 'Aceptar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             });
        //         </script>";
        //     }
        // }

        // public function FirmarMantenimientoCorrectivo ($ID_Mantenimiento, $ID_Salida, $Firmas) {
        //     $totalFirmas = count($Firmas);
        //     $firmasGuardadas = 0;
        //     $FechaFirma = date("d/m/Y");
        //     $EstadoFirmaMecanico = 1;
        //     foreach ($Firmas as $ID_Mecanico => $Firma) {
        //         if (!empty($Firma)) {
        //             if(!empty($ID_Salida)){
        //                 $this->Modelo_Mantenimientos->ActualizarID_Salida($ID_Salida, $ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
        //             }
        //             $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoCorrectivo($ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
        //             if ($Resultado) {
        //                 $firmasGuardadas++;
        //             }
        //         }
        //     }
        //     if ($firmasGuardadas === $totalFirmas && $totalFirmas > 0) {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: '¡Firmado Correctamente!',
        //                 text: 'El mantenimiento ha sido firmado correctamente.',
        //                 icon: 'success',
        //                 confirmButtonText: 'Continuar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'FirmaOperarioC?ID={$ID_Mantenimiento}';
        //                 }
        //             });
        //         </script>";
        //     } else {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
        //                 icon: 'error',
        //                 confirmButtonText: 'Aceptar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             });
        //         </script>";
        //     }

        // }

        // public function FirmarMantenimientoOperarioCorrectivo ($ID_Mantenimiento, $Firma) {
        //     $EstadoFirmaOperario = 1;
        //     $FechaFirma = date("d/m/Y");
        //     if ($this->Modelo_Mantenimientos->FirmarMantenimientoOperarioCorrectivo($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaOperario)) {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: '¡Firmado Correctamente!',
        //                 text: 'El mantenimiento ha sido firmado correctamente.',
        //                 icon: 'success',
        //                 confirmButtonText: 'Continuar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'Inicio';
        //                 }
        //             });
        //         </script>";
        //     } else {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
        //                 icon: 'error',
        //                 confirmButtonText: 'Aceptar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             });
        //         </script>";
        //     }
        // }

        //  public function ObtenerTecnicosMantenimientoC ($ID) {
        //     $Tecnicos = $this->Modelo_Mantenimientos->ObtenerTecnicosMantenimientoC($ID);
        //     return $Tecnicos;
        // }
        
        // public function FirmarMantenimientoSupervisorC ($ID_Mantenimiento, $Firma) {
        //     $EstadoFirmaSupervisor = 1;
        //     $FechaFirma = date("d/m/Y");
        //     if ($this->Modelo_Mantenimientos->FirmarMantenimientoSupervisorC($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor)) {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: '¡Firmado Correctamente!',
        //                 text: 'El mantenimiento ha sido firmado correctamente.',
        //                 icon: 'success',
        //                 confirmButtonText: 'Continuar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'Inicio';
        //                 }
        //             });
        //         </script>";
        //     } else {
        //         echo "
        //         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        //         <script>
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
        //                 icon: 'error',
        //                 confirmButtonText: 'Aceptar',
        //                 allowOutsideClick: false,
        //                 allowEscapeKey: false
        //             });
        //         </script>";
        //     }
        // }

        // public function ObtenerMantenimientoC ($ID) {
        //     $DataMantenimiento = $this->Modelo_Mantenimientos->ObtenerMantenimientoC($ID);
        //     return $DataMantenimiento;
        // }

        // private function GenerarCorreo ($Correo_Supervisor, $Nombre_Supervisor, $ID_Mantenimiento) {
        //     $mail = new PHPMailer(true);
        //     $isLocal = false;
        //     $serverName = $_SERVER['SERVER_NAME']; 
    
        //     if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
        //         $isLocal = true;
        //     }
        //     if ($isLocal === true) {
        //         $FirmarMantenimiento = "localhost/Outkargo2/Mantenimiento/FirmaSupervisor?ID=$ID_Mantenimiento";
        //     }else {
        //         $FirmarMantenimiento = "https://Outkargo.com.co/Mantenimiento/FirmaSupervisor?ID=$ID_Mantenimiento";
        //     }
        //     try {
        //         // Configuración del servidor SMTP
        //         $mail->isSMTP();
        //         $mail->Host       = 'smtp.hostinger.com '; 
        //         $mail->SMTPAuth   = true;
        //         $mail->Username   = 'mensajes@outkargo.com.co'; // Tu usuario SMTP
        //         $mail->Password   = 'B=7WtN;p'; // Tu contraseña SMTP
        //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //         $mail->Port       = 465;

        //         $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
        //         $mail->addAddress($Correo_Supervisor, $Nombre_Supervisor);
        //         $mail->isHTML(true);
        //         $mail->CharSet = 'UTF-8';
        //         $mail->Subject = 'Autorizar Mantenemiento Preventivo';
        //         $mail->Body    = $mail->Body = '
        //         <html>
        //         <head>
        //             <style>
        //                 body {
        //                     font-family: Arial, sans-serif;
        //                     color: #333;
        //                     margin: 0;
        //                     padding: 0;
        //                 }
        //                 .container {
        //                     width: 100%;
        //                     padding: 20px;
        //                     background-color: #f4f4f4;
        //                 }
        //                 .header {
        //                     background-color: #ff5000;
        //                     color: #fff;
        //                     padding: 10px;
        //                     text-align: center;
        //                     border-radius: 8px 8px 0 0;
        //                 }
        //                 .header img {
        //                     vertical-align: middle;
        //                     width: 50px;
        //                     height: 50px;
        //                 }
        //                 .header h1 {
        //                     display: inline;
        //                     margin: 0;
        //                     font-size: 24px;
        //                 }
        //                 .content {
        //                     padding: 20px;
        //                     background-color: #fff;
        //                     border-radius: 0 0 8px 8px;
        //                     box-shadow: 0 0 10px rgba(0,0,0,0.1);
        //                     max-width: 600px;
        //                     margin: 0 auto;
        //                 }
        //                 .content p {
        //                     margin: 0 0 10px;
        //                 }
        //                 .highlight {
        //                     color: #ff5000;
        //                     font-weight: bold;
        //                 }
        //                 .button {
        //                     display: inline-block;
        //                     background-color: #007BFF;
        //                     color: #ffffff;
        //                     padding: 10px 20px;
        //                     font-size: 16px;
        //                     border-radius: 5px;
        //                     text-decoration: none;
        //                     margin-top: 10px;
        //                     text-align: center;
        //                 }
        //                 .button:hover {
        //                     background-color: #0056b3;
        //                 }
        //                 .footer {
        //                     text-align: center;
        //                     font-size: 14px;
        //                     color: #888;
        //                     padding: 10px;
        //                 }
        //                 .footer a {
        //                     color: #ff5000;
        //                     text-decoration: none;
        //                 }
        //                 .link {
        //                     color: #ff5000;
        //                     text-decoration: none;
        //                     font-size: 14px;
        //                 }
        //                 .link:hover {
        //                     text-decoration: underline;
        //                 }
        //             </style>
        //         </head>
        //         <body>
        //             <div class="container">
        //                 <div class="header">
        //                     <img src="https://img.icons8.com/ios/50/ffffff/pos-terminal--v1.png" alt="POS Terminal"/>
        //                     <h1>OUTKARGO</h1>
        //                 </div>
        //                 <div class="content">
        //                     <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Supervisor) . '</strong>,</p>
        //                     <p>Un nuevo Mantenimiento ha sido creado</strong>,</p>
        //                     <p>Para autorizar de clic en el siguente boton:</p>
        //                     <a href="'.$FirmarMantenimiento.'" class="button">Autorizar Mantenimiento</a>
        //                 </div>
        //                 <div class="footer">
        //                     <p>&copy; ' . date("Y") . ' OUTKARGO. Derechos reservados.</p>
        //                 </div>
        //             </div>
        //         </body>
        //         </html>';
        //         $mail->send();
        //     }
        //     catch (Exception $e) {
        //         echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        //     }
        // }

        // public function EnviarCorreo1($ID_Mantenimiento, $ID_Verifica, $Numero){
    }
?>
