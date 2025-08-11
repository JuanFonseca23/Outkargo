<?php
class Dotacion {
    // Atributos
    private $PDO;
    
    // Constructor
    public function __construct() {
        require_once "Conexion.php";
        $Conexion = new Conexion();
        $this->PDO = $Conexion->Conexion();
    }
    
    // Métodos
    public function ContarProductosActivos($ID_Centro) {
        $Cantidad = 0;
        $sql = "SELECT COUNT(*) as NoProductos FROM detalle_inventario WHERE Cantidad > :Cantidad AND ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->bindParam(':Cantidad', $Cantidad);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerUltimoCodigo() {
        $sql = "SELECT Codigo FROM producto ORDER BY ID DESC LIMIT 1";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['Codigo'] : null;
    }

    public function existeCodigo($codigo) {
        $sql = "SELECT COUNT(*) FROM producto WHERE Codigo = :codigo";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $count = $stmt->fetchColumn();  
        return $count > 0; 
    }

    public function RegistrarProducto($Codigo,$Nombre){
        $sql = "INSERT INTO producto (Codigo, Nombre) VALUES (:Codigo, :Nombre)";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':Codigo', $Codigo);
        $stmt->bindParam(':Nombre', $Nombre);
        try {
            $stmt->execute(); 
            return $this->PDO->lastInsertId();
        } catch (Exception $e) {
            echo "Error al registrar el producto: " . $e->getMessage();
            return false;
        }
    }

    public function ContarEntregas($ID_Centro) {
        $Estado = 1;
        $sql = "SELECT COUNT(*) as NoEntregas FROM entrega_dotacion WHERE Estado = :Estado AND ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->bindParam(':Estado', $Estado);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ContarEntradas($ID_Centro) {
        $sql = "SELECT COUNT(*) as NoEntradas FROM entrada_dotacion WHERE ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ContarEntradasTotales() {
        $sql = "SELECT COUNT(*) as NoEntradas FROM entrada_dotacion";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function Leer($ID_Centro) {
        $Cantidad = 0;
        $sql = "SELECT producto.Codigo AS Codigo_Producto, producto.Nombre AS Nombre_producto, detalle_inventario.* 
                FROM detalle_inventario 
                JOIN producto ON detalle_inventario.ID_Producto = producto.ID 
                WHERE Cantidad >= :Cantidad AND ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->bindParam(':Cantidad', $Cantidad);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function LeerE($ID_Centro) {
        $Estado = 1;
        $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, entrega_dotacion.*
                FROM entrega_dotacion
                JOIN usuario AS usuario_ingresa ON entrega_dotacion.ID_Ingresa = usuario_ingresa.ID
                JOIN usuario AS usuario_supervisor ON entrega_dotacion.ID_Supervisa = usuario_supervisor.ID
                WHERE entrega_dotacion.ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function LeerEntradas($ID_Centro) {
        $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, entrada_dotacion.*
                FROM entrada_dotacion
                JOIN usuario AS usuario_ingresa ON entrada_dotacion.ID_Usuario = usuario_ingresa.ID
                JOIN usuario AS usuario_supervisor ON entrada_dotacion.ID_Supervisor = usuario_supervisor.ID
                WHERE entrada_dotacion.ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function LeerEntradasTotales() {
        $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, centro.Nombre AS Nombre_Centro, entrada_dotacion.*
                FROM entrada_dotacion
                JOIN usuario AS usuario_ingresa ON entrada_dotacion.ID_Usuario = usuario_ingresa.ID
                JOIN usuario AS usuario_supervisor ON entrada_dotacion.ID_Supervisor = usuario_supervisor.ID
                JOIN centrot AS centro ON entrada_dotacion.ID_Centro = centro.ID";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function Centro($ID_Centro) {
        $sql = "SELECT centrot.Nombre AS Nombre_Centro 
                FROM detalle_inventario 
                JOIN centrot ON detalle_inventario.ID_Centro = centrot.ID 
                WHERE ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }     
        
    public function MostrarNombre($ID_Producto) {
        $sql = "SELECT Nombre FROM producto WHERE ID = :ID_Producto LIMIT 1";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['Nombre'] : null;
    }

    public function obtenerIDProductoPorCodigo($Codigo) {
        $sql = "SELECT ID FROM producto WHERE Codigo = :Codigo";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":Codigo", $Codigo);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto ? $producto['ID'] : false;
    } 

    public function DetallesEntrega($ID_Persona_Recibe, $ID_Persona_Entrega){       
        $sql = "SELECT producto.Codigo AS Codigo_Producto, producto.Nombre AS Nombre_producto, detalles_temp_entrega_dotacion.* 
                FROM detalles_temp_entrega_dotacion  
                JOIN producto ON detalles_temp_entrega_dotacion.ID_Producto = producto.ID 
                WHERE ID_Usuario = :ID_Usuario 
                ORDER BY Codigo ASC";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Persona_Entrega);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function DetallesEntrada($ID_Usuario){       
        $sql = "SELECT producto.Codigo AS Codigo_Producto, producto.Nombre AS Nombre_producto, detalles_temp_entrada_dotacion.* 
                FROM detalles_temp_entrada_dotacion
                JOIN producto ON detalles_temp_entrada_dotacion.ID_Producto = producto.ID 
                WHERE ID_Usuario = :ID_Usuario 
                ORDER BY Codigo ASC";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ValidarUltimoRegistroEntrega($ID_Usuario, $ID_Producto) {
        $sql = "SELECT * FROM detalles_temp_entrega_dotacion WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function ValidarCantidadActualEntrega($ID_Usuario, $ID_Producto) {
        $sql = "SELECT Cantidad FROM detalles_temp_entrega_dotacion WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->execute();
        $entradaData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $entradaData ? $entradaData['Cantidad'] : false;
    }

    public function ActualizarDotacionEntrega($ID_Usuario, $ID_Producto, $Cantidad) {
        $sql = "UPDATE detalles_temp_entrega_dotacion SET Cantidad = :Cantidad WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":Cantidad", $Cantidad);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        return $stmt->execute();
    }

    public function InsertarDotacionEntrega($ID_Usuario, $ID_Producto, $Cantidad) { 
        $sql = "INSERT INTO detalles_temp_entrega_dotacion (ID_Usuario, ID_Producto, Cantidad) VALUES (:ID_Usuario, :ID_Producto, :Cantidad)"; 
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->bindParam(":Cantidad", $Cantidad);
        return $stmt->execute();
    }

    public function ValidarUltimoRegistroEntrada($ID_Usuario, $ID_Producto) {
        $sql = "SELECT * FROM detalles_temp_entrada_dotacion WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function ValidarCantidadActualEntrada($ID_Usuario, $ID_Producto) {
        $sql = "SELECT Cantidad FROM detalles_temp_entrada_dotacion WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->execute();
        $entradaData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $entradaData ? $entradaData['Cantidad'] : false;
    }

    public function ActualizarDotacionEntrada($ID_Usuario, $ID_Producto, $Cantidad) {
        $sql = "UPDATE detalles_temp_entrada_dotacion SET Cantidad = :Cantidad WHERE ID_Usuario = :ID_Usuario AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":Cantidad", $Cantidad);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        return $stmt->execute();
    }

    public function InsertarDotacionEntrada($ID_Usuario, $ID_Producto, $Cantidad) { 
        $sql = "INSERT INTO detalles_temp_entrada_dotacion (ID_Usuario, ID_Producto, Cantidad) VALUES (:ID_Usuario, :ID_Producto, :Cantidad)"; 
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->bindParam(":Cantidad", $Cantidad);
        return $stmt->execute();
    }

    public function ValidarExistenciaActual($ID_Producto, $ID_Centro){
        $sql = "SELECT Cantidad FROM detalle_inventario WHERE ID_Producto = :ID_Producto AND ID_Centro = :ID_Centro";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->bindParam(":ID_Centro", $ID_Centro);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function LeerUltimoRegistro($ID) {
        $sql = "SELECT producto.Codigo AS Codigo_Producto, producto.Nombre AS Nombre_producto, ultimo_registro_entrega.* 
                FROM ultimo_registro_entrega  
                JOIN producto ON ultimo_registro_entrega.ID_Producto = producto.ID 
                WHERE ID_Usuario = :ID_Usuario 
                ORDER BY Codigo ASC";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function RestarEntregaTemp ($ID_Producto, $ID_Usuario){
        $sql = "UPDATE detalles_temp_entrega_dotacion 
            SET Cantidad = GREATEST(Cantidad - 1, 0) 
            WHERE ID_Usuario = :ID_Usuario 
            AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
        $stmt->bindParam(':ID_Producto', $ID_Producto);
        $stmt->execute();     
        return true;
    }

    public function EliminarEntregaTemp ($ID_Producto, $ID_Usuario){
        $sql = "DELETE FROM detalles_temp_entrega_dotacion 
            WHERE ID_Usuario = :ID_Usuario 
            AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
        $stmt->bindParam(':ID_Producto', $ID_Producto);
        $stmt->execute();     
        return true;
    }

    public function EilinarUltimoRegistro($ID_Usuario){
        $sql = "DELETE FROM ultimo_registro_entrega WHERE ID_Usuario = :ID_Usuario";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->execute();
        return true;
    }

    public function AgregarUltimoRegistro($ID_Producto, $ID_Usuario){
        $sql = "INSERT INTO ultimo_registro_entrega (ID_Producto, ID_Usuario) VALUES (:ID_Producto, :ID_Usuario)";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);        
        $stmt->execute();
        return true;
    }

    public function VerificarEstadoEntrada($ID_Usuario){
        $Estado = 2;
        $sql = "SELECT COUNT(*) as total FROM entrada_dotacion WHERE Estado = :Estado AND ID_Usuario = :ID_Usuario";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":Estado", $Estado);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    public function verificarEstadoFirma($ID_Entrada) {
        $sql = "SELECT Firma_Supervisor_Estado FROM entrada_dotacion WHERE ID = :ID_Entrada";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Entrada", $ID_Entrada);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function LeerUltimoRegistroEntrada($ID) {
        $sql = "SELECT producto.Codigo AS Codigo_Producto, producto.Nombre AS Nombre_producto, ultimo_registro_entrada.* 
                FROM ultimo_registro_entrada  
                JOIN producto ON ultimo_registro_entrada  .ID_Producto = producto.ID 
                WHERE ID_Usuario = :ID_Usuario 
                ORDER BY Codigo ASC";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function EliminarUltimoRegistroEntrada($ID_Usuario){
        $sql = "DELETE FROM ultimo_registro_entrada WHERE ID_Usuario = :ID_Usuario";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->execute();
        return true;
    }

    public function AgregarUltimoRegistroEntrada($ID_Producto, $ID_Usuario){
        $sql = "INSERT INTO ultimo_registro_entrada (ID_Producto, ID_Usuario) VALUES (:ID_Producto, :ID_Usuario)";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Producto", $ID_Producto);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);        
        $stmt->execute();
        return true;
    }

    public function RestarEntradaTemp ($ID_Producto, $ID_Usuario){
        $sql = "UPDATE detalles_temp_entrada_dotacion 
            SET Cantidad = GREATEST(Cantidad - 1, 0) 
            WHERE ID_Usuario = :ID_Usuario 
            AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
        $stmt->bindParam(':ID_Producto', $ID_Producto);
        $stmt->execute();     
        return true;
    }

    public function EliminarEntradaTemp ($ID_Producto, $ID_Usuario){
        $sql = "DELETE FROM detalles_temp_entrada_dotacion 
            WHERE ID_Usuario = :ID_Usuario 
            AND ID_Producto = :ID_Producto";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
        $stmt->bindParam(':ID_Producto', $ID_Producto);
        $stmt->execute();     
        return true;
    }

    public function ObtenerNumeroFormulario(){
        $sql = "SELECT `Numero` FROM entrada_dotacion ORDER BY ID DESC LIMIT 1";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['Numero'] : null;
    }

    public function FirmarEntrada($ID_Usuario, $ID_Supervisor, $ID_Centro, $No_Formulario, $Fecha_Realizado, $Estado, $Firma, $Firma_Supervisor_Estado) {
        $sql = "INSERT INTO entrada_dotacion (ID_Usuario, ID_Supervisor, ID_Centro, Numero, Fecha_Realizado, Fecha_Firma_Supervisor, Estado, Firma_Ingresa, Firma_Supervisor, Firma_Supervisor_Estado, Descripcion_Anulacion)
                VALUES (:ID_Usuario, :ID_Supervisor, :ID_Centro, :Numero, :Fecha_Realizado, NULL, :Estado, :Firma, NULL, :Firma_Supervisor_Estado, NULL)";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $ID_Usuario);
        $stmt->bindParam(":ID_Supervisor", $ID_Supervisor);
        $stmt->bindParam(":ID_Centro", $ID_Centro);
        $stmt->bindParam(":Numero", $No_Formulario);
        $stmt->bindParam(":Fecha_Realizado", $Fecha_Realizado);
        $stmt->bindParam(":Estado", $Estado);
        $stmt->bindParam(":Firma", $Firma); 
        $stmt->bindParam(":Firma_Supervisor_Estado", $Firma_Supervisor_Estado); 
        if($stmt->execute()) {
            return $this->PDO->lastInsertId(); 
        } else {
            return false; 
        }
    }

    public function FirmarEntradaSupervisor($ID, $Fecha_Firma_Supervisor, $Estado, $Firma_Supervisor, $Firma_Supervisor_Estado){
        $sql = "UPDATE entrada_dotacion SET Fecha_Firma_Supervisor = :Fecha_Firma_Supervisor, Estado = :Estado, Firma_Supervisor = :Firma_Supervisor, Firma_Supervisor_Estado = :Firma_Supervisor_Estado WHERE ID = :ID";
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

    public function DotacionEntrada($ID) {
        // Obtener los detalles de la entrada y el ID_Centro desde la tabla entrada_dotacion
        $sql = "SELECT t.ID_Usuario, t.ID_Producto, t.Cantidad, e.ID_Centro
                FROM detalles_temp_entrada_dotacion t
                JOIN entrada_dotacion e ON t.ID_Usuario = e.ID_Usuario
                WHERE e.ID = :ID_Entrada";
        
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Entrada", $ID);
        $stmt->execute();
        
        $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($entradas) {
            // Iniciar la transacción
            $this->PDO->beginTransaction();
            try {
                // Insertar los detalles de la entrada en la tabla final
                foreach ($entradas as $Entrada) {
                    // Insertar en la tabla detalles_entrada_dotacion
                    $stmt = $this->PDO->prepare("INSERT INTO detalles_entrada_dotacion (ID_Entrada, ID_Usuario, ID_Producto, Cantidad)
                                                 VALUES (:ID_Entrada, :ID_Usuario, :ID_Producto, :Cantidad)");
                    $stmt->bindParam(":ID_Entrada", $ID);
                    $stmt->bindParam(":ID_Usuario", $Entrada['ID_Usuario']);
                    $stmt->bindParam(":ID_Producto", $Entrada['ID_Producto']);
                    $stmt->bindParam(":Cantidad", $Entrada['Cantidad']);
                    $stmt->execute();
    
                    // Comprobar si el producto existe en el inventario del centro
                    $stmt = $this->PDO->prepare("SELECT Cantidad FROM detalle_inventario 
                                                   WHERE ID_Producto = :ID_Producto AND ID_Centro = :ID_Centro");
                    $stmt->bindParam(":ID_Producto", $Entrada['ID_Producto']);
                    $stmt->bindParam(":ID_Centro", $Entrada['ID_Centro']);
                    $stmt->execute();
                    $inventario = $stmt->fetch(PDO::FETCH_ASSOC);
    
                    if ($inventario) {
                        // Actualizar la cantidad existente
                        $stmt = $this->PDO->prepare("UPDATE detalle_inventario 
                                                       SET Cantidad = Cantidad + :Cantidad 
                                                       WHERE ID_Producto = :ID_Producto AND ID_Centro = :ID_Centro");
                        $stmt->bindParam(":Cantidad", $Entrada['Cantidad']);
                        $stmt->bindParam(":ID_Producto", $Entrada['ID_Producto']);
                        $stmt->bindParam(":ID_Centro", $Entrada['ID_Centro']);
                        $stmt->execute();
                    } else {
                        // Si no existe, insertar un nuevo registro en detalle_inventario
                        $stmt = $this->PDO->prepare("INSERT INTO detalle_inventario (ID_Producto, ID_Centro, Cantidad) 
                                                       VALUES (:ID_Producto, :ID_Centro, :Cantidad)");
                        $stmt->bindParam(":ID_Producto", $Entrada['ID_Producto']);
                        $stmt->bindParam(":ID_Centro", $Entrada['ID_Centro']);
                        $stmt->bindParam(":Cantidad", $Entrada['Cantidad']);
                        $stmt->execute();
                    }
                }
    
                // Eliminar las entradas de la tabla temporal
                $stmt = $this->PDO->prepare("DELETE FROM detalles_temp_entrada_dotacion 
                                             WHERE ID_Usuario IN (SELECT ID_Usuario FROM entrada_dotacion WHERE ID = :ID_Entrada)");
                $stmt->bindParam(":ID_Entrada", $ID);
                $stmt->execute();
    
                // Confirmar la transacción
                $this->PDO->commit();
                return true;
    
            } catch (Exception $e) {
                // Si algo falla, revertir los cambios
                $this->PDO->rollBack();
                return false;
            }
        } else {
            return false; // No se encontraron entradas
        }
    }

    //Anular Entrada de Dotacion
    public function AnularDotacionEntrada($ID, $Descripcion) {
        // Obtener el estado actual de la entrada desde la tabla entrada_dotacion
        $sqlEstado = "SELECT Estado, ID_Centro FROM entrada_dotacion WHERE ID = :ID_Entrada";
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
                    $sqlDeleteTemp = "DELETE FROM detalles_temp_entrada_dotacion WHERE ID_Usuario IN (SELECT ID_Usuario FROM entrada_dotacion WHERE ID = :ID_Entrada)";
                    $stmtDeleteTemp = $this->PDO->prepare($sqlDeleteTemp);
                    $stmtDeleteTemp->bindParam(":ID_Entrada", $ID);
                    $stmtDeleteTemp->execute();
                } else if ($estado == 1) {
                    // Obtener los detalles de la entrada para eliminar y ajustar inventario
                    $sqlDetalles = "SELECT ID_Producto, Cantidad FROM detalles_entrada_dotacion WHERE ID_Entrada = :ID_Entrada";
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
                            $sqlUpdateInventario = "UPDATE detalle_inventario SET Cantidad = Cantidad - :Cantidad 
                                                    WHERE ID_Producto = :ID_Producto AND ID_Centro = :ID_Centro";
                            $stmtUpdateInventario = $this->PDO->prepare($sqlUpdateInventario);
                            $stmtUpdateInventario->bindParam(":Cantidad", $cantidad);
                            $stmtUpdateInventario->bindParam(":ID_Producto", $idProducto);
                            $stmtUpdateInventario->bindParam(":ID_Centro", $idCentro);
                            $stmtUpdateInventario->execute();
                        }

                        // Eliminar los detalles de la entrada en detalles_entrada_dotacion
                        $sqlDeleteDetalles = "DELETE FROM detalles_entrada_dotacion WHERE ID_Entrada = :ID_Entrada";
                        $stmtDeleteDetalles = $this->PDO->prepare($sqlDeleteDetalles);
                        $stmtDeleteDetalles->bindParam(":ID_Entrada", $ID);
                        $stmtDeleteDetalles->execute();
                    }
                }

                // Actualizar el estado de la dotación y guardar la descripción de la anulación
                $Estado = 3;
                $Firma_Supervisor_Estado = 1;
                $sqlUpdateEstado = "UPDATE entrada_dotacion SET Estado = :Estado, Descripcion_Anulacion = :Descripcion, Firma_Supervisor_Estado = :Firma_Supervisor_Estado WHERE ID = :ID_Entrada";
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
            return false; // No se encontró la entrada
        }
    }
        
    public function RegistrarEntregaDotacion($Firma,$Usuario,$Fecha, $Supervisa, $Centro){
        $Estado = 2;
        $stmt = $this->PDO->prepare("INSERT INTO entrega_dotacion (ID, ID_Ingresa , ID_Supervisa, ID_Centro , Fecha, Fecha_Firma_Supervisado, Estado, Firma_Ingresa, Firma_Supervisa) VALUES (NULL, :ID_Ingresa, :ID_Supervisa, :ID_Centro, :Fecha, NULL, :Estado, :Firma_Ingresa, NULL)");
        $stmt->bindParam(":ID_Ingresa", $Usuario);
        $stmt->bindParam(":ID_Supervisa", $Supervisa);
        $stmt->bindParam(":ID_Centro", $Centro);
        $stmt->bindParam(":Fecha", $Fecha);
        $stmt->bindParam(":Estado", $Estado);
        $stmt->bindParam(":Firma_Ingresa", $Firma);
        $stmt->execute();
        $id_insertado = $this->PDO->lastInsertId();
        if ($id_insertado) {
            return $id_insertado;
        } else {
            return false;
        }     
    }

    public function FirmarEntregaDotacion($Firma,$Usuario,$Fecha, $Cedula){
        $Estado = 1;
        $stmt = $this->PDO->prepare("UPDATE entrega_dotacion SET Firma_Supervisa = :Firma_Supervisa, Fecha_Firma_Supervisado = :Fecha_Firma_Supervisado, Estado = :Estado WHERE ID = :Codigo");
        $stmt->bindParam(":Firma_Supervisa", $Firma);
        $stmt->bindParam(":Fecha_Firma_Supervisado", $Fecha);
        $stmt->bindParam(":Estado", $Estado);
        $stmt->bindParam(":Codigo", $Cedula);
        if($stmt->execute()){
                return true;
            }else{
                return false;
            } 
    }

    public function BorrarEntregaDotacionTemp($Usuario, $ID, $ID_Centro){
        $stmt = $this->PDO->prepare("SELECT * FROM detalles_temp_entrega_dotacion WHERE ID_Usuario = :usuario ORDER BY ID ASC");
        $stmt->bindParam(":usuario", $Usuario);
        $stmt->execute();
        $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);        
        if ($usuarioData) {
            foreach ($usuarioData as $Entrada) {
                $stmt = $this->PDO->prepare("INSERT INTO detalles_entrega_dotacion (ID_Usuario, ID_Entrada, ID_Producto, Cantidad) VALUES (:Usuario, :ID_Entrada, :ID_Producto, :Cantidad)");
                $stmt->bindParam(":Usuario", $Usuario);
                $stmt->bindParam(":ID_Entrada", $ID);
                $stmt->bindParam(":ID_Producto", $Entrada['ID_Producto']);
                $stmt->bindParam(":Cantidad", $Entrada['Cantidad']);
                $stmt->execute();
                $stmt = $this->PDO->prepare("UPDATE detalle_inventario SET Cantidad = Cantidad - :Cantidad WHERE ID_Producto = :ID_Producto AND ID_Centro = :ID_Centro");
                $stmt->bindParam(":Cantidad", $Entrada['Cantidad']);
                $stmt->bindParam(":ID_Producto", $Entrada['ID_Producto']);            
                $stmt->bindParam(":ID_Centro", $ID_Centro); 
                $stmt->execute();
            }            
            $stmt = $this->PDO->prepare("DELETE FROM detalles_temp_entrega_dotacion WHERE ID_Usuario = :Usuario");
            $stmt->bindParam(":Usuario", $Usuario);
            $stmt->execute();
        } else {
            return false;
        }   
    }

    public function VerEntrada($ID, $ID_Centro) {
        $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, entrada_dotacion.*
                FROM entrada_dotacion
                JOIN usuario AS usuario_ingresa ON entrada_dotacion.ID_Usuario = usuario_ingresa.ID
                JOIN usuario AS usuario_supervisor ON entrada_dotacion.ID_Supervisor = usuario_supervisor.ID
                WHERE entrada_dotacion.ID_Centro = :ID_Centro AND entrada_dotacion.ID = :ID";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function MostrarDetallesDotacionEntrada($ID) {
        $stmt = $this->PDO->prepare("
            SELECT ded.ID, p.Codigo, p.Nombre, ded.Cantidad
            FROM detalles_entrada_dotacion ded
            JOIN producto p ON ded.ID_Producto = p.ID
            WHERE ded.ID_Entrada = :id
            ORDER BY p.Codigo ASC
        ");
        $stmt->bindParam(":id", $ID);
        $stmt->execute();
        $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarioData;
    }   

    public function MostrarDetallesDotacionEntradaTemp($ID) {
        $stmt = $this->PDO->prepare("
            SELECT dted.ID, p.Codigo, p.Nombre, dted.Cantidad
            FROM detalles_temp_entrada_dotacion dted
            JOIN producto p ON dted.ID_Producto = p.ID
            JOIN entrada_dotacion ed ON dted.ID_Usuario = ed.ID_Usuario
            WHERE ed.ID = :id
            ORDER BY p.Codigo ASC
        ");
        $stmt->bindParam(":id", $ID);
        $stmt->execute();
        $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarioData;
    }   

    public function VerEntrega($ID, $ID_Centro) {
        $Estado = 1;
        $sql = "SELECT usuario_ingresa.NombreCompleto AS NombreUsuario, usuario_supervisor.NombreCompleto AS NombreSupervisor, entrega_dotacion.*
                FROM entrega_dotacion
                JOIN usuario AS usuario_ingresa ON entrega_dotacion.ID_Ingresa = usuario_ingresa.ID
                JOIN usuario AS usuario_supervisor ON entrega_dotacion.ID_Supervisa = usuario_supervisor.ID
                WHERE entrega_dotacion.ID_Centro = :ID_Centro AND entrega_dotacion.ID = :ID";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function MostrarDetallesDotacionEntrega($ID) {
        $stmt = $this->PDO->prepare("
            SELECT ded.ID, p.Codigo, p.Nombre, ded.Cantidad
            FROM detalles_entrega_dotacion ded
            JOIN producto p ON ded.ID_Producto = p.ID
            WHERE ded.ID_Entrada = :id
            ORDER BY p.Codigo ASC
        ");
        $stmt->bindParam(":id", $ID);
        $stmt->execute();
        $usuarioData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarioData;
    }        

    public function ObtenerCorreo($Usuario){
        $sql = "SELECT Correo FROM usuario WHERE ID = :ID_Usuario";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(":ID_Usuario", $Usuario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['Correo'] : null;
    }

    public function AnularEntrega($ID_Entrega, $Descripcion_Anulacion) {
        // Obtener los detalles de la entrega y el estado actual
        $sqlEstado = "SELECT Estado, ID_Centro FROM entrega_dotacion WHERE ID = :ID_Entrega";
        $stmtEstado = $this->PDO->prepare($sqlEstado);
        $stmtEstado->bindParam(":ID_Entrega", $ID_Entrega);
        $stmtEstado->execute();
        $entrega = $stmtEstado->fetch(PDO::FETCH_ASSOC);
    
        if ($entrega) {
            $estado = $entrega['Estado'];
            $idCentro = $entrega['ID_Centro'];
    
            // Verificar si la entrega ya no está anulada
            if ($estado != 2) {
                // Iniciar la transacción
                $this->PDO->beginTransaction();
                try {
                    // Obtener los detalles de la entrega
                    $sqlDetalles = "SELECT ID_Producto, Cantidad FROM detalles_entrega_dotacion WHERE ID_Entrada = :ID_Entrega";
                    $stmtDetalles = $this->PDO->prepare($sqlDetalles);
                    $stmtDetalles->bindParam(":ID_Entrega", $ID_Entrega);
                    $stmtDetalles->execute();
                    $detalles = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);
    
                    if ($detalles) {
                        // Sumar la cantidad de productos al inventario
                        foreach ($detalles as $detalle) {
                            $idProducto = $detalle['ID_Producto'];
                            $cantidad = $detalle['Cantidad'];
    
                            // Actualizar el inventario del centro
                            $sqlUpdateInventario = "UPDATE detalle_inventario 
                                                    SET Cantidad = Cantidad + :Cantidad 
                                                    WHERE ID_Producto = :ID_Producto 
                                                    AND ID_Centro = :ID_Centro";
                            $stmtUpdateInventario = $this->PDO->prepare($sqlUpdateInventario);
                            $stmtUpdateInventario->bindParam(":Cantidad", $cantidad);
                            $stmtUpdateInventario->bindParam(":ID_Producto", $idProducto);
                            $stmtUpdateInventario->bindParam(":ID_Centro", $idCentro);
                            $stmtUpdateInventario->execute();
                        }
                    }
    
                    // Cambiar el estado de la entrega a "anulado" y agregar la descripción
                    $Estado = 2;
                    $sqlUpdateEstado = "UPDATE entrega_dotacion 
                                        SET Estado = :Estado, 
                                            Descripcion_Anulacion = :Descripcion_Anulacion 
                                        WHERE ID = :ID_Entrega";
                    $stmtUpdateEstado = $this->PDO->prepare($sqlUpdateEstado);
                    $stmtUpdateEstado->bindParam(":ID_Entrega", $ID_Entrega);
                    $stmtUpdateEstado->bindParam(":Estado", $Estado);
                    $stmtUpdateEstado->bindParam(":Descripcion_Anulacion", $Descripcion_Anulacion);
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
                return false; // La entrega ya está anulada
            }
        } else {
            return false; // No se encontró la entrega
        }
    }
    
    public function LeerHuella($ID_Centro) {
        // Establecer zona horaria de Bogotá
        date_default_timezone_set('America/Bogota');
    
        // Obtener fecha actual en formato dd-mm-yyyy
        $fechaHoy = date("d-m-Y");
    
        $sql = "SELECT *
                FROM huella
                WHERE ID_Centro = :ID_Centro
                AND huella.Fecha = :Fecha
                ORDER BY huella.ID DESC";
    
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Centro', $ID_Centro, PDO::PARAM_INT);
        $stmt->bindParam(':Fecha', $fechaHoy, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
