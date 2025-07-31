<?php
    class Inspecciones {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function RegistrarInspeccionPuestoDeTrabajo($idCentro, $fecha, $idMontacargas, $idPersonaRegistra, $idPersonaEvaluada, $recomendacionesMedicas, $observaciones, $usoCorrectoEPP, $criterios){
            $Estado = "2";
            $sql = "INSERT INTO inspecciones_puesto_de_trabajo (ID_Centro, Estado, Fecha, ID_Montacargas, ID_Persona_Registra, ID_Persona_Evaluada, Recomendaciones_Medicas, Observaciones, Uso_Correcto_EPP, Criterio_1, Criterio_2, Criterio_3, Criterio_4, Criterio_5, Criterio_6, Criterio_7, Criterio_8, Criterio_9, Criterio_10, Criterio_11, Criterio_12, Criterio_13, Criterio_14, Criterio_15, Criterio_16, Criterio_17, Criterio_18, Criterio_19, Criterio_20, Criterio_21, Criterio_22, Criterio_23, Criterio_24, Criterio_25, Criterio_26, Criterio_27, Criterio_28, Criterio_29, Criterio_30, Criterio_31, Criterio_32, Criterio_33, Criterio_34) 
                VALUES (:ID_Centro, :Estado, :Fecha, :ID_Montacargas, :ID_Persona_Registra, :ID_Persona_Evaluada, :Recomendaciones_Medicas, :Observaciones, :Uso_Correcto_EPP, :Criterio_1, :Criterio_2, :Criterio_3, :Criterio_4, :Criterio_5, :Criterio_6, :Criterio_7, :Criterio_8, :Criterio_9, :Criterio_10, :Criterio_11, :Criterio_12, :Criterio_13, :Criterio_14, :Criterio_15, :Criterio_16, :Criterio_17, :Criterio_18, :Criterio_19, :Criterio_20, :Criterio_21, :Criterio_22, :Criterio_23, :Criterio_24, :Criterio_25, :Criterio_26, :Criterio_27, :Criterio_28, :Criterio_29, :Criterio_30, :Criterio_31, :Criterio_32, :Criterio_33, :Criterio_34)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $idCentro);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':Fecha', $fecha);
            $stmt->bindParam(':ID_Montacargas', $idMontacargas);
            $stmt->bindParam(':ID_Persona_Registra', $idPersonaRegistra);
            $stmt->bindParam(':ID_Persona_Evaluada', $idPersonaEvaluada);
            $stmt->bindParam(':Recomendaciones_Medicas', $recomendacionesMedicas);
            $stmt->bindParam(':Observaciones', $observaciones);
            $stmt->bindParam(':Uso_Correcto_EPP', $usoCorrectoEPP);
            $stmt->bindParam(':Criterio_1', $criterios['criterio1']);
            $stmt->bindParam(':Criterio_2', $criterios['criterio2']);
            $stmt->bindParam(':Criterio_3', $criterios['criterio3']);
            $stmt->bindParam(':Criterio_4', $criterios['criterio4']);
            $stmt->bindParam(':Criterio_5', $criterios['criterio5']);
            $stmt->bindParam(':Criterio_6', $criterios['criterio6']);
            $stmt->bindParam(':Criterio_7', $criterios['criterio7']);
            $stmt->bindParam(':Criterio_8', $criterios['criterio8']);
            $stmt->bindParam(':Criterio_9', $criterios['criterio9']);
            $stmt->bindParam(':Criterio_10', $criterios['criterio10']);
            $stmt->bindParam(':Criterio_11', $criterios['criterio11']);
            $stmt->bindParam(':Criterio_12', $criterios['criterio12']);
            $stmt->bindParam(':Criterio_13', $criterios['criterio13']);
            $stmt->bindParam(':Criterio_14', $criterios['criterio14']);
            $stmt->bindParam(':Criterio_15', $criterios['criterio15']);
            $stmt->bindParam(':Criterio_16', $criterios['criterio16']);
            $stmt->bindParam(':Criterio_17', $criterios['criterio17']);
            $stmt->bindParam(':Criterio_18', $criterios['criterio18']);
            $stmt->bindParam(':Criterio_19', $criterios['criterio19']);
            $stmt->bindParam(':Criterio_20', $criterios['criterio20']);
            $stmt->bindParam(':Criterio_21', $criterios['criterio21']);
            $stmt->bindParam(':Criterio_22', $criterios['criterio22']);
            $stmt->bindParam(':Criterio_23', $criterios['criterio23']);
            $stmt->bindParam(':Criterio_24', $criterios['criterio24']);
            $stmt->bindParam(':Criterio_25', $criterios['criterio25']);
            $stmt->bindParam(':Criterio_26', $criterios['criterio26']);
            $stmt->bindParam(':Criterio_27', $criterios['criterio27']);
            $stmt->bindParam(':Criterio_28', $criterios['criterio28']);
            $stmt->bindParam(':Criterio_29', $criterios['criterio29']);
            $stmt->bindParam(':Criterio_30', $criterios['criterio30']);
            $stmt->bindParam(':Criterio_31', $criterios['criterio31']);
            $stmt->bindParam(':Criterio_32', $criterios['criterio32']);
            $stmt->bindParam(':Criterio_33', $criterios['criterio33']);
            $stmt->bindParam(':Criterio_34', $criterios['criterio34']);            
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            } else {
                return false;
            }
        }  

        public function RegistrarCondicionesInspeccionPuestoDeTrabajo($result, $condiciones){
            $sql = "INSERT INTO inspecciones_puesto_de_trabajo_condiciones (ID_Puesto_De_Trabajo, consecutivo, descripcion) VALUES (:ID_Puesto_De_Trabajo, :consecutivo, :descripcion)";
            $stmt = $this->PDO->prepare($sql);
            foreach ($condiciones as $index => $descripcion) {
                $consecutivo = $index + 1;
                $stmt->bindParam(':ID_Puesto_De_Trabajo', $result);
                $stmt->bindParam(':consecutivo', $consecutivo);
                $stmt->bindParam(':descripcion', $descripcion['descripcion']);
                if (!$stmt->execute()) {
                    return false;
                }
            }
            return true;
        }

        public function ObtenerNombreRegistra($ID){
            $sql = "SELECT ID, ID_Persona_Registra, ID_Persona_Evaluada FROM inspecciones_puesto_de_trabajo WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ObtenerElNombre($ID){
            $sql = "SELECT * FROM usuario WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function FirmarRegistra($ID, $firma) {
            $Estado = 3;
            $sql = "UPDATE inspecciones_puesto_de_trabajo SET Estado = :Estado, Firma_Persona_Registra = :Firma_Persona_Registra WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':Firma_Persona_Registra', $firma);
            return $stmt->execute();
        }

        public function FirmarEvaluada($ID, $firma) {
            $Estado = 1;
            $sql = "UPDATE inspecciones_puesto_de_trabajo SET Estado = :Estado, Firma_Persona_Evaluada = :Firma_Persona_Evaluada WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':Firma_Persona_Evaluada', $firma);
            return $stmt->execute();
        }
    }
    
?>