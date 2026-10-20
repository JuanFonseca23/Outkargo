<?php
    class Mantenimientos {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function ActualizarID_Salida($ID_Salida, $ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico){
            $sql = "UPDATE salida_insumos 
                    SET  Fecha_Firma_Recibe = :FechaFirma, Firma_Recibe = :Firma,  Firma_Estado_Recibe = :EstadoFirmaMecanico
                    WHERE ID_Origen = :ID_Mantenimiento AND ID_Recibe  = :ID_Mecanico AND ID = :ID_Salida";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Salida', $ID_Salida);
            $stmt->bindParam(':ID_Mantenimiento', $ID_Mantenimiento);
            $stmt->bindParam(':ID_Mecanico', $ID_Mecanico);
            $stmt->bindParam(':Firma', $Firma);
            $stmt->bindParam(':FechaFirma', $FechaFirma);
            $stmt->bindParam(':EstadoFirmaMecanico', $EstadoFirmaMecanico);
            return $stmt->execute();
        }

        public function ActualizarDetallesCorrectivos($ID_Detalle, $Categoria, $Descripcion, $Seccion){
            if($Categoria === 'falla'){
                $sql = "UPDATE detalles_mantenimiento_correctivo
                        SET Seccion = :Seccion, Descripcion_Falla = :Descripcion
                        WHERE ID = :ID_Detalle";
            }else{
                $sql = "UPDATE detalles_mantenimiento_correctivo
                        SET Seccion = :Seccion, Reparacion_Realizada = :Descripcion
                        WHERE ID = :ID_Detalle";
            }
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Detalle', $ID_Detalle);
            $stmt->bindParam(':Descripcion', $Descripcion);
            $stmt->bindParam(':Seccion', $Seccion);
            return $stmt->execute();
        }

        public function ContarMantenimientos($Estado) {
            $sql = "SELECT COUNT(*) as NoMantenimientos  FROM mantenimiento_preventivo WHERE Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ContarMantenimientosCorrectivos($Estado) {
            $sql = "SELECT COUNT(*) as NoMantenimientos FROM mantenimiento_correctivo WHERE Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function CrearDetalleMantenimientoBorrador($ID_Mantenimiento){
            $sql = "INSERT INTO detalles_mantenimiento_preventivo (ID_Mantenimiento) VALUES (:ID_Mantenimiento)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID_Mantenimiento);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function CrearMantenimientoBorrador($ID_Usuario, $NuevoCodigo, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Estado_Firma, $Externo, $Operario_Externo, $TipoMontacargas, $TipoMantenimiento){
            $sql = "INSERT INTO mantenimiento_preventivo (ID_Usuario, Numero, ID_Montacargas, ID_Centro, ID_Area, ID_Supervisor, ID_Operario, ID_Recibe, Hora_Inicio, Hora_Finalizacion, Fecha_Realizado, Firma_Operario, Firma_Supervisor, Estado_Firma_Supervisor, Estado_Firma_Operario, Fecha_Firma_Operario, Fecha_Firma_Supervisor, Tipo, Tipo_Mantenimiento, Externo, Nombre_Externo, ExternoRecibe, Nombre_Externo_Recibe, Estado)
                    VALUES (:ID_Usuario, :Numero, :ID_Montacargas, :ID_Centro, :ID_Area, NULL, :ID_Operario, NULL, NULL, NULL, :Fecha, NULL, NULL, :Estado_Firma, :Estado_Firma, NULL, NULL, :TipoMontacargas, :TipoMantenimiento, :Externo, :Operario_Externo, NULL, NULL, 'BORRADOR')";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':Numero', $NuevoCodigo);
            $stmt->bindParam(':ID_Montacargas', $ID_Montacargas);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':ID_Area', $ID_Area);
            $stmt->bindParam(':ID_Operario', $ID_Operario);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Estado_Firma', $Estado_Firma);
            $stmt->bindParam(':Externo', $Externo);
            $stmt->bindParam(':Operario_Externo', $Operario_Externo);
            $stmt->bindParam(':TipoMontacargas', $TipoMontacargas);
            $stmt->bindParam(':TipoMantenimiento', $TipoMantenimiento);
            // $stmt->bindParam(':HoraInicio', $HoraInicio);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function CrearMantenimientoCorrectivoBorrador($ID_Usuario, $NuevoCodigo, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Estado_Firma, $Externo, $Operario_Externo, $Tipo_Montacargas){
            $sql = "INSERT INTO mantenimiento_correctivo (ID_Usuario, Numero, ID_Montacargas, ID_Orden_Trabajo, ID_Centro, ID_Area, ID_Supervisor, ID_Operario, ID_Recibe, Hora_Inicio, Hora_Finalizacion, Fecha_Realizado, Firma_Operario, Firma_Supervisor, Estado_Firma_Supervisor, Estado_Firma_Operario, Fecha_Firma_Operario, Fecha_Firma_Supervisor, Externo, Nombre_Externo,  ExternoRecibe, Nombre_Externo_Recibe, Horometro, Observaciones, Tipo_Montacargas, Estado)
                    VALUES (:ID_Usuario, :Numero, :ID_Montacargas, NULL, :ID_Centro, :ID_Area, NULL, :ID_Operario, NULL, NULL, NULL, :Fecha, NULL, NULL, :Estado_Firma, :Estado_Firma, NULL, NULL, :Externo, :Operario_Externo, NULL, NULL, NULL, NULL, :Tipo_Montacargas,'BORRADOR')";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':Numero', $NuevoCodigo);
            $stmt->bindParam(':ID_Montacargas', $ID_Montacargas);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':ID_Area', $ID_Area);
            $stmt->bindParam(':ID_Operario', $ID_Operario);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Estado_Firma', $Estado_Firma);
            $stmt->bindParam(':Externo', $Externo);
            $stmt->bindParam(':Operario_Externo', $Operario_Externo);
            $stmt->bindParam(':Tipo_Montacargas', $Tipo_Montacargas);
            // $stmt->bindParam(':HoraInicio', $HoraInicio);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function EliminarBorrador($ID, $Tipo_Mantenimiento){
            try {

                // Iniciar transacción
                $this->PDO->beginTransaction();

                /* 1. OBTENER RUTAS DE LAS IMÁGENES */
                $sql = "SELECT Evidencia_Fotografica FROM mantenimiento_preventivo_imagenes WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);
                $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);

                /* 2. ELIMINAR INSUMOS */

                $sql = "DELETE FROM detalles_insumos_mantenimientos WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);


                /* 3. ELIMINAR NOVEDADES */
                $sql = "DELETE FROM novedades_mantenimiento WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);

                /* 4. ELIMINAR DETALLE PREVENTIVO */
                $sql = "DELETE FROM detalles_mantenimiento_preventivo  WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);

                /* 5. ELIMINAR TÉCNICOS */
                $sql = "DELETE FROM mantenimiento_preventivo_mecanicos WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);

                /* 6. ELIMINAR REGISTROS DE IMÁGENES */
                $sql = "DELETE FROM mantenimiento_preventivo_imagenes WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);

                /* 7. ELIMINAR MANTENIMIENTO PRINCIPAL */
                $sql = "DELETE FROM mantenimiento_preventivo  WHERE ID = :ID_Mantenimiento AND Estado = 'BORRADOR'";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);
                $this->PDO->commit();
                foreach ($imagenes as $ruta) {
                    if (empty($ruta)) {
                        continue;
                    }
                    $rutaFisica = $ruta;
                    if (file_exists($rutaFisica)) {
                        if (!unlink($rutaFisica)) {
                            error_log("No se pudo eliminar la imagen: " . $rutaFisica);
                        }
                    }
                }
                return true;
            } catch (Exception $e) {
                if ($this->PDO->inTransaction()) {$this->PDO->rollBack();}
                error_log( "Error al eliminar el mantenimiento completo: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarBorradorCorrectivo($ID, $Tipo_Mantenimiento){
            try {

                // Iniciar transacción
                $this->PDO->beginTransaction();
                /* 1. OBTENER RUTAS DE LAS IMÁGENES */
                $sql = "SELECT Evidencia_Fotografica FROM mantenimiento_correctivo_imagenes WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);
                $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);
                /* 2. ELIMINAR INSUMOS */
                $sql = "DELETE FROM detalles_insumos_mantenimientos WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);
                /* 3. ELIMINAR REPUESTOS */
                $sql = "DELETE FROM detalles_repuestos_mantenimientos WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);
                /* 4. ELIMINAR NOVEDADES */
                $sql = "DELETE FROM novedades_mantenimiento WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);
                /* 5. ELIMINAR DETALLE PREVENTIVO */
                $sql = "DELETE FROM detalles_mantenimiento_correctivo  WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);

                /* 6. ELIMINAR TÉCNICOS */
                $sql = "DELETE FROM mantenimiento_correctivo_mecanicos WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);

                /* 7. ELIMINAR REGISTROS DE IMÁGENES */
                $sql = "DELETE FROM mantenimiento_correctivo_imagenes WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);
                /* 8. ELIMINAR MANTENIMIENTO PRINCIPAL */
                $sql = "DELETE FROM mantenimiento_correctivo  WHERE ID = :ID_Mantenimiento AND Estado = 'BORRADOR'";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Mantenimiento' => $ID]);
                $this->PDO->commit();
                foreach ($imagenes as $ruta) {
                    if (empty($ruta)) {
                        continue;
                    }
                    $rutaFisica = $ruta;
                    if (file_exists($rutaFisica)) {
                        if (!unlink($rutaFisica)) {
                            error_log("No se pudo eliminar la imagen: " . $rutaFisica);
                        }
                    }
                }
                return true;
            } catch (Exception $e) {
                if ($this->PDO->inTransaction()) {$this->PDO->rollBack();}
                error_log( "Error al eliminar el mantenimiento completo: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarDetalle($ID_Detalle, $ID_Novedad){
            try{
                //Inciamos la transacción 
                $this->PDO->beginTransaction();
                //1. Obtener rutas de las imagenes
                $sql = "SELECT Evidencia_Fotografica FROM mantenimiento_correctivo_imagenes WHERE ID_Detalle = :ID_Detalle";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Detalle' => $ID_Detalle]);
                $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // 2. Eliminar Imagenes
                $sql = "DELETE FROM mantenimiento_correctivo_imagenes WHERE ID_Detalle = :ID_Detalle";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Detalle' => $ID_Detalle]);

                //3. Eliminar Detalle
                $sql = "DELETE FROM detalles_mantenimiento_correctivo WHERE ID = :ID_Detalle";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Detalle' => $ID_Detalle]);

                foreach ($imagenes as $ruta) {
                    if (empty($ruta)) {
                        continue;
                    }
                    $rutaFisica = $ruta;
                    if (file_exists($rutaFisica)) {
                        if (!unlink($rutaFisica)) {
                            error_log("No se pudo eliminar la imagen: " . $rutaFisica);
                        }
                    }
                }

                if (!empty($ID_Novedad)) {
                    $sql = "UPDATE novedades_mantenimiento SET Estado_Novedad = 'Pendiente', ID_Correccion = NULL, Fecha_Correccion = NULL WHERE ID = :ID_Novedad";
                    $stmt = $this->PDO->prepare($sql);
                    $stmt->execute([':ID_Novedad' => $ID_Novedad]);
                }

                $this->PDO->commit();
                return true;
            } catch (Exception $e) {
                if ($this->PDO->inTransaction()) {$this->PDO->rollBack();}
                error_log( "Error al eliminar el detalle completo: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarImagen($ID){
            try {
                // 1. Obtener ruta
                $sql = "SELECT Evidencia_Fotografica FROM mantenimiento_preventivo_imagenes WHERE ID = :ID";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
                $stmt->execute();
                $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$imagen) {
                    return false;
                }

                $ruta = $imagen['Evidencia_Fotografica'];

                // 2. Eliminar registro BD
                $sql = "DELETE FROM mantenimiento_preventivo_imagenes WHERE ID = :ID";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    return false;
                }

                // 3. Eliminar archivo físico
                if ( !empty($ruta) && file_exists($ruta)) {        
                    unlink($ruta);
                }
                return true;

            } catch (Exception $e) {
                error_log("Error al eliminar imagen: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarImagenCorrectivo($ID_Detalle, $imagenesEliminar){
            try {
                // 1. Recorrer los ID de las imágenes que se van a eliminar
                foreach ($imagenesEliminar as $ID) {
                    // 2. Obtener la ruta de la imagen
                    $sql = "SELECT Evidencia_Fotografica FROM mantenimiento_correctivo_imagenes WHERE ID = :ID AND ID_Detalle = :ID_Detalle";
                    $stmt = $this->PDO->prepare($sql);
                    $stmt->bindValue(':ID', (int)$ID, PDO::PARAM_INT);
                    $stmt->bindValue(':ID_Detalle', (int)$ID_Detalle, PDO::PARAM_INT);
                    $stmt->execute();
                    $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Si no existe o no pertenece al detalle, continuar
                    if (!$imagen) {
                        continue;
                    }

                    $ruta = $imagen['Evidencia_Fotografica'];
                    // 3. Eliminar el registro de la base de datos
                    $sql = "DELETE FROM mantenimiento_correctivo_imagenes WHERE ID = :ID AND ID_Detalle = :ID_Detalle";
                    $stmt = $this->PDO->prepare($sql);
                    $stmt->bindValue(':ID', (int)$ID, PDO::PARAM_INT);
                    $stmt->bindValue(':ID_Detalle', (int)$ID_Detalle, PDO::PARAM_INT);
                    if (!$stmt->execute()) {
                        return false;
                    }
                    // 4. Eliminar el archivo físico del servidor
                    if (!empty($ruta)) {
                        $rutaFisica = $ruta;
                        if (file_exists($rutaFisica) && is_file($rutaFisica)) {
                            if (!unlink($rutaFisica)) {
                                error_log("No se pudo eliminar el archivo: " . $rutaFisica);
                            }
                        }
                    }
                }
                return true;
            } catch (Throwable $e) {
                error_log("Error al eliminar imágenes correctivas: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarInsumo($ID_Mantenimiento, $ID_Insumo, $Tipo_Mantenimiento) {
            try {
                $sql = "DELETE FROM detalles_insumos_mantenimientos 
                        WHERE ID_Mantenimiento = :ID_Mantenimiento AND ID_Insumo = :ID_Insumo AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID_Mantenimiento,
                    ':ID_Insumo' => $ID_Insumo,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);

                if ($stmt->rowCount() === 0) {
                    error_log("NO se eliminó ningún registro");
                    return false;
                }

                return true;

            } catch (Exception $e) {
                error_log("Error al eliminar insumo: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento) {
            try {
                $sql = "DELETE FROM novedades_mantenimiento  WHERE ID_Mantenimiento = :ID_Mantenimiento  AND ID = :ID_Novedad AND Tipo_Mantenimiento = :Tipo_Mantenimiento";

                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID_Mantenimiento,
                    ':ID_Novedad' => $ID_Novedad,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);

                if ($stmt->rowCount() === 0) {
                    error_log("NO se eliminó ningún registro");
                    return false;
                }

                return true;

            } catch (Exception $e) {
                error_log("Error al eliminar novedad: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarNovedadCorrectivo($ID_Novedad) {
            try {
                $sql = "DELETE FROM novedades_mantenimiento  WHERE ID = :ID_Novedad";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([':ID_Novedad' => $ID_Novedad,]);
                if ($stmt->rowCount() === 0) {
                    error_log("NO se eliminó ningún registro");
                    return false;
                }
                return true;

            } catch (Exception $e) {
                error_log("Error al eliminar novedad: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarObservacionCorrectivo($ID_Mantenimiento, $Indice){
            try {
                $sql = "SELECT Observaciones FROM mantenimiento_correctivo WHERE ID = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$resultado) {
                    return false;
                }

                // Decodificar el arreglo JSON almacenado
                $observaciones = json_decode(
                    $resultado['Observaciones'] ?? '[]',
                    true
                );

                if (!is_array($observaciones)) {
                    return false;
                }

                // Validar el índice solicitado
                if (!is_numeric($Indice) || (int)$Indice < 0 || (int)$Indice >= count($observaciones)) {
                    return false;
                }

                // Eliminar solo la observación seleccionada
                array_splice($observaciones, (int)$Indice, 1);

                // Convertir nuevamente a JSON
                $jsonObservaciones = json_encode(array_values($observaciones),JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                if ($jsonObservaciones === false) {
                    return false;
                }
                // Actualizar el campo en la base de datos
                $sql = "UPDATE mantenimiento_correctivo SET Observaciones = :Observaciones WHERE ID = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Observaciones', $jsonObservaciones, PDO::PARAM_STR);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                return $stmt->execute();
            } catch (PDOException $e) {
                error_log('Error al eliminar observación: ' . $e->getMessage());
                return false;
            }
        }

        public function EliminarRepuesto($ID_Mantenimiento, $ID_Repuesto, $Tipo_Mantenimiento) {
            try {
                $sql = "DELETE FROM detalles_repuestos_mantenimientos 
                        WHERE ID_Mantenimiento = :ID_Mantenimiento AND ID_Insumo = :ID_Insumo AND Tipo_Mantenimiento = :Tipo_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID_Mantenimiento,
                    ':ID_Insumo' => $ID_Repuesto,
                    ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                ]);

                if ($stmt->rowCount() === 0) {
                    error_log("NO se eliminó ningún registro");
                    return false;
                }

                return true;

            } catch (Exception $e) {
                error_log("Error al eliminar repuesto: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarTecnico($ID_Mantenimiento, $ID_Tecnico){
            try {
                $sql = "DELETE FROM mantenimiento_preventivo_mecanicos 
                        WHERE ID_Mantenimiento = :ID_Mantenimiento 
                        AND ID_Mecanico = :ID_Tecnico";

                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID_Mantenimiento,
                    ':ID_Tecnico' => $ID_Tecnico
                ]);

                if ($stmt->rowCount() === 0) {
                    error_log("NO se eliminó ningún registro");
                    return false;
                }

                return true;

            } catch (Exception $e) {
                error_log("Error al eliminar técnico: " . $e->getMessage());
                return false;
            }
        }

        public function EliminarTecnicoCorrectivo($ID_Mantenimiento, $ID_Tecnico){
            try {
                $sql = "DELETE FROM mantenimiento_correctivo_mecanicos WHERE ID_Mantenimiento = :ID_Mantenimiento AND ID_Mecanico = :ID_Tecnico";
                $stmt = $this->PDO->prepare($sql);
                $stmt->execute([
                    ':ID_Mantenimiento' => $ID_Mantenimiento,
                    ':ID_Tecnico' => $ID_Tecnico
                ]);
                if ($stmt->rowCount() === 0) {
                    error_log("NO se eliminó ningún registro");
                    return false;
                }
                return true;
            } catch (Exception $e) {
                error_log("Error al eliminar técnico: " . $e->getMessage());
                return false;
            }
        }

        public function FinalizarMantenimiento($ID_Mantenimiento,$ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Estado, $Horometro, $ID_Montacargas){
            try {
                /* 1. ACTUALIZAR MANTENIMIENTO PRINCIPAL */
                $sql = "UPDATE mantenimiento_preventivo SET
                            ID_Supervisor = :ID_Supervisor,
                            ID_Recibe = :ID_Recibe,
                            Hora_Inicio = :HoraInicio,
                            Hora_Finalizacion = :HoraFinal,
                            ExternoRecibe = :Externo,
                            Nombre_Externo_Recibe = :Nombre_Recibe,
                            Estado = :Estado
                        WHERE ID = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Supervisor', $ID_Supervisor);
                $stmt->bindValue(':ID_Recibe', $ID_Recibe);
                $stmt->bindValue(':HoraInicio',$HoraInicio);
                $stmt->bindValue(':HoraFinal',$HoraFinal);
                $stmt->bindValue(':Externo',$Externo);
                $stmt->bindValue(':Nombre_Recibe',$Nombre_Recibe);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mantenimiento',$ID_Mantenimiento);
                if (!$stmt->execute()) {
                    return false;
                }

                /* 2. ACTUALIZAR DETALLE PREVENTIVO */
                $sql = "UPDATE detalles_mantenimiento_preventivo SET Horometro = :Horometro WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Horometro',$Horometro);
                $stmt->bindValue(':ID_Mantenimiento',$ID_Mantenimiento);
                if (!$stmt->execute()) {
                    return false;
                }

                $sql = "UPDATE montacargas SET Horometro = :Horometro WHERE ID = :ID_Montacargas";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Horometro',$Horometro);
                $stmt->bindValue(':ID_Montacargas',$ID_Montacargas);
                if (!$stmt->execute()) {
                    return false;
                }

                return true;
            } catch (Exception $e) {

                error_log(
                    "Error al finalizar mantenimiento: " .
                    $e->getMessage()
                );
                return false;
            }
        }

        public function FinalizarMantenimientoCorrectivo($ID_Mantenimiento,$ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Estado, $Horometro, $ID_Montacargas){
            try {
                /* 1. ACTUALIZAR MANTENIMIENTO PRINCIPAL */
                $sql = "UPDATE mantenimiento_correctivo SET
                            ID_Supervisor = :ID_Supervisor,
                            ID_Recibe = :ID_Recibe,
                            Hora_Inicio = :HoraInicio,
                            Hora_Finalizacion = :HoraFinal,
                            ExternoRecibe = :Externo,
                            Nombre_Externo_Recibe = :Nombre_Recibe,
                            Estado = :Estado,
                            Horometro = :Horometro
                        WHERE ID = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Supervisor', $ID_Supervisor);
                $stmt->bindValue(':ID_Recibe', $ID_Recibe);
                $stmt->bindValue(':HoraInicio',$HoraInicio);
                $stmt->bindValue(':HoraFinal',$HoraFinal);
                $stmt->bindValue(':Externo',$Externo);
                $stmt->bindValue(':Nombre_Recibe',$Nombre_Recibe);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':Horometro',$Horometro);
                $stmt->bindValue(':ID_Mantenimiento',$ID_Mantenimiento);
                if (!$stmt->execute()) {
                    return false;
                }
                /* 2. ACTUALIZAR HOROMETRO  EN LA MONTACARGAS*/
                $sql = "UPDATE montacargas SET Horometro = :Horometro WHERE ID = :ID_Montacargas";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Horometro',$Horometro);
                $stmt->bindValue(':ID_Montacargas',$ID_Montacargas);
                if (!$stmt->execute()) {
                    return false;
                }
                return true;
            } catch (Exception $e) {
                error_log(
                    "Error al finalizar mantenimiento: " .
                    $e->getMessage()
                );
                return false;
            }
        }

        public function FirmarMantenimientoCorrectivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_correctivo_mecanicos 
                        SET 
                            Firma_Mecanico = :Firma,
                            Fecha_Firma_Mecanico = :Fecha,
                            Estado_Firma_Mecanico = :Estado
                        WHERE ID_Mecanico = :ID_Mecanico AND ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Firma', $Firma);
                $stmt->bindValue(':Fecha', $Fecha);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mecanico', $ID_Mecanico2);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
                $stmt->execute();
                $this->PDO->commit();
                return true;
            }catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log(
                    'Archivo: ' . $e->getFile() . 
                    'Línea: ' . $e->getLine()
                );
                return false;
            }
        }

        public function FirmarMantenimientoCorrectivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_correctivo 
                        SET 
                            Firma_Operario = :Firma,
                            Fecha_Firma_Operario = :Fecha,
                            Estado_Firma_Operario = :Estado
                        WHERE ID = :ID_Mantenimiento"; 
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Firma', $Firma);
                $stmt->bindValue(':Fecha', $Fecha);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
                $stmt->execute();
                $this->PDO->commit();
                return true;
            }catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log(
                    'Archivo: ' . $e->getFile() . 
                    'Línea: ' . $e->getLine()
                );
                return false;
            }
        }

        public function FirmarMantenimientoCorrectivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_correctivo 
                        SET 
                            Firma_Supervisor = :Firma,
                            Fecha_Firma_Supervisor = :Fecha,
                            Estado_Firma_Supervisor = :Estado
                        WHERE ID = :ID_Mantenimiento"; 
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Firma', $Firma);
                $stmt->bindValue(':Fecha', $Fecha);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
                $stmt->execute();
                $this->PDO->commit();
                return true;
            }catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log(
                    'Archivo: ' . $e->getFile() . 
                    'Línea: ' . $e->getLine()
                );
                return false;
            }
        }

        public function TieneFirmasTecnicosRegistradas($ID_Mantenimiento, $Tipo_Mantenimiento){
            $tabla = $Tipo_Mantenimiento === 'Preventivo'
                ? 'mantenimiento_preventivo_mecanicos'
                : ($Tipo_Mantenimiento === 'Correctivo' ? 'mantenimiento_correctivo_mecanicos' : null);
            if ($tabla === null) {
                return false;
            }

            $sql = "SELECT COUNT(*) FROM `{$tabla}`
                    WHERE ID_Mantenimiento = :ID_Mantenimiento
                      AND Estado_Firma_Mecanico = 1
                      AND Firma_Mecanico IS NOT NULL
                      AND Firma_Mecanico <> ''";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute([':ID_Mantenimiento' => $ID_Mantenimiento]);
            return (int)$stmt->fetchColumn() > 0;
        }

        /**
         * Revierte el cierre de un mantenimiento cuando su salida de inventario
         * falla: limpia las firmas de mecánicos y devuelve el estado a BORRADOR.
         */
        public function RevertirFirmasMantenimientoPorSalidaFallida($ID_Mantenimiento, $Tipo_Mantenimiento){
            $esPreventivo = $Tipo_Mantenimiento === 'Preventivo';
            if (!$esPreventivo && $Tipo_Mantenimiento !== 'Correctivo') {
                return false;
            }

            $tablaMantenimiento = $esPreventivo ? 'mantenimiento_preventivo' : 'mantenimiento_correctivo';
            $tablaTecnicos = $esPreventivo ? 'mantenimiento_preventivo_mecanicos' : 'mantenimiento_correctivo_mecanicos';

            try {
                $this->PDO->beginTransaction();
                $stmtFirmas = $this->PDO->prepare("UPDATE `{$tablaTecnicos}`
                    SET Firma_Mecanico = NULL,
                        Fecha_Firma_Mecanico = NULL,
                        Estado_Firma_Mecanico = 0
                    WHERE ID_Mantenimiento = :ID_Mantenimiento");
                $stmtFirmas->execute([':ID_Mantenimiento' => $ID_Mantenimiento]);

                $stmtEstado = $this->PDO->prepare("UPDATE `{$tablaMantenimiento}`
                    SET Estado = 'BORRADOR'
                    WHERE ID = :ID_Mantenimiento");
                $stmtEstado->execute([':ID_Mantenimiento' => $ID_Mantenimiento]);

                if ($stmtEstado->rowCount() < 1) {
                    throw new RuntimeException('No se pudo devolver el mantenimiento a BORRADOR.');
                }

                $this->PDO->commit();
                return true;
            } catch (Throwable $error) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('Error al revertir firmas del mantenimiento ' . $ID_Mantenimiento . ': ' . $error->getMessage());
                return false;
            }
        }

        public function FirmarMantenimientoCorrectivosTecnicos($ID_Mantenimiento, $Firmas, $Fecha, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_correctivo_mecanicos 
                        SET Firma_Mecanico = :Firma,
                            Fecha_Firma_Mecanico = :Fecha,
                            Estado_Firma_Mecanico = :Estado
                        WHERE ID_Mecanico = :ID_Tecnico AND ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                foreach ($Firmas as $firma) {
                    $ID_Tecnico = intval($firma['ID_Tecnico'] ?? 0);
                    $Firma = $firma['Firma'] ?? null;
                    $stmt->execute([
                        ':Firma' => $Firma,
                        ':Fecha' => $Fecha,
                        ':Estado' => $Estado,
                        ':ID_Tecnico' => $ID_Tecnico,
                        ':ID_Mantenimiento' => $ID_Mantenimiento
                    ]);
                }
                $this->PDO->commit();
                return true;

            } catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log('Archivo: ' . $e->getFile() . ' Línea: ' . $e->getLine());
                return false;
            }
        }

        public function FirmarMantenimientoPreventivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_preventivo_mecanicos 
                        SET 
                            Firma_Mecanico = :Firma,
                            Fecha_Firma_Mecanico = :Fecha,
                            Estado_Firma_Mecanico = :Estado
                        WHERE ID_Mecanico = :ID_Mecanico AND ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Firma', $Firma);
                $stmt->bindValue(':Fecha', $Fecha);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mecanico', $ID_Mecanico2);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
                $stmt->execute();
                $this->PDO->commit();
                return true;
            }catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log(
                    'Archivo: ' . $e->getFile() . 
                    'Línea: ' . $e->getLine()
                );
                return false;
            }
        }

        public function FirmarMantenimientoPreventivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_preventivo 
                        SET 
                            Firma_Operario = :Firma,
                            Fecha_Firma_Operario = :Fecha,
                            Estado_Firma_Operario = :Estado
                        WHERE ID = :ID_Mantenimiento"; 
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Firma', $Firma);
                $stmt->bindValue(':Fecha', $Fecha);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
                $stmt->execute();
                $this->PDO->commit();
                return true;
            }catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log(
                    'Archivo: ' . $e->getFile() . 
                    'Línea: ' . $e->getLine()
                );
                return false;
            }
        }

        public function FirmarMantenimientoPreventivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_preventivo 
                        SET 
                            Firma_Supervisor = :Firma,
                            Fecha_Firma_Supervisor = :Fecha,
                            Estado_Firma_Supervisor = :Estado
                        WHERE ID = :ID_Mantenimiento"; 
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Firma', $Firma);
                $stmt->bindValue(':Fecha', $Fecha);
                $stmt->bindValue(':Estado', $Estado);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
                $stmt->execute();
                $this->PDO->commit();
                return true;
            }catch (Throwable $e) {
                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }
                error_log('ERROR MODELO FIRMAS: ' . $e->getMessage());
                error_log(
                    'Archivo: ' . $e->getFile() . 
                    'Línea: ' . $e->getLine()
                );
                return false;
            }
        }

        public function FirmarMantenimientoPreventivoTecnicos($ID_Mantenimiento, $Firmas, $Fecha, $Estado){
            try {
                $this->PDO->beginTransaction();
                $sql = "UPDATE mantenimiento_preventivo_mecanicos 
                        SET 
                            Firma_Mecanico = :Firma,
                            Fecha_Firma_Mecanico = :Fecha,
                            Estado_Firma_Mecanico = :Estado
                        WHERE ID_Mecanico = :ID_Tecnico AND ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                foreach ($Firmas as $firma) {
                    $ID_Tecnico = intval($firma['ID_Tecnico'] ?? 0);
                    $Firma = $firma['Firma'] ?? null;
                    $stmt->execute([
                        ':Firma' => $Firma,
                        ':Fecha' => $Fecha,
                        ':Estado' => $Estado,
                        ':ID_Tecnico' => $ID_Tecnico,
                        ':ID_Mantenimiento' => $ID_Mantenimiento
                    ]);
                }

                $this->PDO->commit();

                return true;

            } catch (Throwable $e) {

                if ($this->PDO->inTransaction()) {
                    $this->PDO->rollBack();
                }

                error_log(
                    'ERROR MODELO FIRMAS: ' . $e->getMessage()
                );

                error_log(
                    'Archivo: ' . 
                    $e->getFile() . 
                    ' Línea: ' . 
                    $e->getLine()
                );

                return false;
            }
        }

        public function GuardarCriterio($ID_Detalle, $campo, $valor) {
            try {
                error_log("=== GuardarCriterio ===");
                error_log("ID_Detalle: " . $ID_Detalle);
                error_log("Campo: " . $campo);
                error_log("Valor: " . $valor);

                $sql = "UPDATE detalles_mantenimiento_preventivo SET $campo = :valor WHERE ID = :ID_Detalle";
                error_log("SQL: " . $sql);
                $stmt = $this->PDO->prepare($sql);
                error_log("Prepare ejecutado");
                $stmt->bindParam(':valor', $valor);
                $stmt->bindParam(':ID_Detalle', $ID_Detalle);
                error_log("Parámetros asignados");
                $resultado = $stmt->execute();
                error_log("Resultado execute: " . ($resultado ? 'TRUE' : 'FALSE'));
                return $resultado;
            } catch (Exception $e) {
                error_log("ERROR GuardarCriterio: " . $e->getMessage());
                return false;
            }
        }

        public function GuardarDetallesCorrectivos($ID_Mantenimiento, $DescripcionFalla, $DescripcionCorreccion, $Seccion, $ID_Novedad, $Fecha){
            $Estado = 'Realizado';
            $sql = "INSERT INTO detalles_mantenimiento_correctivo(ID_Mantenimiento, ID_Detalle, Seccion, Descripcion_Falla, Reparacion_Realizada)
                    VALUES (:ID_Mantenimiento, :ID_Novedad, :Seccion, :DescripcionFalla, :DescripcionCorreccion)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento);
            $stmt->bindValue(':ID_Novedad', $ID_Novedad);
            $stmt->bindValue(':Seccion', $Seccion);
            $stmt->bindValue(':DescripcionFalla', $DescripcionFalla);
            $stmt->bindValue(':DescripcionCorreccion', $DescripcionCorreccion);
            if($stmt->execute()) {
                $ID_Detalle = $this->PDO->lastInsertId(); 
                if($ID_Novedad !== null) {
                    $updateNovedad = $this->PDO->prepare("UPDATE novedades_mantenimiento SET Estado_Novedad = :Estado, 	ID_Correccion = :ID_Mantenimiento, Fecha_Correccion = :Fecha WHERE ID = :ID_Novedad");
                    $updateNovedad->bindParam(":Estado", $Estado);
                    $updateNovedad->bindParam(":Fecha", $Fecha);
                    $updateNovedad->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
                    $updateNovedad->bindParam(":ID_Novedad", $ID_Novedad);
                    $updateNovedad->execute();
                    if ($updateNovedad->rowCount() === 0) {
                        error_log("No se actualizó ninguna novedad con ID: " . $ID_Novedad);
                    }else{
                        return $ID_Detalle;
                    }
                }else{
                    return $ID_Detalle;
                }
            } else {
                return false; 
            }   
        }

        public function GuardarImagen($ID_Mantenimiento, $Categoria, $Archivo){
            $sql = "INSERT INTO mantenimiento_preventivo_imagenes (ID_Mantenimiento, Categoria, Evidencia_Fotografica)
                    VALUES (:ID_Mantenimiento, :Categoria, :Evidencia_Fotografica)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
            $stmt->bindValue(':Categoria', $Categoria);
            $stmt->bindValue(':Evidencia_Fotografica',$Archivo);
            if (!$stmt->execute()) {
                return false;
            }
            return [
                'id' => $this->PDO->lastInsertId(),
                'ruta' => $Archivo
            ];
        }

        public function GuardarImagenCorrectivo($ID_Mantenimiento, $ID_Detalle, $Archivo, $Categoria){
            $sql = "INSERT INTO mantenimiento_correctivo_imagenes (ID_Mantenimiento, ID_Detalle, Categoria, Evidencia_Fotografica)
                    VALUES (:ID_Mantenimiento, :ID_Detalle, :Categoria, :Evidencia_Fotografica)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
            $stmt->bindValue(':ID_Detalle', $ID_Detalle, PDO::PARAM_INT); 
            $stmt->bindValue(':Categoria', $Categoria);
            $stmt->bindValue(':Evidencia_Fotografica',$Archivo);
            if (!$stmt->execute()) {
                return false;
            }
            return [
                'id' => $this->PDO->lastInsertId(),
                'ruta' => $Archivo
            ];
        }

        public function GuardarInsumos($ID_Mantenimiento, $Insumos, $Tipo_Mantenimiento) {
            try {
                $this->PDO->beginTransaction();
                $sqlInsert = "INSERT INTO detalles_insumos_mantenimientos (ID_Mantenimiento, ID_Insumo, Cantidad, Medida, Tipo_Mantenimiento)
                              VALUES (:ID_Mantenimiento, :ID_Insumo, :Cantidad, :Medida, :Tipo_Mantenimiento)";
                $stmt = $this->PDO->prepare($sqlInsert);
                foreach ($Insumos as $Insumo) {
                    try {
                        $stmt->execute([
                            ':ID_Mantenimiento' => $ID_Mantenimiento,
                            ':ID_Insumo' => $Insumo['id'],
                            ':Cantidad' => $Insumo['cantidad'],
                            ':Medida' => $Insumo['medida'],
                            ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                        ]);

                    } catch (PDOException $e) {
                        throw $e;
                    }
                }
                $this->PDO->commit();
                return true;
            } catch (Exception $e) {
                $this->PDO->rollBack();
                error_log("Error al guardar insumos: " . $e->getMessage());
                return false;
            }
        }

        public function GuardarNovedades($ID_Mantenimiento, $Novedades, $ID_Montacargas, $Estado, $FechaReporte, $Tipo_Mantenimiento) {
            try {
                $this->PDO->beginTransaction();
                $sqlInsert = "INSERT INTO novedades_mantenimiento (ID_Mantenimiento, ID_Montacargas, Descripcion, Estado_Novedad, Fecha_Reporte, Fecha_Correccion, ID_Correccion, Tipo_Mantenimiento) 
                              VALUES (:ID_Mantenimiento, :ID_Montacargas, :Descripcion, :Estado_Novedad, :Fecha_Reporte, NULL, NULL, :Tipo_Mantenimiento)";
                $stmt = $this->PDO->prepare($sqlInsert);
                $NovedadesGuardadas = [];
                foreach ($Novedades as $Novedad) {
                    try {
                        $stmt->execute([
                            ':Descripcion' => $Novedad['txt'],
                            ':ID_Mantenimiento' => $ID_Mantenimiento,
                            ':ID_Montacargas' => $ID_Montacargas,
                            ':Estado_Novedad' => $Estado,
                            ':Fecha_Reporte' => $FechaReporte,
                            ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                        ]);
                        $ID_Generado = $this->PDO->lastInsertId();
                        $NovedadesGuardadas[] =[
                            'id' => $ID_Generado,
                            'txt' => $Novedad['txt'],
                        ];
                    } catch (PDOException $e) {
                        if ($e->errorInfo[1] == 1062) {
                            continue;
                        } else {
                            throw $e; 
                        }
                    }
                }
                $this->PDO->commit();
                return [
                    'success' => true,
                    'novedades' => $NovedadesGuardadas
                ];
            } catch (Exception $e) {
                $this->PDO->rollBack();
                error_log("Error al guardar novedades: " . $e->getMessage());
                return [
                    'success' => false,
                    'novedades' => [],
                    'message' => $e->getMessage()
                ];
            }
        }

        public function GuardarObservacion($ID_Detalle, $criterio, $observacion){
            try {

                // 1. Obtener observaciones actuales
                $sql = "SELECT Observaciones FROM detalles_mantenimiento_preventivo WHERE ID = :ID_Detalle";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Detalle', $ID_Detalle, PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$resultado) {
                    return false;
                }
                // 2. Convertir JSON de BD a array PHP
                $observaciones = [];

                if (!empty($resultado['Observaciones'])) {
                    $observaciones = json_decode( $resultado['Observaciones'], true);
                    if (!is_array($observaciones)) {
                        $observaciones = [];
                    }
                }

                // 3. SI LA OBSERVACIÓN VIENE VACÍA
                if (trim($observacion) === '') {
                    $observaciones = array_values(
                        array_filter(
                            $observaciones,
                            function ($item) use ($criterio) {
                                return !(isset($item['criterio']) && $item['criterio'] === $criterio);
                            }
                        )
                    );
                } else {
                    // 4. SI TIENE CONTENIDO
                    $encontrada = false;
                    foreach ($observaciones as &$item) {
                        if (isset($item['criterio']) && $item['criterio'] === $criterio) {
                            $item['observacion'] = $observacion;
                            $encontrada = true;
                            break;
                        }
                    }

                    unset($item);

                    // Si no existe, agregarla
                    if (!$encontrada) {
                        $observaciones[] = [
                            'criterio' => $criterio,
                            'observacion' => $observacion
                        ];
                    }
                }

                // 5. Convertir nuevamente a JSON
                $observacionesJson = json_encode($observaciones, JSON_UNESCAPED_UNICODE);
                if ($observacionesJson === false) {
                    return false;
                }
                // 6. Actualizar BD

                $sql = "UPDATE detalles_mantenimiento_preventivo SET Observaciones = :Observaciones WHERE ID = :ID_Detalle";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Observaciones',$observacionesJson);
                $stmt->bindValue(':ID_Detalle', $ID_Detalle, PDO::PARAM_INT);
                return $stmt->execute();

            } catch (Exception $e) {
                error_log("Error al guardar observación: " . $e->getMessage());
                return false;
            }
        }

        public function GuardarObservaciones($ID_Mantenimiento, $Observaciones){
            try {
                // Consultar las observaciones actuales
                $sql = "SELECT Observaciones FROM mantenimiento_correctivo WHERE ID = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$resultado) {
                    return false;
                }
                // Decodificar las observaciones existentes
                $observacionesActuales = [];
                if (!empty($resultado['Observaciones'])) {
                    $decodificadas = json_decode(
                        $resultado['Observaciones'],
                        true
                    );

                    if (is_array($decodificadas)) {
                        $observacionesActuales = $decodificadas;
                    } else {
                        // Compatibilidad si anteriormente se guardó texto plano
                        $textoAnterior = trim($resultado['Observaciones']);
                        if ($textoAnterior !== '') {
                            $observacionesActuales = [$textoAnterior];
                        }
                    }
                }
                // Validar que las nuevas observaciones sean un arreglo
                if (!is_array($Observaciones)) {
                    return false;
                }
                // Conservar únicamente textos no vacíos
                $observacionesNuevas = array_values(array_filter(array_map(fn($texto) => is_string($texto) ? trim($texto) : '', $Observaciones), fn($texto) => $texto !== ''));
                // Unir las existentes con las recibidas
                $observacionesFinales = array_values(array_unique(array_merge($observacionesActuales, $observacionesNuevas)));
                $jsonObservaciones = json_encode($observacionesFinales, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                if ($jsonObservaciones === false) {
                    return false;
                }
                $sql = "UPDATE mantenimiento_correctivo SET Observaciones = :Observaciones WHERE ID = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':Observaciones', $jsonObservaciones, PDO::PARAM_STR);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                return [
                    'success' => true,
                    'observaciones' => $observacionesFinales
                ];

            } catch (PDOException $e) {
                error_log('Error al guardar observaciones: ' . $e->getMessage());
                return [
                    'success' => false,
                    'observaciones' => [],
                    'message' => $e->getMessage()
                ];
            }
        }

        public function GuardarRepuestos($ID_Mantenimiento, $ID_Montacargas, $Repuestos, $Tipo_Mantenimiento) {
            try {
                $this->PDO->beginTransaction();
                $sqlInsert = "INSERT INTO detalles_repuestos_mantenimientos (ID_Mantenimiento, ID_Insumo, ID_Montacargas, Cantidad, Medida, Descripcion, Tipo_Mantenimiento)
                              VALUES (:ID_Mantenimiento, :ID_Insumo, :ID_Montacargas, :Cantidad, :Medida, :Descripcion, :Tipo_Mantenimiento)";
                $stmt = $this->PDO->prepare($sqlInsert);
                foreach ($Repuestos as $Repuesto) {
                    try {
                        $stmt->execute([
                            ':ID_Mantenimiento' => $ID_Mantenimiento,
                            ':ID_Insumo' => $Repuesto['id'],
                            ':ID_Montacargas' => $ID_Montacargas,
                            ':Cantidad' => $Repuesto['cantidad'],
                            ':Medida' => $Repuesto['medida'],
                            ':Descripcion' => $Repuesto['descripcion'],
                            ':Tipo_Mantenimiento' => $Tipo_Mantenimiento
                        ]);

                    } catch (PDOException $e) {
                        throw $e;
                    }
                }
                $this->PDO->commit();
                return true;
            } catch (Exception $e) {
                $this->PDO->rollBack();
                error_log("Error al guardar repuestos: " . $e->getMessage());
                return false;
            }
        }

        public function GuardarTecnicos($ID_Mantenimiento, $ID_Tecnicos){
            $Estado_Firma_Mecanico = 0;

            try {
                $this->PDO->beginTransaction();

                $sqlInsert = "INSERT INTO mantenimiento_preventivo_mecanicos (ID_Mantenimiento, ID_Mecanico, Firma_Mecanico, Fecha_Firma_Mecanico, Estado_Firma_Mecanico) 
                              VALUES (:ID_Mantenimiento, :ID_Tecnico, NULL, NULL, :Estado_Firma_Mecanico)";

                $stmt = $this->PDO->prepare($sqlInsert);

                foreach ($ID_Tecnicos as $ID_Tecnico) {
                    try {
                        $stmt->execute([
                            ':ID_Mantenimiento' => $ID_Mantenimiento,
                            ':ID_Tecnico' => $ID_Tecnico,
                            ':Estado_Firma_Mecanico' => $Estado_Firma_Mecanico
                        ]);
                    } catch (PDOException $e) {

                        if ($e->errorInfo[1] == 1062) {
                            
                            continue;
                        } else {
                            throw $e; 
                        }
                    }
                }

                $this->PDO->commit();
                return true;

            } catch (Exception $e) {
                $this->PDO->rollBack();
                error_log("Error al guardar técnicos: " . $e->getMessage());
                return false;
            }
        }

        public function GuardarTecnicosCorrectivo($ID_Mantenimiento, $ID_Tecnicos){
            $Estado_Firma_Mecanico = 0;

            try {
                $this->PDO->beginTransaction();

                $sqlInsert = "INSERT INTO mantenimiento_correctivo_mecanicos (ID_Mantenimiento, ID_Mecanico, Firma_Mecanico, Fecha_Firma_Mecanico, Estado_Firma_Mecanico) 
                              VALUES (:ID_Mantenimiento, :ID_Tecnico, NULL, NULL, :Estado_Firma_Mecanico)";

                $stmt = $this->PDO->prepare($sqlInsert);

                foreach ($ID_Tecnicos as $ID_Tecnico) {
                    try {
                        $stmt->execute([
                            ':ID_Mantenimiento' => $ID_Mantenimiento,
                            ':ID_Tecnico' => $ID_Tecnico,
                            ':Estado_Firma_Mecanico' => $Estado_Firma_Mecanico
                        ]);
                    } catch (PDOException $e) {

                        if ($e->errorInfo[1] == 1062) {
                            
                            continue;
                        } else {
                            throw $e; 
                        }
                    }
                }

                $this->PDO->commit();
                return true;

            } catch (Exception $e) {
                $this->PDO->rollBack();
                error_log("Error al guardar técnicos: " . $e->getMessage());
                return false;
            }
        }

        public function LeerMantenimientos($Estado){
            $sql = "SELECT
                        mantenimiento_preventivo.ID AS ID,
                        mantenimiento_preventivo.Numero,
                        mantenimiento_preventivo.Fecha_Realizado,
                        mantenimiento_preventivo.Tipo_Mantenimiento,
                        mantenimiento_preventivo.Estado_Firma_Supervisor,
                        mantenimiento_preventivo.Estado_Firma_Operario,
                        mantenimiento_preventivo.ID_Supervisor,
                        mantenimiento_preventivo.ID_Recibe,
                        mantenimiento_preventivo.Nombre_Externo,
                        mantenimiento_preventivo.Tipo AS TipoMontacargas,
                        usuario_operario.NombreCompleto AS NombreOperario,
                        usuario_recibe.NombreCompleto AS NombreRecibe,
                        usuario_supervisor.NombreCompleto AS NombreSupervisor,
                        No_montacargas.Numero AS NumeroM,
                        No_montacargas.Marca AS MarcaM,
                        No_montacargas.Modelo AS ModeloM,
                        No_montacargas.Serie AS SerieM,
                        Centro.Nombre AS Centrot,
                        Detalle_mantenimiento.Horometro AS HorometroM,
                        GROUP_CONCAT(
                            CONCAT(
                                mantenimiento_preventivo_mecanicos.ID_Mecanico,
                                ':',
                                usuario_mecanico.NombreCompleto,
                                ':',
                                mantenimiento_preventivo_mecanicos.Estado_Firma_Mecanico
                            )
                            SEPARATOR ','
                        ) AS Mecanicos
                    FROM mantenimiento_preventivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_preventivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN usuario AS usuario_recibe ON mantenimiento_preventivo.ID_Recibe = usuario_recibe.ID
                    LEFT JOIN usuario AS usuario_supervisor ON mantenimiento_preventivo.ID_Supervisor = usuario_supervisor.ID
                    JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID
                    JOIN centrot AS Centro ON mantenimiento_preventivo.ID_Centro = Centro.ID
                    JOIN detalles_mantenimiento_preventivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_preventivo.ID
                    LEFT JOIN mantenimiento_preventivo_mecanicos ON mantenimiento_preventivo_mecanicos.ID_Mantenimiento = mantenimiento_preventivo.ID
                    LEFT JOIN usuario AS usuario_mecanico ON mantenimiento_preventivo_mecanicos.ID_Mecanico = usuario_mecanico.ID
                    WHERE mantenimiento_preventivo.Estado = :Estado
                    GROUP BY
                        mantenimiento_preventivo.ID,
                        mantenimiento_preventivo.Numero,
                        mantenimiento_preventivo.Fecha_Realizado,
                        mantenimiento_preventivo.Tipo_Mantenimiento,
                        mantenimiento_preventivo.Estado_Firma_Supervisor,
                        mantenimiento_preventivo.Estado_Firma_Operario,
                        mantenimiento_preventivo.ID_Supervisor,
                        mantenimiento_preventivo.ID_Recibe,
                        mantenimiento_preventivo.Nombre_Externo,
                        mantenimiento_preventivo.Tipo,
                        usuario_operario.NombreCompleto,
                        usuario_recibe.NombreCompleto,
                        usuario_supervisor.NombreCompleto,
                        No_montacargas.Numero,
                        No_montacargas.Marca,
                        No_montacargas.Modelo,
                        No_montacargas.Serie,
                        Centro.Nombre,
                        Detalle_mantenimiento.Horometro
                    ORDER BY mantenimiento_preventivo.ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerMantenimientosCorrectivos($Estado) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreUsuario, 
                           No_montacargas.Numero AS NumeroM,
                           No_montacargas.Marca AS MarcaM,
                           No_montacargas.Modelo AS ModeloM,
                           No_montacargas.Serie AS SerieM,
                           Centro.Nombre AS Centrot,
                           mantenimiento_correctivo.Horometro AS HorometroM,
                           mantenimiento_correctivo.Tipo_Montacargas AS TipoMontacargas,
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_correctivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID
                    LEFT JOIN centrot AS Centro ON mantenimiento_correctivo.ID_Centro = Centro.ID
                    WHERE mantenimiento_correctivo.Estado = :Estado ";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerDatos($ID_Mantenimiento) {
            $sql = "SELECT No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM, 
                           No_montacargas.Modelo AS ModeloM, 
                           No_montacargas.Voltaje AS VoltajeM,
                           No_montacargas.Horquillas AS LongitudH,
                           Bateria.Numero_Interno AS NumeroB, 
                           Centro.Nombre AS NombreCentro, 
                           Area.Nombre AS NombreArea, 
                           COALESCE(Operario.NombreCompleto, mantenimiento_preventivo.Nombre_Externo) AS NombreOperario,
                           GROUP_CONCAT(Tecnico.ID SEPARATOR ',') AS ID_Tecnicos,
                           GROUP_CONCAT(Tecnico.NombreCompleto SEPARATOR ', ') AS NombreTecnicos,
                           mantenimiento_preventivo.*
                    FROM mantenimiento_preventivo 
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID 
                    LEFT JOIN baterias AS Bateria ON No_montacargas.ID_Bateria = Bateria.ID 
                    LEFT JOIN centrot AS Centro ON mantenimiento_preventivo.ID_Centro = Centro.ID 
                    LEFT JOIN area AS Area ON mantenimiento_preventivo.ID_Area = Area.ID 
                    LEFT JOIN usuario AS Operario ON mantenimiento_preventivo.ID_Operario = Operario.ID
                    LEFT JOIN mantenimiento_preventivo_mecanicos AS Mecanicos ON mantenimiento_preventivo.ID = Mecanicos.ID_Mantenimiento
                    LEFT JOIN usuario AS Tecnico ON Mecanicos.ID_Mecanico = Tecnico.ID
                    WHERE mantenimiento_preventivo.ID = :ID_Mantenimiento
                    GROUP BY mantenimiento_preventivo.ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ObtenerDatosCorrectivos($ID_Mantenimiento) {
            $sql = "SELECT No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM, 
                           No_montacargas.Modelo AS ModeloM, 
                           No_montacargas.Voltaje AS VoltajeM,
                           No_montacargas.Horquillas AS LongitudH,
                           Bateria.Numero_Interno AS NumeroB, 
                           Centro.Nombre AS NombreCentro, 
                           Area.Nombre AS NombreArea, 
                           COALESCE(Operario.NombreCompleto, mantenimiento_correctivo.Nombre_Externo) AS NombreOperario,
                           GROUP_CONCAT(Tecnico.ID SEPARATOR ',') AS ID_Tecnicos,
                           GROUP_CONCAT(Tecnico.NombreCompleto SEPARATOR ', ') AS NombreTecnicos,
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo 
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID 
                    LEFT JOIN baterias AS Bateria ON No_montacargas.ID_Bateria = Bateria.ID 
                    LEFT JOIN centrot AS Centro ON mantenimiento_correctivo.ID_Centro = Centro.ID 
                    LEFT JOIN area AS Area ON mantenimiento_correctivo.ID_Area = Area.ID 
                    LEFT JOIN usuario AS Operario ON mantenimiento_correctivo.ID_Operario = Operario.ID
                    LEFT JOIN mantenimiento_correctivo_mecanicos AS Mecanicos ON mantenimiento_correctivo.ID = Mecanicos.ID_Mantenimiento
                    LEFT JOIN usuario AS Tecnico ON Mecanicos.ID_Mecanico = Tecnico.ID
                    WHERE mantenimiento_correctivo.ID = :ID_Mantenimiento
                    GROUP BY mantenimiento_correctivo.ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ObtenerNovedadesPendientes($ID_Montacargas) {
            $sql = "SELECT novedades_mantenimiento.* FROM novedades_mantenimiento WHERE novedades_mantenimiento.ID_Montacargas = :ID_Montacargas AND novedades_mantenimiento.Estado_Novedad = 'Pendiente' ";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Montacargas', $ID_Montacargas, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerInsumosMantenimiento($ID, $Tipo) {
            $sql = "SELECT 
                        Insumo.Nombre AS NombreInsumo,
                        Insumo.Codigo AS CodigoInsumo,
                        detalles_insumos_mantenimientos.*  
                    FROM detalles_insumos_mantenimientos 
                    LEFT JOIN insumos AS Insumo ON detalles_insumos_mantenimientos.ID_Insumo = Insumo.ID
                    WHERE ID_Mantenimiento = :ID AND Tipo_Mantenimiento = :Tipo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Tipo', $Tipo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerMantenimientoCompleto($ID_Mantenimiento){
            try {
                /* 1. MANTENIMIENTO PRINCIPAL */
                $sql = "SELECT No_montacargas.Numero AS NumeroM,
                            No_montacargas.Serie AS SerieM,
                            No_montacargas.Modelo AS ModeloM,
                            No_montacargas.Voltaje AS VoltajeM,
                            Centro.Nombre AS NombreCentro,
                            Area.Nombre AS NombreArea,
                            COALESCE(Operario.NombreCompleto, mantenimiento_preventivo.Nombre_Externo) AS NombreOperario,
                            GROUP_CONCAT(Tecnico.ID SEPARATOR ',') AS ID_Tecnicos,
                            GROUP_CONCAT(Tecnico.NombreCompleto SEPARATOR ', ') AS NombreTecnicos,
                            mantenimiento_preventivo.*
                        FROM mantenimiento_preventivo
                        LEFT JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID
                        LEFT JOIN centrot AS Centro ON mantenimiento_preventivo.ID_Centro = Centro.ID
                        LEFT JOIN area AS Area ON mantenimiento_preventivo.ID_Area = Area.ID
                        LEFT JOIN usuario AS Operario ON mantenimiento_preventivo.ID_Operario = Operario.ID
                        LEFT JOIN mantenimiento_preventivo_mecanicos AS Mecanicos ON mantenimiento_preventivo.ID = Mecanicos.ID_Mantenimiento
                        LEFT JOIN usuario AS Tecnico ON Mecanicos.ID_Mecanico = Tecnico.ID
                        WHERE mantenimiento_preventivo.ID = :ID_Mantenimiento
                        GROUP BY mantenimiento_preventivo.ID";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento,PDO::PARAM_INT);
                $stmt->execute();
                $mantenimiento = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$mantenimiento) {
                    return false;
                }

                /* 2. DETALLE PREVENTIVO */
                $sql = "SELECT * FROM detalles_mantenimiento_preventivo WHERE ID_Mantenimiento = :ID_Mantenimiento LIMIT 1";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $detalle = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$detalle) {
                    return false;
                }

                /* 3. INSUMOS */
                $sql = "SELECT Insumo.Nombre AS Nombre,
                               Insumo.Codigo AS Codigo,
                               detalles_insumos_mantenimientos.*  
                        FROM detalles_insumos_mantenimientos 
                        LEFT JOIN insumos AS Insumo ON detalles_insumos_mantenimientos.ID_Insumo = Insumo.ID
                        WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = 'Preventivo'";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $insumos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 4. IMÁGENES */
                $sql = "SELECT * FROM mantenimiento_preventivo_imagenes WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 5. TÉCNICOS */
                $sql = "SELECT * FROM mantenimiento_preventivo_mecanicos WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);


                /* 6. NOVEDADES */
                $sql = "SELECT * FROM novedades_mantenimiento WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = 'Preventivo'";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $novedades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 7. DEVOLVER TODO */
                return [
                    'mantenimiento' => $mantenimiento,
                    'detalle'       => $detalle,
                    'insumos'       => $insumos,
                    'imagenes'      => $imagenes,
                    'tecnicos'      => $tecnicos,
                    'novedades'     => $novedades
                ];

            } catch (Exception $e) {
                error_log("Error al obtener mantenimiento completo: " . $e->getMessage());
                return false;
            }
        }

        public function ObtenerMantenimientoCorrectivoCompleto($ID_Mantenimiento){
            try {
                /* 1. MANTENIMIENTO PRINCIPAL */
                $sql = "SELECT No_montacargas.Numero AS NumeroM,
                            No_montacargas.Serie AS SerieM,
                            No_montacargas.Modelo AS ModeloM,
                            No_montacargas.Voltaje AS VoltajeM,
                            Centro.Nombre AS NombreCentro,
                            Area.Nombre AS NombreArea,
                            COALESCE(Operario.NombreCompleto, mantenimiento_correctivo.Nombre_Externo) AS NombreOperario,
                            GROUP_CONCAT(Tecnico.ID SEPARATOR ',') AS ID_Tecnicos,
                            GROUP_CONCAT(Tecnico.NombreCompleto SEPARATOR ', ') AS NombreTecnicos,
                            mantenimiento_correctivo.*
                        FROM mantenimiento_correctivo
                        LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID
                        LEFT JOIN centrot AS Centro ON mantenimiento_correctivo.ID_Centro = Centro.ID
                        LEFT JOIN area AS Area ON mantenimiento_correctivo.ID_Area = Area.ID
                        LEFT JOIN usuario AS Operario ON mantenimiento_correctivo.ID_Operario = Operario.ID
                        LEFT JOIN mantenimiento_correctivo_mecanicos AS Mecanicos ON mantenimiento_correctivo.ID = Mecanicos.ID_Mantenimiento
                        LEFT JOIN usuario AS Tecnico ON Mecanicos.ID_Mecanico = Tecnico.ID
                        WHERE mantenimiento_correctivo.ID = :ID_Mantenimiento
                        GROUP BY mantenimiento_correctivo.ID";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento,PDO::PARAM_INT);
                $stmt->execute();
                $mantenimiento = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$mantenimiento) {
                    return false;
                }
                $ID_Montacargas = $mantenimiento['ID_Montacargas'];

                /* 2. DETALLE CORRECTIVOS */
                $sql = "SELECT * 
                        FROM detalles_mantenimiento_correctivo 
                        WHERE ID_Mantenimiento = :ID_Mantenimiento ";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 3. INSUMOS */
                $sql = "SELECT Insumo.Nombre AS Nombre,
                               Insumo.Codigo AS Codigo,
                               detalles_insumos_mantenimientos.*  
                        FROM detalles_insumos_mantenimientos 
                        LEFT JOIN insumos AS Insumo ON detalles_insumos_mantenimientos.ID_Insumo = Insumo.ID
                        WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = 'Correctivo' ";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $insumos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 4. TÉCNICOS */
                $sql = "SELECT * FROM mantenimiento_correctivo_mecanicos WHERE ID_Mantenimiento = :ID_Mantenimiento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 5. NOVEDADES */
                $sql = "SELECT * FROM novedades_mantenimiento WHERE ID_Montacargas = :ID_Montacargas AND novedades_mantenimiento.Estado_Novedad = 'Pendiente'";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Montacargas', $ID_Montacargas, PDO::PARAM_INT);
                $stmt->execute();
                $novedades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 6. REPUESTOS */
                $sql = "SELECT Insumo.Nombre AS Nombre,
                               Insumo.Codigo AS Codigo,
                               detalles_repuestos_mantenimientos.*  
                        FROM detalles_repuestos_mantenimientos 
                        LEFT JOIN insumos AS Insumo ON detalles_repuestos_mantenimientos.ID_Insumo = Insumo.ID
                        WHERE ID_Mantenimiento = :ID_Mantenimiento AND Tipo_Mantenimiento = 'Correctivo' ";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Mantenimiento', $ID_Mantenimiento, PDO::PARAM_INT);
                $stmt->execute();
                $repuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /* 7. DEVOLVER TODO */
                return [
                    'mantenimiento' => $mantenimiento,
                    'detalles'       => $detalles,
                    'insumos'       => $insumos,
                    'tecnicos'      => $tecnicos,
                    'novedades'     => $novedades,
                    'repuestos'     => $repuestos
                ];

            } catch (Exception $e) {
                error_log("Error al obtener mantenimiento completo: " . $e->getMessage());
                return false;
            }
        }

        public function ObtenerNovedadesMantenimiento($ID, $Tipo) {
            $sql = "SELECT novedades_mantenimiento.*  
                    FROM novedades_mantenimiento 
                    WHERE ID_Mantenimiento = :ID 
                    AND Tipo_Mantenimiento = :Tipo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Tipo', $Tipo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerUltimoCodigoMantenimientoCorrectivo() {
            $sql = "SELECT Numero FROM mantenimiento_correctivo ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function ObtenerUltimoCodigoMantenimientoPreventivo() {
            $sql = "SELECT Numero FROM mantenimiento_preventivo ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function RegistrarMantenimientoTecnico($ID_Mantenimiento, $ID_Tecnico){
            $Estado_Firma_Mecanico = 0;
            $sql = "INSERT INTO mantenimiento_preventivo_mecanicos (ID_Mantenimiento, ID_Mecanico, Firma_Mecanico, Fecha_Firma_Mecanico, Estado_Firma_Mecanico) 
                    VALUES (:ID_Mantenimiento, :ID_Tecnico, NULL, NULL, :Estado_Firma_Mecanico)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":ID_Tecnico", $ID_Tecnico);
            $stmt->bindParam(":Estado_Firma_Mecanico", $Estado_Firma_Mecanico);
            return $stmt->execute();
        }

        public function RegistrarMantenimientoCorrectivoTecnico($ID_Mantenimiento, $ID_Tecnico){
            $Estado_Firma_Mecanico = 0;
            $sql = "INSERT INTO mantenimiento_correctivo_mecanicos (ID_Mantenimiento, ID_Mecanico, Firma_Mecanico, Fecha_Firma_Mecanico, Estado_Firma_Mecanico) 
                    VALUES (:ID_Mantenimiento, :ID_Tecnico, NULL, NULL, :Estado_Firma_Mecanico)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":ID_Tecnico", $ID_Tecnico);
            $stmt->bindParam(":Estado_Firma_Mecanico", $Estado_Firma_Mecanico);
            return $stmt->execute();
        }

        public function TraerAreas($ID_Centro){
            $sql = "SELECT * FROM area WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            $DataOperarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataOperarios;
        }

        public function TraerDetallesCorrectivos($ID_Mantenimiento) {
            $sql = "SELECT * FROM detalles_mantenimiento_correctivo WHERE ID_Mantenimiento = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID_Mantenimiento);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function TraerImagenesCorrectivos($ID_Mantenimiento) {
            $sql = "SELECT * FROM mantenimiento_correctivo_imagenes WHERE ID_Mantenimiento = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID_Mantenimiento);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function TraerMontacargas($ID_Centro){
            $sql = "SELECT * FROM montacargas WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            $DataMontacargas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataMontacargas;
        }

        public function TraerOperarios($ID_Centro){
            $sql = "SELECT * FROM usuario WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            $DataOperarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataOperarios;
        }

        public function TraerTecnicos(){
            $sql = "SELECT ID, NombreCompleto FROM usuario WHERE (ID_Cargo = 4 OR ID_Cargo = 6 OR ID_Cargo = 8 OR ID_Cargo = 13)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataTecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataTecnicos;
        }

        public function TraerSupervisores() {
            $sql ="SELECT * FROM usuario WHERE ID_Cargo = 8";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataSupervisores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataSupervisores;
        }

        public function VerificarBorrador($ID_Usuario){
            try {
                $sql = "SELECT * FROM mantenimiento_preventivo WHERE ID_Usuario = :ID_Usuario AND Estado = 'BORRADOR' ORDER BY ID DESC LIMIT 1";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Usuario', $ID_Usuario, PDO::PARAM_INT);
                $stmt->execute();
                $borrador = $stmt->fetch(PDO::FETCH_ASSOC);
                return $borrador ?: false;
            } catch (Exception $e) {
                    error_log("Error al verificar borrador: " . $e->getMessage());
                return false;
            }
        }

        public function VerificarBorradorCorrectivo($ID_Usuario){
            try {
                $sql = "SELECT * FROM mantenimiento_correctivo WHERE ID_Usuario = :ID_Usuario AND Estado = 'BORRADOR' ORDER BY ID DESC LIMIT 1";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindValue(':ID_Usuario', $ID_Usuario, PDO::PARAM_INT);
                $stmt->execute();
                $borrador = $stmt->fetch(PDO::FETCH_ASSOC);
                return $borrador ?: false;
            } catch (Exception $e) {
                    error_log("Error al verificar borrador: " . $e->getMessage());
                return false;
            }
        }

        public function VerDetalleM($ID) {
            $sql = "SELECT detalles_mantenimiento_preventivo.*  FROM detalles_mantenimiento_preventivo WHERE detalles_mantenimiento_preventivo.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function VerDetalleMC($ID) {
            $sql = "SELECT detalles_mantenimiento_correctivo.*  FROM detalles_mantenimiento_correctivo WHERE detalles_mantenimiento_correctivo.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }    

        public function VerImagenesM($ID) {
            $sql = "SELECT mantenimiento_preventivo_imagenes.*  FROM mantenimiento_preventivo_imagenes WHERE mantenimiento_preventivo_imagenes.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function DataImagenesMC($ID) {
            $sql = "SELECT ID_Detalle, Categoria, Evidencia_Fotografica FROM mantenimiento_correctivo_imagenes WHERE ID_Mantenimiento = :ID ORDER BY ID_Detalle ASC, Categoria ASC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerInformeF145($centro = '', $fechaDesde = '', $fechaHasta = '', $montacargas = '', $tipoMantenimiento = ''){
            try {
                /*NORMALIZAR PARÁMETROS*/
                $centro = $centro ?? '';
                $fechaDesde = $fechaDesde ?? '';
                $fechaHasta = $fechaHasta ?? '';
                $montacargas = $montacargas ?? '';
                $tipoMantenimiento = $tipoMantenimiento ?? '';
                $fechaDesde = rtrim(trim($fechaDesde), '.');
                $fechaHasta = rtrim(trim($fechaHasta), '.');
                /*CONSULTA PRINCIPAL*/
                $sql = "SELECT m.ID AS ID_Montacargas, c.ID AS ID_Centro, c.Nombre AS CentroTrabajo, m.Numero AS Equipo, m.Serie, m.Modelo, m.Marca, m.Horometro,
                            (SELECT COUNT(*) FROM mantenimiento_preventivo mpc  WHERE mpc.ID_Montacargas = m.ID AND mpc.Estado = 'COMPLETADO') AS TotalCompletados,
                            /*ÚLTIMO 250*/
                            u250.Fecha_Realizado AS Fecha_Ultimo_250,
                            u250.Horometro AS Horometro_Ultimo_250,
                            /*ÚLTIMO 1000 */
                            u1000.Fecha_Realizado AS Fecha_Ultimo_1000,
                            u1000.Horometro AS Horometro_Ultimo_1000,
                            /* ÚLTIMO 2000*/
                            u2000.Fecha_Realizado AS Fecha_Ultimo_2000,
                            u2000.Horometro AS Horometro_Ultimo_2000
                        FROM montacargas m
                        INNER JOIN centrot c  ON c.ID = m.ID_Centro
                        /*ÚLTIMO MANTENIMIENTO 250*/
                        LEFT JOIN (SELECT mp.ID_Montacargas, mp.Fecha_Realizado, d.Horometro 
                                FROM mantenimiento_preventivo mp
                                INNER JOIN detalles_mantenimiento_preventivo d ON d.ID_Mantenimiento = mp.ID
                                WHERE mp.Estado = 'COMPLETADO' AND mp.Tipo_Mantenimiento = '250_Horas' AND mp.ID = (
                                    SELECT mp2.ID FROM mantenimiento_preventivo mp2 WHERE mp2.ID_Montacargas = mp.ID_Montacargas AND mp2.Estado = 'COMPLETADO' AND mp2.Tipo_Mantenimiento = '250_Horas'
                                    ORDER BY mp2.Fecha_Realizado DESC, mp2.ID DESC LIMIT 1)
                                ) u250 ON u250.ID_Montacargas = m.ID
                        /*ÚLTIMO MANTENIMIENTO 1000*/
                        LEFT JOIN (SELECT mp.ID_Montacargas, mp.Fecha_Realizado, d.Horometro
                                FROM mantenimiento_preventivo mp
                                INNER JOIN detalles_mantenimiento_preventivo d ON d.ID_Mantenimiento = mp.ID
                                WHERE mp.Estado = 'COMPLETADO' AND mp.Tipo_Mantenimiento = '1000_Horas' AND mp.ID = (
                                    SELECT mp2.ID FROM mantenimiento_preventivo mp2 WHERE mp2.ID_Montacargas = mp.ID_Montacargas AND mp2.Estado = 'COMPLETADO' AND mp2.Tipo_Mantenimiento = '1000_Horas'
                                    ORDER BY mp2.Fecha_Realizado DESC, mp2.ID DESC LIMIT 1)
                                ) u1000 ON u1000.ID_Montacargas = m.ID
                        /*ÚLTIMO MANTENIMIENTO 2000*/
                        LEFT JOIN (SELECT mp.ID_Montacargas, mp.Fecha_Realizado, d.Horometro
                                FROM mantenimiento_preventivo mp
                                INNER JOIN detalles_mantenimiento_preventivo d ON d.ID_Mantenimiento = mp.ID
                                WHERE mp.Estado = 'COMPLETADO' AND mp.Tipo_Mantenimiento = '2000_Horas' AND mp.ID = (
                                    SELECT mp2.ID FROM mantenimiento_preventivo mp2 WHERE mp2.ID_Montacargas = mp.ID_Montacargas AND mp2.Estado = 'COMPLETADO' AND mp2.Tipo_Mantenimiento = '2000_Horas'
                                    ORDER BY mp2.Fecha_Realizado DESC, mp2.ID DESC LIMIT 1)
                                ) u2000 ON u2000.ID_Montacargas = m.ID
                        WHERE 1 = 1";
                /*PARÁMETROS*/
                $params = [];
                /*FILTRO CENTRO*/
                if ($centro !== '') {
                    $sql .= " AND m.ID_Centro = :centro";
                    $params[':centro'] = $centro;
                }
                /*FILTRO MONTACARGAS*/
                if ($montacargas !== '') {
                    $sql .= " AND (m.Numero LIKE :montacargas OR m.Serie LIKE :montacargasOR m.Modelo LIKE :montacargas OR m.Marca LIKE :montacargas)";
                    $params[':montacargas'] = '%' . $montacargas . '%';
                }
                /* ORDEN*/
                $sql .= " ORDER BY c.Nombre ASC, m.Numero ASC";
                /*EJECUTAR CONSULTA*/
                $stmt = $this->PDO->prepare($sql);
                foreach ($params as $param => $valor) {
                    $stmt->bindValue($param, $valor);
                }
                $stmt->execute();
                $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                /*APLICAR REGLAS DEL F-145*/
                foreach ($datos as &$fila) {
                    /*DATOS ORIGINALES*/
                    $fecha250 = $fila['Fecha_Ultimo_250'] ?? null;
                    $fecha1000 = $fila['Fecha_Ultimo_1000'] ?? null;
                    $fecha2000 = $fila['Fecha_Ultimo_2000'] ?? null;
                    $horometro250 = $fila['Horometro_Ultimo_250'] ?? null;
                    $horometro1000 = $fila['Horometro_Ultimo_1000'] ?? null;
                    $horometro2000 = $fila['Horometro_Ultimo_2000'] ?? null;
                    /* REGLA 250
                    Un 1000 o un 2000 reinicia el 250.
                    Por eso tomamos la fecha más reciente entre:
                    - 250
                    - 1000
                    - 2000*/
                    $fechas250 = array_filter([$fecha250, $fecha1000, $fecha2000]);
                    if (!empty($fechas250)) {
                        $fechaBase250 = max($fechas250);
                    } else {
                        $fechaBase250 = null;
                    }
                    /*HORÓMETRO BASE DEL 250*/
                    if ($fechaBase250 === $fecha2000) {
                        $horometroBase250 = $horometro2000;
                    } elseif ($fechaBase250 === $fecha1000) {
                        $horometroBase250 = $horometro1000;
                    } else {
                        $horometroBase250 = $horometro250;
                    }
                    /*REGLA 1000
                    Un 2000 también reinicia el ciclo de 1000.
                    Se toma la fecha más reciente entre:
                    - 1000
                    - 2000*/
                    $fechas1000 = array_filter([$fecha1000, $fecha2000]);
                    if (!empty($fechas1000)) {
                        $fechaBase1000 = max($fechas1000);
                    } else {
                        $fechaBase1000 = null;
                    }
                    /*HORÓMETRO BASE DEL 1000*/
                    if ($fechaBase1000 === $fecha2000) {
                        $horometroBase1000 = $horometro2000;
                    } else {
                        $horometroBase1000 = $horometro1000;
                    }
                    /*REGLA 2000
                    Solo otro mantenimiento 2000 reinicia el ciclo.*/
                    $fechaBase2000 = $fecha2000;
                    $horometroBase2000 = $horometro2000;
                    /*SOBRESCRIBIR VALORES PARA LA VISTA*/
                    $fila['Fecha_Ultimo_250'] = $fechaBase250;
                    $fila['Horometro_Ultimo_250'] = $horometroBase250;
                    $fila['Fecha_Ultimo_1000'] = $fechaBase1000;
                    $fila['Horometro_Ultimo_1000'] = $horometroBase1000;
                    $fila['Fecha_Ultimo_2000'] = $fechaBase2000;
                    $fila['Horometro_Ultimo_2000'] = $horometroBase2000;
                    /* FILTRO POR FECHAS IMPORTANTE: Se hace DESPUÉS de aplicar las reglas F-145.*/
                    $mostrarFila = true;
                    /*Solo aplicamos filtro si el usuario diligenció alguna de las dos fechas.*/
                    if ($fechaDesde !== '' || $fechaHasta !== '') {
                        /*DETERMINAR QUÉ FECHA SE DEBE REVISAR*/
                        if ($tipoMantenimiento === '250_Horas') {
                            $fechasFiltro = [$fila['Fecha_Ultimo_250']];
                        } elseif ($tipoMantenimiento === '1000_Horas') {
                            $fechasFiltro = [$fila['Fecha_Ultimo_1000']];
                        } elseif ($tipoMantenimiento === '2000_Horas') {
                            $fechasFiltro = [$fila['Fecha_Ultimo_2000']];
                        } else {
                            /*Si no se seleccionó ningún tipo, revisamos los tres.*/
                            $fechasFiltro = [
                                $fila['Fecha_Ultimo_250'],
                                $fila['Fecha_Ultimo_1000'],
                                $fila['Fecha_Ultimo_2000']
                            ];
                        }
                        /*INICIALMENTE NO MOSTRAR*/
                        $mostrarFila = false;
                        /*VALIDAR LAS FECHAS*/
                        foreach ($fechasFiltro as $fechaFiltro) {
                            if (empty($fechaFiltro)) {
                                continue;
                            }
                            $cumpleDesde = true;
                            $cumpleHasta = true;
                            /*FECHA DESDE*/
                            if ($fechaDesde !== '') {
                                $cumpleDesde = ($fechaFiltro >= $fechaDesde);
                            }
                            /*FECHA HASTA*/
                            if ($fechaHasta !== '') {
                                $cumpleHasta = ($fechaFiltro <= $fechaHasta);
                            }
                            /*CUMPLE TODO EL RANGO*/
                            if ($cumpleDesde && $cumpleHasta) {
                                $mostrarFila = true;
                                break;
                            }
                        }
                    }
                    /*MARCA AUXILIAR PARA FILTRAR DESPUÉS*/
                    $fila['_mostrar'] = $mostrarFila;
                }
                unset($fila);
                /*ELIMINAR FILAS QUE NO CUMPLAN EL FILTRO*/
                $datos = array_values(array_filter($datos, function ($fila) {
                    return ($fila['_mostrar'] ?? true) === true;})
                );
                /*ELIMINAR CAMPO AUXILIAR*/
                foreach ($datos as &$fila) {
                    unset($fila['_mostrar']);
                }
                unset($fila);
                /*RETORNAR INFORMACIÓN*/
                return $datos;
            } catch (PDOException $e) {
                error_log('Error en VerInformeF145: ' . $e->getMessage());
                return [];
            }
        }

        public function VerMantenimiento($ID) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreOperario, 
                           usuario_recibe.NombreCompleto AS NombreRecibe,
                           usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_mantenimiento.Nombre AS CentroMantenimiento, 
                           area_mantenimiento.Nombre AS AreaMantenimiento,
                           No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM,
                           No_montacargas.Modelo AS ModeloM,
                           No_montacargas.Voltaje AS VoltajeM,
                           Detalle_mantenimiento.Horometro AS HorometroM,
                           mantenimiento_preventivo.*
                    FROM mantenimiento_preventivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_preventivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN usuario AS usuario_recibe ON mantenimiento_preventivo.ID_Recibe = usuario_recibe.ID
                    LEFT JOIN usuario AS usuario_Supervisor ON mantenimiento_preventivo.ID_Supervisor = usuario_Supervisor.ID
                    LEFT JOIN centrot AS centro_mantenimiento ON mantenimiento_preventivo.ID_Centro = centro_mantenimiento.ID
                    LEFT JOIN area AS area_mantenimiento ON mantenimiento_preventivo.ID_Area = area_mantenimiento.ID
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID
                    LEFT JOIN detalles_mantenimiento_preventivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_preventivo.ID
                    WHERE mantenimiento_preventivo.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

         public function VerMantenimientoC($ID) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreOperario, 
                           usuario_recibe.NombreCompleto AS NombreRecibe,
                           usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_mantenimiento.Nombre AS CentroMantenimiento, 
                           area_mantenimiento.Nombre AS AreaMantenimiento,
                           No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM,
                           No_montacargas.Modelo AS ModeloM,
                           No_montacargas.Voltaje AS VoltajeM,
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_correctivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN usuario AS usuario_recibe ON mantenimiento_correctivo.ID_Recibe = usuario_recibe.ID
                    LEFT JOIN usuario AS usuario_Supervisor ON mantenimiento_correctivo.ID_Supervisor = usuario_Supervisor.ID
                    LEFT JOIN centrot AS centro_mantenimiento ON mantenimiento_correctivo.ID_Centro = centro_mantenimiento.ID
                    LEFT JOIN area AS area_mantenimiento ON mantenimiento_correctivo.ID_Area = area_mantenimiento.ID
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID
                    LEFT JOIN detalles_mantenimiento_correctivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_correctivo.ID
                    WHERE mantenimiento_correctivo.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function VerMecanicos($ID) {
            $sql = "SELECT usuario_mecanico.NombreCompleto AS NombreMecanico, 
                           mantenimiento_preventivo_mecanicos.*
                    FROM mantenimiento_preventivo_mecanicos
                    JOIN usuario AS usuario_mecanico ON mantenimiento_preventivo_mecanicos.ID_Mecanico = usuario_mecanico.ID
                    WHERE mantenimiento_preventivo_mecanicos.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerMecanicosC($ID) {
            $sql = "SELECT usuario_mecanico.NombreCompleto AS NombreMecanico, 
                           mantenimiento_correctivo_mecanicos.*
                    FROM mantenimiento_correctivo_mecanicos
                    JOIN usuario AS usuario_mecanico ON mantenimiento_correctivo_mecanicos.ID_Mecanico = usuario_mecanico.ID
                    WHERE mantenimiento_correctivo_mecanicos.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //Salidas 
        public function CrearSalida($ID_UsuarioSalida, $ID_Usuario, $ID_SupervisorSalida, $ID_Centro, $ID_Destino, $ID_Mantenimiento, $No_Formulario, $Mantenimiento, $Fecha_Recibe, $Estado, $FirmaSalida, $Firma_Estado_Salida, $EstadoFirmaMecanico){
            $sql = "INSERT INTO salida_insumos (ID_Usuario, ID_Recibe, ID_Supervisor, ID_Centro, ID_Destino, ID_Origen, Numero, Tipo_Origen, Fecha_Realizado, Fecha_Firma_Recibe, Fecha_Firma_Supervisor, Estado, Firma_Salida, Firma_Recibe, Firma_Supervisor, Firma_Estado_Salida, Firma_Estado_Recibe, Firma_Supervisor_Estado, Descripcion_Anulacion)
                    VALUES (:ID_Usuario, :ID_Recibe, :ID_Supervisor, :ID_Centro, :ID_Destino, :ID_Origen, :Numero, :Tipo_Origen, :Fecha_Realizado, :Fecha_Recibe, NULL, :Estado, NULL, :Firma, NULL, :Firma_Estado_Salida, :Firma_Estado_Recibe, :Firma_Estado_Supervisor, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Usuario", $ID_UsuarioSalida);
            $stmt->bindParam(":ID_Recibe", $ID_Usuario);
            $stmt->bindParam(":ID_Supervisor", $ID_SupervisorSalida);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Destino", $ID_Destino);
            $stmt->bindParam(":ID_Origen", $ID_Mantenimiento);
            $stmt->bindParam(":Numero", $No_Formulario);
            $stmt->bindParam(":Tipo_Origen", $Mantenimiento);
            $stmt->bindParam(":Fecha_Realizado", $Fecha_Recibe);
            $stmt->bindParam(":Fecha_Recibe", $Fecha_Recibe);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Firma", $FirmaSalida); 
            $stmt->bindParam(":Firma_Estado_Salida", $Firma_Estado_Salida); 
            $stmt->bindParam(":Firma_Estado_Recibe", $EstadoFirmaMecanico); 
            $stmt->bindParam(":Firma_Estado_Supervisor", $Firma_Estado_Salida); 
            if($stmt->execute()){
                return $this->PDO->lastInsertId(); 
            }else{
                return false; 
            }
        }

        // Modelos anteriores  
        public function RegistrarDetallesMantenimientoCorrectivo($ID_Montacargas, $ID_Mantenimiento, $Horometro, $Falla, $Reparacion, $Observaciones, $FechaCorrecion, $FallaC, $Pendiente){
            $sql = "INSERT INTO detalles_mantenimiento_correctivo (ID_Mantenimiento, ID_Detalle,  Descripcion_Falla, Reparacion_Realizada, FallaC, Fecha_Correccion, Pendiente, Observaciones)
                    VALUES (:ID_Mantenimiento, NULL,  :Falla, :Reparacion, :FallaC, :FechaCorrecion, :Pendiente, :Observaciones)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":Falla", $Falla);
            $stmt->bindParam(":Reparacion", $Reparacion);
            $stmt->bindParam(":FallaC", $FallaC);
            $stmt->bindParam(":FechaCorrecion", $FechaCorrecion);
            $stmt->bindParam(":Pendiente", $Pendiente);
            $stmt->bindParam(":Observaciones", $Observaciones);
            $success = $stmt->execute();

            if ($success) {
                // --- Actualizar Horómetro y Longitud ---
                $update = $this->PDO->prepare("UPDATE montacargas SET Horometro = :Horometro WHERE ID = :ID_Montacargas");
                $update->bindParam(":Horometro", $Horometro);
                $update->bindParam(":ID_Montacargas", $ID_Montacargas);
                $update->execute();
            }

            return $success; 
        }       
    }
?>
