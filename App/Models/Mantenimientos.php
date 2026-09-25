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

        public function CrearMantenimientoCorrectivoBorrador($ID_Usuario, $NuevoCodigo, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Estado_Firma, $Externo, $Operario_Externo){
            $sql = "INSERT INTO mantenimiento_correctivo (ID_Usuario, Numero, ID_Montacargas, ID_Orden_Trabajo, ID_Centro, ID_Area, ID_Supervisor, ID_Operario, ID_Recibe, Hora_Inicio, Hora_Finalizacion, Fecha_Realizado, Firma_Operario, Firma_Supervisor, Estado_Firma_Supervisor, Estado_Firma_Operario, Fecha_Firma_Operario, Fecha_Firma_Supervisor, Externo, Nombre_Externo,  ExternoRecibe, Nombre_Externo_Recibe, Horometro, Estado)
                    VALUES (:ID_Usuario, :Numero, :ID_Montacargas, NULL, :ID_Centro, :ID_Area, NULL, :ID_Operario, NULL, NULL, NULL, :Fecha, NULL, NULL, :Estado_Firma, :Estado_Firma, NULL, NULL, :Externo, :Operario_Externo, NULL, NULL, NULL,'BORRADOR')";
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
            // $stmt->bindParam(':HoraInicio', $HoraInicio);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
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

        public function EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento) {
            try {
                $sql = "DELETE FROM novedades_mantenimiento 
                        WHERE ID_Mantenimiento = :ID_Mantenimiento 
                        AND ID = :ID_Novedad
                        AND Tipo_Mantenimiento = :Tipo_Mantenimiento";

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
                $sql = "DELETE FROM mantenimiento_correctivo_mecanicos 
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
                $sqlInsert = "INSERT INTO novedades_mantenimiento (ID_Mantenimiento, ID_Montacargas, Descripcion, Estado_Novedad, Fecha_Reporte, Fecha_Correcion, ID_Correcion, Tipo_Mantenimiento) 
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
                           No_montacargas.Serie AS SerieM,
                           No_montacargas.Horometro AS HorometroA,
                           mantenimiento_correctivo.Horometro AS HorometroM,
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_correctivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID
                    LEFT JOIN detalles_mantenimiento_correctivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_correctivo.ID
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
                    WHERE ID_Mantenimiento = :ID 
                    AND Tipo_Mantenimiento = :Tipo";
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
                        WHERE ID_Mantenimiento = :ID_Mantenimiento";
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
                $sql = "SELECT * FROM novedades_mantenimiento WHERE ID_Mantenimiento = :ID_Mantenimiento";
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

        public function VerDetalleM($ID) {
            $sql = "SELECT detalles_mantenimiento_preventivo.*  FROM detalles_mantenimiento_preventivo WHERE detalles_mantenimiento_preventivo.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function VerImagenesM($ID) {
            $sql = "SELECT mantenimiento_preventivo_imagenes.*  FROM mantenimiento_preventivo_imagenes WHERE mantenimiento_preventivo_imagenes.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
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

        // public function ContarMantenimientos($ID_Centro, $Tipo) {
        //     $sql = "SELECT COUNT(*) as NoMantenimientos FROM mantenimiento_preventivo WHERE ID_Centro = :ID_Centro AND Tipo = :Tipo";
        //     $stmt = $this->PDO->prepare($sql);
        //     $stmt->bindParam(':ID_Centro', $ID_Centro);
        //     $stmt->bindParam(':Tipo', $Tipo);
        //     $stmt->execute();
        //     return $stmt->fetch(PDO::FETCH_ASSOC);
        // }

        // public function LeerMantenimientos($ID_Centro, $Tipo) {
        //     $sql = "SELECT usuario_operario.NombreCompleto AS NombreUsuario, 
        //                    No_montacargas.Numero AS NumeroM, 
        //                    No_montacargas.Serie AS SerieM,
        //                    No_montacargas.Horometro AS HorometroA,
        //                    Detalle_mantenimiento.Horometro AS HorometroM,
        //                    mantenimiento_preventivo.*
        //             FROM mantenimiento_preventivo
        //             JOIN usuario AS usuario_operario ON mantenimiento_preventivo.ID_Operario = usuario_operario.ID
        //             JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID
        //             JOIN detalles_mantenimiento_preventivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_preventivo.ID
        //             WHERE mantenimiento_preventivo.ID_Centro = :ID_Centro AND mantenimiento_preventivo.Tipo = :Tipo";
        //     $stmt = $this->PDO->prepare($sql);
        //     $stmt->bindParam(':ID_Centro', $ID_Centro);
        //     $stmt->bindParam(':Tipo', $Tipo);
        //     $stmt->execute();
        //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // }

        

        public function ContarMantenimientosCorrectivoOrden($ID_Centro) {
            $sql = "SELECT COUNT(*) as NoMantenimientos FROM mantenimiento_correctivo WHERE ID_Centro = :ID_Centro AND ID_Orden_Trabajo IS NOT NULL";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function LeerMantenimientosC($ID_Centro) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreUsuario, 
                           No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM,
                           No_montacargas.Horometro AS HorometroA,
                           Detalle_mantenimiento.Horometro AS HorometroM,
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_correctivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID
                    LEFT JOIN detalles_mantenimiento_correctivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_correctivo.ID
                    WHERE mantenimiento_correctivo.ID_Centro = :ID_Centro AND mantenimiento_correctivo.ID_Orden_Trabajo IS NULL";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function LeerMantenimientosCorrectivosOrden($ID_Centro) {
            $sql = "SELECT OrdenTrabajo.Numero AS NumeroO, 
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo
                    LEFT JOIN orden_trabajo AS OrdenTrabajo ON mantenimiento_correctivo.ID_Orden_Trabajo = OrdenTrabajo.ID
                    WHERE mantenimiento_correctivo.ID_Centro = :ID_Centro AND mantenimiento_correctivo.ID_Orden_Trabajo IS NOT NULL";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerMantenimientoC($ID) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreOperario, 
                           usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_mantenimiento.Nombre AS CentroMantenimiento, 
                           area_mantenimiento.Nombre AS AreaMantenimiento,
                           No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM,
                           No_montacargas.Modelo AS ModeloM,
                           No_montacargas.Voltaje AS VoltajeM,
                           Detalle_mantenimiento.Horometro AS HorometroM,
                           Orden.Numero AS NumeroOrden,
                           Orden.Prioridad AS PrioridadOrden,
                           mantenimiento_correctivo.*
                    FROM mantenimiento_correctivo
                    LEFT JOIN usuario AS usuario_operario ON mantenimiento_correctivo.ID_Operario = usuario_operario.ID
                    LEFT JOIN usuario AS usuario_Supervisor ON mantenimiento_correctivo.ID_Supervisor = usuario_Supervisor.ID
                    LEFT JOIN centrot AS centro_mantenimiento ON mantenimiento_correctivo.ID_Centro = centro_mantenimiento.ID
                    LEFT JOIN area AS area_mantenimiento ON mantenimiento_correctivo.ID_Area = area_mantenimiento.ID
                    LEFT JOIN montacargas AS No_montacargas ON mantenimiento_correctivo.ID_Montacargas = No_montacargas.ID
                    LEFT JOIN detalles_mantenimiento_correctivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_correctivo.ID
                    LEFT JOIN orden_trabajo AS Orden ON mantenimiento_correctivo.ID_Orden_Trabajo = Orden.ID
                    WHERE mantenimiento_correctivo.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
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

        public function VerDetalleMC($ID) {
            $sql = "SELECT detalles_mantenimiento_correctivo.*  FROM detalles_mantenimiento_correctivo WHERE detalles_mantenimiento_correctivo.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }        

        public function DataImagenesMC($ID) {
            $sql = "SELECT 
                        ID_Detalle,
                        Categoria,
                        Evidencia_Fotografica
                    FROM mantenimiento_correctivo_imagenes
                    WHERE ID_Mantenimiento = :ID
                    ORDER BY 
                        ID_Detalle ASC,
                        Categoria ASC";

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function RegistrarMantenimiento($ID_Montacargas, $ID_Area, $ID_Operario, $ID_Centro, $ID_Supervisor, $HoraInicio, $Horafinal, $FechaCreado,
                                               $EstadoFirmaOperario, $EstadoFirmaSupervisor, $Tipo){
            $sql = "INSERT INTO mantenimiento_preventivo (ID_Montacargas, ID_Centro, ID_Area, ID_Supervisor, ID_Operario, Hora_Inicio, Hora_Finalizacion, Fecha_Realizado,
                                                          Firma_Operario, Firma_Supervisor, Estado_Firma_Supervisor, Estado_Firma_Operario, Fecha_Firma_Operario, Fecha_Firma_Supervisor, Tipo) 
                    VALUES (:ID_Montacargas, :ID_Centro, :ID_Area, :ID_Supervisor, :ID_Operario, :HoraInicio, :Horafinal, :FechaCreado, NULL, NULL, :EstadoFirmaSupervisor, :EstadoFirmaOperario, NULL, NULL, :Tipo)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Montacargas", $ID_Montacargas);
            $stmt->bindParam(":ID_Area", $ID_Area);
            $stmt->bindParam(":ID_Operario", $ID_Operario);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Supervisor", $ID_Supervisor);
            $stmt->bindParam(":HoraInicio", $HoraInicio);
            $stmt->bindParam(":Horafinal", $Horafinal); 
            $stmt->bindParam(":FechaCreado", $FechaCreado); 
            $stmt->bindParam(":EstadoFirmaOperario", $EstadoFirmaOperario);
            $stmt->bindParam(":EstadoFirmaSupervisor", $EstadoFirmaSupervisor);
            $stmt->bindParam(":Tipo", $Tipo);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function RegistrarDetallesMantenimiento($ID_Montacargas, $ID_Mantenimiento, $NumeroBateria, $NumeroControlador, $NumeroCargador, $Observaciones, $Longitudh, $Horometro, $Criterio_1, $Criterio_2, $Criterio_3, $Criterio_4, $Criterio_5, $Criterio_6, $Criterio_7, $Criterio_8, $Criterio_9, $Criterio_10, $Criterio_11, $Criterio_12, $Criterio_13,
                                                       $Criterio_14, $Criterio_15, $Criterio_16, $Criterio_17, $Criterio_18, $Criterio_19, $Criterio_20, $Criterio_21, $Criterio_22, $Criterio_23, $Criterio_24, $Criterio_25, $Criterio_26, $Criterio_27, $Criterio_28, $Criterio_29, $Criterio_30, $Criterio_31, $Criterio_32, $Criterio_33, $Criterio_34, $Criterio_35,
                                                       $Criterio_36, $Criterio_37, $Criterio_38, $Criterio_39, $Criterio_40, $Criterio_41, $Criterio_42, $Criterio_43, $Criterio_44, $Criterio_45, $Criterio_46, $Criterio_47, $Criterio_48, $Criterio_49, $Criterio_50, $Criterio_51, $Criterio_52, $Criterio_53, $Criterio_54, $Criterio_55, $Criterio_56, $Criterio_57,
                                                       $Criterio_58, $Criterio_59, $Criterio_60, $Criterio_61, $Criterio_62, $Criterio_63, $Criterio_64, $Criterio_65, $Criterio_66, $Criterio_67, $Criterio_68, $Criterio_69, $Criterio_70, $Criterio_71, $Criterio_72, $Criterio_73, $Criterio_74, $Criterio_75, $Criterio_76, $Criterio_77, $Criterio_78, $Criterio_79,
                                                       $Criterio_80, $Criterio_81, $Criterio_82, $Criterio_83, $Criterio_84, $Criterio_85, $Criterio_86, $Criterio_87, $Criterio_88, $Criterio_89, $Criterio_90, $Criterio_91, $Criterio_92, $Criterio_93, $Criterio_94, $Criterio_95, $Criterio_96, $Criterio_97, $Criterio_98, $Criterio_99, $Criterio_100, $Criterio_101,
                                                       $Criterio_102, $Criterio_103, $Criterio_104, $Criterio_105, $Criterio_106, $Criterio_107, $Criterio_108, $Criterio_109, $Criterio_110, $Criterio_111, $Criterio_112, $Criterio_113, $Criterio_114, $Criterio_115, $Criterio_116, $Criterio_117, $Criterio_118, $Criterio_119, $Criterio_120, $Criterio_121, $Criterio_122,
                                                       $Criterio_123, $Criterio_124, $Criterio_125, $Criterio_126, $Criterio_127, $Criterio_128, $Criterio_129, $Criterio_130,$Criterio_131,$Criterio_132,$Criterio_133,$Criterio_134,$Criterio_135,$Criterio_136,$Criterio_137,$Criterio_138,$Criterio_139){
            $sql = "INSERT INTO detalles_mantenimiento_preventivo (ID_Mantenimiento, Numero_Bateria, Numero_Controlador, Numero_Cargador, Observaciones, Horometro, Longitud, Criterio_1, Criterio_2, Criterio_3, Criterio_4, Criterio_5, Criterio_6, Criterio_7, Criterio_8, Criterio_9, Criterio_10, Criterio_11, Criterio_12, Criterio_13, Criterio_14, Criterio_15, Criterio_16, Criterio_17, Criterio_18, Criterio_19, Criterio_20,
                                                                   Criterio_21, Criterio_22, Criterio_23, Criterio_24, Criterio_25, Criterio_26, Criterio_27, Criterio_28, Criterio_29, Criterio_30, Criterio_31, Criterio_32, Criterio_33, Criterio_34, Criterio_35, Criterio_36, Criterio_37, Criterio_38, Criterio_39, Criterio_40, Criterio_41, Criterio_42, Criterio_43, Criterio_44, Criterio_45, Criterio_46, Criterio_47,
                                                                   Criterio_48, Criterio_49, Criterio_50, Criterio_51, Criterio_52, Criterio_53, Criterio_54, Criterio_55, Criterio_56, Criterio_57, Criterio_58, Criterio_59, Criterio_60, Criterio_61, Criterio_62, Criterio_63, Criterio_64, Criterio_65, Criterio_66, Criterio_67, Criterio_68, Criterio_69, Criterio_70, Criterio_71, Criterio_72, Criterio_73, Criterio_74,
                                                                   Criterio_75, Criterio_76, Criterio_77, Criterio_78, Criterio_79, Criterio_80, Criterio_81, Criterio_82, Criterio_83, Criterio_84, Criterio_85, Criterio_86, Criterio_87, Criterio_88, Criterio_89, Criterio_90, Criterio_91, Criterio_92, Criterio_93, Criterio_94, Criterio_95, Criterio_96, Criterio_97, Criterio_98, Criterio_99, Criterio_100, Criterio_101, 
                                                                   Criterio_102, Criterio_103, Criterio_104, Criterio_105, Criterio_106, Criterio_107, Criterio_108, Criterio_109, Criterio_110, Criterio_111, Criterio_112, Criterio_113, Criterio_114, Criterio_115, Criterio_116, Criterio_117, Criterio_118, Criterio_119, Criterio_120, Criterio_121, Criterio_122, Criterio_123, Criterio_124, Criterio_125, Criterio_126, Criterio_127, 
                                                                   Criterio_128, Criterio_129, Criterio_130, Criterio_131, Criterio_132, Criterio_133, Criterio_134, Criterio_135, Criterio_136, Criterio_137, Criterio_138, Criterio_139)
                    VALUES (:ID_Mantenimiento, :NumeroBateria, :NumeroControlador, :NumeroCargador, :Observaciones, :Horometro, :Longitudh, :Criterio_1, :Criterio_2, :Criterio_3, :Criterio_4, :Criterio_5, :Criterio_6, :Criterio_7, :Criterio_8, :Criterio_9, :Criterio_10, :Criterio_11, :Criterio_12, :Criterio_13, :Criterio_14, :Criterio_15, :Criterio_16, :Criterio_17, :Criterio_18, :Criterio_19, :Criterio_20, :Criterio_21, 
                            :Criterio_22, :Criterio_23, :Criterio_24, :Criterio_25, :Criterio_26, :Criterio_27, :Criterio_28, :Criterio_29, :Criterio_30, :Criterio_31, :Criterio_32, :Criterio_33, :Criterio_34, :Criterio_35, :Criterio_36, :Criterio_37, :Criterio_38, :Criterio_39, :Criterio_40, :Criterio_41, :Criterio_42, :Criterio_43, :Criterio_44, :Criterio_45, :Criterio_46, :Criterio_47, :Criterio_48, :Criterio_49, 
                            :Criterio_50, :Criterio_51, :Criterio_52, :Criterio_53, :Criterio_54, :Criterio_55, :Criterio_56, :Criterio_57, :Criterio_58, :Criterio_59, :Criterio_60, :Criterio_61, :Criterio_62, :Criterio_63, :Criterio_64, :Criterio_65, :Criterio_66, :Criterio_67, :Criterio_68, :Criterio_69, :Criterio_70, :Criterio_71, :Criterio_72, :Criterio_73, :Criterio_74, :Criterio_75, :Criterio_76, :Criterio_77,
                            :Criterio_78, :Criterio_79, :Criterio_80, :Criterio_81, :Criterio_82, :Criterio_83, :Criterio_84, :Criterio_85, :Criterio_86, :Criterio_87, :Criterio_88, :Criterio_89, :Criterio_90, :Criterio_91, :Criterio_92, :Criterio_93, :Criterio_94, :Criterio_95, :Criterio_96, :Criterio_97, :Criterio_98, :Criterio_99, :Criterio_100, :Criterio_101, :Criterio_102, :Criterio_103, :Criterio_104, :Criterio_105, 
                            :Criterio_106, :Criterio_107, :Criterio_108, :Criterio_109, :Criterio_110, :Criterio_111, :Criterio_112, :Criterio_113, :Criterio_114, :Criterio_115, :Criterio_116, :Criterio_117, :Criterio_118, :Criterio_119, :Criterio_120, :Criterio_121, :Criterio_122, :Criterio_123, :Criterio_124, :Criterio_125, :Criterio_126, :Criterio_127, :Criterio_128, :Criterio_129, :Criterio_130, :Criterio_131, :Criterio_132,
                            :Criterio_133, :Criterio_134, :Criterio_135, :Criterio_136, :Criterio_137, :Criterio_138, :Criterio_139)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":NumeroBateria", $NumeroBateria);
            $stmt->bindParam(":NumeroControlador", $NumeroControlador);
            $stmt->bindParam(":NumeroCargador", $NumeroCargador);
            $stmt->bindParam(":Observaciones", $Observaciones);
            $stmt->bindParam(":Horometro", $Horometro);
            $stmt->bindParam(":Longitudh", $Longitudh);
            $stmt->bindParam(":Criterio_1", $Criterio_1);
            $stmt->bindParam(":Criterio_2", $Criterio_2);
            $stmt->bindParam(":Criterio_3", $Criterio_3);
            $stmt->bindParam(":Criterio_4", $Criterio_4);
            $stmt->bindParam(":Criterio_5", $Criterio_5);
            $stmt->bindParam(":Criterio_6", $Criterio_6);
            $stmt->bindParam(":Criterio_7", $Criterio_7);
            $stmt->bindParam(":Criterio_8", $Criterio_8);
            $stmt->bindParam(":Criterio_9", $Criterio_9);
            $stmt->bindParam(":Criterio_10", $Criterio_10);
            $stmt->bindParam(":Criterio_11", $Criterio_11);
            $stmt->bindParam(":Criterio_12", $Criterio_12);
            $stmt->bindParam(":Criterio_13", $Criterio_13);
            $stmt->bindParam(":Criterio_14", $Criterio_14);
            $stmt->bindParam(":Criterio_15", $Criterio_15);
            $stmt->bindParam(":Criterio_16", $Criterio_16);
            $stmt->bindParam(":Criterio_17", $Criterio_17);
            $stmt->bindParam(":Criterio_18", $Criterio_18);
            $stmt->bindParam(":Criterio_19", $Criterio_19);
            $stmt->bindParam(":Criterio_20", $Criterio_20);
            $stmt->bindParam(":Criterio_21", $Criterio_21);
            $stmt->bindParam(":Criterio_22", $Criterio_22);
            $stmt->bindParam(":Criterio_23", $Criterio_23);
            $stmt->bindParam(":Criterio_24", $Criterio_24);
            $stmt->bindParam(":Criterio_25", $Criterio_25);
            $stmt->bindParam(":Criterio_26", $Criterio_26);
            $stmt->bindParam(":Criterio_27", $Criterio_27);
            $stmt->bindParam(":Criterio_28", $Criterio_28);
            $stmt->bindParam(":Criterio_29", $Criterio_29);
            $stmt->bindParam(":Criterio_30", $Criterio_30);
            $stmt->bindParam(":Criterio_31", $Criterio_31);
            $stmt->bindParam(":Criterio_32", $Criterio_32);
            $stmt->bindParam(":Criterio_33", $Criterio_33);
            $stmt->bindParam(":Criterio_34", $Criterio_34);
            $stmt->bindParam(":Criterio_35", $Criterio_35);
            $stmt->bindParam(":Criterio_36", $Criterio_36);
            $stmt->bindParam(":Criterio_37", $Criterio_37);
            $stmt->bindParam(":Criterio_38", $Criterio_38);
            $stmt->bindParam(":Criterio_39", $Criterio_39);
            $stmt->bindParam(":Criterio_40", $Criterio_40);
            $stmt->bindParam(":Criterio_41", $Criterio_41);
            $stmt->bindParam(":Criterio_42", $Criterio_42);
            $stmt->bindParam(":Criterio_43", $Criterio_43);
            $stmt->bindParam(":Criterio_44", $Criterio_44);
            $stmt->bindParam(":Criterio_45", $Criterio_45);
            $stmt->bindParam(":Criterio_46", $Criterio_46);
            $stmt->bindParam(":Criterio_47", $Criterio_47);
            $stmt->bindParam(":Criterio_48", $Criterio_48);
            $stmt->bindParam(":Criterio_49", $Criterio_49);
            $stmt->bindParam(":Criterio_50", $Criterio_50);
            $stmt->bindParam(":Criterio_51", $Criterio_51);
            $stmt->bindParam(":Criterio_52", $Criterio_52);
            $stmt->bindParam(":Criterio_53", $Criterio_53);
            $stmt->bindParam(":Criterio_54", $Criterio_54);
            $stmt->bindParam(":Criterio_55", $Criterio_55);
            $stmt->bindParam(":Criterio_56", $Criterio_56);
            $stmt->bindParam(":Criterio_57", $Criterio_57);
            $stmt->bindParam(":Criterio_58", $Criterio_58);
            $stmt->bindParam(":Criterio_59", $Criterio_59);
            $stmt->bindParam(":Criterio_60", $Criterio_60);
            $stmt->bindParam(":Criterio_61", $Criterio_61);
            $stmt->bindParam(":Criterio_62", $Criterio_62);
            $stmt->bindParam(":Criterio_63", $Criterio_63);
            $stmt->bindParam(":Criterio_64", $Criterio_64);
            $stmt->bindParam(":Criterio_65", $Criterio_65);
            $stmt->bindParam(":Criterio_66", $Criterio_66);
            $stmt->bindParam(":Criterio_67", $Criterio_67);
            $stmt->bindParam(":Criterio_68", $Criterio_68);
            $stmt->bindParam(":Criterio_69", $Criterio_69);
            $stmt->bindParam(":Criterio_70", $Criterio_70);
            $stmt->bindParam(":Criterio_71", $Criterio_71);
            $stmt->bindParam(":Criterio_72", $Criterio_72);
            $stmt->bindParam(":Criterio_73", $Criterio_73);
            $stmt->bindParam(":Criterio_74", $Criterio_74);
            $stmt->bindParam(":Criterio_75", $Criterio_75);
            $stmt->bindParam(":Criterio_76", $Criterio_76);
            $stmt->bindParam(":Criterio_77", $Criterio_77);
            $stmt->bindParam(":Criterio_78", $Criterio_78);
            $stmt->bindParam(":Criterio_79", $Criterio_79);
            $stmt->bindParam(":Criterio_80", $Criterio_80);
            $stmt->bindParam(":Criterio_81", $Criterio_81);
            $stmt->bindParam(":Criterio_82", $Criterio_82);
            $stmt->bindParam(":Criterio_83", $Criterio_83);
            $stmt->bindParam(":Criterio_84", $Criterio_84);
            $stmt->bindParam(":Criterio_85", $Criterio_85);
            $stmt->bindParam(":Criterio_86", $Criterio_86);
            $stmt->bindParam(":Criterio_87", $Criterio_87);
            $stmt->bindParam(":Criterio_88", $Criterio_88);
            $stmt->bindParam(":Criterio_89", $Criterio_89);
            $stmt->bindParam(":Criterio_90", $Criterio_90);
            $stmt->bindParam(":Criterio_91", $Criterio_91);
            $stmt->bindParam(":Criterio_92", $Criterio_92);
            $stmt->bindParam(":Criterio_93", $Criterio_93);
            $stmt->bindParam(":Criterio_94", $Criterio_94);
            $stmt->bindParam(":Criterio_95", $Criterio_95);
            $stmt->bindParam(":Criterio_96", $Criterio_96);
            $stmt->bindParam(":Criterio_97", $Criterio_97);
            $stmt->bindParam(":Criterio_98", $Criterio_98);
            $stmt->bindParam(":Criterio_99", $Criterio_99);
            $stmt->bindParam(":Criterio_100", $Criterio_100);
            $stmt->bindParam(":Criterio_101", $Criterio_101);
            $stmt->bindParam(":Criterio_102", $Criterio_102);
            $stmt->bindParam(":Criterio_103", $Criterio_103);
            $stmt->bindParam(":Criterio_104", $Criterio_104);
            $stmt->bindParam(":Criterio_105", $Criterio_105);
            $stmt->bindParam(":Criterio_106", $Criterio_106);
            $stmt->bindParam(":Criterio_107", $Criterio_107);
            $stmt->bindParam(":Criterio_108", $Criterio_108);
            $stmt->bindParam(":Criterio_109", $Criterio_109);
            $stmt->bindParam(":Criterio_110", $Criterio_110);
            $stmt->bindParam(":Criterio_111", $Criterio_111);
            $stmt->bindParam(":Criterio_112", $Criterio_112);
            $stmt->bindParam(":Criterio_113", $Criterio_113);
            $stmt->bindParam(":Criterio_114", $Criterio_114);
            $stmt->bindParam(":Criterio_115", $Criterio_115);
            $stmt->bindParam(":Criterio_116", $Criterio_116);
            $stmt->bindParam(":Criterio_117", $Criterio_117);
            $stmt->bindParam(":Criterio_118", $Criterio_118);
            $stmt->bindParam(":Criterio_119", $Criterio_119);
            $stmt->bindParam(":Criterio_120", $Criterio_120);
            $stmt->bindParam(":Criterio_121", $Criterio_121);
            $stmt->bindParam(":Criterio_122", $Criterio_122);
            $stmt->bindParam(":Criterio_123", $Criterio_123);
            $stmt->bindParam(":Criterio_124", $Criterio_124);
            $stmt->bindParam(":Criterio_125", $Criterio_125);
            $stmt->bindParam(":Criterio_126", $Criterio_126);
            $stmt->bindParam(":Criterio_127", $Criterio_127);
            $stmt->bindParam(":Criterio_128", $Criterio_128);
            $stmt->bindParam(":Criterio_129", $Criterio_129);
            $stmt->bindParam(":Criterio_130", $Criterio_130);
            $stmt->bindParam(":Criterio_131", $Criterio_131);
            $stmt->bindParam(":Criterio_132", $Criterio_132);
            $stmt->bindParam(":Criterio_133", $Criterio_133);
            $stmt->bindParam(":Criterio_134", $Criterio_134);
            $stmt->bindParam(":Criterio_135", $Criterio_135);
            $stmt->bindParam(":Criterio_136", $Criterio_136);
            $stmt->bindParam(":Criterio_137", $Criterio_137);
            $stmt->bindParam(":Criterio_138", $Criterio_138);
            $stmt->bindParam(":Criterio_139", $Criterio_139);
            $success = $stmt->execute();

            if ($success) {
                // --- Actualizar Horómetro y Longitud ---
                $update = $this->PDO->prepare("UPDATE montacargas SET Horometro = :Horometro, Horquillas = :Longitudh WHERE ID = :ID_Montacargas");
                $update->bindParam(":Horometro", $Horometro);
                $update->bindParam(":Longitudh", $Longitudh);
                $update->bindParam(":ID_Montacargas", $ID_Montacargas);
                $update->execute();
            }

            return $success; 
        }

        public function RegistrarMantenimientoEvidencia($ID_Mantenimiento, $Categoria, $uploadFile){
            $sql = "INSERT INTO mantenimiento_preventivo_imagenes (ID_Mantenimiento, Categoria, Evidencia_Fotografica) 
                    VALUES (:ID_Mantenimiento, :Categoria, :Evidencia_Fotografica)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":Categoria", $Categoria);
            $stmt->bindParam(":Evidencia_Fotografica", $uploadFile);
            return $stmt->execute();
        }

        public function RegistrarMantenimientoCorrectivo($ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro, $ID_Supervisor, $HoraInicio, $Horafinal, $FechaCreado, $EstadoFirmaOperario, $EstadoFirmaSupervisor, $NuevoCodigo){
            $sql = "INSERT INTO mantenimiento_correctivo(Numero, ID_Montacargas, ID_Orden_Trabajo, ID_Centro, ID_Area, ID_Supervisor, ID_Operario, Hora_Inicio, Hora_Finalizacion, Fecha_Realizado,
                                                         Firma_Operario, Firma_Supervisor, Estado_Firma_Supervisor, Estado_Firma_Operario, Fecha_Firma_Operario, Fecha_Firma_Supervisor)
                    VALUES (:NuevoCodigo, :ID_Montacargas, NULL, :ID_Centro, :ID_Area, :ID_Supervisor, :ID_Operario, :HoraInicio, :Horafinal, :FechaCreado, NULL, NULL, :EstadoFirmaSupervisor, :EstadoFirmaOperario, NULL, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":NuevoCodigo", $NuevoCodigo);
            $stmt->bindParam(":ID_Montacargas", $ID_Montacargas); 
            $stmt->bindParam(":ID_Area", $ID_Area);
            $stmt->bindParam(":ID_Operario", $ID_Operario);
            $stmt->bindParam(":ID_Centro", $ID_Centro);
            $stmt->bindParam(":ID_Supervisor", $ID_Supervisor);
            $stmt->bindParam(":HoraInicio", $HoraInicio);
            $stmt->bindParam(":Horafinal", $Horafinal);
            $stmt->bindParam(":FechaCreado", $FechaCreado);
            $stmt->bindParam(":EstadoFirmaOperario", $EstadoFirmaOperario);
            $stmt->bindParam(":EstadoFirmaSupervisor", $EstadoFirmaSupervisor);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function RegistrarDetallesMantenimientoCorrectivo($ID_Montacargas, $ID_Mantenimiento, $Horometro, $Falla, $Reparacion, $Observaciones, $FechaCorrecion, $FallaC, $Pendiente){
            $sql = "INSERT INTO detalles_mantenimiento_correctivo (ID_Mantenimiento, ID_Detalle, Horometro, Descripcion_Falla, Reparacion_Realizada, FallaC, Fecha_Correcion, Pendiente, Observaciones)
                    VALUES (:ID_Mantenimiento, NULL, :Horometro, :Falla, :Reparacion, :FallaC, :FechaCorrecion, :Pendiente, :Observaciones)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":Horometro", $Horometro);
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

        public function RegistrarMantenimientoCorrectivoEvidencia($ID_Mantenimiento, $Categoria, $uploadFile){
            $sql = "INSERT INTO mantenimiento_correctivo_imagenes (ID_Mantenimiento, ID_Detalle, Categoria, Evidencia_Fotografica) 
                    VALUES (:ID_Mantenimiento, NULL, :Categoria, :Evidencia_Fotografica)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":Categoria", $Categoria);
            $stmt->bindParam(":Evidencia_Fotografica", $uploadFile);
            return $stmt->execute();
        }

        public function RegistrarTrabajoPendiente($ID_Mantenimiento, $Descripcion,$Tipo_Trabajo, $Estado_Trabajo){
            $sql = "INSERT INTO trabajos_overhauling (ID_Overhauling, Seccion, Criterio, Tipo, Descripcion, Tipo_Trabajo, Estado_Trabajo) 
                    VALUES (:ID_Mantenimiento, NULL, NULL, NULL, :Descripcion, :Tipo_Trabajo, :Estado_Trabajo)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":Descripcion", $Descripcion);
            $stmt->bindParam(":Tipo_Trabajo", $Tipo_Trabajo);
            $stmt->bindParam(":Estado_Trabajo", $Estado_Trabajo);
            return $stmt->execute();
        }

        public function ObtenerTecnicosMantenimiento($ID){
            $sql = "SELECT mp.ID_Mecanico, u.NombreCompleto AS Nombre_Mecanico
                    FROM mantenimiento_preventivo_mecanicos mp
                    JOIN usuario u ON mp.ID_Mecanico = u.ID
                    WHERE mp.ID_Mantenimiento = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID);
            $stmt->execute();
            $DataTecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataTecnicos;
        }

        public function ObtenerMantenimiento($ID){
            $sql = "SELECT * FROM mantenimiento_preventivo WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            $DataMantenimiento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataMantenimiento;
        }

        

        

        public function FirmarMantenimiento($ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico){
            $sql = "UPDATE mantenimiento_preventivo_mecanicos 
                    SET Firma_Mecanico = :Firma_Mecanico, Fecha_Firma_Mecanico = :Fecha_Firma_Mecanico, Estado_Firma_Mecanico = :Estado_Firma_Mecanico
                    WHERE ID_Mantenimiento = :ID_Mantenimiento AND ID_Mecanico = :ID_Mecanico";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Mecanico", $Firma);
            $stmt->bindParam(":Fecha_Firma_Mecanico", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Mecanico", $EstadoFirmaMecanico);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":ID_Mecanico", $ID_Mecanico);
            return $stmt->execute();
        }

        public function FirmarMantenimientoOperario($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaOperario){
            $sql = "UPDATE mantenimiento_preventivo SET Firma_Operario = :Firma_Operario, Fecha_Firma_Operario = :Fecha_Firma_Operario, Estado_Firma_Operario = :Estado_Firma_Operario WHERE ID = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Operario", $Firma);
            $stmt->bindParam(":Fecha_Firma_Operario", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Operario", $EstadoFirmaOperario);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            return $stmt->execute();
        }

        public function FirmarMantenimientoSupervisor($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor){
            $sql = "UPDATE mantenimiento_preventivo SET Firma_Supervisor = :Firma_Supervisor, Fecha_Firma_Supervisor = :Fecha_Firma_Supervisor, Estado_Firma_Supervisor = :Estado_Firma_Supervisor WHERE ID = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Supervisor", $Firma);
            $stmt->bindParam(":Fecha_Firma_Supervisor", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Supervisor", $EstadoFirmaSupervisor);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            return $stmt->execute();
        }

        public function ObtenerTecnicosMantenimientoC($ID){
            $sql = "SELECT mp.ID_Mecanico, u.NombreCompleto AS Nombre_Mecanico
                    FROM mantenimiento_correctivo_mecanicos mp
                    JOIN usuario u ON mp.ID_Mecanico = u.ID
                    WHERE mp.ID_Mantenimiento = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Mantenimiento', $ID);
            $stmt->execute();
            $DataTecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataTecnicos;
        }

        public function ObtenerMantenimientoC($ID){
            $sql = "SELECT * FROM mantenimiento_correctivo WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            $DataMantenimiento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataMantenimiento;
        }

        public function FirmarMantenimientoCorrectivo($ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico){
            $sql = "UPDATE mantenimiento_correctivo_mecanicos 
                    SET Firma_Mecanico = :Firma_Mecanico, Fecha_Firma_Mecanico = :Fecha_Firma_Mecanico, Estado_Firma_Mecanico = :Estado_Firma_Mecanico
                    WHERE ID_Mantenimiento = :ID_Mantenimiento AND ID_Mecanico = :ID_Mecanico";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Mecanico", $Firma);
            $stmt->bindParam(":Fecha_Firma_Mecanico", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Mecanico", $EstadoFirmaMecanico);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            $stmt->bindParam(":ID_Mecanico", $ID_Mecanico);
            return $stmt->execute();
        }

        public function FirmarMantenimientoOperarioCorrectivo($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaOperario){
            $sql = "UPDATE mantenimiento_correctivo SET Firma_Operario = :Firma_Operario, Fecha_Firma_Operario = :Fecha_Firma_Operario, Estado_Firma_Operario = :Estado_Firma_Operario WHERE ID = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Operario", $Firma);
            $stmt->bindParam(":Fecha_Firma_Operario", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Operario", $EstadoFirmaOperario);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            return $stmt->execute();
        }

        public function FirmarMantenimientoSupervisorC($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor){
            $sql = "UPDATE mantenimiento_correctivo SET Firma_Supervisor = :Firma_Supervisor, Fecha_Firma_Supervisor = :Fecha_Firma_Supervisor, Estado_Firma_Supervisor = :Estado_Firma_Supervisor WHERE ID = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Supervisor", $Firma);
            $stmt->bindParam(":Fecha_Firma_Supervisor", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Supervisor", $EstadoFirmaSupervisor);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            return $stmt->execute();
        }
    }
    
?>