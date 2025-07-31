<?php
    class Productos {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        // Métodos

        public function Centro($ID_Centro) {
            $sql = "SELECT centrot.Nombre AS Nombre_Centro 
                    FROM detalle_inventario_insumos 
                    JOIN centrot ON detalle_inventario_insumos.ID_Centro = centrot.ID 
                    WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }  

        public function ObtenerCentro($ID_Centro) {
            $sql = "SELECT Nombre FROM centrot WHERE ID = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }  

        public function ListaMontacargas($ID_Centro) {
            $sql = "SELECT ID, Numero FROM montacargas WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 

        public function ContarEntradas($ID_Centro) {
            $sql = "SELECT COUNT(*) as NoEntradas FROM entrada_insumos WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarEntradasTotales() {
            $sql = "SELECT COUNT(*) as NoEntradas FROM entrada_insumos";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarTraslados($ID_Centro) {
            $sql = "SELECT COUNT(*) as NoTraslados FROM traslado_insumos WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarTrasladosTotales() {
            $sql = "SELECT COUNT(*) as NoTraslados FROM traslado_insumos";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarSalidas($ID_Centro) {
            $sql = "SELECT COUNT(*) as NoSalidas FROM salida_insumos WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarSalidasTotales() {
            $sql = "SELECT COUNT(*) as NoSalidas FROM salida_insumos";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function existeCodigo($codigo) {
            $sql = "SELECT COUNT(*) FROM insumos WHERE Codigo = :codigo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            $count = $stmt->fetchColumn();  
            return $count > 0; 
        }

        public function LeerEntradas($ID_Centro) {
            $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, entrada_insumos.*
                    FROM entrada_insumos
                    JOIN usuario AS usuario_ingresa ON entrada_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_supervisor ON entrada_insumos.ID_Supervisor = usuario_supervisor.ID
                    WHERE entrada_insumos.ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerEntradasTotales() {
            $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, centro.Nombre AS Nombre_Centro, entrada_insumos.*
                    FROM entrada_insumos
                    JOIN usuario AS usuario_ingresa ON entrada_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_supervisor ON entrada_insumos.ID_Supervisor = usuario_supervisor.ID
                    JOIN centrot AS centro ON entrada_insumos.ID_Centro = centro.ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }  

        public function LeerTraslados($ID_Centro) {
            $sql = "SELECT usuario_Recibe.Documento AS Documento, usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_Recibe.NombreCompleto AS NombreRecibe, 
                        centro_traslada.Nombre AS NombreCentro, centro_recibe.Nombre AS NombreCentroRecibe, traslado_insumos.*
                    FROM traslado_insumos
                    JOIN usuario AS usuario_ingresa ON traslado_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_Recibe ON traslado_insumos.ID_Recibe = usuario_Recibe.ID
                    JOIN centrot AS centro_traslada ON traslado_insumos.ID_Centro = centro_traslada.ID
                    JOIN centrot AS centro_recibe ON traslado_insumos.ID_Centro_Destinado = centro_recibe.ID
                    WHERE traslado_insumos.ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerTrasladosTotales() {
            $sql = "SELECT usuario_Recibe.Documento AS Documento, usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_Recibe.NombreCompleto AS NombreRecibe, 
                        centro_traslada.Nombre AS NombreCentro, centro_recibe.Nombre AS NombreCentroRecibe, traslado_insumos.*
                    FROM traslado_insumos
                    JOIN usuario AS usuario_ingresa ON traslado_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_Recibe ON traslado_insumos.ID_Recibe = usuario_Recibe.ID
                    JOIN centrot AS centro_traslada ON traslado_insumos.ID_Centro = centro_traslada.ID
                    JOIN centrot AS centro_recibe ON traslado_insumos.ID_Centro_Destinado = centro_recibe.ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }  

        public function LeerSalidas($ID_Centro) {
            $sql = "SELECT usuario_recibe.Documento AS Documento, 
                           usuario_ingresa.NombreCompleto AS NombreUsuario, 
                           usuario_recibe.NombreCompleto AS NombreRecibe, 
                           usuario_supervisor.NombreCompleto AS NombreSupervisor, 
                           salida_insumos.*
                    FROM salida_insumos
                    JOIN usuario AS usuario_ingresa ON salida_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_recibe ON salida_insumos.ID_Recibe = usuario_recibe.ID
                    JOIN usuario AS usuario_supervisor ON salida_insumos.ID_Supervisor = usuario_supervisor.ID
                    WHERE salida_insumos.ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerSalidasTotales() {
            $sql = "SELECT usuario_recibe.Documento AS Documento, 
                        usuario_ingresa.NombreCompleto AS NombreUsuario, 
                        usuario_recibe.NombreCompleto AS NombreRecibe, 
                        usuario_supervisor.NombreCompleto AS NombreSupervisor,
                        centro_salida.Nombre AS NombreCentro, 
                        centro_destino.Nombre AS NombreCentroRecibe, 
                        salida_insumos.* 
                    FROM salida_insumos
                    JOIN usuario AS usuario_ingresa ON salida_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_recibe ON salida_insumos.ID_Recibe = usuario_recibe.ID
                    JOIN usuario AS usuario_supervisor ON salida_insumos.ID_Supervisor = usuario_supervisor.ID
                    JOIN centrot AS centro_salida ON salida_insumos.ID_Centro = centro_salida.ID
                    JOIN centrot AS centro_destino ON salida_insumos.ID_Destino = centro_destino.ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerUltimoCodigo() {
            $sql = "SELECT Codigo FROM insumos ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Codigo'] : null;
        }

        public function ObtenerNumeroFormulario(){
            $sql = "SELECT `Numero` FROM entrada_insumos ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function ObtenerNumeroFormularioTraslado(){
            $sql = "SELECT `Numero` FROM traslado_insumos ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function ObtenerNumeroFormularioSalida(){
            $sql = "SELECT `Numero` FROM salida_insumos ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function ObtenerCorreo($Usuario){
            $sql = "SELECT Correo FROM usuario WHERE ID = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $Usuario);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Correo'] : null;
        }

        public function verificarEstadoFirma($ID_Entrada) {
            $sql = "SELECT Firma_Supervisor_Estado FROM entrada_insumos WHERE ID = :ID_Entrada";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Entrada", $ID_Entrada);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        public function verificarEstadoFirmaS($ID_Salida) {
            $sql = "SELECT Firma_Estado_Recibe FROM salida_insumos WHERE ID = :ID_Salida";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Salida", $ID_Salida);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        public function verificarEstadoFirmaSalida($ID_Salida) {
            $sql = "SELECT Firma_Supervisor_Estado FROM salida_insumos WHERE ID = :ID_Salida";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Salida", $ID_Salida);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        public function verificarEstadoFirmaT($ID_Traslado) {
            $sql = "SELECT Firma_Estado_Recibe FROM traslado_insumos WHERE ID = :ID_Traslado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Traslado", $ID_Traslado);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }

        public function ContarProductosActivos($ID_Centro) {
            $Cantidad = 0;
            $sql = "SELECT COUNT(*) as NoProductos FROM detalle_inventario_insumos WHERE Cantidad > :Cantidad AND ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function LeerCantidadTotal($ID_Centro) {
            $Cantidad = 0;
            $sql = "SELECT insumos.Codigo AS Codigo_insumos, insumos.Nombre AS Nombre_insumos, insumos.stockMinimo AS stockMinimo, entrada_insumos.Numero AS N_Entrada, detalle_inventario_insumos.* 
                    FROM detalle_inventario_insumos
                    JOIN insumos ON detalle_inventario_insumos.ID_Insumo = insumos.ID 
                    LEFT JOIN entrada_insumos ON detalle_inventario_insumos.ID_Entrada = entrada_insumos.ID
                    WHERE detalle_inventario_insumos.Cantidad > :Cantidad AND detalle_inventario_insumos.ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerInventarioTotal() {
            $Cantidad = 0;
            $sql = "SELECT insumos.Codigo AS Codigo_insumos, insumos.Nombre AS Nombre_insumos, insumos.stockMinimo AS stockMinimo, entrada_insumos.Numero AS N_Entrada, centrot.Nombre AS Centro, detalle_inventario_insumos.* 
                    FROM detalle_inventario_insumos
                    JOIN insumos ON detalle_inventario_insumos.ID_Insumo = insumos.ID 
                    LEFT JOIN entrada_insumos ON detalle_inventario_insumos.ID_Entrada = entrada_insumos.ID
                    LEFT JOIN centrot ON detalle_inventario_insumos.ID_Centro = centrot.ID
                    WHERE detalle_inventario_insumos.Cantidad > :Cantidad";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function Leer($ID_Centro) {
            $Cantidad = 0;
            $sql = "SELECT insumos.Codigo AS Codigo_insumos, insumos.Nombre AS Nombre_insumos, insumos.stockMinimo AS stockMinimo,  SUM(detalle_inventario_insumos.Cantidad) AS Total_Cantidad, detalle_inventario_insumos.* 
                    FROM detalle_inventario_insumos
                    JOIN insumos ON detalle_inventario_insumos.ID_Insumo = insumos.ID 
                    WHERE Cantidad >= :Cantidad AND ID_Centro = :ID_Centro
                    GROUP BY detalle_inventario_insumos.ID_Insumo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerProducto($ID_Producto){
            $sql = "SELECT categorias.Nombre AS Nombre_categoria, subcategorias.Nombre AS Nombre_subcategoria, insumos.* 
                    FROM insumos 
                    LEFT JOIN categorias ON insumos.Categoria = categorias.ID 
                    LEFT JOIN subcategorias ON insumos.SubCategoria = subcategorias.ID 
                    WHERE insumos.ID = :ID_Producto";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->execute();
            $DataInsumos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataInsumos;
        }

        public function registrarProducto($nuevoCodigo, $Nombre, $Descripcion, $NumeroParte, $NumeroSerie, $ID_Categoria, $ID_SubCategoria, $Estado, $uploadFile, $stockMinimo) {
            $sql = "INSERT INTO insumos (Codigo, Nombre, Descripcion, N_Parte, N_Serial, Categoria, SubCategoria, Estado, Foto, stockMinimo) VALUES (:Codigo, :Nombre, :Descripcion, :NumeroParte, :NumeroSerie, :ID_Categoria, :ID_SubCategoria, :Estado, :Foto, :stockMinimo)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Codigo', $nuevoCodigo);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Descripcion', $Descripcion);
            $stmt->bindParam(':ID_Categoria', $ID_Categoria);
            $stmt->bindParam(':ID_SubCategoria', $ID_SubCategoria);
            $stmt->bindParam(':Foto', $uploadFile);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':NumeroParte', $NumeroParte);
            $stmt->bindParam(':NumeroSerie', $NumeroSerie);
            $stmt->bindParam(':stockMinimo', $stockMinimo);
            try {
                $stmt->execute(); 
                return $this->PDO->lastInsertId();
            } catch (Exception $e) {
                echo "Error al registrar el insumo: " . $e->getMessage();
                return false;
            }
        }

        public function insertarProducto($ID_Producto, $ID_Centro, $Cantidad, $Valor, $N_Factura, $Fecha_Ingreso){
            $sql = "INSERT INTO detalle_inventario_insumos (ID_Insumo, ID_Centro, N_Factura, Cantidad, valor_unitario, Fecha_Ingreso) VALUES (:ID_Insumo, :ID_Centro, :N_Factura, :Cantidad, :Valor, :Fecha_Ingreso)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Insumo', $ID_Producto);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->bindParam(':Valor', $Valor);
            $stmt->bindParam(':N_Factura', $N_Factura);
            $stmt->bindParam(':Fecha_Ingreso', $Fecha_Ingreso);
            return $stmt->execute();
        }

        public function registrarCategoria($Nombre){
            $sql = "INSERT INTO categorias (Nombre) VALUES (:Nombre)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Nombre', $Nombre);
            return $stmt->execute();
        }

        public function registrarSubcategoria($Nombre, $ID_Categoria){
            $sql = "INSERT INTO subcategorias (Nombre, ID_Categoria) VALUES (:Nombre, :ID_Categoria)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':ID_Categoria', $ID_Categoria);
            return $stmt->execute();
        }

        public function Editar($ID_Producto, $Nombre, $Descripcion, $Estado, $ID_Categoria, $ID_SubCategoria, $NumeroParte, $NumeroSerie, $stockMinimo, $uploadFile){
            $sql = "UPDATE insumos SET Nombre = :Nombre, Descripcion = :Descripcion, Categoria = :ID_Categoria, SubCategoria = :ID_SubCategoria, Estado = :Estado, N_Parte = :NumeroParte, N_Serial = :NumeroSerie, stockMinimo = :stockMinimo, Foto = :Foto WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID_Producto);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Descripcion', $Descripcion);
            $stmt->bindParam(':ID_Categoria', $ID_Categoria);
            $stmt->bindParam(':ID_SubCategoria', $ID_SubCategoria);
            $stmt->bindParam(':Foto', $uploadFile);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':NumeroParte', $NumeroParte);
            $stmt->bindParam(':NumeroSerie', $NumeroSerie);
            $stmt->bindParam(':stockMinimo', $stockMinimo);
            try {
                $stmt->execute();
                return true; 
            } catch (Exception $e) {
                echo "Error al editar el insumo: " . $e->getMessage();
                return false; 
            }
        }

        public function TraerCategorias(){
            $sql = "SELECT * FROM categorias";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataCategorias;
        }

        public function TraerSubcategorias1(){
            $sql = "SELECT * FROM subcategorias";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataSubcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataSubcategorias;
        }

        public function TraerSubcategorias($ID_Categoria){
            $sql = "SELECT * FROM subcategorias WHERE ID_Categoria = :ID_Categoria";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Categoria', $ID_Categoria);
            $stmt->execute();
            $DataCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataCategorias;
        }

        public function MostrarNombre($ID_Producto) {
            $sql = "SELECT Nombre FROM insumos WHERE ID = :ID_Producto LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Nombre'] : null;
        }

        public function obtenerIDProductoPorCodigo($Codigo) {
            $sql = "SELECT ID FROM insumos WHERE Codigo = :Codigo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Codigo", $Codigo);
            $stmt->execute();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            return $producto ? $producto['ID'] : false;
        }

        public function ValidarExistenciaActual($ID_Producto, $ID_Centro){
            $sql = "SELECT Cantidad FROM detalle_inventario_insumos WHERE ID_Insumo = :ID_Producto AND ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->execute();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            return $producto;
        }

        public function VerificarEstadoEntrada($ID_Usuario){
            $Estado = 2;
            $sql = "SELECT COUNT(*) as total FROM entrada_insumos WHERE Estado = :Estado AND ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] > 0;
        }

        public function DetallesEntrada($ID_Usuario){       
            $sql = "SELECT insumos.Codigo AS Codigo_Producto, insumos.Nombre AS Nombre_producto, detalles_temp_entrada_insumos.* 
                    FROM detalles_temp_entrada_insumos
                    JOIN insumos ON detalles_temp_entrada_insumos.ID_Producto = insumos.ID 
                    WHERE ID_Usuario = :ID_Usuario 
                    ORDER BY Codigo ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerUltimoRegistroEntrada($ID) {
            $sql = "SELECT insumos.Codigo AS Codigo_Producto, insumos.Nombre AS Nombre_producto, ultimo_registro_entrada_insumos.* 
                    FROM ultimo_registro_entrada_insumos  
                    JOIN insumos ON ultimo_registro_entrada_insumos.ID_Producto = insumos.ID 
                    WHERE ID_Usuario = :ID_Usuario 
                    ORDER BY Codigo ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function EliminarUltimoRegistroEntrada($ID_Usuario){
            $sql = "DELETE FROM ultimo_registro_entrada_insumos WHERE ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            return true;
        }

        public function ValidarUltimoRegistroEntrada($ID_Usuario, $ID_Producto) {
            $sql = "SELECT * FROM detalles_temp_entrada_insumos  WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
        }

        public function ValidarCantidadActualEntrada($ID_Usuario, $ID_Producto) {
            $sql = "SELECT Cantidad FROM detalles_temp_entrada_insumos WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            $entradaData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $entradaData ? $entradaData['Cantidad'] : false;
        }

        public function AgregarUltimoRegistroEntrada($ID_Producto, $ID_Usuario){
            $sql = "INSERT INTO ultimo_registro_entrada_insumos (ID_Producto, ID_Usuario) VALUES (:ID_Producto, :ID_Usuario)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);        
            $stmt->execute();
            return true;
        }

        public function InsertarProductosEntrada($ID_Usuario, $ID_Producto, $Cantidad, $Medida, $Factura, $ValorUnitario, $ValorTotal) { 
            $sql = "INSERT INTO detalles_temp_entrada_insumos (ID_Usuario, ID_Producto, Cantidad, Medida, N_Factura, valor_unitario, valor_total) VALUES (:ID_Usuario, :ID_Producto, :Cantidad, :Medida, :Factura, :ValorUnitario, :ValorTotal)"; 
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->bindParam(":Cantidad", $Cantidad);
            $stmt->bindParam(":Medida", $Medida);
            $stmt->bindParam(":Factura", $Factura);
            $stmt->bindParam(":ValorUnitario", $ValorUnitario);
            $stmt->bindParam(":ValorTotal", $ValorTotal);
            return $stmt->execute();
        }

        public function EliminarEntradaTemp ($ID_Producto, $ID_Usuario, $ID){
            $sql = "DELETE FROM detalles_temp_entrada_insumos 
                WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto AND ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();     
            return true;
        }

        public function RestarEntradaTemp($ID_Producto, $ID_Usuario, $ID) {
            // Actualizar la cantidad y el valor total
            $sql = "UPDATE detalles_temp_entrada_insumos 
                    SET Cantidad = GREATEST(Cantidad - 1, 0),
                        Valor_Total = Cantidad * valor_unitario
                    WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto AND ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
        
            // Eliminar el producto si la cantidad es igual o menor a 0
            $sqlDelete = "DELETE FROM detalles_temp_entrada_insumos 
                          WHERE ID_Usuario = :ID_Usuario 
                          AND ID_Producto = :ID_Producto 
                          AND Cantidad <= 0";
            $stmtDelete = $this->PDO->prepare($sqlDelete);
            $stmtDelete->bindParam(':ID_Usuario', $ID_Usuario);
            $stmtDelete->bindParam(':ID_Producto', $ID_Producto);
            $stmtDelete->execute();
        
            return true;
        }

        public function EditarEntrada($ID_Producto, $N_Factura, $valor_unitario, $Total, $ID_Entrada, $Estado){
            if ($Estado == "1"){
                $sql = "UPDATE detalles_entrada_insumos SET N_Factura = :N_Factura, valor_unitario = :valor_unitario, valor_total = :valor_total WHERE ID_Producto = :ID_Producto AND ID_Entrada = :ID_Entrada ";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindParam(':N_Factura', $N_Factura);
                $stmt->bindParam(':valor_unitario', $valor_unitario);
                $stmt->bindParam(':valor_total', $Total);
                $stmt->bindParam(':ID_Producto', $ID_Producto);
                $stmt->bindParam(':ID_Entrada', $ID_Entrada);
                $stmt->execute();

                $sql = "UPDATE detalle_inventario_insumos SET N_Factura = :N_Factura, valor_unitario = :valor_unitario WHERE ID_Insumo = :ID_Producto AND ID_Entrada = :ID_Entrada ";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindParam(':N_Factura', $N_Factura);
                $stmt->bindParam(':valor_unitario', $valor_unitario);
                $stmt->bindParam(':ID_Producto', $ID_Producto);
                $stmt->bindParam(':ID_Entrada', $ID_Entrada);
                $stmt->execute();
                return true;
            }
            if ($Estado == "2"){
                $sql = "UPDATE detalles_temp_entrada_insumos SET N_Factura = :N_Factura, valor_unitario = :valor_unitario, valor_total = :valor_total WHERE ID_Producto = :ID_Producto ";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindParam(':N_Factura', $N_Factura);
                $stmt->bindParam(':valor_unitario', $valor_unitario);
                $stmt->bindParam(':valor_total', $Total);
                $stmt->bindParam(':ID_Producto', $ID_Producto);
                $stmt->execute();
                return true;
            }
        }     

        public function EditarEntradaObservaciones($Observaciones, $ID_Entrada){
            $sql = "UPDATE entrada_insumos SET Observaciones = :Observaciones WHERE ID = :ID_Entrada ";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Observaciones', $Observaciones);
            $stmt->bindParam(':ID_Entrada', $ID_Entrada);
            $stmt->execute();

            return true;
        }    

        public function VerEntrada($ID) {
            $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, entrada_insumos.*
                    FROM entrada_insumos
                    JOIN usuario AS usuario_ingresa ON entrada_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_supervisor ON entrada_insumos.ID_Supervisor = usuario_supervisor.ID
                    WHERE entrada_insumos.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        private function Convertir($Cantidad, $Medida){
            $Conversiones = [
                "1/4" => 0.25,
                "1/2" => 0.5,
                "3/4" => 0.75,
            ];

            if (array_key_exists($Medida, $Conversiones)) {
                return $Cantidad * $Conversiones[$Medida];
            }

            return $Cantidad;
        }

        public function ProductosEntrada($ID, $Fecha_Ingreso) {
            // Obtener los detalles de la entrada y el ID_Centro desde la tabla entrada_insumos
            $sql = "SELECT t.ID_Usuario, t.ID_Producto, t.Cantidad, t.Medida, t.N_Factura, t.valor_unitario, t.valor_total, e.ID_Centro
                    FROM detalles_temp_entrada_insumos t
                    JOIN entrada_insumos e ON t.ID_Usuario = e.ID_Usuario
                    WHERE e.ID = :ID_Entrada";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Entrada", $ID);
            $stmt->execute();  
            $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);     
            if($entradas){
                $this->PDO->beginTransaction();
                try{
                    foreach ($entradas as $entrada) {
                        $cantidadConvertida = $this->Convertir($entrada['Cantidad'], $entrada['Medida']);
                        // Insertar en detalles_entrada_insumos
                        $stmt = $this->PDO->prepare("INSERT INTO detalles_entrada_insumos (ID_Usuario, ID_Entrada, ID_Producto, Cantidad, Medida, N_Factura, valor_unitario, valor_total)
                                                     VALUES (:ID_Usuario, :ID_Entrada, :ID_Producto, :Cantidad, :Medida, :N_Factura, :valor_unitario, :valor_total)");
                        $stmt->bindParam(":ID_Entrada", $ID);
                        $stmt->bindParam(":ID_Usuario", $entrada['ID_Usuario']);
                        $stmt->bindParam(":ID_Producto", $entrada['ID_Producto']);
                        $stmt->bindParam(":Cantidad", $entrada['Cantidad']);
                        $stmt->bindParam(":Medida", $entrada['Medida']);
                        $stmt->bindParam(":N_Factura", $entrada['N_Factura']);
                        $stmt->bindParam(":valor_unitario", $entrada['valor_unitario']);
                        $stmt->bindParam(":valor_total", $entrada['valor_total']);
                        $stmt->execute();
                        
                        // Insertar un nuevo registro en detalle_inventario_insumos
                        $stmt = $this->PDO->prepare("INSERT INTO detalle_inventario_insumos (ID_Insumo, ID_Centro, ID_Entrada, Cantidad, N_Factura, valor_unitario, Fecha_Ingreso) 
                                                     VALUES (:ID_Producto, :ID_Centro, :ID_Entrada, :Cantidad, :N_Factura, :valor_unitario, :Fecha_Ingreso)");
                        $stmt->bindParam(":ID_Producto", $entrada['ID_Producto']);
                        $stmt->bindParam(":ID_Centro", $entrada['ID_Centro']);
                        $stmt->bindParam(":Cantidad", $cantidadConvertida);
                        $stmt->bindParam(":N_Factura", $entrada['N_Factura']);
                        $stmt->bindParam(":ID_Entrada", $ID);
                        $stmt->bindParam(":valor_unitario", $entrada['valor_unitario']);
                        $stmt->bindParam(":Fecha_Ingreso", $Fecha_Ingreso);
                        $stmt->execute();
                        echo "pase la insercion";
                    }
                    // Eliminar las entradas de la tabla temporal
                    $stmt = $this->PDO->prepare("DELETE FROM detalles_temp_entrada_insumos 
                                                WHERE ID_Usuario IN (SELECT ID_Usuario FROM entrada_insumos WHERE ID = :ID_Entrada)");
                    $stmt->bindParam(":ID_Entrada", $ID);
                    $stmt->execute();
                
                    $this->PDO->commit();
                    return true;
                } catch (Exception $e) {
                    $this->PDO->rollBack();
                    return false;
                }
            } else {
                return false; 
            }                
        }

        public function DetallesProductosEntrada($ID, $Codigo) {
            $stmt = $this->PDO->prepare("
                SELECT ded.ID, p.Codigo, p.Nombre, ded.Cantidad, ded.N_Factura, ded.valor_unitario, ded.valor_total
                FROM detalles_entrada_insumos ded
                JOIN insumos p ON ded.ID_Producto = p.ID
                WHERE ded.ID_Entrada = :id AND ded.ID_Producto = (SELECT ID FROM insumos WHERE Codigo = :codigo)
                ORDER BY p.Codigo ASC
            ");
            $stmt->bindParam(":id", $ID);
            $stmt->bindParam(":codigo", $Codigo);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        } 
        
        public function DetallesProductosInventario($ID, $Codigo, $ID_Centro) {
            $stmt = $this->PDO->prepare("
                SELECT * 
                FROM detalle_inventario_insumos
                WHERE ID_Entrada = :id AND ID_Centro = :id_centro AND ID_Insumo = (SELECT ID FROM insumos WHERE Codigo = :codigo)
            ");
            $stmt->bindParam(":id", $ID);
            $stmt->bindParam(":id_centro", $ID_Centro);
            $stmt->bindParam(":codigo", $Codigo);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        }  

        public function MostrarDetallesProductosEntrada($ID) {
            $stmt = $this->PDO->prepare("
                SELECT ded.ID, p.Codigo, p.Nombre, ded.Cantidad, ded.Medida, ded.N_Factura, ded.valor_unitario, ded.valor_total
                FROM detalles_entrada_insumos ded
                JOIN insumos p ON ded.ID_Producto = p.ID
                WHERE ded.ID_Entrada = :id
                ORDER BY p.Codigo ASC
            ");
            $stmt->bindParam(":id", $ID);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        }   

        public function MostrarDetallesProductosEntradaTemp($ID) {
            $stmt = $this->PDO->prepare("
                SELECT dted.ID, p.Codigo, p.Nombre, dted.Cantidad, dted.Medida, dted.N_Factura, dted.valor_unitario, dted.valor_total
                FROM detalles_temp_entrada_insumos dted
                JOIN insumos p ON dted.ID_Producto = p.ID
                JOIN entrada_insumos ed ON dted.ID_Usuario = ed.ID_Usuario
                WHERE ed.ID = :id
                ORDER BY p.Codigo ASC
            ");
            $stmt->bindParam(":id", $ID);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        } 

        public function FirmarEntrada($ID_Usuario, $ID_Supervisor, $ID_Centro, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Supervisor_Estado, $Observaciones) {
            $sql = "INSERT INTO entrada_insumos (ID_Usuario, ID_Supervisor, ID_Centro, Numero, Fecha_Realizado, Fecha_Firma_Supervisor, Estado, Firma_Ingresa, Firma_Supervisor, Firma_Supervisor_Estado, Observaciones, Descripcion_Anulacion)
                    VALUES (:ID_Usuario, :ID_Supervisor, :ID_Centro, :Numero, :Fecha_Realizado, NULL, :Estado, :Firma, NULL, :Firma_Supervisor_Estado, :Observaciones, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Supervisor", $ID_Supervisor);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":Numero", $No_Formulario);
            $stmt->bindParam(":Fecha_Realizado", $Fecha_Realizado);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma", $Firma); 
            $stmt->bindParam(":Firma_Supervisor_Estado", $Firma_Supervisor_Estado); 
            $stmt->bindParam(":Observaciones", $Observaciones); 
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function FirmarEntradaSupervisor($ID, $Fecha_Firma_Supervisor, $Estado, $Firma_Supervisor, $Firma_Supervisor_Estado){
            $sql = "UPDATE entrada_insumos SET Fecha_Firma_Supervisor = :Fecha_Firma_Supervisor, Estado = :Estado, Firma_Supervisor = :Firma_Supervisor, Firma_Supervisor_Estado = :Firma_Supervisor_Estado WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID", $ID);
            $stmt->bindParam(":Fecha_Firma_Supervisor", $Fecha_Firma_Supervisor);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma_Supervisor", $Firma_Supervisor); 
            $stmt->bindParam(":Firma_Supervisor_Estado", $Firma_Supervisor_Estado); 
            if($stmt->execute()){
                return true;
            }else{
                return false;
            } 
        }

        public function AnularDotacionEntrada($ID, $Descripcion) {
            // Obtener el estado actual de la entrada desde la tabla entrada_dotacion
            $sqlEstado = "SELECT Estado, ID_Centro FROM entrada_insumos WHERE ID = :ID_Entrada";
            $stmtEstado = $this->PDO->prepare($sqlEstado);
            $stmtEstado->bindParam(":ID_Entrada", $ID);
            $stmtEstado->execute();
            $entrada = $stmtEstado->fetch(PDO::FETCH_ASSOC);

            if ($entrada) {
                $estado = $entrada['Estado'];
                $idCentro = $entrada['ID_Centro'];

                // Iniciar la transacción
                $this->PDO->beginTransaction();
                try {
                    if ($estado == 2) {
                        // Eliminar el contenido de la tabla temporal detalles_temp_entrada_dotacion
                        $sqlDeleteTemp = "DELETE FROM detalles_temp_entrada_insumos WHERE ID_Usuario IN (SELECT ID_Usuario FROM entrada_insumos WHERE ID = :ID_Entrada)";
                        $stmtDeleteTemp = $this->PDO->prepare($sqlDeleteTemp);
                        $stmtDeleteTemp->bindParam(":ID_Entrada", $ID);
                        $stmtDeleteTemp->execute();
                    } else if ($estado == 1) {
                        // Obtener los detalles de la entrada para eliminar y ajustar inventario
                        $sqlDetalles = "SELECT ID_Producto, Cantidad FROM detalles_entrada_insumos WHERE ID_Entrada = :ID_Entrada";
                        $stmtDetalles = $this->PDO->prepare($sqlDetalles);
                        $stmtDetalles->bindParam(":ID_Entrada", $ID);
                        $stmtDetalles->execute();
                        $detalles = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);

                        if ($detalles) {
                            // Restar la cantidad de productos del inventario
                            foreach ($detalles as $detalle) {
                                $idProducto = $detalle['ID_Producto'];
                                $cantidad = $detalle['Cantidad'];

                                // Restar la cantidad del inventario
                                $sqlUpdateInventario = "UPDATE detalle_inventario_insumos SET Cantidad = Cantidad - :Cantidad 
                                                        WHERE ID_Insumo = :ID_Producto AND ID_Centro = :ID_Centro";
                                $stmtUpdateInventario = $this->PDO->prepare($sqlUpdateInventario);
                                $stmtUpdateInventario->bindParam(":Cantidad", $cantidad);
                                $stmtUpdateInventario->bindParam(":ID_Producto", $idProducto);
                                $stmtUpdateInventario->bindParam(":ID_Centro", $idCentro);
                                $stmtUpdateInventario->execute();
                            }

                            // Eliminar los detalles de la entrada en detalles_entrada_dotacion
                            $sqlDeleteDetalles = "DELETE FROM detalles_entrada_insumos WHERE ID_Entrada = :ID_Entrada";
                            $stmtDeleteDetalles = $this->PDO->prepare($sqlDeleteDetalles);
                            $stmtDeleteDetalles->bindParam(":ID_Entrada", $ID);
                            $stmtDeleteDetalles->execute();
                        }
                    }

                    // Actualizar el estado de la dotación y guardar la descripción de la anulación
                    $Estado = 3;
                    $Firma_Supervisor_Estado = 1;
                    $sqlUpdateEstado = "UPDATE entrada_insumos SET Estado = :Estado, Descripcion_Anulacion = :Descripcion, Firma_Supervisor_Estado = :Firma_Supervisor_Estado WHERE ID = :ID_Entrada";
                    $stmtUpdateEstado = $this->PDO->prepare($sqlUpdateEstado);
                    $stmtUpdateEstado->bindParam(":ID_Entrada", $ID);
                    $stmtUpdateEstado->bindParam(":Estado", $Estado);
                    $stmtUpdateEstado->bindParam(":Firma_Supervisor_Estado", $Firma_Supervisor_Estado);
                    $stmtUpdateEstado->bindParam(":Descripcion", $Descripcion);
                    $stmtUpdateEstado->execute();

                    // Confirmar la transacción
                    $this->PDO->commit();
                    return true;

                } catch (Exception $e) {
                    // Revertir los cambios si ocurre un error
                    $this->PDO->rollBack();
                    return false;
                }
            } else {
                return false; 
            }
        }

        public function ObtenerCantidadEnTempS($ID_Usuario, $ID_Producto) {
            $sql = "SELECT SUM(Cantidad) as Total FROM detalles_temp_salida_insumos WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['Total'] ?? 0; 
        }

        public function insertarSalidaTemp($ID_Usuario, $ID_Producto, $Cantidad,  $Medida, $ID_Montacarga, $Factura, $Observaciones, $ValorUnitario, $ValorTotal, $ID_Producto_Seleccionado) { 
            $sql = "INSERT INTO detalles_temp_salida_insumos 
                    (ID_Usuario, ID_Producto, ID_Montacargas, N_Factura, Cantidad, Medida, Observaciones, valor_unitario, valor_total, ID_Producto_Seleccionado) 
                    VALUES (:ID_Usuario, :ID_Producto, :ID_Montacarga, :Factura, :Cantidad, :Medida, :Observaciones, :ValorUnitario, :ValorTotal, :ID_Producto_Seleccionado)"; 
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->bindParam(":Cantidad", $Cantidad);
            $stmt->bindParam(":Medida", $Medida);
            $stmt->bindParam(":ID_Montacarga", $ID_Montacarga);
            $stmt->bindParam(":Factura", $Factura);
            $stmt->bindParam(":Observaciones", $Observaciones);
            $stmt->bindParam(":ValorUnitario", $ValorUnitario);
            $stmt->bindParam(":ValorTotal", $ValorTotal);
            $stmt->bindParam(":ID_Producto_Seleccionado", $ID_Producto_Seleccionado);
            return $stmt->execute();
        }

        public function RestarSalidaTemp($ID_Producto, $ID_Usuario, $ID) {
            // Actualizar la cantidad y el valor total
            $sql = "UPDATE detalles_temp_salida_insumos 
                    SET Cantidad = GREATEST(Cantidad - 1, 0),
                        Valor_Total = Cantidad * valor_unitario
                    WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto AND ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
        
            // Eliminar el producto si la cantidad es igual o menor a 0
            $sqlDelete = "DELETE FROM detalles_temp_salida_insumos 
                          WHERE ID_Usuario = :ID_Usuario 
                          AND ID_Producto = :ID_Producto 
                          AND Cantidad <= 0";
            $stmtDelete = $this->PDO->prepare($sqlDelete);
            $stmtDelete->bindParam(':ID_Usuario', $ID_Usuario);
            $stmtDelete->bindParam(':ID_Producto', $ID_Producto);
            $stmtDelete->execute();
        
            return true;
        }

        public function EliminarSalidaTemp ($ID_Producto, $ID_Usuario, $ID){
            $sql = "DELETE FROM detalles_temp_salida_insumos 
                WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto AND ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();     
            return true;
        }

        public function DetallesSalida($ID_Usuario){       
            $sql = "SELECT montacargas.Numero AS Numero_Montacargas, insumos.Codigo AS Codigo_Producto, insumos.Nombre AS Nombre_producto, detalles_temp_salida_insumos.* 
                    FROM detalles_temp_salida_insumos
                    JOIN insumos ON detalles_temp_salida_insumos.ID_Producto = insumos.ID
                    LEFT JOIN montacargas ON detalles_temp_salida_insumos.ID_Montacargas  = montacargas.ID 
                    WHERE ID_Usuario = :ID_Usuario 
                    ORDER BY Codigo ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerUltimoRegistroSalida($ID) {
            $sql = "SELECT insumos.Codigo AS Codigo_Producto, insumos.Nombre AS Nombre_producto, ultimo_registro_salida_insumos.* 
                    FROM ultimo_registro_salida_insumos  
                    JOIN insumos ON ultimo_registro_salida_insumos.ID_Producto = insumos.ID 
                    WHERE ID_Usuario = :ID_Usuario 
                    ORDER BY Codigo ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function EliminarUltimoRegistroSalida($ID_Usuario){
            $sql = "DELETE FROM ultimo_registro_salida_insumos WHERE ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            return true;
        }

        public function FirmarSalida($ID_Usuario, $ID_Recibe, $ID_Supervisor, $ID_Centro, $ID_Destino, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Estado_Recibe) {
            $sql = "INSERT INTO salida_insumos (ID_Usuario, ID_Recibe, ID_Supervisor, ID_Centro, ID_Destino, Numero, Fecha_Realizado, Fecha_Firma_Recibe, Fecha_Firma_Supervisor, Estado, Firma_Salida, Firma_Recibe, Firma_Supervisor, Firma_Estado_Recibe, Firma_Supervisor_Estado, Descripcion_Anulacion)
                    VALUES (:ID_Usuario, :ID_Recibe, :ID_Supervisor, :ID_Centro, :ID_Destino, :Numero, :Fecha_Realizado, NULL, NULL, :Estado, :Firma, NULL, NULL, :Firma_Estado_Recibe, :Firma_Estado_Recibe, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Recibe", $ID_Recibe);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Supervisor", $ID_Supervisor);
            $stmt->bindParam(":ID_Destino", $ID_Destino);
            $stmt->bindParam(":Numero", $No_Formulario);
            $stmt->bindParam(":Fecha_Realizado", $Fecha_Realizado);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma", $Firma); 
            $stmt->bindParam(":Firma_Estado_Recibe", $Firma_Estado_Recibe); 
            if($stmt->execute()){
                return $this->PDO->lastInsertId(); 
            }else{
                return false; 
            }
        }

        public function FirmarSalidaRecibe ($ID_Salida, $Fecha_Recibe, $Firma, $Firma_Estado_Recibe){
            $sql = "UPDATE salida_insumos SET Fecha_Firma_Recibe = :Fecha_Firma_Recibe, Firma_Recibe = :Firma_Recibe, Firma_Estado_Recibe = :Firma_Estado_Recibe WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID", $ID_Salida);
            $stmt->bindParam(":Fecha_Firma_Recibe", $Fecha_Recibe);
            $stmt->bindParam(":Firma_Recibe", $Firma); 
            $stmt->bindParam(":Firma_Estado_Recibe", $Firma_Estado_Recibe); 
            if($stmt->execute()){
                return true;
            }else{
                return false;
            } 
        }

        public function FirmarSalidaSupervisor ($ID_Salida, $Fecha_Recibe, $Estado, $Firma, $Firma_Estado_Recibe){
            $sql = "UPDATE salida_insumos SET Fecha_Firma_Supervisor = :Fecha_Firma_Supervisor, Estado = :Estado, Firma_Supervisor = :Firma_Supervisor, Firma_Supervisor_Estado = :Firma_Supervisor_Estado WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID", $ID_Salida);
            $stmt->bindParam(":Fecha_Firma_Supervisor", $Fecha_Recibe);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma_Supervisor", $Firma); 
            $stmt->bindParam(":Firma_Supervisor_Estado", $Firma_Estado_Recibe); 
            if($stmt->execute()){
                return true;
            }else{
                return false;
            } 
        }

        public function ProductosSalida($ID) {
            // Obtener los detalles de la entrada y el ID_Centro desde la tabla entrada_insumos
            $sql = "SELECT t.ID_Usuario, t.ID_Producto, t.ID_Montacargas, t.N_Factura, t.Cantidad, t.Observaciones, t.valor_unitario, t.valor_total, t.ID_Producto_Seleccionado AS Producto_Seleccionado, e.ID_Centro AS Centro_Origen
                    FROM detalles_temp_salida_insumos t
                    JOIN salida_insumos e ON t.ID_Usuario = e.ID_Usuario
                    WHERE e.ID = :ID_Salida";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Salida", $ID);
            $stmt->execute();  
            $Salidas = $stmt->fetchAll(PDO::FETCH_ASSOC);     
            if($Salidas){
                $this->PDO->beginTransaction();
                try{
                    foreach ($Salidas as $Salida) {
                        $ID_Usuario = $Salida['ID_Usuario'];
                        $ID_Centro_Origen = $Salida['Centro_Origen'];
                        $ID_Producto = $Salida['ID_Producto'];
                        $ID_Montacargas = $Salida['ID_Montacargas'];
                        $Producto_Seleccionado = $Salida['Producto_Seleccionado'];
                        $Observaciones = $Salida['Observaciones'];
                        $Cantidad = $Salida['Cantidad'];
                        $Factura = $Salida['N_Factura'];
                        $Valor_Unitario = $Salida['valor_unitario'];
                        $valor_total = $Salida['valor_total'];
                        // Insertar en detalles_entrada_insumos
                        $stmt = $this->PDO->prepare("INSERT INTO detalles_salida_insumos (ID_Usuario, ID_Salida, ID_Producto, ID_Montacargas, Cantidad, N_Factura, Observaciones, valor_unitario, valor_total)
                                                     VALUES (:ID_Usuario, :ID_Salida, :ID_Producto, :ID_Montacargas, :Cantidad, :N_Factura, :Observaciones, :valor_unitario, :valor_total)");
                        $stmt->bindParam(":ID_Salida", $ID);
                        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
                        $stmt->bindParam(":ID_Producto", $ID_Producto);
                        $stmt->bindParam(":ID_Montacargas", $ID_Montacargas);
                        $stmt->bindParam(":Cantidad", $Cantidad);
                        $stmt->bindParam(":N_Factura", $Factura);
                        $stmt->bindParam(":Observaciones", $Observaciones);
                        $stmt->bindParam(":valor_unitario", $Valor_Unitario);
                        $stmt->bindParam(":valor_total", $valor_total);
                        $stmt->execute();

                        // Descontar del Inventario de Donde salen los productos
                        $stmt = $this->PDO->prepare("UPDATE detalle_inventario_insumos SET Cantidad = Cantidad - :Cantidad WHERE ID_Centro = :ID_Centro AND ID_Insumo = :ID_Insumo AND ID = :Producto_Seleccionado");
                        $stmt->bindParam(":ID_Insumo", $ID_Producto);
                        $stmt->bindParam(":ID_Centro", $ID_Centro_Origen);
                        $stmt->bindParam(":Cantidad", $Cantidad);
                        $stmt->bindParam(":Producto_Seleccionado", $Producto_Seleccionado);
                        $stmt->execute();
                    }
                    // Eliminar las entradas de la tabla temporal
                    $stmt = $this->PDO->prepare("DELETE FROM detalles_temp_salida_insumos 
                                                WHERE ID_Usuario IN (SELECT ID_Usuario FROM salida_insumos WHERE ID = :ID_Salida)");
                    $stmt->bindParam(":ID_Salida", $ID);
                    $stmt->execute();
                
                    $this->PDO->commit();
                    return true;
                } catch (Exception $e) {
                    $this->PDO->rollBack();
                    return false;
                }
            } else {
                return false; 
            }                
        }

        public function VerSalida($ID) {
            $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreSalida, usuario_recibe.NombreCompleto AS NombreRecibe, usuario_Supervisor.NombreCompleto AS NombreSupervisor, centro_traslada.Nombre AS CentroTraslada, centro_recibe.Nombre AS CentroDestino, salida_insumos.*
                    FROM salida_insumos
                    JOIN usuario AS usuario_ingresa ON salida_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_recibe ON salida_insumos.ID_Recibe = usuario_recibe.ID
                    JOIN usuario AS usuario_Supervisor ON salida_insumos.ID_Supervisor = usuario_Supervisor.ID
                    JOIN centrot AS centro_traslada ON salida_insumos.ID_Centro = centro_traslada.ID
                    JOIN centrot AS centro_recibe ON salida_insumos.ID_Destino = centro_recibe.ID
                    WHERE salida_insumos.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function MostrarDetallesProductosSalida($ID) {
            $stmt = $this->PDO->prepare("SELECT ded.ID, p.Codigo, p.Nombre, ded.Cantidad, ded.N_Factura, m.Numero, ded.Observaciones
                FROM detalles_salida_insumos ded
                JOIN insumos p ON ded.ID_Producto = p.ID
                LEFT JOIN montacargas m ON ded.ID_Montacargas = m.ID
                WHERE ded.ID_Salida = :id
                ORDER BY p.Codigo ASC");
            $stmt->bindParam(":id", $ID);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        }   

        public function MostrarDetallesProductosSalidaTemp($ID) {
            $stmt = $this->PDO->prepare("SELECT dted.ID, p.Codigo, p.Nombre, dted.Cantidad, dted.N_Factura, m.Numero, dted.Observaciones
                FROM detalles_temp_salida_insumos dted
                JOIN insumos p ON dted.ID_Producto = p.ID
                LEFT JOIN montacargas m ON dted.ID_Montacargas = m.ID
                JOIN traslado_insumos ed ON dted.ID_Usuario = ed.ID_Usuario
                WHERE ed.ID = :id
                ORDER BY p.Codigo ASC");
            $stmt->bindParam(":id", $ID);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        } 

        public function AgregarUltimoRegistroTraslado($ID_Producto, $ID_Usuario){
            $sql = "INSERT INTO ultimo_registro_traslado_insumos (ID_Producto, ID_Usuario) VALUES (:ID_Producto, :ID_Usuario)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);        
            $stmt->execute();
            return true;
        }

        public function EliminarUltimoRegistroTraslado($ID_Usuario){
            $sql = "DELETE FROM ultimo_registro_traslado_insumos WHERE ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            return true;
        }

        public function CantidadActual($ID_Centro, $ID_Producto){
            $sql ="SELECT *, (SELECT SUM(Cantidad) FROM detalle_inventario_insumos WHERE ID_Centro = :ID_Centro AND ID_Insumo = :ID_Producto) AS TotalCantidad FROM detalle_inventario_insumos 
                    WHERE ID_Centro = :ID_Centro AND ID_Insumo = :ID_Producto ORDER BY Fecha_Ingreso ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            $entradaData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $entradaData ? $entradaData['TotalCantidad'] : 0;
        }

        public function ObtenerCantidadEnTemp($ID_Usuario, $ID_Producto) {
            $sql = "SELECT SUM(Cantidad) as Total FROM detalles_temp_traslado_insumos WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['Total'] ?? 0; 
        }

        public function obtenerFactura($ID_Centro, $ID_Producto, $ValorCantidad, $Medida){ 
            $sql ="SELECT ID, N_Factura, valor_unitario, Cantidad FROM detalle_inventario_insumos WHERE ID_Centro = :ID_Centro AND ID_Insumo = :ID_Producto ORDER BY Fecha_Ingreso ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->execute();
            $Detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $CantidadRestante = $ValorCantidad;
            $Facturas = [];
            foreach ($Detalles as $Detalle) {
                if ($CantidadRestante <= 0) break;
                $usarCantidad = min($CantidadRestante, $Detalle['Cantidad']);
                $CantidadRestante -= $usarCantidad;
                $Facturas[] = [
                    'ID' => $Detalle['ID'],
                    'N_Factura' => $Detalle['N_Factura'],
                    'valor_unitario' => $Detalle['valor_unitario'],
                    'Cantidad' => $usarCantidad
                ];
            }

            return $Facturas;
        }

        public function LeerUltimoRegistroTraslado($ID) {
            $sql = "SELECT insumos.Codigo AS Codigo_Producto, insumos.Nombre AS Nombre_producto, ultimo_registro_traslado_insumos.* 
                    FROM ultimo_registro_traslado_insumos  
                    JOIN insumos ON ultimo_registro_traslado_insumos.ID_Producto = insumos.ID 
                    WHERE ID_Usuario = :ID_Usuario 
                    ORDER BY Codigo ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function verificarEstadoTraslado($ID_Usuario){
            $Estado = 2;
            $sql = "SELECT COUNT(*) as total FROM traslado_insumos WHERE Estado = :Estado AND ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] > 0;
        }

        public function insertarTrasladoTemp($ID_Usuario, $ID_Producto, $Cantidad, $Medida, $Factura, $ValorUnitario, $ValorTotal, $ID_Producto_Seleccionado) { 
            $sql = "INSERT INTO detalles_temp_traslado_insumos 
                    (ID_Usuario, ID_Producto, Cantidad, Medida, Factura, Valor_Unitario, valor_total, ID_Producto_Seleccionado) 
                    VALUES (:ID_Usuario, :ID_Producto, :Cantidad, :Medida, :Factura, :ValorUnitario, :ValorTotal, :ID_Producto_Seleccionado)"; 
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Producto", $ID_Producto);
            $stmt->bindParam(":Cantidad", $Cantidad);
            $stmt->bindParam(":Medida", $Medida);
            $stmt->bindParam(":Factura", $Factura);
            $stmt->bindParam(":ValorUnitario", $ValorUnitario);
            $stmt->bindParam(":ValorTotal", $ValorTotal);
            $stmt->bindParam(":ID_Producto_Seleccionado", $ID_Producto_Seleccionado);
            return $stmt->execute();
        }

        public function FirmarTraslado($ID_Usuario, $ID_Recibe, $ID_Centro, $ID_Centro_Destinado, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Estado_Recibe, $Observaciones) {
            $sql = "INSERT INTO traslado_insumos (ID_Usuario, ID_Recibe, ID_Centro, ID_Centro_Destinado , Numero, Fecha_Realizado, Fecha_Firma_Recibe, Estado, Firma_Ingresa, Firma_Recibe, Firma_Estado_Recibe, Observaciones, Descripcion_Anulacion)
                    VALUES (:ID_Usuario, :ID_Recibe, :ID_Centro, :ID_Centro_Destinado, :Numero, :Fecha_Realizado, NULL, :Estado, :Firma, NULL, :Firma_Estado_Recibe, :Observaciones, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->bindParam(":ID_Recibe", $ID_Recibe);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Centro_Destinado", $ID_Centro_Destinado);
            $stmt->bindParam(":Numero", $No_Formulario);
            $stmt->bindParam(":Fecha_Realizado", $Fecha_Realizado);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma", $Firma); 
            $stmt->bindParam(":Firma_Estado_Recibe", $Firma_Estado_Recibe); 
            $stmt->bindParam(":Observaciones", $Observaciones); 
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function FirmarTrasladoRecibe ($ID_Traslado, $Fecha_Recibe, $Estado, $Firma, $Firma_Estado_Recibe){
            $sql = "UPDATE traslado_insumos SET Fecha_Firma_Recibe = :Fecha_Firma_Recibe, Estado = :Estado, Firma_Recibe = :Firma_Recibe, Firma_Estado_Recibe = :Firma_Estado_Recibe WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID", $ID_Traslado);
            $stmt->bindParam(":Fecha_Firma_Recibe", $Fecha_Recibe);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma_Recibe", $Firma); 
            $stmt->bindParam(":Firma_Estado_Recibe", $Firma_Estado_Recibe); 
            if($stmt->execute()){
                return true;
            }else{
                return false;
            } 
        }

        public function ProductosTraslado($ID, $Fecha_Ingreso) {
            // Obtener los detalles de la entrada y el ID_Centro desde la tabla entrada_insumos
            $sql = "SELECT t.ID_Usuario, t.ID_Producto, t.Cantidad, t.Factura, t.Valor_Unitario, t.valor_total, t.ID_Producto_Seleccionado AS Producto_Seleccionado, e.ID_Centro AS Centro_Origen, e.ID_Centro_Destinado AS Centro_Destino
                    FROM detalles_temp_traslado_insumos t
                    JOIN traslado_insumos e ON t.ID_Usuario = e.ID_Usuario
                    WHERE e.ID = :ID_Traslado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Traslado", $ID);
            $stmt->execute();  
            $Traslados = $stmt->fetchAll(PDO::FETCH_ASSOC);     
            if($Traslados){
                $this->PDO->beginTransaction();
                try{
                    foreach ($Traslados as $Traslado) {
                        $ID_Usuario = $Traslado['ID_Usuario'];
                        $ID_Centro_Origen = $Traslado['Centro_Origen'];
                        $ID_Centro_Destino = $Traslado['Centro_Destino'];
                        $ID_Producto = $Traslado['ID_Producto'];
                        $Producto_Seleccionado = $Traslado['Producto_Seleccionado'];
                        $Cantidad = $Traslado['Cantidad'];
                        $Factura = $Traslado['Factura'];
                        $Valor_Unitario = $Traslado['Valor_Unitario'];
                        $valor_total = $Traslado['valor_total'];
                        // Insertar en detalles_entrada_insumos
                        $stmt = $this->PDO->prepare("INSERT INTO detalles_traslado_insumos (ID_Usuario, ID_Traslado, ID_Producto, Cantidad, N_Factura, valor_unitario, valor_total)
                                                     VALUES (:ID_Usuario, :ID_Traslado, :ID_Producto, :Cantidad, :N_Factura, :valor_unitario, :valor_total)");
                        $stmt->bindParam(":ID_Traslado", $ID);
                        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
                        $stmt->bindParam(":ID_Producto", $ID_Producto);
                        $stmt->bindParam(":Cantidad", $Cantidad);
                        $stmt->bindParam(":N_Factura", $Factura);
                        $stmt->bindParam(":valor_unitario", $Valor_Unitario);
                        $stmt->bindParam(":valor_total", $valor_total);
                        $stmt->execute();

                        // Descontar del Inventario de Donde salen los productos
                        $stmt = $this->PDO->prepare("UPDATE detalle_inventario_insumos SET Cantidad = Cantidad - :Cantidad WHERE ID_Centro = :ID_Centro AND ID_Insumo = :ID_Insumo AND ID = :Producto_Seleccionado");
                        $stmt->bindParam(":ID_Insumo", $ID_Producto);
                        $stmt->bindParam(":ID_Centro", $ID_Centro_Origen);
                        $stmt->bindParam(":Cantidad", $Cantidad);
                        $stmt->bindParam(":Producto_Seleccionado", $Producto_Seleccionado);
                        $stmt->execute();
                       
                        $sql = "SELECT ID, Cantidad FROM detalle_inventario_insumos 
                                WHERE ID_Centro = :ID_Centro_Destinado 
                                AND ID_Insumo = :ID_Producto 
                                AND (N_Factura = :Factura OR (N_Factura IS NULL AND :Factura IS NULL))
                                ORDER BY Fecha_Ingreso DESC";
                        $stmt = $this->PDO->prepare($sql);
                        $stmt->bindParam(":ID_Centro_Destinado", $ID_Centro_Destino);
                        $stmt->bindParam(":ID_Producto", $ID_Producto);
                        $stmt->bindParam(":Factura", $Factura, PDO::PARAM_STR); 
                        $stmt->execute();
                        $Inventario = $stmt->fetch(PDO::FETCH_ASSOC); 

                        if ($Inventario) { 
                            // Actualizar la cantidad en el inventario del centro de destino
                            $stmt = $this->PDO->prepare("UPDATE detalle_inventario_insumos 
                                                        SET Cantidad = Cantidad + :Cantidad
                                                        WHERE ID = :ID AND ID_Centro = :ID_Centro");

                            $stmt->bindParam(":ID", $Inventario['ID']);
                            $stmt->bindParam(":Cantidad", $Cantidad);
                            $stmt->bindParam(":ID_Centro", $ID_Centro_Destino);
                            $stmt->execute();
                        }else{
                            // Insertar un nuevo registro en detalle_inventario_insumos
                            $stmt = $this->PDO->prepare("INSERT INTO detalle_inventario_insumos (ID_Insumo, ID_Entrada, ID_Centro, N_Factura, Cantidad, valor_unitario, Fecha_Ingreso) 
                                                    VALUES (:ID_Producto, NULL, :ID_Centro, :N_Factura, :Cantidad, :valor_unitario, :Fecha_Ingreso)");
                            $stmt->bindParam(":ID_Producto", $ID_Producto);
                            $stmt->bindParam(":ID_Centro", $ID_Centro_Destino);
                            $stmt->bindParam(":Cantidad", $Cantidad);
                            $stmt->bindParam(":N_Factura", $Factura);
                            $stmt->bindParam(":valor_unitario", $Valor_Unitario);
                            $stmt->bindParam(":Fecha_Ingreso", $Fecha_Ingreso);
                            $stmt->execute();
                        }

                    }
                    // Eliminar las entradas de la tabla temporal
                    $stmt = $this->PDO->prepare("DELETE FROM detalles_temp_traslado_insumos 
                                                WHERE ID_Usuario IN (SELECT ID_Usuario FROM traslado_insumos WHERE ID = :ID_Traslado)");
                    $stmt->bindParam(":ID_Traslado", $ID);
                    $stmt->execute();
                
                    $this->PDO->commit();
                    return true;
                } catch (Exception $e) {
                    $this->PDO->rollBack();
                    return false;
                }
            } else {
                return false; 
            }                
        }
        
        public function RestarTrasladoTemp($ID_Producto, $ID_Usuario, $ID) {
            // Actualizar la cantidad y el valor total
            $sql = "UPDATE detalles_temp_traslado_insumos 
                    SET Cantidad = GREATEST(Cantidad - 1, 0),
                        Valor_Total = Cantidad * valor_unitario
                    WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto AND ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
        
            // Eliminar el producto si la cantidad es igual o menor a 0
            $sqlDelete = "DELETE FROM detalles_temp_traslado_insumos 
                          WHERE ID_Usuario = :ID_Usuario 
                          AND ID_Producto = :ID_Producto 
                          AND Cantidad <= 0";
            $stmtDelete = $this->PDO->prepare($sqlDelete);
            $stmtDelete->bindParam(':ID_Usuario', $ID_Usuario);
            $stmtDelete->bindParam(':ID_Producto', $ID_Producto);
            $stmtDelete->execute();
        
            return true;
        }

        public function EliminarTrasladoTemp ($ID_Producto, $ID_Usuario, $ID){
            $sql = "DELETE FROM detalles_temp_traslado_insumos 
                WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto AND ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Producto', $ID_Producto);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();     
            return true;
        }

        public function DetallesTraslado($ID_Usuario){       
            $sql = "SELECT insumos.Codigo AS Codigo_Producto, insumos.Nombre AS Nombre_producto, detalles_temp_traslado_insumos.* 
                    FROM detalles_temp_traslado_insumos
                    JOIN insumos ON detalles_temp_traslado_insumos.ID_Producto = insumos.ID 
                    WHERE ID_Usuario = :ID_Usuario 
                    ORDER BY Codigo ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_Usuario);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerTraslado($ID) {
            $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreTraslada, usuario_recibe.NombreCompleto AS NombreRecibe, centro_traslada.Nombre AS CentroTraslada, centro_recibe.Nombre AS CentroDestino, traslado_insumos.*
                    FROM traslado_insumos
                    JOIN usuario AS usuario_ingresa ON traslado_insumos.ID_Usuario = usuario_ingresa.ID
                    JOIN usuario AS usuario_recibe ON traslado_insumos.ID_Recibe = usuario_recibe.ID
                    JOIN centrot AS centro_traslada ON traslado_insumos.ID_Centro = centro_traslada.ID
                    JOIN centrot AS centro_recibe ON traslado_insumos.ID_Centro_Destinado = centro_recibe.ID
                    WHERE traslado_insumos.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function MostrarDetallesProductosTraslado($ID) {
            $stmt = $this->PDO->prepare("SELECT ded.ID, p.Codigo, p.Nombre, ded.Cantidad, ded.N_Factura
                FROM detalles_traslado_insumos ded
                JOIN insumos p ON ded.ID_Producto = p.ID
                WHERE ded.ID_Traslado = :id
                ORDER BY p.Codigo ASC");
            $stmt->bindParam(":id", $ID);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        }   

        public function MostrarDetallesProductosTrasladoTemp($ID) {
            $stmt = $this->PDO->prepare("SELECT dted.ID, p.Codigo, p.Nombre, dted.Cantidad, dted.Factura AS N_Factura
                FROM detalles_temp_traslado_insumos dted
                JOIN insumos p ON dted.ID_Producto = p.ID
                JOIN traslado_insumos ed ON dted.ID_Usuario = ed.ID_Usuario
                WHERE ed.ID = :id
                ORDER BY p.Codigo ASC");
            $stmt->bindParam(":id", $ID);
            $stmt->execute();
            $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $usuarioData;
        } 
    }
?>
