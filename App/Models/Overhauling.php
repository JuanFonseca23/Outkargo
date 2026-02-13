<?php
    class Overhauling {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function ActualizarEstadoTrabajoOverhauling($ID_Mantenimiento, $EstadoTrabajo){
            $sql = "UPDATE trabajos_overhauling SET Estado_Trabajo = :Estado_Trabajo WHERE ID_Overhauling = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Estado_Trabajo", $EstadoTrabajo);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            return $stmt->execute();
        }

        public function ContarDiagnosticos($ID_Centro) {
            $sql = "SELECT COUNT(*) as NoDiagnosticos FROM overhauling_inicial WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function DataImagenesM($ID) {
            $sql = "SELECT overhauling_inicial_imagenes.*  FROM overhauling_inicial_imagenes WHERE overhauling_inicial_imagenes.ID_Overhauling = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function FirmarDiagnostico($ID_Diagnostico, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico){
            $sql = "UPDATE overhauling_inicial_mecanico 
                    SET Firma_Mecanico = :Firma_Mecanico, Fecha_Firma_Mecanico = :Fecha_Firma_Mecanico, Estado_Firma_Mecanico = :Estado_Firma_Mecanico
                    WHERE ID_Overhauling = :ID_Diagnostico AND ID_Mecanico = :ID_Mecanico";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Mecanico", $Firma);
            $stmt->bindParam(":Fecha_Firma_Mecanico", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Mecanico", $EstadoFirmaMecanico);
            $stmt->bindParam(":ID_Diagnostico", $ID_Diagnostico);
            $stmt->bindParam(":ID_Mecanico", $ID_Mecanico);
            return $stmt->execute();
        }

        public function FirmarOverhaulingSupervisor($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor){
            $sql = "UPDATE overhauling_inicial SET Firma_Supervisor = :Firma_Supervisor, Fecha_Firma_Supervisor = :Fecha_Firma_Supervisor, Estado_Firma_Supervisor = :Estado_Firma_Supervisor WHERE ID = :ID_Mantenimiento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":Firma_Supervisor", $Firma);
            $stmt->bindParam(":Fecha_Firma_Supervisor", $FechaFirma);
            $stmt->bindParam(":Estado_Firma_Supervisor", $EstadoFirmaSupervisor);
            $stmt->bindParam(":ID_Mantenimiento", $ID_Mantenimiento);
            return $stmt->execute();
        }

        public function LeerDiagnosticos($ID_Centro) {
            $sql = "SELECT usuario_supervisor.NombreCompleto AS NombreUsuario, 
                           Detalle_Overhauling.Serie AS Serie,
                           Detalle_Overhauling.Modelo AS Modelo,
                           Detalle_Overhauling.Marca AS Marca,
                           overhauling_inicial.*
                    FROM overhauling_inicial
                    JOIN usuario AS usuario_supervisor ON overhauling_inicial.ID_Supervisor = usuario_supervisor.ID
                    JOIN detalles_overhauling_inicial AS Detalle_Overhauling ON Detalle_Overhauling.ID_Overhauling = overhauling_inicial.ID
                    WHERE overhauling_inicial.ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

         public function ObtenerDiagnostico($ID){
            $sql = "SELECT * FROM overhauling_inicial WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            $DataMantenimiento = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataMantenimiento;
        }

        public function ObtenerTecnicosOverhauling($ID){
            $sql = "SELECT oim.ID_Mecanico, u.NombreCompleto AS Nombre_Mecanico
                    FROM overhauling_inicial_mecanico oim
                    JOIN usuario u ON oim.ID_Mecanico = u.ID
                    WHERE oim.ID_Overhauling = :ID_Overhauling";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Overhauling', $ID);
            $stmt->execute();
            $DataTecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataTecnicos;
        }

        public function ObtenerUltimoCodigoDiagnostico() {
            $sql = "SELECT Numero FROM overhauling_inicial ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function RegistrarDetallesOverhauling($ID_Diagnostico, $Serie, $Modelo, $Marca, $ClaseH, $LongitudH, $Horometro, $Voltaje,
                                                                        $Criterio_1, $Criterio_2, $Criterio_3, $Criterio_4, $Criterio_5, $Criterio_6, $Criterio_7, $Criterio_8, $Criterio_9, $Criterio_10,
                                                                        $Criterio_11, $Criterio_12, $Criterio_13, $Criterio_14, $Criterio_15, $Criterio_16, $Criterio_17, $Criterio_18, $Criterio_19, $Criterio_20,
                                                                        $Criterio_21, $Criterio_22, $Criterio_23, $Criterio_24, $Criterio_25, $Criterio_26, $Criterio_27, $Criterio_28, $Criterio_29, $Criterio_30,
                                                                        $Criterio_31, $Criterio_32, $Criterio_33, $Criterio_34, $Criterio_35, $Criterio_36, $Criterio_37, $Criterio_38, $Criterio_39, $Criterio_40,
                                                                        $Criterio_41, $Criterio_42, $Criterio_43, $Criterio_44, $Criterio_45, $Criterio_46, $Criterio_47, $Criterio_48, $Criterio_49, $Criterio_50,
                                                                        $Criterio_51, $Criterio_52, $Criterio_53, $Criterio_54, $Criterio_55, $Criterio_56, $Criterio_57, $Criterio_58, $Criterio_59, $Criterio_60,
                                                                        $Criterio_61, $Criterio_62, $Criterio_63, $Criterio_64, $Criterio_65, $Criterio_66, $Criterio_67, $Criterio_68, $Criterio_69, $Criterio_70,
                                                                        $Criterio_71, $Criterio_72, $Criterio_73, $Criterio_74, $Criterio_75, $Criterio_76, $Criterio_77, $Criterio_78, $Criterio_79, $Criterio_80,
                                                                        $Criterio_81, $Criterio_82, $Criterio_83, $Criterio_84, $Criterio_85, $Criterio_86, $Criterio_87, $Criterio_88, $Criterio_89, $Criterio_90,
                                                                        $Criterio_91, $Criterio_92, $Criterio_93, $Criterio_94, $Criterio_95, $Criterio_96, $Criterio_97, $Criterio_98, $Criterio_99, $Criterio_100,
                                                                        $Criterio_101, $Criterio_102, $Criterio_103, $Criterio_104, $Criterio_105, $Criterio_106, $Criterio_107, $Criterio_108, $Criterio_109, $Criterio_110,
                                                                        $Criterio_111, $Criterio_112, $Criterio_113, $Criterio_114, $Criterio_115, $Criterio_116, $Criterio_117, $Criterio_118, $Criterio_119, $Criterio_120,
                                                                        $Criterio_121, $Criterio_122, $Criterio_123, $Criterio_124, $Criterio_125, $Criterio_126, $Criterio_127, $Criterio_128, $Criterio_129, $Criterio_130, $Criterio_131){
            $sql = "INSERT INTO detalles_overhauling_inicial (ID_Overhauling, Marca, Serie, Modelo, ClaseH, LongitudH, Horometro, Voltaje, Criterio_1, Criterio_2, Criterio_3, Criterio_4, Criterio_5, Criterio_6, Criterio_7, Criterio_8, Criterio_9, Criterio_10,
                                                              Criterio_11, Criterio_12, Criterio_13, Criterio_14, Criterio_15, Criterio_16, Criterio_17, Criterio_18, Criterio_19, Criterio_20, Criterio_21, Criterio_22, Criterio_23, Criterio_24, Criterio_25, 
                                                              Criterio_26, Criterio_27, Criterio_28, Criterio_29, Criterio_30, Criterio_31, Criterio_32, Criterio_33, Criterio_34, Criterio_35, Criterio_36, Criterio_37, Criterio_38, Criterio_39, Criterio_40,
                                                              Criterio_41, Criterio_42, Criterio_43, Criterio_44, Criterio_45, Criterio_46, Criterio_47, Criterio_48, Criterio_49, Criterio_50, Criterio_51, Criterio_52, Criterio_53, Criterio_54, Criterio_55, 
                                                              Criterio_56, Criterio_57, Criterio_58, Criterio_59, Criterio_60, Criterio_61, Criterio_62, Criterio_63, Criterio_64, Criterio_65, Criterio_66, Criterio_67, Criterio_68, Criterio_69, Criterio_70,
                                                              Criterio_71, Criterio_72, Criterio_73, Criterio_74, Criterio_75, Criterio_76, Criterio_77, Criterio_78, Criterio_79, Criterio_80, Criterio_81, Criterio_82, Criterio_83, Criterio_84, Criterio_85,
                                                              Criterio_86, Criterio_87, Criterio_88, Criterio_89, Criterio_90, Criterio_91, Criterio_92, Criterio_93, Criterio_94, Criterio_95, Criterio_96, Criterio_97, Criterio_98, Criterio_99, Criterio_100,
                                                              Criterio_101, Criterio_102, Criterio_103, Criterio_104, Criterio_105, Criterio_106, Criterio_107, Criterio_108, Criterio_109, Criterio_110, Criterio_111, Criterio_112, Criterio_113, Criterio_114, 
                                                              Criterio_115, Criterio_116, Criterio_117, Criterio_118, Criterio_119, Criterio_120, Criterio_121, Criterio_122, Criterio_123, Criterio_124, Criterio_125, Criterio_126, Criterio_127, Criterio_128, Criterio_129, Criterio_130, Criterio_131) 
                    VALUES (:ID_Overhauling, :Marca, :Serie, :Modelo, :ClaseH, :LongitudH, :Horometro, :Voltaje, :Criterio_1, :Criterio_2, :Criterio_3, :Criterio_4, :Criterio_5, :Criterio_6, :Criterio_7, :Criterio_8, :Criterio_9, :Criterio_10, :Criterio_11, :Criterio_12, 
                            :Criterio_13, :Criterio_14, :Criterio_15, :Criterio_16, :Criterio_17, :Criterio_18, :Criterio_19, :Criterio_20, :Criterio_21, :Criterio_22, :Criterio_23, :Criterio_24, :Criterio_25, :Criterio_26, :Criterio_27, :Criterio_28, :Criterio_29, 
                            :Criterio_30, :Criterio_31, :Criterio_32, :Criterio_33, :Criterio_34, :Criterio_35, :Criterio_36, :Criterio_37, :Criterio_38, :Criterio_39, :Criterio_40, :Criterio_41, :Criterio_42, :Criterio_43, :Criterio_44, :Criterio_45, :Criterio_46, 
                            :Criterio_47, :Criterio_48, :Criterio_49, :Criterio_50, :Criterio_51, :Criterio_52, :Criterio_53, :Criterio_54, :Criterio_55, :Criterio_56, :Criterio_57, :Criterio_58, :Criterio_59, :Criterio_60, :Criterio_61, :Criterio_62, :Criterio_63, 
                            :Criterio_64, :Criterio_65, :Criterio_66, :Criterio_67, :Criterio_68, :Criterio_69, :Criterio_70, :Criterio_71, :Criterio_72, :Criterio_73, :Criterio_74, :Criterio_75, :Criterio_76, :Criterio_77, :Criterio_78, :Criterio_79, :Criterio_80,
                            :Criterio_81, :Criterio_82, :Criterio_83, :Criterio_84, :Criterio_85, :Criterio_86, :Criterio_87, :Criterio_88, :Criterio_89, :Criterio_90, :Criterio_91, :Criterio_92, :Criterio_93, :Criterio_94, :Criterio_95, :Criterio_96, :Criterio_97, 
                            :Criterio_98, :Criterio_99, :Criterio_100, :Criterio_101, :Criterio_102, :Criterio_103, :Criterio_104, :Criterio_105, :Criterio_106, :Criterio_107, :Criterio_108, :Criterio_109, :Criterio_110, :Criterio_111, :Criterio_112, :Criterio_113, 
                            :Criterio_114, :Criterio_115, :Criterio_116, :Criterio_117, :Criterio_118, :Criterio_119, :Criterio_120, :Criterio_121, :Criterio_122, :Criterio_123, :Criterio_124, :Criterio_125, :Criterio_126, :Criterio_127, :Criterio_128, :Criterio_129, :Criterio_130, :Criterio_131)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Overhauling", $ID_Diagnostico);
            $stmt->bindParam(":Marca", $Marca);
            $stmt->bindParam(":Serie", $Serie);
            $stmt->bindParam(":Modelo", $Modelo);
            $stmt->bindParam(":ClaseH", $ClaseH);
            $stmt->bindParam(":LongitudH", $LongitudH);
            $stmt->bindParam(":Horometro", $Horometro);
            $stmt->bindParam(":Voltaje", $Voltaje);
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
            return $stmt->execute();
        }

        public function RegistrarDiagnosticoInicial($Numero, $ID_Centro, $ID_Supervisor, $TipoMontacargas, $FechaCreado, $EstadoFirmaSupervisor) {
            $sql = "INSERT INTO overhauling_inicial (Numero, ID_Centro, ID_Supervisor, Tipo_Montacargas, Fecha_Realizado, Firma_Supervisor, Estado_Firma_Supervisor, Fecha_Firma_Supervisor) 
                    VALUES (:Numero, :ID_Centro, :ID_Supervisor, :Tipo_Montacargas, :Fecha_Realizado, NULL, :EstadoFirmaSupervisor, NULL)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Numero', $Numero);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':ID_Supervisor', $ID_Supervisor);
            $stmt->bindParam(':Tipo_Montacargas', $TipoMontacargas);
            $stmt->bindParam(':Fecha_Realizado', $FechaCreado);
            $stmt->bindParam(':EstadoFirmaSupervisor', $EstadoFirmaSupervisor);
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            } else {
                return false;
            }
        }

        public function RegistrarDiagnosticoTecnico($ID_Diagnostico, $ID_Tecnico, $EstadoFirmaMecanico){
            $sql = "INSERT INTO overhauling_inicial_mecanico (ID_Overhauling, ID_Mecanico, Firma_Mecanico, Fecha_Firma_Mecanico, Estado_Firma_Mecanico) 
                    VALUES (:ID_Overhauling, :ID_Mecanico, NULL, NULL, :Estado_Firma_Mecanico)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Overhauling", $ID_Diagnostico);
            $stmt->bindParam(":ID_Mecanico", $ID_Tecnico);
            $stmt->bindParam(":Estado_Firma_Mecanico", $EstadoFirmaMecanico);
            return $stmt->execute();
        }

        public function RegistrarOverhaulingEvidencia($ID_Diagnostico, $Categoria, $uploadFile){
            $sql = "INSERT INTO overhauling_inicial_imagenes (ID_Overhauling, Categoria, Evidencia_Fotografica) 
                    VALUES (:ID_Overhauling, :Categoria, :Evidencia_Fotografica)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Overhauling", $ID_Diagnostico);
            $stmt->bindParam(":Categoria", $Categoria);
            $stmt->bindParam(":Evidencia_Fotografica", $uploadFile);
            return $stmt->execute();
        }

        public function RegistrarTrabajoOverhauling($ID_Diagnostico, $Seccion, $Criterio, $Tipo, $Descripcion, $Estado_Trabajo){
            $sql = "INSERT INTO trabajos_overhauling (ID_Overhauling, Seccion, Criterio, Tipo, Descripcion, Estado_Trabajo) 
                    VALUES (:ID_Overhauling, :Seccion, :Criterio, :Tipo, :Descripcion, :Estado_Trabajo)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID_Overhauling", $ID_Diagnostico);
            $stmt->bindParam(":Seccion", $Seccion);
            $stmt->bindParam(":Criterio", $Criterio);
            $stmt->bindParam(":Tipo", $Tipo);
            $stmt->bindParam(":Descripcion", $Descripcion);
            $stmt->bindParam(":Estado_Trabajo", $Estado_Trabajo);
            return $stmt->execute();
        }

        public function TraerOperarios($ID_Centro){
            $sql = "SELECT * FROM usuario WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            $DataOperarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataOperarios;
        }

        public function TraerSupervisores() {
            $sql ="SELECT * FROM usuario WHERE ID_Cargo = 8 OR ID_Cargo = 13";;
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataSupervisores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataSupervisores;
        }

        public function VerDetalleD($ID) {
            $sql = "SELECT detalles_overhauling_inicial.*  FROM detalles_overhauling_inicial WHERE detalles_overhauling_inicial.ID_Overhauling = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function VerDetalleTrabajos($ID) {
            $sql = "SELECT trabajos_overhauling.*  FROM trabajos_overhauling WHERE trabajos_overhauling.ID_Overhauling = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerMecanicos($ID) {
            $sql = "SELECT usuario_mecanico.NombreCompleto AS NombreMecanico, 
                           overhauling_inicial_mecanico.*
                    FROM overhauling_inicial_mecanico
                    JOIN usuario AS usuario_mecanico ON overhauling_inicial_mecanico.ID_Mecanico = usuario_mecanico.ID
                    WHERE overhauling_inicial_mecanico.ID_Overhauling = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerOverhauling($ID) {
            $sql = "SELECT usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_overhauling.Nombre AS CentroOverhauling, 
                           Detalle_Overhauling.Marca AS Marca,
                           Detalle_Overhauling.Serie AS Serie,
                           Detalle_Overhauling.Modelo AS Modelo,
                           Detalle_Overhauling.Voltaje AS Voltaje,
                           Detalle_Overhauling.Horometro AS Horometro,
                           overhauling_inicial.*
                    FROM overhauling_inicial
                    JOIN usuario AS usuario_Supervisor ON overhauling_inicial.ID_Supervisor = usuario_Supervisor.ID
                    JOIN centrot AS centro_overhauling ON overhauling_inicial.ID_Centro = centro_overhauling.ID
                    JOIN detalles_overhauling_inicial AS Detalle_Overhauling ON Detalle_Overhauling.ID_Overhauling = overhauling_inicial.ID
                    WHERE overhauling_inicial.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>