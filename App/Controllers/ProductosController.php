<?php
    include_once  "App/Models/Productos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";
    include_once "App/Controllers/UsuarioController.php";     

    class ProductosController {
        // Atributos
        private $Modelo_Productos;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;

        // Constructor
        public function __construct() {
            $this->Modelo_Productos = new Productos();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        // Métodos
        public function ContarProductosActivos($ID_Centro){
            $Resultado = $this->Modelo_Productos->ContarProductosActivos($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function Centro($ID_Centro){
            if ($this->Modelo_Productos->Centro($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->Centro($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ObtenerCentro($ID_Centro){
            if ($this->Modelo_Productos->ObtenerCentro($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->ObtenerCentro($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ListaMontacargas($ID_Centro){
            if ($this->Modelo_Productos->ListaMontacargas($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->ListaMontacargas($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ContarEntradas($ID_Centro){
            $Resultado = $this->Modelo_Productos->ContarEntradas($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarEntradasTotales(){
            $Resultado = $this->Modelo_Productos->ContarEntradasTotales();
            return $Resultado ? $Resultado : 0;
        }

        public function ContarTraslados($ID_Centro){
            $Resultado = $this->Modelo_Productos->ContarTraslados($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarTrasladosTotales(){
            $Resultado = $this->Modelo_Productos->ContarTrasladosTotales();
            return $Resultado ? $Resultado : 0;
        }

        public function ContarSalidas($ID_Centro){
            $Resultado = $this->Modelo_Productos->ContarSalidas($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function ContarSalidasTotales(){
            $Resultado = $this->Modelo_Productos->ContarSalidasTotales();
            return $Resultado ? $Resultado : 0;
        }

        public function Leer($ID_Centro){
            if ($this->Modelo_Productos->Leer($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->Leer($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerCantidadTotal($ID_Centro){
            if ($this->Modelo_Productos->LeerCantidadTotal($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->LeerCantidadTotal($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerInventarioTotal(){
            if ($this->Modelo_Productos->LeerInventarioTotal()) {
                $Resultado = $this->Modelo_Productos->LeerInventarioTotal();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerEntradas($ID_Centro){
            if ($this->Modelo_Productos->LeerEntradas($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->LeerEntradas($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerEntradasTotales(){
            if ($this->Modelo_Productos->LeerEntradasTotales()) {
                $Resultado = $this->Modelo_Productos->LeerEntradasTotales();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerTraslados($ID_Centro){
            if ($this->Modelo_Productos->LeerTraslados($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->LeerTraslados($ID_Centro);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerTrasladosTotales(){
            if ($this->Modelo_Productos->LeerTrasladosTotales()) {
                $Resultado = $this->Modelo_Productos->LeerTrasladosTotales();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function LeerSalidas($ID_Centro){
            if ($this->Modelo_Productos->LeerSalidas($ID_Centro)) {
                $Resultado = $this->Modelo_Productos->LeerSalidas($ID_Centro);
                return $Resultado;
            }
        }

        public function LeerSalidasTotales(){
            if ($this->Modelo_Productos->LeerSalidasTotales()) {
                $Resultado = $this->Modelo_Productos->LeerSalidasTotales();
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function VerEntrada($ID){
            $DataEntrada = $this->Modelo_Productos->VerEntrada($ID);
            return $DataEntrada;
        }

        public function MostrarDetallesProductosEntrada($ID){
            if ($resultado=$this->Modelo_Productos->MostrarDetallesProductosEntrada($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function DetallesProductosEntrada($ID, $Codigo){
            if ($resultado=$this->Modelo_Productos->DetallesProductosEntrada($ID, $Codigo)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function MostrarDetallesProductosEntradaTemp($ID){
            if ($resultado=$this->Modelo_Productos->MostrarDetallesProductosEntradaTemp($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function MostrarDetallesProductosSalida($ID){
            if ($resultado=$this->Modelo_Productos->MostrarDetallesProductosSalida($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function MostrarDetallesProductosSalidaTemp($ID){
            if ($resultado=$this->Modelo_Productos->MostrarDetallesProductosSalidaTemp($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function VerSalida($ID){
            $DataEntrada = $this->Modelo_Productos->VerSalida($ID);
            return $DataEntrada;
        }

        public function VerTraslado($ID){
            $DataEntrada = $this->Modelo_Productos->VerTraslado($ID);
            return $DataEntrada;
        }

        public function MostrarDetallesProductosTraslado($ID){
            if ($resultado=$this->Modelo_Productos->MostrarDetallesProductosTraslado($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function MostrarDetallesProductosTrasladoTemp($ID){
            if ($resultado=$this->Modelo_Productos->MostrarDetallesProductosTrasladoTemp($ID)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function DetallesProductosInventario($ID, $Codigo, $ID_Centro){
            if ($resultado=$this->Modelo_Productos->DetallesProductosInventario($ID, $Codigo, $ID_Centro)) {
                return $resultado;
            }else {
                echo "<script>alertify.error('ERROR COMUNICARSE CON EL AREA DE SISTEMAS'); </script>";
            }
        }

        public function obtenerProducto($ID_Producto){
            if ($this->Modelo_Productos->obtenerProducto($ID_Producto)) {
                $Resultado = $this->Modelo_Productos->obtenerProducto($ID_Producto);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function registrarCategoria($Nombre, $ID_Crea, $NombreCreo) {
            if ($this->Modelo_Productos->registrarCategoria($Nombre)) {
                $tipo ='Categoría';
                $Creo = 'creo';
                $ID_Usuario1 = $ID_Crea;
                $ID_Usuario = Null;
                $Frase = $NombreCreo. ' creó la ' .$tipo . ' de ' . $Nombre;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
                echo "<script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: '" . ucfirst($tipo) . " creada exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'Inicio'; // Redirige a la página 'Inicio'
                        }
                    });
                </script>";
            }
        }
        
        public function registrarSubcategoria($Nombre, $ID_Categoria, $ID_Crea, $NombreCreo) {
            if ($this->Modelo_Productos->registrarSubcategoria($Nombre, $ID_Categoria)) {
                $tipo ='Subcategoria';
                $Creo = 'creo';
                $ID_Usuario1 = $ID_Crea;
                $ID_Usuario = Null;
                $Frase = $NombreCreo. ' creó la ' .$tipo . ' de ' . $Nombre;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo,$Frase);
                echo "<script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: '" . ucfirst($tipo) . " creada exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'Inicio'; // Redirige a la página 'Inicio'
                        }
                    });
                </script>";
            }
        }
        
        public function TraerCategorias(){
            $Resultado = $this->Modelo_Productos->TraerCategorias();
            return $Resultado;   
        }

        public function TraerSubcategorias1(){
            $Resultado = $this->Modelo_Productos->TraerSubcategorias1();
            return $Resultado;  
        }
        
        public function TraerSubcategorias($ID_Categoria){
            $Resultado = $this->Modelo_Productos->TraerSubcategorias($ID_Categoria);
            return $Resultado;            
        }

        public function registrarProducto($Nombre, $Descripcion, $ID_Categoria, $ID_SubCategoria, $Foto, $Estado, $NumeroParte, $stockMinimo, $manejaInventario, $Centro, $stockInicial, $ID_Crea, $NombreCreo, $NumeroSerie, $ValorUnitario, $Factura) {  
            $ultimoCodigo = $this->Modelo_Productos->obtenerUltimoCodigo();
    
            if ($ultimoCodigo) {
                $nuevoCodigo = 'P-' . str_pad(intval(substr($ultimoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $nuevoCodigo = 'P-000001';
            }

            while ($this->Modelo_Productos->existeCodigo($nuevoCodigo)) {
                $nuevoCodigo = 'P-' . str_pad(intval(substr($nuevoCodigo, 2)) + 1, 6, "0", STR_PAD_LEFT);
            }
            $uploadDir = 'App/Views/Upload/Img/Insumos/';
            $NombreFoto = $nuevoCodigo . '.png';
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
                if (!in_array($fileType, $allowedTypes)) {
                    echo "
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Tipo de archivo no permitido. Solo se aceptan imágenes PNG, JPEG o GIF.',
                            icon: 'error',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    </script>";
                    return;
                }
            }

            $ID_Producto = $this->Modelo_Productos->registrarProducto($nuevoCodigo, $Nombre, $Descripcion, $NumeroParte, $NumeroSerie, $ID_Categoria, $ID_SubCategoria, $Estado, $uploadFile, $stockMinimo);     
        
            if ($ID_Producto) {
                if ($manejaInventario === "si") {
                    $ID_Centro = $Centro;
                    $Cantidad = $stockInicial;
                    $Fecha_Ingreso = date("d-m-y"); 
                    $Valor = $ValorUnitario;
                    $N_Factura = $Factura;
                    $this ->Modelo_Productos->insertarProducto($ID_Producto, $ID_Centro, $Cantidad, $Valor, $N_Factura, $Fecha_Ingreso);
                }   
                if ($manejaInventario === "no") {
                    $ID_Centro = $Centro;
                    $Cantidad = $stockInicial;
                    $Fecha_Ingreso = date("d-m-y"); 
                    $Valor = $ValorUnitario;
                    $N_Factura = $Factura;
                    $this ->Modelo_Productos->insertarProducto($ID_Producto, $ID_Centro, $Cantidad, $Valor, $N_Factura, $Fecha_Ingreso);
                }
                $ID_Usuario1 = $ID_Crea;
                $Creo = 'ingreso';
                $Frase = $NombreCreo . ' ingresó el Producto: ' . $Nombre;
                $ID_Usuario2 = null;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario2, $Creo, $Frase);
                echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Producto registrado exitosamente: $nuevoCodigo',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location = 'Inicio';
                        }
                    });
                </script>";  
            } else {
                echo 
                "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al registrar el Producto',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>";
                return;
            }
        }

        public function Editar($ID_Usuario, $NombreEdita, $ID_Producto, $Codigo, $Nombre, $Descripcion, $Estado, $ID_Categoria, $ID_SubCategoria, $NumeroParte, $NumeroSerie, $stockMinimo, $Foto){
            $uploadDir = 'App/Views/Upload/Img/Insumos/';
            $NombreFoto = $Codigo . '.png';
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
            $DataInsumos = $this->obtenerProducto($ID_Producto);
            if($this->Modelo_Productos->Editar($ID_Producto, $Nombre, $Descripcion , $Estado, $ID_Categoria, $ID_SubCategoria, $NumeroParte, $NumeroSerie, $stockMinimo, $uploadFile)){
                $Creo = 'modifico';
                $Frase = $NombreEdita . ' Modifico el insumo ' . $Nombre;
                $ID_Usuario2 = null;
                $ID_Actividad = $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario, $ID_Usuario2, $Creo, $Frase);
                if ($DataInsumos) {
                    foreach ($DataInsumos as $Producto) {

                        if ($Producto['Nombre'] != $Nombre) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - Nombre", $Producto['Nombre'], $Nombre);
                        }
                        if ($Producto['Descripcion'] != $Descripcion) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - Descripcion", $Producto['Descripcion'], $Descripcion);
                        }
                        if ($Producto['Categoria'] != $ID_Categoria) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - Categoria", $Producto['Categoria'], $ID_Categoria);
                        }
                        if ($Producto['SubCategoria'] != $ID_SubCategoria) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - SubCategoria", $Producto['SubCategoria'], $ID_SubCategoria);
                        }
                        if ($Producto['N_Parte'] != $NumeroParte) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - NumeroParte", $Producto['N_Parte'], $NumeroParte);
                        }
                        if ($Producto['N_Serial'] != $NumeroSerie) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - N_Serial", $Producto['N_Serial'], $NumeroSerie);
                        }
                        if ($Producto['Estado'] != $Estado) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - Estado", $Producto['Estado'], $Estado);
                        }
                        if ($Producto['Foto'] != $uploadFile) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - Foto", $Producto['Foto'], $uploadFile);
                        }
                        if ($Producto['stockMinimo'] != $stockMinimo) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Insumo - stockMinimo", $Producto['stockMinimo'], $stockMinimo);
                        }
                    }
                }
                echo "
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Insumo Editado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Ver?ID=$ID_Producto';
                            }
                        });
                    </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al editar el insumo',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>";
            }
        }

        public function verificarEstadoEntrada($ID_Usuario) {
            $Resultado = $this->Modelo_Productos->verificarEstadoEntrada($ID_Usuario);
            return $Resultado; 
        }

        public function DetallesEntrada($ID_Usuario){
            if ($DataEntrada = $this->Modelo_Productos->DetallesEntrada($ID_Usuario)){
                return $DataEntrada;
            } else{
                return false;
            }
        }

        public function TraerUltimoRegistroEntrada($ID) {
            $Resultado = $this->Modelo_Productos->LeerUltimoRegistroEntrada($ID);
            if ($Resultado) {
                return $Resultado;
            } else {
                return false;
            }
        }

        public function EliminarUltimoRegistroEntrada($ID_Usuario){
            $this->Modelo_Productos->EliminarUltimoRegistroEntrada($ID_Usuario);
        }

        public function InsertarEntradaTemp($Codigo, $ValorCantidad, $Medida, $ValorUnitario, $Factura, $ID_Usuario) {
            if (!empty($Codigo)) {
                $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);
                
                $this->Modelo_Productos->EliminarUltimoRegistroEntrada($ID_Usuario);                   
                if ($ID_Producto) {
                    $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);
                    if ($NombreDelCodigo) {
                        $Cantidad = $ValorCantidad; 
                        $ValorTotal = $Cantidad * $ValorUnitario;
                        if ($this->Modelo_Productos->InsertarProductosEntrada( $ID_Usuario, $ID_Producto, $Cantidad, $Medida, $Factura, $ValorUnitario, $ValorTotal)) {
                            $this->Modelo_Productos->AgregarUltimoRegistroEntrada($ID_Producto, $ID_Usuario);
                            echo "<script>window.location.href = 'Entrada';</script>";
                        } else {
                            echo "<script>alertify.error('Error al ingresar el objeto: Cod." . $NombreDelCodigo . "');</script>";
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

        public function FirmarEntrada($ID_Usuario, $ID_Supervisor, $ID_Centro, $Firma, $Nombre_Ingresa, $Correo_Supervisor, $Nombre_Supervisor, $Observaciones){
            $Ultimo_Formulario= $this->Modelo_Productos->ObtenerNumeroFormulario();
            if ($Ultimo_Formulario) {
                $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $No_Formulario = '000001';
            }
            $Estado = 2;            
            $Fecha_Realizado = date("d/m/Y");      
            $Firma_Supervisor_Estado = 2;
            if($ID = $this->Modelo_Productos->FirmarEntrada($ID_Usuario, $ID_Supervisor, $ID_Centro, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Supervisor_Estado, $Observaciones)){
                $ID_Entrada=$ID;
                $this->GenerarCorreo($Correo_Supervisor, $Nombre_Supervisor, $No_Formulario, $ID_Entrada);
                $ID_Usuario1 =$ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $Nombre_Ingresa.' Creó la entrada de producto  de '.$No_Formulario;
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

        public function EliminarEntradaTemp ($Codigo, $ID_Usuario, $ID){
            $this->Modelo_Productos->EliminarUltimoRegistroEntrada($ID_Usuario);
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);     
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);   
            if ($this->Modelo_Productos->EliminarEntradaTemp($ID_Producto, $ID_Usuario, $ID)) {
                echo "<script>alertify.message('Producto Eliminado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Entrada';</script>";
            }
        }

        public function RestarEntradaTemp ($Codigo, $ID_Usuario, $ID){
            $this->Modelo_Productos->EliminarUltimoRegistroEntrada($ID_Usuario);
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);  
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);    
            if ($this->Modelo_Productos->RestarEntradaTemp($ID_Producto, $ID_Usuario, $ID)) {
                echo "<script>alertify.error('Producto Descontado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Entrada';</script>";
            }
        }

        public function EditarEntrada($Codigo, $ID_Usuario, $Cantidad, $N_Factura, $valor_unitario, $Numero, $NombreEdita, $ID_Entrada, $Centro, $Estado){
            $Total = $Cantidad * $valor_unitario;
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo); 
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto); 
            $DataEntrada= $this->DetallesProductosEntrada($ID_Entrada, $Codigo);
            $DataInventario= $this->DetallesProductosInventario($ID_Entrada, $Codigo, $Centro); 
            if($this->Modelo_Productos->EditarEntrada($ID_Producto,  $N_Factura, $valor_unitario, $Total, $ID_Entrada, $Estado)){
                $Creo = 'modifico';
                $Frase = $NombreEdita . ' Modifico la Entrada #' . $Numero;
                $ID_Usuario2 = null;
                $ID_Actividad = $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario, $ID_Usuario2, $Creo, $Frase);
                if ($DataEntrada) {
                    foreach ($DataEntrada as $Entrada) {

                        if ($Entrada['N_Factura'] != $N_Factura) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Entrada - N_Factura", $Entrada['N_Factura'], $N_Factura);
                        }
                        if ($Entrada['valor_unitario'] != $valor_unitario) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Entrada - valor_unitario", $Entrada['valor_unitario'], $valor_unitario);
                        }
                        if ($Entrada['valor_total'] != $Total) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Entrada - valor_total", $Entrada['valor_total'], $Total);
                        }
                    }
                }

                if ($DataInventario) {
                    foreach ($DataInventario as $Inventario) {

                        if ($Inventario['N_Factura'] != $N_Factura) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Inventario - N_Factura", $Inventario['N_Factura'], $N_Factura);
                        }
                        if ($Inventario['valor_unitario'] != $valor_unitario) {
                            $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Inventario - valor_unitario", $Inventario['valor_unitario'], $valor_unitario);
                        }
                    }
                }
                echo "<script>alertify.success('Entrada Modificada : " . $Numero . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'EditarEntrada?ID=$ID_Entrada';</script>";
            }
        }

        public function EditarEntradaObservaciones($ID_Usuario, $Numero, $Centro, $Observaciones, $NombreEdita, $ID_Entrada){ 
            $DataEntrada= $this->VerEntrada($ID_Entrada);
            // $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);   
            if($this->Modelo_Productos->EditarEntradaObservaciones(  $Observaciones, $ID_Entrada)){
                $Creo = 'modifico';
                $Frase = $NombreEdita . ' Modifico la Entrada #' . $Numero;
                $ID_Usuario2 = null;
                $ID_Actividad = $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario, $ID_Usuario2, $Creo, $Frase);
                if ($DataEntrada) {
                    if ($DataEntrada['Observaciones'] != $Observaciones) {
                         $this->Controller_Trazabilidad->RegistrarTrazabilidad($ID_Actividad, "Entrada - Observaciones", $DataEntrada['Observaciones'], $Observaciones);
                    }
                }
                echo "<script>alertify.success('Entrada Modificada : " . $Numero . " ');</script>";
                echo "<script>window.location.href = 'EditarEntrada?ID=$ID_Entrada';</script>";
            }
        }

        public function AnularDotacionEntrada($ID, $Usuario, $Nombre_Ingresa, $Descripcion, $No_Formulario){
            if($this->Modelo_Productos->AnularDotacionEntrada($ID, $Descripcion)){
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'anulo';
                $Frase = $Nombre_Ingresa.' Realizo la anulacion de la la entrada de productos con el numero: '.$No_Formulario;
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

        public function FirmarEntradaSupervisor($ID, $Usuario, $Nombre_Ingresa, $No_Formulario, $Firma_Supervisor){
            $Estado = 1;
            $Fecha_Firma_Supervisor = date("d/m/Y");  
            $Firma_Supervisor_Estado = 1;
            if ($this->Modelo_Productos->FirmarEntradaSupervisor($ID, $Fecha_Firma_Supervisor, $Estado, $Firma_Supervisor, $Firma_Supervisor_Estado)) {
                $Fecha_Ingreso = $Fecha_Firma_Supervisor;
                $this->Modelo_Productos->ProductosEntrada ($ID, $Fecha_Ingreso);
                $Correo = $this->Modelo_Productos->ObtenerCorreo($Usuario);
                $this->GenerarCorreoConfirmacion($Correo, $Nombre_Ingresa, $No_Formulario);
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre_Ingresa.' Autorizo la entrada de producto con el numero: '.$No_Formulario;
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

        public function verificarEstadoFirma($ID_Entrada) {
            $Resultado = $this->Modelo_Productos->verificarEstadoFirma($ID_Entrada);
            return $Resultado; 
        }

        public function verificarEstadoFirmaS($ID_Salida) {
            $Resultado = $this->Modelo_Productos->verificarEstadoFirmaS($ID_Salida);
            return $Resultado; 
        }

        public function verificarEstadoFirmaSalida($ID_Salida) {
            $Resultado = $this->Modelo_Productos->verificarEstadoFirmaSalida($ID_Salida);
            return $Resultado; 
        }

        public function verificarEstadoFirmaSalida1($ID_Salida) {
            $Resultado = $this->Modelo_Productos->verificarEstadoFirmaSalida1($ID_Salida);
            return $Resultado; 
        }

        public function DetallesSalida($ID_Usuario){
            if ($DataSalida = $this->Modelo_Productos->DetallesSalida($ID_Usuario)){
                return $DataSalida;
            } else{
                return false;
            }
        }

        public function TraerUltimoRegistroSalida($ID) {
            $Resultado = $this->Modelo_Productos->LeerUltimoRegistroSalida($ID);
            if ($Resultado) {
                return $Resultado;
            } else {
                return false;
            }
        }

        public function EliminarUltimoRegistroSalida($ID_Usuario){
            $this->Modelo_Productos->EliminarUltimoRegistroSalida($ID_Usuario);
        }

        public function InsertarSalidaTemp($Codigo, $ValorCantidad, $Medida, $No_Documento, $ID_Centro, $CentroTrabajo, $ID_Usuario) {
            if (!empty($Codigo)) {
                // Obtener el ID del producto
                $this->Modelo_Productos->EliminarUltimoRegistroSalida($ID_Usuario); 
                $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);
                $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);
                if (empty($ID_Producto)) {
                    echo "<script>alertify.error('Producto no encontrado.');</script>";
                    return;
                }      
                $Conversiones = [
                    "1/4" => 0.25,
                    "1/2" => 0.5,
                    "3/4" => 0.75,
                ];
            
                // Si la medida está en la lista de conversiones, se aplica la conversión
                $Cantidad = isset($Conversiones[$Medida]) ? $ValorCantidad * $Conversiones[$Medida] : $ValorCantidad;

                $CantidadActual = $this->Modelo_Productos->CantidadActual($ID_Centro, $ID_Producto); 
                $CantidadEnTemp = $this->Modelo_Productos->ObtenerCantidadEnTempS($ID_Usuario, $ID_Producto);
                $StockDisponible = $CantidadActual - $CantidadEnTemp;

                if ($StockDisponible >= $Cantidad) {
                    $Facturas = $this->Modelo_Productos->obtenerFactura($ID_Centro, $ID_Producto, $ValorCantidad, $Medida);

                    if (empty($Facturas)) {
                        echo "<script>alertify.error('No se encontraron facturas para este producto');</script>";
                        return;
                    }

                    // Recorrer todas las facturas y manejar las cantidades
                    $cantidadRestante = $Cantidad;
                    foreach ($Facturas as $factura) {
                        if ($cantidadRestante <= 0) break;
                    
                        $CantidadDisponible = min($cantidadRestante, $factura['Cantidad']);
                    
                        if ($CantidadDisponible > 0) { 
                            $ID_Producto_Seleccionado = $factura['ID'];
                            $N_Lote = $factura['N_Lote'];
                            $N_Factura = $factura['N_Factura'];
                            $ValorUnitario = $factura['valor_unitario'];
                            $ValorTotal = $CantidadDisponible * $ValorUnitario;
                    
                            $this->Modelo_Productos->insertarSalidaTemp($ID_Usuario, $ID_Producto, $CantidadDisponible,  $Medida, $N_Lote, $N_Factura, $ValorUnitario, $ValorTotal, $ID_Producto_Seleccionado);
                            $cantidadRestante -= $CantidadDisponible;
                        }
                    }                   
                    echo "<script>window.location.href = 'Salida?Documento=".$No_Documento."&Centro=". $CentroTrabajo."';</script>";
                } else {
                    echo "<script>alertify.error('Producto sin stock suficiente: " . $NombreDelCodigo . "');</script>";
                }
            }
        }

        public function RestarSalidaTemp ($Codigo, $ID_Usuario, $ID, $No_Documento, $ID_Centro){
            $this->Modelo_Productos->EliminarUltimoRegistroSalida($ID_Usuario);
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);  
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);    
            if ($this->Modelo_Productos->RestarSalidaTemp($ID_Producto, $ID_Usuario, $ID)) {
                echo "<script>alertify.error('Producto Descontado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Salida?Documento=".$No_Documento."&Centro=".$ID_Centro."';</script>";
            }
        }

        public function EliminarSalidaTemp ($Codigo, $ID_Usuario, $ID, $No_Documento, $ID_Centro){
            $this->Modelo_Productos->EliminarUltimoRegistroSalida($ID_Usuario);
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);     
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);   
            if ($this->Modelo_Productos->EliminarSalidaTemp($ID_Producto, $ID_Usuario, $ID)) {
                echo "<script>alertify.message('Producto Eliminado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Salida?Documento=".$No_Documento."&Centro=".$ID_Centro."';</script>";
            }
        }

        public function FirmarSalida($No_Documento, $ID_Recibe, $ID_Usuario, $ID_Centro, $ID_Destino, $Firma_Usuario, $Nombre_Ingresa, $ID_Supervisor, $CorreoSupervisor, $Nombre_Supervisor){
            $Ultimo_Formulario= $this->Modelo_Productos->ObtenerNumeroFormularioSalida();
            if ($Ultimo_Formulario) {
                $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $No_Formulario = '000001';
            }
            $Estado = 2;            
            $Fecha_Realizado = date("d/m/Y");      
            $Fecha_Recibe = NULL;
            $Firma_Estado_Salida = 1;
            $Firma_Estado_Recibe = 2;
            $Firma = NULL;
            $ID_Origen = NULL;
            $Tipo_Origen = NULL;
            if($ID =$this->Modelo_Productos->FirmarSalida($ID_Usuario, $ID_Recibe, $ID_Supervisor, $ID_Centro, $ID_Destino, $ID_Origen, $No_Formulario, $Tipo_Origen, $Fecha_Realizado, $Fecha_Recibe, $Estado, $Firma_Usuario, $Firma, $Firma_Estado_Salida, $Firma_Estado_Recibe)){
                $ID_Salida=$ID;
                $this->Modelo_Productos->ProductosSalida($ID_Salida);
                $this->GenerarCorreoSalida($CorreoSupervisor, $Nombre_Supervisor, $No_Documento, $No_Formulario, $ID_Salida);
                $ID_Usuario1 =$ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $Nombre_Ingresa.' Creó la salida de productos #'.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'La salida ha sido firmada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'FirmaSalidaReceptor?Documento=". $No_Documento ."&Salida=". $ID_Salida ." &No_Formulario=". $No_Formulario ."';
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

        public function FirmarSalida1($ID, $Usuario, $Nombre_Ingresa, $No_Formulario, $Firma_Supervisor){
            $Firma_Supervisor_Estado = 1;
            if ($this->Modelo_Productos->FirmarSalida1($ID, $Firma_Supervisor, $Firma_Supervisor_Estado)) {
                $Correo = $this->Modelo_Productos->ObtenerCorreo($Usuario);
                $this->GenerarCorreoConfirmacionSalida($Correo, $Nombre_Ingresa, $No_Formulario);
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre_Ingresa.' Autorizo la salida de producto con el numero: '.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'La salida ha sido firmada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioSalida';
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

        public function FirmarSalidaRecibe($ID_Salida, $No_Formulario, $ID_Recibe, $Nombre_Ingresa, $Firma){         
            $Fecha_Recibe = date("d/m/Y");      
            $Firma_Estado_Recibe = 1;
            if($this->Modelo_Productos->FirmarSalidaRecibe($ID_Salida, $Fecha_Recibe, $Firma, $Firma_Estado_Recibe)){
                $ID_Usuario1 =$ID_Recibe;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre_Ingresa.'Recibio la salida de productos #'.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'La salida ha sido firmada con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioSalida';
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

        public function FirmarSalidaSupervisor($ID, $Usuario, $Nombre_Ingresa, $No_Formulario, $Firma_Supervisor){
            $Estado = 1;
            $Fecha_Firma_Supervisor = date("d/m/Y");  
            $Firma_Supervisor_Estado = 1;
            if ($this->Modelo_Productos->FirmarSalidaSupervisor($ID, $Fecha_Firma_Supervisor, $Estado, $Firma_Supervisor, $Firma_Supervisor_Estado)) {
                $Correo = $this->Modelo_Productos->ObtenerCorreo($Usuario);
                $this->GenerarCorreoConfirmacionSalida($Correo, $Nombre_Ingresa, $No_Formulario);
                $ID_Usuario1 =$Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre_Ingresa.' Autorizo la salida de producto con el numero: '.$No_Formulario;
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
                                window.location.href = 'InicioSalida';
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

        public function verificarEstadoTraslado($ID_Usuario) {
            $Resultado = $this->Modelo_Productos->verificarEstadoTraslado($ID_Usuario);
            return $Resultado; 
        }

        public function verificarEstadoFirmaT($ID_Traslado) {
            $Resultado = $this->Modelo_Productos->verificarEstadoFirmaT($ID_Traslado);
            return $Resultado; 
        }

        public function TraerUltimoRegistroTraslado($ID) {
            $Resultado = $this->Modelo_Productos->LeerUltimoRegistroTraslado($ID);
            if ($Resultado) {
                return $Resultado;
            } else {
                return false;
            }
        }

        public function EliminarUltimoRegistroTraslado($ID_Usuario){
            $this->Modelo_Productos->EliminarUltimoRegistroTraslado($ID_Usuario);
        }

        public function InsertarTrasladoTemp($Codigo, $ValorCantidad, $Medida, $No_Documento, $ID_Centro, $CentroTrabajo,$ID_Usuario) {
            if (!empty($Codigo)) {
                // Obtener el ID del producto
                $this->Modelo_Productos->EliminarUltimoRegistroTraslado($ID_Usuario); 
                $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);
                $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);
                if (empty($ID_Producto)) {
                    echo "<script>alertify.error('Producto no encontrado.');</script>";
                    return;
                }      
                $Conversiones = [
                    "1/4" => 0.25,
                    "1/2" => 0.5,
                    "3/4" => 0.75,
                ];     

                // Si la medida está en la lista de conversiones, se aplica la conversión
                $Cantidad = isset($Conversiones[$Medida]) ? $ValorCantidad * $Conversiones[$Medida] : $ValorCantidad;
                $CantidadActual = $this->Modelo_Productos->CantidadActual($ID_Centro, $ID_Producto); 
                $CantidadEnTemp = $this->Modelo_Productos->ObtenerCantidadEnTemp($ID_Usuario, $ID_Producto);
                $StockDisponible = $CantidadActual - $CantidadEnTemp;

                if ($StockDisponible >= $ValorCantidad) {
                    $Facturas = $this->Modelo_Productos->obtenerFactura($ID_Centro, $ID_Producto, $ValorCantidad, $Medida);

                    if (empty($Facturas)) {
                        echo "<script>alertify.error('No se encontraron facturas para este producto');</script>";
                        return;
                    }

                    // Recorrer todas las facturas y manejar las cantidades
                    $cantidadRestante = $Cantidad;
                    foreach ($Facturas as $factura) {
                        if ($cantidadRestante <= 0) break;
                    
                        $CantidadDisponible = min($cantidadRestante, $factura['Cantidad']);
                        if ($CantidadDisponible > 0) { 
                            $ID_Producto_Seleccionado = $factura['ID'];
                            $N_Factura = $factura['N_Factura'];
                            $ValorUnitario = $factura['valor_unitario'];
                            $ValorTotal = $CantidadDisponible * $ValorUnitario;                    
                            $this->Modelo_Productos->insertarTrasladoTemp($ID_Usuario, $ID_Producto, $CantidadDisponible, $Medida, $N_Factura, $ValorUnitario, $ValorTotal, $ID_Producto_Seleccionado);
                            $cantidadRestante -= $CantidadDisponible;
                        }
                    }                   
                    echo "<script>window.location.href = 'Traslados?Documento=".$No_Documento."&Centro=".$CentroTrabajo."';</script>";
                } else {
                    echo "<script>alertify.error('Producto sin stock suficiente: " . $NombreDelCodigo . "');</script>";
                }
            }
        }

        public function FirmarTraslado($No_Documento, $ID_Recibe, $ID_Usuario, $ID_Centro, $ID_Centro_Destinado, $Firma, $Nombre_Ingresa, $Observaciones){
            $Ultimo_Formulario= $this->Modelo_Productos->ObtenerNumeroFormularioTraslado();
            if ($Ultimo_Formulario) {
                $No_Formulario = str_pad(intval($Ultimo_Formulario) + 1, 6, "0", STR_PAD_LEFT);
            } else {
                $No_Formulario = '000001';
            }
            $Estado = 2;            
            $Fecha_Realizado = date("d/m/Y");      
            $Firma_Estado_Recibe = 2;
            if($ID =$this->Modelo_Productos->FirmarTraslado($ID_Usuario, $ID_Recibe, $ID_Centro, $ID_Centro_Destinado, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Estado_Recibe, $Observaciones)){
                $ID_Traslado=$ID;
                $Fecha_Ingreso = date("d/m/Y"); 
                $this->Modelo_Productos->ProductosTraslado($ID_Traslado, $Fecha_Ingreso);
                $ID_Usuario1 =$ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $Nombre_Ingresa.' Creó el traslado de productos #'.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'El traslado ha sido firmado con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'FirmaRecibe?Documento=". $No_Documento ."&Traslado=". $ID_Traslado ." &No_Formulario=". $No_Formulario ."';
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

        public function FirmarTrasladoRecibe($ID_Traslado, $No_Formulario, $ID_Recibe, $Nombre_Ingresa, $Firma){
            $Estado = 1;            
            $Fecha_Recibe = date("d/m/Y");      
            $Firma_Estado_Recibe = 1;
            if($this->Modelo_Productos->FirmarTrasladoRecibe($ID_Traslado, $Fecha_Recibe, $Estado, $Firma, $Firma_Estado_Recibe)){
                $ID_Usuario1 =$ID_Recibe;
                $ID_Usuario2 = Null;
                $Creo = 'autorizo';
                $Frase = $Nombre_Ingresa.'Recibio el traslado de productos #'.$No_Formulario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Firmado Correctamente!',
                            text: 'El traslado ha sido firmado con éxito.',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Continuar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioTraslados';
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

        public function RestarTrasladoTemp ($Codigo, $ID_Usuario, $ID, $No_Documento, $CentroTrabajo){
            $this->Modelo_Productos->EliminarUltimoRegistroEntrada($ID_Usuario);
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);  
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);    
            if ($this->Modelo_Productos->RestarTrasladoTemp($ID_Producto, $ID_Usuario, $ID)) {
                echo "<script>alertify.error('Producto Descontado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Traslados?Documento=".$No_Documento."&Centro=".$CentroTrabajo."';</script>";
            }
        }

        public function EliminarTrasladoTemp ($Codigo, $ID_Usuario, $ID, $No_Documento, $CentroTrabajo){
            $this->Modelo_Productos->EliminarUltimoRegistroEntrada($ID_Usuario);
            $ID_Producto = $this->Modelo_Productos->obtenerIDProductoPorCodigo($Codigo);     
            $NombreDelCodigo = $this->Modelo_Productos->MostrarNombre($ID_Producto);   
            if ($this->Modelo_Productos->EliminarTrasladoTemp($ID_Producto, $ID_Usuario, $ID)) {
                echo "<script>alertify.message('Producto Eliminado: " . $Codigo . " -  " . $NombreDelCodigo . " ');</script>";
                echo "<script>window.location.href = 'Traslados?Documento=".$No_Documento."&Centro=".$CentroTrabajo."';</script>";
            }
        }
        
        public function DetallesTraslado($ID_Usuario){
            if ($DataSalida = $this->Modelo_Productos->DetallesTraslado($ID_Usuario)){
                return $DataSalida;
            } else{
                return false;
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
                $AceptarEntrada = "localhost/Outkargo2/Productos/FirmaSupervisor?ID=$ID_Entrada&No=$No_Formulario";
            }else {
                $AceptarEntrada = "https://Outkargo.com.co/Productos/FirmaSupervisor?ID=$ID_Entrada&No=$No_Formulario/";
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
                $mail->Subject = 'Autorizar Entrada de Productos # '.$No_Formulario.'. ';
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
                            <p>Una nueva entrada con el numero: <strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong>,</p>
                            <p>Para autorizar su ingreso de clic en el siguente boton:</p>
                            <a href="'.$AceptarEntrada.'" class="button">Aceptar Entrada</a>
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
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; 
                $mail->Password   = 'B=7WtN;p';
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
                            <h1>OUTKARGO</h1>
                        </div>
                        <div class="content">
                            <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Ingresa) . '</strong>,</p>
                            <p>La entrada #: <strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong>. Fue autorizada con exito</p>
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

        private function GenerarCorreoSalida ($Correo_Supervisor, $Nombre_Supervisor, $No_Documento, $No_Formulario, $ID_Salida) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $AceptarSalida = "localhost/Outkargo2/Productos/FirmaSupervisorSalida?Documento=$No_Documento&Salida=$ID_Salida&No_Formulario=$No_Formulario";
            }else {
                $AceptarSalida = "https://Outkargo.com.co/Productos/FirmaSupervisorSalida?Documento=$No_Documento&Salida=$ID_Salida&No_Formulario=$No_Formulario/";
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
                $mail->Subject = 'Autorizar Salida de Productos # '.$No_Formulario.'. ';
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
                            <p>Una nueva salida con el numero: <strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong>,</p>
                            <p>Para autorizar su ingreso de clic en el siguente boton:</p>
                            <a href="'.$AceptarSalida.'" class="button">Aceptar Entrada</a>
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
        private function GenerarCorreoConfirmacionSalida ($Correo, $Nombre_Ingresa, $No_Formulario) {
            $mail = new PHPMailer(true);    
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com '; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'mensajes@outkargo.com.co'; 
                $mail->Password   = 'B=7WtN;p';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('mensajes@outkargo.com.co', 'OutKargo');
                $mail->addAddress($Correo, $Nombre_Ingresa);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Confirmacion de Autorizacion de Salida #' . $No_Formulario .'';
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
                            <p>Buen Dia, <strong class="highlight">' . htmlspecialchars($Nombre_Ingresa) . '</strong>,</p>
                            <p>La salida #: <strong class="highlight">' . htmlspecialchars($No_Formulario) . '</strong>. Fue autorizada con exito</p>
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
    }
?>
