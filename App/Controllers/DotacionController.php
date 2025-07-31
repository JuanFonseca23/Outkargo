<?php
    include_once  "App/Models/Dotacion.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";   
    include_once "App/Controllers/UsuarioController.php";

    class DotacionController {
        // Atributos
        private $Modelo_Dotacion;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Contactos;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_Dotacion = new Dotacion();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
            $this->Controller_Usuarios = new UsuarioController();
        }

        // Métodos
        public function ContarProductosActivos($ID_Centro){
            $Resultado = $this->Modelo_Dotacion->ContarProductosActivos($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarEntregas($ID_Centro){
            $Resultado = $this->Modelo_Dotacion->ContarEntregas($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarEntradas($ID_Centro){
            $Resultado = $this->Modelo_Dotacion->ContarEntradas($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarEntradasTotales(){
            $Resultado = $this->Modelo_Dotacion->ContarEntradasTotales();
            return $Resultado ? $Resultado : 0;
        }
        
        public function Leer($ID_Centro){
            if ($this->Modelo_Dotacion->Leer($ID_Centro)) {
                $Resultado = $this->Modelo_Dotacion->Leer($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerE($ID_Centro){
            if ($this->Modelo_Dotacion->LeerE($ID_Centro)) {
                $Resultado = $this->Modelo_Dotacion->LeerE($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerEntradas($ID_Centro){
            if ($this->Modelo_Dotacion->LeerEntradas($ID_Centro)) {
                $Resultado = $this->Modelo_Dotacion->LeerEntradas($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerEntradasTotales(){
            if ($this->Modelo_Dotacion->LeerEntradasTotales()) {
                $Resultado = $this->Modelo_Dotacion->LeerEntradasTotales();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function Centro($ID_Centro){
            if ($this->Modelo_Dotacion->Centro($ID_Centro)) {
                $Resultado = $this->Modelo_Dotacion->Centro($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function BuscarPersona($No_Documento) {
            $datausuario = $this->Controller_Usuarios->BuscarPersonaDocumento($No_Documento);     
            if ($datausuario) {               
                return $datausuario;   
            }else {
                return false;
            }
        }

        public function DetallesEntrega($ID_Persona_Recibe, $ID_Persona_Entrega){
            if ($DataEntrega = $this->Modelo_Dotacion->DetallesEntrega($ID_Persona_Recibe, $ID_Persona_Entrega)) {
                return $DataEntrega;
            }else {
                return false;
            }
        }

        public function DetallesEntrada($ID_Usuario){
            if ($DataEntrada = $this->Modelo_Dotacion->DetallesEntrada($ID_Usuario)){
                return $DataEntrada;
            } else{
                return false;
            }
        }
        

        public function RegistrarProducto($ID, $Nombre1, $Nombre){
            $ultimoCodigo = $this->Modelo_Dotacion->obtenerUltimoCodigo();
            if ($ultimoCodigo) {
                $nuevoCodigo = str_pad(intval($ultimoCodigo) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $nuevoCodigo = '000001';
            }

            while ($this->Modelo_Dotacion->existeCodigo($nuevoCodigo)) {
                $nuevoCodigo = str_pad(intval($nuevoCodigo) + 1, 6, "0", STR_PAD_LEFT);
            }

            $ID_Producto = $this->Modelo_Dotacion->RegistrarProducto($nuevoCodigo, $Nombre);

            if ($ID_Producto){
                $ID_Usuario1 = $ID;
                $Creo = 'ingreso';
                $Frase = $Nombre1 . ' ingresó el Producto: ' . $Nombre;
                $ID_Usuario2 = null;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario2, $Creo, $Frase);
            }     
            return $nuevoCodigo;   
        }

        public function InsertarEntregaTemp($Codigo, $ID_Usuario, $ID_Centro, $Documento) {
            $ID_Producto = $this->Modelo_Dotacion->obtenerIDProductoPorCodigo($Codigo);    
            $this->Modelo_Dotacion->EilinarUltimoRegistro($ID_Usuario);
            if ($ID_Producto) {
                $CantidadActual = $this->Modelo_Dotacion->ValidarExistenciaActual($ID_Producto, $ID_Centro);
                if ($CantidadActual['Cantidad'] > 0) {
                    if ($this->Modelo_Dotacion->ValidarUltimoRegistroEntrega($ID_Usuario, $ID_Producto)) {
                        $CantidadAnterior = $this->Modelo_Dotacion->ValidarCantidadActualEntrega($ID_Usuario, $ID_Producto);
                        $Cantidad = $CantidadAnterior + 1;
                        if ($Cantidad > $CantidadActual['Cantidad']) {
                            echo "<script>alertify.error('Producto sin stock suficiente: " . $Codigo . "');</script>";
                        }else {
                            $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);
                                $this->Modelo_Dotacion->AgregarUltimoRegistro($ID_Producto, $ID_Usuario);
                            if ($this->Modelo_Dotacion->ActualizarDotacionEntrega($ID_Usuario, $ID_Producto, $Cantidad)) {
                                echo "<script>window.location.href = 'Entrega?Documento=$Documento';</script>";
                            } else {
                                echo "<script>alertify.error('Error al actualizar el objeto: Cod." . $NombreDelCodigo . "');</script>";
                            }
                        }                        
                    } else {
                        $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);                    
                        if ($NombreDelCodigo) {
                            $Cantidad = 1;                    
                            if ($this->Modelo_Dotacion->InsertarDotacionEntrega($ID_Usuario, $ID_Producto, $Cantidad)) {
                                $this->Modelo_Dotacion->AgregarUltimoRegistro($ID_Producto, $ID_Usuario);
                                echo "<script>window.location.href = 'Entrega?Documento=$Documento';</script>";
                            } else {
                                $this->Modelo_Dotacion->EilinarUltimoRegistro($ID_Usuario);
                                echo "<script>alertify.error('Error al ingresar el objeto: Cod." . $NombreDelCodigo . "');</script>";
                            }
                        } 
                    }
                }else {
                    $this->Modelo_Dotacion->EilinarUltimoRegistro($ID_Usuario);
                    echo "<script>alertify.error('Producto sin stock : " . $Codigo . "');</script>";
                }                
            }else {
                echo "<script>alertify.error('Producto no encontrado : " . $Codigo . "');</script>";
            }
        }
        
        public function EilinarUltimoRegistro($ID_Usuario){
            $this->Modelo_Dotacion->EilinarUltimoRegistro($ID_Usuario);
        }

        public function InsertarEntradaTemp($Codigo, $ID_Usuario) {
            if (!empty($Codigo)) {
                $ID_Producto = $this->Modelo_Dotacion->obtenerIDProductoPorCodigo($Codigo);
                // Elimina cualquier registro anterior relacionado con la misma dotación para evitar duplicados
                $this->Modelo_Dotacion->EliminarUltimoRegistroEntrada($ID_Usuario);                   
                if ($ID_Producto) {
                    // Verifica si ya existe un registro para el producto y el usuario
                    if ($this->Modelo_Dotacion->ValidarUltimoRegistroEntrada($ID_Usuario, $ID_Producto)) {
                        // Si ya existe, recupera la cantidad actual
                        $CantidadAnterior = $this->Modelo_Dotacion->ValidarCantidadActualEntrada($ID_Usuario, $ID_Producto);
                        $Cantidad = $CantidadAnterior + 1;
                        $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);
                            $this->Modelo_Dotacion->AgregarUltimoRegistroEntrada($ID_Producto, $ID_Usuario);
                        if ($this->Modelo_Dotacion->ActualizarDotacionEntrada($ID_Usuario, $ID_Producto, $Cantidad)) {
                            echo "<script>window.location.href = 'Entrada';</script>";
                        } else {
                            $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);
                            echo "<script>alertify.error('Error al actualizar el objeto: Cod." . $NombreDelCodigo . "');</script>";
                        }
                    } else {
                        // Si no existe, inserta una nueva entrada
                        $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);
                        if ($NombreDelCodigo) {
                            $Cantidad = 1; // Inicia con una cantidad de 1
                            if ($this->Modelo_Dotacion->InsertarDotacionEntrada($ID_Usuario, $ID_Producto, $Cantidad)) {
                                $this->Modelo_Dotacion->AgregarUltimoRegistroEntrada($ID_Producto, $ID_Usuario);
                                echo "<script>window.location.href = 'Entrada';</script>";
                            } else {
                                echo "<script>alertify.error('Error al ingresar el objeto: Cod." . $NombreDelCodigo . "');</script>";
                            }
                        }
                    }
                } else {
                    // Producto no encontrado
                    echo "<script>alertify.error('Producto no encontrado: " . $Codigo . "');</script>";
                }
            } else {
                // Si el campo de código está vacío
                echo "<script>alertify.message('Por favor digite un código en el campo.');</script>";
            }
        }   

        public function EliminarUltimoRegistroEntrada($ID_Usuario){
            $this->Modelo_Dotacion->EliminarUltimoRegistroEntrada($ID_Usuario);
        }   
        
        public function TraerUltimoRegistro($ID){
            if ($this->Modelo_Dotacion->LeerUltimoRegistro($ID)) {
                $Resultado = $this->Modelo_Dotacion->LeerUltimoRegistro($ID);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function RestarEntregaTemp ($Codigo, $ID_Usuario, $Documento){
            $this->Modelo_Dotacion->EilinarUltimoRegistro($ID_Usuario);
            $ID_Producto = $this->Modelo_Dotacion->obtenerIDProductoPorCodigo($Codigo);      
            if ($this->Modelo_Dotacion->RestarEntregaTemp($ID_Producto, $ID_Usuario)) {
                echo "<script>window.location.href = 'Entrega?Documento=$Documento';</script>";
            }
        }

        public function EliminarEntregaTemp ($Codigo, $ID_Usuario, $Documento){
            $this->Modelo_Dotacion->EilinarUltimoRegistro($ID_Usuario);
            $ID_Producto = $this->Modelo_Dotacion->obtenerIDProductoPorCodigo($Codigo);      
            if ($this->Modelo_Dotacion->EliminarEntregaTemp($ID_Producto, $ID_Usuario)) {
                echo "<script>window.location.href = 'Entrega?Documento=$Documento';</script>";
            }
        }

        public function verificarEstadoEntrada($ID_Usuario) {
            $Resultado = $this->Modelo_Dotacion->verificarEstadoEntrada($ID_Usuario);
            return $Resultado; 
        }

        public function verificarEstadoFirma($ID_Entrada) {
            $Resultado = $this->Modelo_Dotacion->verificarEstadoFirma($ID_Entrada);
            return $Resultado; 
        }
                
        public function TraerUltimoRegistroEntrada($ID) {
            $Resultado = $this->Modelo_Dotacion->LeerUltimoRegistroEntrada($ID);
            if ($Resultado) {
                return $Resultado;
            } else {
                return false;
            }
        }
        
        public function RestarEntradaTemp ($Codigo, $ID_Usuario){
            $this->Modelo_Dotacion->EliminarUltimoRegistroEntrada($ID_Usuario);
            $ID_Producto = $this->Modelo_Dotacion->obtenerIDProductoPorCodigo($Codigo);  
            $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);    
            if ($this->Modelo_Dotacion->RestarEntradaTemp($ID_Producto, $ID_Usuario)) {
                echo "<script>alertify.error('Producto Descontado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Entrada';</script>";
            }
        }

        public function EliminarEntradaTemp ($Codigo, $ID_Usuario){
            $this->Modelo_Dotacion->EliminarUltimoRegistroEntrada($ID_Usuario);
            $ID_Producto = $this->Modelo_Dotacion->obtenerIDProductoPorCodigo($Codigo);     
            $NombreDelCodigo = $this->Modelo_Dotacion->MostrarNombre($ID_Producto);   
            if ($this->Modelo_Dotacion->EliminarEntradaTemp($ID_Producto, $ID_Usuario)) {
                echo "<script>alertify.message('Producto Eliminado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Entrada';</script>";
            }
        }

        public function FirmarEntrega($Firma,$Usuario, $Nombre_Ingresa,$Fecha, $Cedula, $Centro){
            if ($ID_Entrega = $this->Modelo_Dotacion->RegistrarEntregaDotacion($Firma,$Usuario,$Fecha, $Cedula, $Centro)) {                
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = $Cedula;
                $Creo = 'creo';
                $Data_Persona = $this->Controller_Usuarios->Mostrar($Cedula);
                $Nombre_Persona = $Data_Persona['Nombre1'];
                $Frase = $Nombre_Ingresa.' Realizo una entrega de dotacion para la persona '.$Nombre_Persona;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                $this->Modelo_Dotacion->BorrarEntregaDotacionTemp($Usuario, $ID_Entrega, $Centro);
                header("location:AceptarEntrega?Cod=".$ID_Entrega."&Cedula=".$Cedula);
                exit;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function FirmarEntregaRecibe($Firma, $Usuario, $Fecha, $Cedula, $ID_Centro,$ID_Usuario_Recibe) {
            if ($ID_Entrega = $this->Modelo_Dotacion->FirmarEntregaDotacion($Firma, $Usuario, $Fecha, $Cedula)) {
                $ID_Usuario1 =$ID_Usuario_Recibe;
                $ID_Usuario2 = null;
                $Creo = 'completo';
                $Data_Persona = $this->Controller_Usuarios->Mostrar($ID_Usuario_Recibe);
                $Nombre_Persona = $Data_Persona['Nombre1'];
                $Frase = $Nombre_Persona.' Firmo la entrega de dotacion No.'.$Cedula ;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);                
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'La entrega ha sido firmada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioE';
                            }
                        });
                    </script>";
            } else {
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'ERROR: Comuníquese con el área de sistemas.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    </script>";
            }
        }
        
        public function FirmarEntrada($ID_Usuario, $ID_Supervisor, $ID_Centro, $Firma, $Nombre_Ingresa, $Correo_Supervisor, $Nombre_Supervisor){
        
            $Ultimo_Formulario= $this->Modelo_Dotacion->ObtenerNumeroFormulario();
            if ($Ultimo_Formulario) {
                $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $No_Formulario = '000001';
            }
            #Insertar la nueva entrada en la base de datos
            $Estado = 2;            
            $Fecha_Realizado = date("d/m/Y");      
            $Firma_Supervisor_Estado = 2;
            if($ID = $this->Modelo_Dotacion->FirmarEntrada($ID_Usuario, $ID_Supervisor, $ID_Centro, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Supervisor_Estado)){
                $ID_Entrada=$ID;
                $this->GenerarCorreo($Correo_Supervisor, $Nombre_Supervisor, $No_Formulario, $ID_Entrada);
                $ID_Usuario1 =$ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $Nombre_Ingresa.' Creó el usuario de '.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'La entrada ha sido firmada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioEntrada';
                            }
                        });
                    </script>";
            } else {
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'ERROR: Comuníquese con el área de sistemas.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    </script>";
            }           
        }

        public function FirmarEntradaSupervisor($ID, $Usuario, $Nombre_Ingresa, $No_Formulario, $Firma_Supervisor){
            $Estado = 1;
            $Fecha_Firma_Supervisor = date("d/m/Y");  
            $Firma_Supervisor_Estado = 1;
            if ($this->Modelo_Dotacion->FirmarEntradaSupervisor($ID, $Fecha_Firma_Supervisor, $Estado, $Firma_Supervisor, $Firma_Supervisor_Estado)) {
                $this->Modelo_Dotacion->DotacionEntrada ($ID);
                $Correo = $this->Modelo_Dotacion->ObtenerCorreo($Usuario);
                $this->GenerarCorreoConfirmacion($Correo, $Nombre_Ingresa, $No_Formulario);
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre_Ingresa.' Autorizo la entrada con el numero: '.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'La entrada ha sido firmada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioEntrada';
                            }
                        });
                    </script>";
            } else {
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'ERROR: Comuníquese con el área de sistemas.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    </script>";
            }
        }

        public function AnularDotacionEntrada($ID, $Usuario, $Nombre_Ingresa, $Descripcion, $No_Formulario){
            if($this->Modelo_Dotacion->AnularDotacionEntrada($ID, $Descripcion)){
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'anulo';
                $Frase = $Nombre_Ingresa.' Realizo la anulacion de la entrada con el numero: '.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Anulada!',
                            text: 'La entrada ha sido Anulada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioEntrada';
                            }
                        });
                    </script>";
            } else {
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'ERROR: Comuníquese con el área de sistemas.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    </script>";
            }
            
        }

        public function VerEntrada($ID, $ID_Centro){
            $DataEntrada = $this->Modelo_Dotacion->VerEntrada($ID, $ID_Centro);
            return $DataEntrada;
        }

        public function MostrarDetallesDotacionEntrada($ID){
            if ($resultado=$this->Modelo_Dotacion->MostrarDetallesDotacionEntrada($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function MostrarDetallesDotacionEntradaTemp($ID){
            if ($resultado=$this->Modelo_Dotacion->MostrarDetallesDotacionEntradaTemp($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function VerEntrega($ID, $ID_Centro){
            $DataEntrega = $this->Modelo_Dotacion->VerEntrega($ID, $ID_Centro);
            return $DataEntrega;
        }

        public function MostrarDetallesDotacionEntrega($ID){
            if ($resultado=$this->Modelo_Dotacion->MostrarDetallesDotacionEntrega($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }
    
        private function GenerarCorreo ($Correo_Supervisor, $Nombre_Supervisor, $No_Formulario, $ID_Entrada) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarEntrada = "localhost/Outkargo2/Dotacion/FirmaSupervisor?ID=$ID_Entrada&No=$No_Formulario";
            }else {
                $AceptarEntrada = "https://Outkargo.com.co/Dotacion/FirmaSupervisor?ID=$ID_Entrada&No=$No_Formulario/";
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
                $mail->Subject = 'Autorizar Entrada de Dotacion # '.$No_Formulario.'. ';
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
                            <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Supervisor) . '</strong>,</p>
                            <p>Una nueva entrada con el numero: <strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong>,</p>
                            <p>Para autorizar su ingreso de clic en el siguente boton:</p>
                            <a href="'.$AceptarEntrada.'" class="button">Aceptar Entrada</a>
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

        private function GenerarCorreoConfirmacion ($Correo, $Nombre_Ingresa, $No_Formulario) {
            $mail = new PHPMailer(true);    
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
                $mail->addAddress($Correo, $Nombre_Ingresa);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Confirmacion de Autorizacion de Entrada #' . $No_Formulario .'';
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
                            <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Ingresa) . '</strong>,</p>
                            <p>La entrada #: <strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong>. Fue autorizada con exito</p>
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

        public function AnularDotacionEntrega($ID, $Usuario, $Nombre_Ingresa, $Descripcion, $No_Formulario){
            if($this->Modelo_Dotacion->AnularEntrega($ID, $Descripcion)){
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'anulo';
                $Frase = $Nombre_Ingresa.' Realizo la anulacion de la entrega con el No.'.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Anulada!',
                            text: 'La entrega ha sido Anulada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioE';
                            }
                        });
                    </script>";
            } else {
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'ERROR: Comuníquese con el área de sistemas.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    </script>";
            }
            
        }
    }
?>
