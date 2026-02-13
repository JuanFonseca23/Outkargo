<?php
    class OrdenesTrabajo {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        public function ActualizarEstado($ID_Trabajo, $Estado_Trabajo, $Tipo_Trabajo){
            if ($Tipo_Trabajo === 'Overhauling' || $Tipo_Trabajo === 'MantenimientoP' || $Tipo_Trabajo === 'MantenimientoC'){
                $sql = "UPDATE trabajos_overhauling 
                        SET Estado_Trabajo = :Estado_Trabajo 
                        WHERE ID = :ID_Trabajo";
            } else {
                $sql = "UPDATE detalles_solicitud_orden_trabajo 
                        SET Estado_Trabajo = :Estado_Trabajo 
                        WHERE ID = :ID_Trabajo";
            }

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Trabajo', $ID_Trabajo);
            $stmt->bindParam(':Estado_Trabajo', $Estado_Trabajo);

            if ($stmt->execute()) {
                return $stmt->rowCount() > 0; 
            }
            return false;
        }

        public function ActualizarOrden($ID_Detalle, $DescripcionT){
            $Estado = 0;
            $sql = "UPDATE detalles_orden_trabajo 
                    SET Descripcion = :DescripcionT , Estado = :Estado
                    WHERE ID = :ID_Detalle";

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Detalle', $ID_Detalle);
            $stmt->bindParam(':DescripcionT', $DescripcionT);
            $stmt->bindParam(':Estado', $Estado);

            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            return false;
        }

        public function ActualizarEstadoDetalle($ID_Detalle, $Estado){
            $sql = "UPDATE detalles_solicitud_orden_trabajo 
                    SET Estado_Trabajo = :Estado_Trabajo 
                    WHERE ID = :ID_Detalle";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':Estado_Trabajo', $Estado);
            $stmt->bindValue(':ID_Detalle', $ID_Detalle);
            return $stmt->execute();
        }

        public function AutorizarOrdenTrabajo($ID_Solicitud, $Firma, $Comentarios, $Fecha_Autorizacion, $Estado_Trabajo){
            $sql = "UPDATE solicitud_orden_trabajo 
                    SET Firma_Autoriza = :Firma_Autoriza, Fecha_Firma_Autoriza = :Fecha_Firma_Autoriza, Comentarios = :Comentarios, Estado_Orden = :Estado_Trabajo 
                    WHERE ID = :ID_Solicitud";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':Firma_Autoriza', $Firma);
            $stmt->bindValue(':Fecha_Firma_Autoriza', $Fecha_Autorizacion);
            $stmt->bindValue(':Comentarios', $Comentarios);
            $stmt->bindValue(':ID_Solicitud', $ID_Solicitud);
            $stmt->bindValue(':Estado_Trabajo', $Estado_Trabajo);
            return $stmt->execute();
        }

        public function BuscarBateria($q){
            $sql = "SELECT ID AS id, Nombre AS nombre, Codigo AS codigo FROM insumos WHERE Nombre LIKE :q OR Codigo LIKE :q ORDER BY Nombre";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function BuscarCargadores($q){
            $sql = "SELECT ID AS id, Nombre AS nombre, Codigo AS codigo FROM insumos WHERE Nombre LIKE :q OR Codigo LIKE :q ORDER BY Nombre";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function BuscarInsumos($q){
            $sql = "SELECT ID AS id, Nombre AS nombre, Codigo AS codigo FROM insumos WHERE Nombre LIKE :q OR Codigo LIKE :q ORDER BY Nombre";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function BuscarMontacargas($q){
            $sql = "SELECT ID AS id, Serie AS serie, Modelo AS modelo, Numero AS numero FROM montacargas WHERE Numero LIKE :q OR Modelo LIKE :q OR Serie LIKE :q ORDER BY Numero";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function BuscarTecnicos($q){
            $sql = "SELECT ID AS id, NombreCompleto AS nombre FROM usuario WHERE ID_Cargo IN (4,6,8,13) AND NombreCompleto LIKE :q ORDER BY NombreCompleto";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function BuscarUsuario(){
            $sql = "SELECT ID AS ID_Usuario, NombreCompleto AS Nombre, ID_Cargo AS Cargo, Correo, Documento FROM usuario WHERE ID_Cargo = 2 Or ID_Cargo = 11";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function CambiarEstadoOrden($ID_Orden, $Estado){
            $sql = "UPDATE orden_trabajo 
                    SET Estado_Orden = :Estado 
                    WHERE ID = :ID_Orden";

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':ID_Orden', $ID_Orden);

            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            return false;
        }

        public function CambiarFecha($ID_Orden, $Fecha, $Fecha_FinO){
            if ($Fecha === null && $Fecha_FinO !== null) {
                $sql = "UPDATE orden_trabajo 
                        SET Fecha_Finalizacion = :Fecha_Finalizacion 
                        WHERE ID = :ID_Orden";

                $stmt = $this->PDO->prepare($sql);
                $stmt->bindParam(':Fecha_Finalizacion', $Fecha_FinO);
                $stmt->bindParam(':ID_Orden', $ID_Orden);

                return $stmt->execute();
            }
            if ($Fecha_FinO === null && $Fecha !== null) {

                $sql = "UPDATE orden_trabajo 
                        SET Fecha_Inicio = :Fecha 
                        WHERE ID = :ID_Orden";

                $stmt = $this->PDO->prepare($sql);
                $stmt->bindParam(':Fecha', $Fecha);
                $stmt->bindParam(':ID_Orden', $ID_Orden);

                return $stmt->execute();
            }

            return false;
        }

        public function ContarOrdenesPorCentro($ID_Centro) {
            $sql = "SELECT COUNT(*) as Nosolicitudes FROM orden_trabajo WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarSolicitudesPorCentro($ID_Centro) {
            $sql = "SELECT COUNT(*) as Nosolicitudes FROM solicitud_orden_trabajo WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function EliminarDetalleInsumoTemp($ID_Orden, $ID_Insumo){
            $sql = "DELETE FROM detalles_temp_insumos_orden_trabajo WHERE ID_Orden_Trabajo = :ID_Orden AND ID = :ID_Insumo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden',  $ID_Orden);
            $stmt->bindValue(':ID_Insumo', $ID_Insumo);
            return $stmt->execute();
        }

        public function FirmarOrden($ID_Orden, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico){
            $sql = "UPDATE tecnicos_orden 
                    SET Firma_Mecanico = :Firma, 
                        Fecha_Firma_Mecanico = :FechaFirma,
                        Estado_Firma_Mecanico = :EstadoFirmaMecanico
                    WHERE ID_Orden_Trabajo  = :ID_Orden AND ID_Mecanico = :ID_Mecanico";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden', $ID_Orden);
            $stmt->bindValue(':ID_Mecanico', $ID_Mecanico);
            $stmt->bindValue(':Firma', value: $Firma);
            $stmt->bindValue(':FechaFirma', $FechaFirma);
            $stmt->bindValue(':EstadoFirmaMecanico', $EstadoFirmaMecanico);
            return $stmt->execute();
        }

        public function InsertarDetalleInsumoTemp($ID_Orden, $ID_Insumo, $CantidadF, $Medida, $ID_Usuario){
            $sql = "INSERT INTO detalles_temp_insumos_orden_trabajo (ID_Orden_Trabajo, ID_Producto, ID_Usuario, Cantidad, Medida) 
                    VALUES (:ID_Orden, :ID_Insumo, :ID_Usuario, :Cantidad, :Medida)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden',  $ID_Orden);
            $stmt->bindValue(':ID_Insumo', $ID_Insumo);
            $stmt->bindValue(':Cantidad', $CantidadF);
            $stmt->bindValue(':Medida', $Medida);
            $stmt->bindValue(':ID_Usuario', $ID_Usuario);
            return $stmt->execute();
        }

        public function leerOrdenesTrabajo($ID_Centro) {
            $sql = "SELECT usuario_solicita.NombreCompleto AS NombreUsuario,
                           orden_trabajo.*,
                           GROUP_CONCAT(DISTINCT tecnico_asignado.ID_Mecanico) AS IDMecanicos,
                           GROUP_CONCAT(DISTINCT usuario_tecnico.NombreCompleto SEPARATOR ' / ') AS Tecnicos
                    FROM orden_trabajo
                    LEFT JOIN usuario AS usuario_solicita ON orden_trabajo.ID_Genera = usuario_solicita.ID
                    LEFT JOIN tecnicos_orden AS tecnico_asignado ON orden_trabajo.ID = tecnico_asignado.ID_Orden_Trabajo
                    LEFT JOIN usuario AS usuario_tecnico ON tecnico_asignado.ID_Mecanico = usuario_tecnico.ID
                    WHERE orden_trabajo.ID_Centro = :ID_Centro GROUP BY orden_trabajo.ID;";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }  

        public function leerSolicitudesTrabajo($ID_Centro) {
            $sql = "SELECT usuario_solicita.NombreCompleto AS NombreUsuario, 
                           usuario_autoriza.NombreCompleto AS NombreAutoriza, 
                           solicitud_orden_trabajo.*
                    FROM solicitud_orden_trabajo
                    LEFT JOIN usuario AS usuario_solicita ON solicitud_orden_trabajo.ID_Solicita = usuario_solicita.ID
                    LEFT JOIN usuario AS usuario_autoriza ON solicitud_orden_trabajo.ID_Autoriza = usuario_autoriza.ID
                    WHERE solicitud_orden_trabajo.ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }     

        public function MostrarDetallesSolicitud($ID) {
            $sql = "SELECT  d.*,
                    CASE 
                        WHEN d.Tipo_Producto = 'Repuestos' THEN i.Nombre
                        WHEN d.Tipo_Producto = 'Bateria'  THEN b.Nombre
                        WHEN d.Tipo_Producto = 'Cargador' THEN c.Nombre
                    END AS NombreProducto,
                    CASE 
                        WHEN d.Tipo_Producto = 'Repuestos' THEN i.N_Serial
                        WHEN d.Tipo_Producto = 'Bateria' THEN b.N_Serial
                        WHEN d.Tipo_Producto = 'Cargador' THEN c.N_Serial
                        WHEN d.Tipo_Producto = 'Montacargas' THEN m.Serie
                    END AS Serie,
                    CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Numero END AS NumeroMontacargas,
                    CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Modelo END AS ModeloMontacargas
                    FROM detalles_solicitud_orden_trabajo d
                    LEFT JOIN insumos i ON d.ID_Producto = i.ID
                    LEFT JOIN insumos b ON d.ID_Producto = b.ID
                    LEFT JOIN insumos c ON d.ID_Producto = c.ID
                    LEFT JOIN montacargas m ON d.ID_Producto = m.ID 
                    WHERE d.ID_Solicitud = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }

        public function ObtenerCorreo($ID_Verifica){
            $sql = "SELECT  NombreCompleto, Correo FROM usuario WHERE ID = :ID_Verifica";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Verifica', $ID_Verifica);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ObtenerTrabajos($Tipo_Trabajo, $ID){
            $sql = "SELECT * FROM trabajos_overhauling WHERE ID_Overhauling = :ID AND Tipo_Trabajo = :Tipo_Trabajo AND Estado_Trabajo = 2";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID', $ID);
            $stmt->bindValue(':Tipo_Trabajo', $Tipo_Trabajo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerTrabajosRepuestos($ID){
            $sql = "SELECT d.*,
                    CASE 
                        WHEN d.Tipo_Producto = 'Repuestos' THEN i.Nombre
                        WHEN d.Tipo_Producto = 'Bateria'  THEN b.Nombre
                        WHEN d.Tipo_Producto = 'Cargador' THEN c.Nombre
                    END AS NombreProducto,
                    CASE 
                        WHEN d.Tipo_Producto = 'Repuestos' THEN i.N_Serial
                        WHEN d.Tipo_Producto = 'Bateria' THEN b.N_Serial
                        WHEN d.Tipo_Producto = 'Cargador' THEN c.N_Serial
                        WHEN d.Tipo_Producto = 'Montacargas' THEN m.Serie
                    END AS Serie,
                    CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Numero END AS NumeroMontacargas,
                    CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Marca END AS MarcaMontacargas
                    FROM detalles_solicitud_orden_trabajo d
                    LEFT JOIN insumos i ON d.ID_Producto = i.ID  AND d.Tipo_Producto = 'Repuestos'
                    LEFT JOIN insumos b ON d.ID_Producto = b.ID AND d.Tipo_Producto = 'Bateria'
                    LEFT JOIN insumos c ON d.ID_Producto = c.ID AND d.Tipo_Producto = 'Cargador'
                    LEFT JOIN montacargas m ON d.ID_Producto = m.ID 
                    WHERE ID_Solicitud = :ID AND Estado_Trabajo = 2";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function ObtenerUltimoCodigoDiagnostico() {
            $sql = "SELECT Numero FROM solicitud_orden_trabajo ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function ObtenerUltimoCodigoOrden() {
            $sql = "SELECT Numero FROM orden_trabajo ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function RegistrarDetalleInsumo($ID_Orden, $ID_Insumo, $Cantidad_Solicitadad, $Medida){
            $sql = "INSERT INTO detalles_insumos_orden_trabajo (ID_Orden_Trabajo, ID_Producto, Cantidad, Medida) 
                    VALUES (:ID_Orden, :ID_Insumo, :Cantidad, :Medida)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden',  $ID_Orden);
            $stmt->bindValue(':ID_Insumo', $ID_Insumo);
            $stmt->bindValue(':Cantidad', $Cantidad_Solicitadad);
            $stmt->bindValue(':Medida', $Medida);
            return $stmt->execute();
        }

         public function RegistrarDetalleOrden($ID_Orden, $ID_Trabajo){
            $sql = "INSERT INTO detalles_orden_trabajo (ID_Orden_Trabajo, ID_Trabajo, Descripcion)
                    VALUES(:ID_Orden_Trabajo, :ID_Trabajo, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden_Trabajo', $ID_Orden);
            $stmt->bindValue(':ID_Trabajo', $ID_Trabajo );
            return $stmt->execute();
        }

        public function RegistrarDetalleSolicitud($ID_Solicitud, $ID_Producto, $Cantidad, $TipoEquipo, $Descripcion, $EstadoTrabajo){
            $sql = "INSERT INTO detalles_solicitud_orden_trabajo (ID_Solicitud, ID_Producto, Cantidad, Descripcion, Tipo_Producto, Estado_Trabajo)
                    VALUES(:ID_Solicitud, :ID_Producto, :Cantidad, :Descripcion, :Tipo_Producto, :Estado_Trabajo)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Solicitud', $ID_Solicitud);
            $stmt->bindValue(':ID_Producto', $ID_Producto);
            $stmt->bindValue(':Cantidad', $Cantidad);
            $stmt->bindValue(':Descripcion', $Descripcion);
            $stmt->bindValue(':Tipo_Producto', $TipoEquipo);
            $stmt->bindValue(':Estado_Trabajo', $EstadoTrabajo);
            return $stmt->execute();
        }

        public function RegistrarOrdenTrabajo($ID_Usuario, $Centro_Trabajo, $NuevoCodigo, $Prioridad, $Fecha_Generado, $Fecha_InicioF, $Fecha_FinF, $EstadoFirmaVerifica, $Estado_Orden, $Tipo_Trabajo){
            $sql = "INSERT INTO orden_trabajo (ID_Genera, ID_Centro, Numero, Prioridad, Fecha_Generada, Fecha_Entrega_Aprox, Fecha_Inicio, Fecha_Finalizacion, Firma_Verifica, Estado_Firma_Verifica, Estado_Orden, Tipo_Trabajo)
                    VALUES (:ID_Usuario, :ID_Centro, :Numero, :Prioridad, :Fecha_Generada, :Fecha_FinF, :Fecha_InicioF, NULL, NULL, :EstadoFirmaVerifica, :Estado_Orden, :Tipo_Trabajo)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Usuario', $ID_Usuario);
            $stmt->bindValue(':ID_Centro', $Centro_Trabajo);
            $stmt->bindValue(':Numero', $NuevoCodigo);
            $stmt->bindValue(':Prioridad', $Prioridad);
            $stmt->bindValue(':Fecha_Generada', $Fecha_Generado);
            $stmt->bindValue(':Fecha_FinF', $Fecha_FinF);
            $stmt->bindValue(':Fecha_InicioF', $Fecha_InicioF);
            $stmt->bindValue(':EstadoFirmaVerifica', $EstadoFirmaVerifica);
            $stmt->bindValue(':Estado_Orden', $Estado_Orden);
            $stmt->bindValue(':Tipo_Trabajo', $Tipo_Trabajo);
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            } else {
                return false;
            }
        }

        public function RegistrarPausa($ID_Orden, $ID_Usuario, $DescripcionT){
            $sql = "INSERT INTO detalles_pausas_orden_trabajo (ID_Orden_Trabajo, ID_Usuario, Observaciones)
                    VALUES(:ID_Orden, :ID_Usuario, :DescripcionT)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden', $ID_Orden);
            $stmt->bindValue(':ID_Usuario', $ID_Usuario);
            $stmt->bindValue(':DescripcionT', $DescripcionT);
            return $stmt->execute();
        }

        public function RegistarSolicitud($ID_Solicitante, $ID_Supervisor, $ID_Centro, $nuevoCodigo, $Fecha_Solicitud, $EstadoFirmaSupervisor, $Firma_Solicitante, $EstadoTrabajo){
            $sql = "INSERT INTO solicitud_orden_trabajo (Numero, ID_Solicita, ID_Autoriza, ID_Centro, Fecha_Solicitud, Fecha_Firma_Autoriza, Firma_Solicita, Firma_Autoriza, Comentarios, Estado_Orden)
                    VALUES (:Numero, :ID_Solicita, :ID_Autoriza, :ID_Centro, :Fecha_Solicitud, NULL, :Firma_Solicita, NULL, NULL, :Estado_Orden)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':Numero', $nuevoCodigo);
            $stmt->bindValue(':ID_Solicita', $ID_Solicitante);
            $stmt->bindValue(':ID_Autoriza', $ID_Supervisor);
            $stmt->bindValue(':ID_Centro', $ID_Centro);
            $stmt->bindValue(':Fecha_Solicitud', $Fecha_Solicitud);
            $stmt->bindValue(':Firma_Solicita', $Firma_Solicitante);
            $stmt->bindValue(':Estado_Orden', $EstadoTrabajo);
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            } else {
                return false;
            }
        }

        public function RegistrarTecnicoOrden($ID_Orden, $ID_Tecnico, $EstadoFirmaVerifica){
            $sql = "INSERT INTO tecnicos_orden (ID_Orden_Trabajo, ID_Mecanico, Firma_Mecanico, Fecha_Firma_Mecanico, Estado_Firma_Mecanico)
                    VALUES(:ID_Orden_Trabajo, :ID_Tecnico, NULL, NULL, :EstadoFirmaVerifica)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Orden_Trabajo', $ID_Orden);
            $stmt->bindValue(':ID_Tecnico', $ID_Tecnico );
            $stmt->bindValue(':EstadoFirmaVerifica', $EstadoFirmaVerifica);
            return $stmt->execute();
        }

        public function TraerSolicitud() {
            $sql = "SELECT ID, Numero FROM solicitud_orden_trabajo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function TraerSupervisores() {
            $sql ="SELECT * FROM usuario WHERE ID_Cargo = 8 OR ID_Cargo = 11 OR ID_Cargo = 12 OR ID_Cargo = 13";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataSupervisores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataSupervisores;
        }

        public function VerDetallesInsumosOrden($ID){
            $sql = "SELECT insumo_orden.Nombre AS NombreInsumo,
                           insumo_orden.Codigo AS CodigoInsumo,
                           detalles_insumos_orden_trabajo.*
                    FROM detalles_insumos_orden_trabajo
                    LEFT JOIN insumos AS insumo_orden ON detalles_insumos_orden_trabajo.ID_Producto = insumo_orden.ID
                    WHERE detalles_insumos_orden_trabajo.ID_Orden_Trabajo = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerDetalleInsumoTemp($ID){
            $sql = "SELECT insumo_orden.Nombre AS NombreInsumo,
                           insumo_orden.Codigo AS CodigoInsumo,
                           detalles_temp_insumos_orden_trabajo.*
                    FROM detalles_temp_insumos_orden_trabajo
                    LEFT JOIN insumos AS insumo_orden ON detalles_temp_insumos_orden_trabajo.ID_Producto = insumo_orden.ID
                    WHERE detalles_temp_insumos_orden_trabajo.ID_Orden_Trabajo = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerDetallesOrden($ID, $Tipo){
            if ($Tipo === 'Overhauling' || $Tipo === 'MantenimientoP' || $Tipo === 'MantenimientoC'){

                $sql = "SELECT 
                            detalle_orden.Descripcion AS DescripcionFalla, 
                            detalle_orden.Estado_Trabajo AS EstadoTrabajo,
                            detalle_orden.ID AS IDTrabajo,
                            detalles_orden_trabajo.*
                        FROM detalles_orden_trabajo
                        LEFT JOIN trabajos_overhauling AS detalle_orden ON detalles_orden_trabajo.ID_Trabajo = detalle_orden.ID
                        WHERE detalles_orden_trabajo.ID_Orden_Trabajo = :ID";

            } else {
                $sql = "SELECT dt.*, 
                                d.Cantidad, 
                                d.Descripcion AS DescripcionFalla, 
                                d.Tipo_Producto, 
                                d.Estado_Trabajo AS EstadoTrabajo,
                                d.ID AS IDTrabajo,
                                usuario_solicita.NombreCompleto AS NombreSolicita,
                                centro_solicita.Nombre AS NombreCentro,
                                sot.Fecha_Solicitud AS FechaSolicitud,
                        CASE 
                            WHEN d.Tipo_Producto = 'Repuestos' THEN i.Nombre
                            WHEN d.Tipo_Producto = 'Bateria'  THEN b.Nombre
                            WHEN d.Tipo_Producto = 'Cargador' THEN c.Nombre
                        END AS NombreProducto,
                        CASE 
                            WHEN d.Tipo_Producto = 'Repuestos' THEN i.N_Serial
                            WHEN d.Tipo_Producto = 'Bateria' THEN b.N_Serial
                            WHEN d.Tipo_Producto = 'Cargador' THEN c.N_Serial
                        END AS Serie,
                        CASE 
                            WHEN d.Tipo_Producto = 'Repuestos' THEN i.N_Parte
                            WHEN d.Tipo_Producto = 'Bateria' THEN b.N_Parte
                            WHEN d.Tipo_Producto = 'Cargador' THEN c.N_Parte
                        END AS Parte,
                        CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Serie END AS SerieMontacargas,
                        CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Numero END AS NumeroMontacargas,
                        CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Marca END AS MarcaMontacargas,
                        CASE WHEN d.Tipo_Producto = 'Montacargas' THEN m.Modelo END AS ModeloMontacargas

                        FROM detalles_orden_trabajo dt
                        LEFT JOIN  detalles_solicitud_orden_trabajo d ON dt.ID_Trabajo = d.ID
                        LEFT JOIN insumos i ON d.ID_Producto = i.ID  AND d.Tipo_Producto = 'Repuestos'
                        LEFT JOIN insumos b ON d.ID_Producto = b.ID AND d.Tipo_Producto = 'Bateria'
                        LEFT JOIN insumos c ON d.ID_Producto = c.ID AND d.Tipo_Producto = 'Cargador'
                        LEFT JOIN solicitud_orden_trabajo sot ON d.ID_Solicitud = sot.ID
                        LEFT JOIN usuario AS usuario_solicita ON sot.ID_Solicita = usuario_solicita.ID
                        LEFT JOIN centrot AS centro_solicita ON sot.ID_Centro = centro_solicita.ID
                        LEFT JOIN montacargas m ON d.ID_Producto = m.ID 
                        WHERE dt.ID_Orden_Trabajo = :ID";
            }

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerMecanicos($ID) {
            $sql = "SELECT usuario_mecanico.NombreCompleto AS NombreMecanico, 
                           tecnicos_orden.*
                    FROM tecnicos_orden
                    JOIN usuario AS usuario_mecanico ON tecnicos_orden.ID_Mecanico = usuario_mecanico.ID
                    WHERE tecnicos_orden.ID_Orden_Trabajo = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerMontacargas($ID) {
            $sql = "SELECT DISTINCT
                        COALESCE(doi.Marca, m.Marca)   AS Marca,
                        COALESCE(doi.Modelo, m.Modelo) AS Modelo,
                        COALESCE(doi.Serie, m.Serie)   AS Serie,
                        m.Numero                       AS Numero

                    FROM detalles_orden_trabajo dot
                    INNER JOIN trabajos_overhauling tro ON dot.ID_Trabajo = tro.ID
                    LEFT JOIN detalles_overhauling_inicial doi ON tro.ID_Overhauling = doi.ID_Overhauling AND tro.Tipo_Trabajo = 'Overhauling'
                    LEFT JOIN mantenimiento_preventivo mp ON tro.ID_Overhauling = mp.ID_Montacargas AND tro.Tipo_Trabajo = 'MantenimientoP'
                    LEFT JOIN mantenimiento_correctivo mc ON tro.ID_Overhauling = mc.ID_Montacargas AND tro.Tipo_Trabajo = 'MantenimientoC'
                    LEFT JOIN montacargas m ON m.ID = COALESCE(mp.ID_Montacargas, mc.ID_Montacargas)

                    WHERE dot.ID_Orden_Trabajo = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function VerOrden($ID){
            $sql = "SELECT usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_orden.Nombre AS CentroOrden, 
                           orden_trabajo.*
                    FROM orden_trabajo
                    JOIN usuario AS usuario_Supervisor ON orden_trabajo.ID_Genera = usuario_Supervisor.ID
                    JOIN centrot AS centro_orden ON orden_trabajo.ID_Centro = centro_orden.ID
                    WHERE orden_trabajo.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function VerficarOrden($ID_Orden, $ID_Verifica, $Estado_Trabajo, $FirmaVerifica, $Estado_Firma_Trabajo){
            $sql = "UPDATE orden_trabajo 
                    SET Firma_Verifica = :FirmaVerifica, Estado_Firma_Verifica = :Estado_Firma_Trabajo, Estado_Orden = :Estado
                    WHERE ID = :ID_Orden AND ID_Genera = :ID_Verifica";

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado_Trabajo);
            $stmt->bindParam(':ID_Verifica', $ID_Verifica);
            $stmt->bindParam(':FirmaVerifica', $FirmaVerifica);
            $stmt->bindParam(':Estado_Firma_Trabajo', $Estado_Firma_Trabajo);
            $stmt->bindParam(':ID_Orden', $ID_Orden);

            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            return false;
        }

        public function VerSolicitud($ID){
            $sql = "SELECT usuario_Solicita.NombreCompleto AS NombreSolicita,
                           usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_solicita.Nombre AS CentroSolicita, 
                           solicitud_orden_trabajo.*
                    FROM solicitud_orden_trabajo
                    LEFT JOIN usuario AS usuario_Solicita ON solicitud_orden_trabajo.ID_Solicita  = usuario_Solicita.ID
                    LEFT JOIN usuario AS usuario_Supervisor ON solicitud_orden_trabajo.ID_Autoriza  = usuario_Supervisor.ID
                    LEFT JOIN centrot AS centro_solicita ON solicitud_orden_trabajo.ID_Centro = centro_solicita.ID
                    WHERE solicitud_orden_trabajo.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>