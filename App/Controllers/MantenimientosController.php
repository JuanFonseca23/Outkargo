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
        public function ActualizarDetallesCorrectivos($ID_Detalle, $Categoria, $Descripcion, $Seccion){
            return $this->Modelo_Mantenimientos->ActualizarDetallesCorrectivos($ID_Detalle, $Categoria, $Descripcion, $Seccion);
        }

        public function ContarMantenimientos(){
            $Estado = 'COMPLETADO';
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientos($Estado);
            return [
                'NoMantenimientos' => (int) (is_array($Resultado) ? ($Resultado['NoMantenimientos'] ?? 0) : 0)
            ];
        }

        public function ContarMantenimientosCorrectivos(){
            $Estado = 'COMPLETADO';
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientosCorrectivos($Estado);
            return [
                'NoMantenimientos' => (int) (is_array($Resultado) ? ($Resultado['NoMantenimientos'] ?? 0) : 0)
            ];
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

        public function CrearMantenimientoCorrectivoBorrador($ID_Usuario, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Externo, $Operario_Externo, $Tipo_Montacargas) {
            $Estado_Firma = 0;
            // $HoraInicio = date('H:i');
            $ultimoCodigo = $this->Modelo_Mantenimientos->ObtenerUltimoCodigoMantenimientoCorrectivo();
            if($ultimoCodigo){
                $NuevoCodigo = str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            }else{
                $NuevoCodigo = '000001';
            }
            $ID_Mantenimiento = $this->Modelo_Mantenimientos->CrearMantenimientoCorrectivoBorrador($ID_Usuario, $NuevoCodigo, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Estado_Firma, $Externo, $Operario_Externo, $Tipo_Montacargas);
            if ($ID_Mantenimiento) {
                $this->Modelo_Mantenimientos->RegistrarMantenimientoCorrectivoTecnico($ID_Mantenimiento, $ID_Usuario);
                $Detalles = $this->Modelo_Mantenimientos->ObtenerDatosCorrectivos($ID_Mantenimiento);
                $Novedades = $this->Modelo_Mantenimientos->ObtenerNovedadesPendientes($ID_Montacargas);
                return [$ID_Mantenimiento, $Detalles, $Novedades];
            } else {
                throw new Exception("Error al crear el mantenimiento preventivo.");
            }
        }

        public function EliminarBorrador($ID, $Tipo_Mantenimiento){
            $Resultado = $this->Modelo_Mantenimientos->EliminarBorrador($ID, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarBorradorCorrectivo($ID, $Tipo_Mantenimiento){
            $Resultado = $this->Modelo_Mantenimientos->EliminarBorradorCorrectivo($ID, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarDetalle($ID_Detalle, $ID_Novedad){
            return $this->Modelo_Mantenimientos->EliminarDetalle($ID_Detalle, $ID_Novedad);
        }

        public function EliminarImagen($ID){
            return $this->Modelo_Mantenimientos->EliminarImagen($ID);
        }

        public function EliminarImagenCorrectivo($ID_Detalle, $imagenesEliminar){
            return $this->Modelo_Mantenimientos->EliminarImagenCorrectivo($ID_Detalle, $imagenesEliminar);
        }

        public function EliminarInsumo($ID_Mantenimiento, $ID_Insumo, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarInsumo($ID_Mantenimiento, $ID_Insumo, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento);
            return $Resultado;
        }

        public function EliminarNovedadCorrectivo($ID_Novedad) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarNovedadCorrectivo($ID_Novedad);
            return $Resultado;
        }

        public function EliminarObservacionCorrectivo($ID_Mantenimiento, $Indice){
            $Resultado = $this->Modelo_Mantenimientos->EliminarObservacionCorrectivo($ID_Mantenimiento, $Indice);
            return $Resultado;
        }

        public function EliminarRepuesto($ID_Mantenimiento, $ID_Repuesto, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->EliminarRepuesto($ID_Mantenimiento, $ID_Repuesto, $Tipo_Mantenimiento);
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

        public function FinalizarMantenimientoCorrectivo($ID_Mantenimiento, $ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Horometro, $ID_Montacargas){
            $Estado = 'COMPLETADO';
            return $this->Modelo_Mantenimientos->FinalizarMantenimientoCorrectivo($ID_Mantenimiento, $ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Estado, $Horometro, $ID_Montacargas);
        }

        public function FirmarMantenimientoCorrectivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado){
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoCorrectivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado);
            return $Resultado;
        }

        public function FirmarMantenimientoCorrectivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoCorrectivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado);
            return $Resultado;
        }

        public function FirmarMantenimientoCorrectivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoCorrectivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado);
            return $Resultado;
        }
        
        public function FirmarMantenimientoCorrectivosTecnicos($ID_Mantenimiento, $Firmas, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas, $ID_Usuario, $NombreCreo, $Mantenimiento){
            $Fecha = date('Y-m-d');
            $Estado = 1;
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoCorrectivosTecnicos($ID_Mantenimiento, $Firmas, $Fecha, $Estado);
            return $Resultado;
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

        public function FirmarMantenimientoPreventivoTecnicos($ID_Mantenimiento, $Firmas, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas, $ID_Usuario, $NombreCreo, $Mantenimiento){
            $Fecha = date('Y-m-d');
            $Estado = 1;
            $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoPreventivoTecnicos($ID_Mantenimiento, $Firmas, $Fecha, $Estado);
            return $Resultado;
        }

        public function TieneFirmasTecnicosRegistradas($ID_Mantenimiento, $Tipo_Mantenimiento){
            return $this->Modelo_Mantenimientos->TieneFirmasTecnicosRegistradas($ID_Mantenimiento, $Tipo_Mantenimiento);
        }

        public function NotificarMantenimientoFirmado($ID_Mantenimiento, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas, $ID_Usuario, $NombreCreo, $Mantenimiento){
            try {
                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = null;
                $Creo = 'registro';
                $Frase = $NombreCreo . ' Creó un nuevo ' . $Mantenimiento;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario2, $Creo, $Frase);
                return $this->EnviarCorreo($ID_Mantenimiento, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas);
            } catch (Throwable $error) {
                error_log('No se pudo enviar la notificación de mantenimiento ' . $ID_Mantenimiento . ': ' . $error->getMessage());
                return false;
            }
        }

        public function RevertirFirmasMantenimientoPorSalidaFallida($ID_Mantenimiento, $Mantenimiento){
            $Tipo = stripos($Mantenimiento, 'Preventivo') !== false ? 'Preventivo' : 'Correctivo';
            return $this->Modelo_Mantenimientos->RevertirFirmasMantenimientoPorSalidaFallida($ID_Mantenimiento, $Tipo);
        }

        public function GuardarCriterio($ID_Detalle, $campo, $valor) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarCriterio($ID_Detalle, $campo, $valor);
            return $Resultado;
        }

        public function GuardarDetallesCorrectivos($ID_Mantenimiento, $DescripcionFalla, $DescripcionCorreccion, $Seccion, $ID_Novedad, $Fecha){
            $ID_Detalle = $this->Modelo_Mantenimientos->GuardarDetallesCorrectivos($ID_Mantenimiento, $DescripcionFalla, $DescripcionCorreccion, $Seccion, $ID_Novedad, $Fecha);
            return $ID_Detalle;
        }

        public function GuardarImagen($ID_Mantenimiento, $Categoria, $Archivo){
            return $this->Modelo_Mantenimientos->GuardarImagen($ID_Mantenimiento,$Categoria,$Archivo);
        }

        public function GuardarImagenCorrectivo($ID_Mantenimiento, $ID_Detalle, $Archivo, $Categoria){
            return $this->Modelo_Mantenimientos->GuardarImagenCorrectivo($ID_Mantenimiento, $ID_Detalle, $Archivo, $Categoria);
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

        public function GuardarObservaciones($ID_Mantenimiento, $Observaciones){
            $Resultado = $this->Modelo_Mantenimientos->GuardarObservaciones($ID_Mantenimiento, $Observaciones);
            return $Resultado;
        }
        
        public function GuardarRepuestos($ID_Mantenimiento, $ID_Montacargas, $Repuestos, $Tipo_Mantenimiento) {
            $Resultado = $this->Modelo_Mantenimientos->GuardarRepuestos($ID_Mantenimiento, $ID_Montacargas, $Repuestos, $Tipo_Mantenimiento);
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

        public function ObtenerMantenimientoCorrectivoCompleto($ID_Mantenimiento){
            return $this->Modelo_Mantenimientos->ObtenerMantenimientoCorrectivoCompleto($ID_Mantenimiento);
        }    
        
        public function ObtenerNovedadesMantenimiento($ID, $Tipo){
            $DataNovedadesM = $this->Modelo_Mantenimientos->ObtenerNovedadesMantenimiento($ID, $Tipo);
            return $DataNovedadesM;
        }

        public function TraerAreas($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerAreas($ID_Centro);
            return $Resultado;
        }

        public function TraerDetallesCorrectivos($ID_Mantenimiento) {
            $Detalles = $this->Modelo_Mantenimientos->TraerDetallesCorrectivos($ID_Mantenimiento);
            $Imagenes = $this->Modelo_Mantenimientos->TraerImagenesCorrectivos($ID_Mantenimiento);
            return ['detalles' => $Detalles, 'imagenes' => $Imagenes];
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

        public function VerificarBorradorCorrectivo($ID_Usuario){
            return $this->Modelo_Mantenimientos->VerificarBorradorCorrectivo($ID_Usuario);
        }

        public function VerDetalleM($ID){
            $DataDetalleM = $this->Modelo_Mantenimientos->VerDetalleM($ID);
            return $DataDetalleM;
        }

        public function VerDetalleMC($ID){
            $DataDetalleM = $this->Modelo_Mantenimientos->VerDetalleMC($ID);
            return $DataDetalleM;
        }

        public function VerImagenesM($ID){
            $DataImagenesM = $this->Modelo_Mantenimientos->VerImagenesM($ID);
            return $DataImagenesM;
        }

        public function DataImagenesMC($ID){
            $DataImagenesM = $this->Modelo_Mantenimientos->DataImagenesMC($ID);
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

        public function VerMantenimientoC($ID){
            $DataMantenimiento = $this->Modelo_Mantenimientos->VerMantenimientoC($ID);
            return $DataMantenimiento;
        }

        public function VerMecanicos($ID){
            $DataMecanicos = $this->Modelo_Mantenimientos->VerMecanicos($ID);
            return $DataMecanicos;
        }

        public function VerMecanicosC($ID){
            $DataMecanicos = $this->Modelo_Mantenimientos->VerMecanicosC($ID);
            return $DataMecanicos;
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

        //Salidas PARTE COMENTADAS 
        public function RealizarSalidaMantenimiento($ID_Mantenimiento, $ID_Usuario, $NombreCreo, $ID_Centro, $FirmaSalida, $Mantenimiento, $Insumos){
            try {
                $SalidaExistente = $this->Modelo_Inventario->ObtenerSalidaMantenimiento($ID_Mantenimiento, $Mantenimiento);
            } catch (Throwable $error) {
                error_log('No se pudo verificar si ya existe la salida del mantenimiento ' . $ID_Mantenimiento . ': ' . $error->getMessage());
                return false;
            }
            if ($SalidaExistente) {
                return true;
            }

            $Ultimo_Formulario= $this->Modelo_Inventario->ObtenerNumeroFormularioSalida();
            if ($Ultimo_Formulario) {
                $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $No_Formulario = '000001';
            }
            $Usuarios = $this->Modelo_OrdenesTrabajo->BuscarUsuario();
            $CentroSalida = (int)$ID_Centro;
            $ID_UsuarioSalida = null;
            $ID_SupervisorSalida = null;

            foreach ($Usuarios as $Usuario) {
                $CargoUsuario = (int)($Usuario['Cargo'] ?? 0);
                $CentroUsuario = (int)($Usuario['Centro'] ?? 0);
                $DocumentoUsuario = trim((string)($Usuario['Documento'] ?? ''));

                if ($CentroSalida === 2 || $CentroSalida === 3) {
                    $EsPersonaEntrega = $CargoUsuario === 5 && $CentroUsuario === $CentroSalida;
                } elseif ($CentroSalida === 8) {
                    $EsPersonaEntrega = $DocumentoUsuario === '79564608' && $CentroUsuario === 8;
                } elseif ($CentroSalida === 13) {
                    $EsPersonaEntrega = $DocumentoUsuario === '1003190749' && $CentroUsuario === 13;
                } else {
                    $EsPersonaEntrega = $CargoUsuario === 10;
                }

                // Conservar la primera coincidencia para no depender del último
                // registro que devuelva la consulta.
                if (!$ID_UsuarioSalida && $EsPersonaEntrega) {
                    $ID_UsuarioSalida = (int)$Usuario['ID_Usuario'];
                    $NombreEntregaSalida = $Usuario['Nombre'];
                    $CorreoEntregaSalida = $Usuario['Correo'];
                }

                if (!$ID_SupervisorSalida && $CargoUsuario === 11) {
                    $ID_SupervisorSalida = (int)$Usuario['ID_Usuario'];
                    $NombreSupervisorSalida = $Usuario['Nombre'];
                    $CorreoSupervisorSalida = $Usuario['Correo'];
                    $DocumentoSupervisorSalida = $Usuario['Documento'];
                }
            }
            if (!$ID_UsuarioSalida){
                error_log('Salida de mantenimiento cancelada: no hay persona de entrega configurada para el centro ' . $CentroSalida . '.');
                if ($CentroSalida === 2 || $CentroSalida === 3) {
                    $ReglaEntrega = 'un usuario con cargo 5 y centro ' . $CentroSalida;
                } elseif ($CentroSalida === 8) {
                    $ReglaEntrega = 'un usuario con documento 79564608 y centro 8';
                } elseif ($CentroSalida === 13) {
                    $ReglaEntrega = 'un usuario con documento 1003190749 y centro 13';
                } else {
                    $ReglaEntrega = 'un usuario con cargo 10';
                }
                return ['success' => false, 'message' => 'No hay una persona de entrega configurada. Debe existir ' . $ReglaEntrega . '.'];
            }
            if (!$ID_SupervisorSalida){
                error_log('Salida de mantenimiento cancelada: no se encontró un supervisor con cargo 11.');
                return ['success' => false, 'message' => 'No se encontró un supervisor con cargo 11 para autorizar la salida.'];
            }
            $Estado = 2;
            $Firma_Estado_Salida = 2;
            $Fecha_Recibe = date("d/m/Y");
            $EstadoFirmaMecanico = 1;
            if (empty($Insumos)) {
                return true;
            }

            $ID_Salida = $this->Modelo_Inventario->CrearSalidaMantenimientoAtomica(
                $ID_UsuarioSalida,
                $ID_Usuario,
                $ID_SupervisorSalida,
                $ID_Centro,
                $ID_Mantenimiento,
                $No_Formulario,
                $Mantenimiento,
                $Fecha_Recibe,
                $Estado,
                $FirmaSalida,
                $Firma_Estado_Salida,
                $EstadoFirmaMecanico,
                $Insumos
            );
            if (!$ID_Salida) {
                error_log('No se pudo crear la salida de mantenimiento ' . $ID_Mantenimiento . '; revise el log de Productos::CrearSalidaMantenimientoAtomica.');
                return false;
            }

            $ID_Usuario1 = $ID_Usuario;
            $ID_Usuario2 = null;
            $Creo = 'registro';
            $Frase = $NombreCreo . ' Creó un nuevo ' . $Mantenimiento . ' y realizó la salida de insumos #' . $No_Formulario;
            $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario2, $Creo, $Frase);

            $this->EnviarCorreo2($ID_Salida, $NombreEntregaSalida, $CorreoEntregaSalida, $No_Formulario);
            $this->EnviarCorreo3($ID_Salida, $NombreSupervisorSalida, $CorreoSupervisorSalida, $No_Formulario, $DocumentoSupervisorSalida);
            return true;
        }
        //FUNCIONES DE ENVIAR CORREO SALIDA 
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
    }
?>
