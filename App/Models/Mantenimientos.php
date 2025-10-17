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

        public function TraerAreas($ID_Centro){
            $sql = "SELECT * FROM area WHERE ID_Centro = :ID_Centro";
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

        public function ContarMantenimientos($ID_Centro, $Tipo) {
            $sql = "SELECT COUNT(*) as NoMantenimientos FROM mantenimiento_preventivo WHERE ID_Centro = :ID_Centro AND Tipo = :Tipo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Tipo', $Tipo);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function LeerMantenimientos($ID_Centro, $Tipo) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreUsuario, 
                           No_montacargas.Numero AS NumeroM, 
                           No_montacargas.Serie AS SerieM,
                           No_montacargas.Horometro AS HorometroA,
                           Detalle_mantenimiento.Horometro AS HorometroM,
                           mantenimiento_preventivo.*
                    FROM mantenimiento_preventivo
                    JOIN usuario AS usuario_operario ON mantenimiento_preventivo.ID_Operario = usuario_operario.ID
                    JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID
                    JOIN detalles_mantenimiento_preventivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_preventivo.ID
                    WHERE mantenimiento_preventivo.ID_Centro = :ID_Centro AND mantenimiento_preventivo.Tipo = :Tipo";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Tipo', $Tipo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerMantenimiento($ID) {
            $sql = "SELECT usuario_operario.NombreCompleto AS NombreOperario, 
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
                    JOIN usuario AS usuario_operario ON mantenimiento_preventivo.ID_Operario = usuario_operario.ID
                    JOIN usuario AS usuario_Supervisor ON mantenimiento_preventivo.ID_Supervisor = usuario_Supervisor.ID
                    JOIN centrot AS centro_mantenimiento ON mantenimiento_preventivo.ID_Centro = centro_mantenimiento.ID
                    JOIN area AS area_mantenimiento ON mantenimiento_preventivo.ID_Area = area_mantenimiento.ID
                    JOIN montacargas AS No_montacargas ON mantenimiento_preventivo.ID_Montacargas = No_montacargas.ID
                    JOIN detalles_mantenimiento_preventivo AS Detalle_mantenimiento ON Detalle_mantenimiento.ID_Mantenimiento = mantenimiento_preventivo.ID
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

        public function VerDetalleM($ID) {
            $sql = "SELECT detalles_mantenimiento_preventivo.*  FROM detalles_mantenimiento_preventivo WHERE detalles_mantenimiento_preventivo.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function DataImagenesM($ID) {
            $sql = "SELECT mantenimiento_preventivo_imagenes.*  FROM mantenimiento_preventivo_imagenes WHERE mantenimiento_preventivo_imagenes.ID_Mantenimiento = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
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

    }
    
?>