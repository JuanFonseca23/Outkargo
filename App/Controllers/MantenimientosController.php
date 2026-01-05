<?php
    include_once  "App/Models/Mantenimientos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";
    include_once "App/Controllers/UsuarioController.php";     

    class MantenimientosController {
        // Atributos
        private $Modelo_Mantenimientos;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_Mantenimientos = new Mantenimientos();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Usuarios = new UsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        // Métodos

        public function TraerMontacargas($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerMontacargas($ID_Centro);
            return $Resultado;
        }

        public function TraerOperarios($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerOperarios($ID_Centro);
            return $Resultado;
        }

        public function TraerAreas($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerAreas($ID_Centro);
            return $Resultado;
        }

        public function ContarMantenimientos($ID_Centro, $Tipo){
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientos($ID_Centro, $Tipo);
            return $Resultado ? $Resultado : 0;
        }

        public function LeerMantenimientos($ID_Centro, $Tipo){
            if ($this->Modelo_Mantenimientos->LeerMantenimientos($ID_Centro, $Tipo)) {
                $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientos($ID_Centro, $Tipo);
                return $Resultado;
            }
        }

        public function ContarMantenimientosC($ID_Centro){
            $Resultado = $this->Modelo_Mantenimientos->ContarMantenimientosC($ID_Centro);
            return $Resultado ? $Resultado : 0;
        }

        public function LeerMantenimientosC($ID_Centro){
            if ($this->Modelo_Mantenimientos->LeerMantenimientosC($ID_Centro)) {
                $Resultado = $this->Modelo_Mantenimientos->LeerMantenimientosC($ID_Centro);
                return $Resultado;
            }
        }

        public function VerMantenimiento($ID){
            $DataMantenimiento = $this->Modelo_Mantenimientos->VerMantenimiento($ID);
            return $DataMantenimiento;
        }

        public function VerMecanicos($ID){
            $DataMecanicos = $this->Modelo_Mantenimientos->VerMecanicos($ID);
            return $DataMecanicos;
        }

        public function VerDetalleM($ID){
            $DataDetalleM = $this->Modelo_Mantenimientos->VerDetalleM($ID);
            return $DataDetalleM;
        }

        public function DataImagenesM($ID){
            $DataImagenesM = $this->Modelo_Mantenimientos->DataImagenesM($ID);
            return $DataImagenesM;
        }

        public function VerMantenimientoC($ID){
            $DataMantenimiento = $this->Modelo_Mantenimientos->VerMantenimientoC($ID);
            return $DataMantenimiento;
        }

        public function VerMecanicosC($ID){
            $DataMecanicos = $this->Modelo_Mantenimientos->VerMecanicosC($ID);
            return $DataMecanicos;
        }

        public function VerDetalleMC($ID){
            $DataDetalleM = $this->Modelo_Mantenimientos->VerDetalleMC($ID);
            return $DataDetalleM;
        }

        public function DataImagenesMC($ID){
            $DataImagenesM = $this->Modelo_Mantenimientos->DataImagenesMC($ID);
            return $DataImagenesM;
        }

        public function ObtenerInsumosMantenimiento($DataDetalleM){
            // Mapeo de códigos a nombres
            $insumos = [
                'P-000119' => 'Agua para batería',
                'P-000054' => 'Grasa Wurth',
                'P-000120' => 'Aceite Hidráulico',
                'P-000210' => 'Valvulina',
                'P-000207' => 'Gasolina',
                'P-000053' => 'Lubricante Wurth',
                'P-000905' => 'Limpiador Wurth',
                'P-000994' => 'Limpiador Eléctrico',
                'P-000021' => 'Líquido de Frenos'
            ];

            $resultado = [];

            for ($i = 122; $i <= 130; $i++) {
                $campo = "Criterio_$i";

                if (!empty($DataDetalleM[$campo]) && $DataDetalleM[$campo] !== 'null|null|null') {
                    $partes = explode('|', $DataDetalleM[$campo]);
                    
                    if (count($partes) === 3) {
                        [$codigo, $cantidad, $medida] = $partes;
                        if (!empty($codigo) && !empty($cantidad) && $cantidad !== 'null') {
                            $nombre = $insumos[$codigo] ?? $codigo; 
                            $resultado[] = [
                                'nombre' => $nombre,
                                'cantidad' => $cantidad,
                                'medida' => $medida
                            ];
                        }
                    }
                }
            }

            return $resultado;
        }

        public function BuscarPersona($No_Documento) {
            $datausuario = $this->Controller_Usuarios->BuscarPersonaDocumento($No_Documento);     
            if ($datausuario) {               
                return $datausuario;   
            }else {
                return false;
            }
        }

        public function TraerSupervisores() {
            $Resultado = $this->Modelo_Mantenimientos->TraerSupervisores();
            return $Resultado;
        }

        public function RegistrarMantenimiento($ID_Usuario, $NombreCreo,$ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro,$ID_Supervisor,$Correo_Supervisor,$Nombre_Supervisor,$NumeroBateria,$NumeroControlador,$NumeroCargador,$Observaciones,$Longitudh,$Horometro,$HoraInicio,
                                               $Criterio_1,$Criterio_2,$Criterio_3,$Criterio_4,$Criterio_5,$Criterio_6,$Criterio_7,$Criterio_8,$Criterio_9,$Criterio_10,
                                               $Criterio_11,$Criterio_12,$Criterio_13,$Criterio_14,$Criterio_15,$Criterio_16,$Criterio_17,$Criterio_18,$Criterio_19,$Criterio_20,
                                               $Criterio_21,$Criterio_22,$Criterio_23,$Criterio_24,$Criterio_25,$Criterio_26,$Criterio_27,$Criterio_28,$Criterio_29,$Criterio_30,
                                               $Criterio_31,$Criterio_32,$Criterio_33,$Criterio_34,$Criterio_35,$Criterio_36,$Criterio_37,$Criterio_38,$Criterio_39,$Criterio_40,
                                               $Criterio_41,$Criterio_42,$Criterio_43,$Criterio_44,$Criterio_45,$Criterio_46,$Criterio_47,$Criterio_48,$Criterio_49,$Criterio_50,
                                               $Criterio_51,$Criterio_52,$Criterio_53,$Criterio_54,$Criterio_55,$Criterio_56,$Criterio_57,$Criterio_58,$Criterio_59,$Criterio_60,
                                               $Criterio_61,$Criterio_62,$Criterio_63,$Criterio_64,$Criterio_65,$Criterio_66,$Criterio_67,$Criterio_68,$Criterio_69,$Criterio_70,
                                               $Criterio_71,$Criterio_72,$Criterio_73,$Criterio_74,$Criterio_75,$Criterio_76,$Criterio_77,$Criterio_78,$Criterio_79,$Criterio_80,
                                               $Criterio_81,$Criterio_82,$Criterio_83,$Criterio_84,$Criterio_85,$Criterio_86,$Criterio_87,$Criterio_88,$Criterio_89,$Criterio_90,
                                               $Criterio_91,$Criterio_92,$Criterio_93,$Criterio_94,$Criterio_95,$Criterio_96,$Criterio_97,$Criterio_98,$Criterio_99,$Criterio_100,
                                               $Criterio_101,$Criterio_102,$Criterio_103,$Criterio_104,$Criterio_105,$Criterio_106,$Criterio_107,$Criterio_108,$Criterio_109,$Criterio_110,
                                               $Criterio_111,$Criterio_112,$Criterio_113,$Criterio_114,$Criterio_115,$Criterio_116,$Criterio_117,$Criterio_118,$Criterio_119,$Criterio_120,
                                               $Criterio_121,$Criterio_122,$Criterio_123,$Criterio_124,$Criterio_125,$Criterio_126,$Criterio_127,$Criterio_128,$Criterio_129,$Criterio_130,
                                               $Criterio_131,$Criterio_132,$Criterio_133,$Criterio_134,$Criterio_135,$Criterio_136,$Criterio_137,$Criterio_138,$Criterio_139,
                                               $Tecnicos,$Baterias,$Electricos,$Tracciones,$Frenos,$Direcciones,$Hidraulicos,$Mastiles,$Carros,$Aditamientos,$Horquillas,$Ruedas,$Chasis,$Luces,$Lubricaciones,$Cargadores,$Revisiones, $Caja, 
                                               $Auxiliares, $Pantografo, $Suspension, $Combustion, $Transmision, $Motor, $Refigeracion, $Componentes, $Ausencias, $Correas, $Panel, $Funcionamiento, $Tipo){
            $Horafinal = date('H:i');
            $FechaCreado = date("d/m/Y");
            $EstadoFirmaOperario = 0;
            $EstadoFirmaSupervisor = 0;
            if($ID = $this -> Modelo_Mantenimientos->RegistrarMantenimiento($ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro, $ID_Supervisor, $HoraInicio, $Horafinal,
                                                                            $FechaCreado, $EstadoFirmaOperario, $EstadoFirmaSupervisor, $Tipo)){
                $ID_Mantenimiento = $ID;
                if (!in_array($ID_Usuario, $Tecnicos)) { array_unshift($Tecnicos, $ID_Usuario); }
                foreach ($Tecnicos as $ID_Tecnico) {
                    $this->Modelo_Mantenimientos->RegistrarMantenimientoTecnico($ID_Mantenimiento, $ID_Tecnico);
                }
                $this->Modelo_Mantenimientos->RegistrarDetallesMantenimiento($ID_Montacargas, $ID_Mantenimiento, $NumeroBateria, $NumeroControlador, $NumeroCargador, $Observaciones, $Longitudh, $Horometro, $Criterio_1, $Criterio_2, $Criterio_3, $Criterio_4, $Criterio_5, $Criterio_6, $Criterio_7, $Criterio_8, $Criterio_9, $Criterio_10, $Criterio_11, $Criterio_12, $Criterio_13,
                                                      $Criterio_14, $Criterio_15, $Criterio_16, $Criterio_17, $Criterio_18, $Criterio_19, $Criterio_20, $Criterio_21, $Criterio_22, $Criterio_23, $Criterio_24, $Criterio_25, $Criterio_26, $Criterio_27, $Criterio_28, $Criterio_29, $Criterio_30, $Criterio_31, $Criterio_32, $Criterio_33,
                                                      $Criterio_34, $Criterio_35, $Criterio_36, $Criterio_37, $Criterio_38, $Criterio_39, $Criterio_40, $Criterio_41, $Criterio_42, $Criterio_43, $Criterio_44, $Criterio_45, $Criterio_46, $Criterio_47, $Criterio_48, $Criterio_49, $Criterio_50, $Criterio_51, $Criterio_52, $Criterio_53,
                                                      $Criterio_54, $Criterio_55, $Criterio_56, $Criterio_57, $Criterio_58, $Criterio_59, $Criterio_60, $Criterio_61, $Criterio_62, $Criterio_63, $Criterio_64, $Criterio_65, $Criterio_66, $Criterio_67, $Criterio_68, $Criterio_69, $Criterio_70, $Criterio_71, $Criterio_72, $Criterio_73,
                                                      $Criterio_74, $Criterio_75, $Criterio_76, $Criterio_77, $Criterio_78, $Criterio_79, $Criterio_80, $Criterio_81, $Criterio_82, $Criterio_83, $Criterio_84, $Criterio_85, $Criterio_86, $Criterio_87, $Criterio_88, $Criterio_89, $Criterio_90, $Criterio_91, $Criterio_92, $Criterio_93,
                                                      $Criterio_94, $Criterio_95, $Criterio_96, $Criterio_97, $Criterio_98, $Criterio_99, $Criterio_100, $Criterio_101, $Criterio_102, $Criterio_103, $Criterio_104, $Criterio_105, $Criterio_106, $Criterio_107, $Criterio_108, $Criterio_109, $Criterio_110, $Criterio_111, $Criterio_112,
                                                      $Criterio_113, $Criterio_114, $Criterio_115, $Criterio_116, $Criterio_117, $Criterio_118, $Criterio_119, $Criterio_120, $Criterio_121, $Criterio_122, $Criterio_123, $Criterio_124, $Criterio_125, $Criterio_126, $Criterio_127, $Criterio_128, $Criterio_129, $Criterio_130,
                                                      $Criterio_131,$Criterio_132,$Criterio_133,$Criterio_134,$Criterio_135,$Criterio_136,$Criterio_137,$Criterio_138,$Criterio_139);
                $this->RegistrarManteniminetosEvidencia($ID_Mantenimiento, $Baterias,$Electricos,$Tracciones,$Frenos,$Direcciones,$Hidraulicos,$Mastiles,$Carros,$Aditamientos,$Horquillas,$Ruedas,$Chasis,$Luces,$Lubricaciones,$Cargadores,$Revisiones, $Caja, $Auxiliares, $Pantografo, $Suspension, $Combustion, $Transmision, $Motor, $Refigeracion, $Componentes, $Ausencias, $Correas, $Panel, $Funcionamiento);
                $this->GenerarCorreo($Correo_Supervisor, $Nombre_Supervisor, $ID_Mantenimiento);
                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $NombreCreo.' Creó el mantenimiento preventivo del montacargas con ID: '.$ID_Montacargas;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                return $ID_Mantenimiento;
            }else{
                return false;
            }

        }

        public function RegistrarManteniminetosEvidencia ($ID_Mantenimiento, $Baterias, $Electricos, $Tracciones, $Frenos, $Direcciones, $Hidraulicos, $Mastiles, $Carros, $Aditamientos, $Horquillas, $Ruedas, $Chasis, $Luces, $Lubricaciones, $Cargadores, $Revisiones, $Caja, $Auxiliares, $Pantografo, $Suspension, $Combustion, $Transmision, $Motor, $Refigeracion, $Componentes, $Ausencias, $Correas, $Panel, $Funcionamiento){
            $uploadDir = 'App/Views/Upload/Img/Mantenimientos_Preventivos/'; 
            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // ⚙️ Función reutilizable para evitar repetir código
            $subirArchivos = function($Categoria, $archivos) use ($ID_Mantenimiento, $uploadDir, $allowedTypes){
                $contador = 1;
                if(empty($archivos['name'][0])) return; // No hay archivos
                foreach ($archivos['tmp_name'] as $key => $tmp_name) {
                    $fileType = $archivos['type'][$key];
                    if (in_array($fileType, $allowedTypes)) {
                        $extension = pathinfo($archivos['name'][$key], PATHINFO_EXTENSION);
                        $NombreFoto  = "Mantenimiento{$ID_Mantenimiento}_{$Categoria}{$contador}." . $extension;
                        $uploadFile = $uploadDir . $NombreFoto;

                        if (move_uploaded_file($tmp_name, $uploadFile)) {
                            $this->Modelo_Mantenimientos->RegistrarMantenimientoEvidencia($ID_Mantenimiento, $Categoria, $uploadFile);
                            $contador++;
                        } else {
                            // Error al mover el archivo
                            echo "❌ Error al cargar la imagen: $uploadFile<br>";
                        }
                    }else {
                        echo "⚠️ Tipo de archivo no permitido: {$archivos['name'][$key]}<br>";
                    }
                }

            };

            $subirArchivos('bateria', $Baterias);
            $subirArchivos('electrico', $Electricos);
            $subirArchivos('traccion', $Tracciones);
            $subirArchivos('freno', $Frenos);
            $subirArchivos('direccion', $Direcciones);
            $subirArchivos('hidraulico', $Hidraulicos);
            $subirArchivos('mastil', $Mastiles);
            $subirArchivos('carro', $Carros);
            $subirArchivos('aditamento', $Aditamientos);
            $subirArchivos('horquilla', $Horquillas);
            $subirArchivos('rueda', $Ruedas);
            $subirArchivos('chasis', $Chasis);
            $subirArchivos('luces', $Luces);
            $subirArchivos('lubricacion', $Lubricaciones);
            $subirArchivos('cargador', $Cargadores);
            $subirArchivos('revision', $Revisiones);
            $subirArchivos('caja', $Caja);
            $subirArchivos('auxiliares', $Auxiliares);
            $subirArchivos('pantografo', $Pantografo);
            $subirArchivos('suspension', $Suspension);
            $subirArchivos('combustion', $Combustion);
            $subirArchivos('transmision', $Transmision);
            $subirArchivos('motor', $Motor);
            $subirArchivos('refigeracion', $Refigeracion);
            $subirArchivos('componentes', $Componentes);
            $subirArchivos('ausencias', $Ausencias);
            $subirArchivos('correas', $Correas);
            $subirArchivos('panel', $Panel);
            $subirArchivos('funcionamiento', $Funcionamiento);        
        }

        public function RegistrarMantenimientoCorrectivo ($ID_Usuario, $NombreCreo, $ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro,$ID_Supervisor,$Correo_Supervisor,$Nombre_Supervisor,$Horometro, $HoraInicio,
                                                           $Falla,$Reparacion,$Insumos,$Observaciones,$FechaCorrecion,$FallaC, $Pendiente,$Tecnicos,$ImgFalla,$ImgReparacion){
            $Horafinal = date('H:i');
            $FechaCreado = date("d/m/Y");
            $EstadoFirmaOperario = 0;
            $EstadoFirmaSupervisor = 0;
            if($ID = $this -> Modelo_Mantenimientos->RegistrarMantenimientoCorrectivo($ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro, $ID_Supervisor, $HoraInicio, $Horafinal, $FechaCreado, $EstadoFirmaOperario, $EstadoFirmaSupervisor)){
                $ID_Mantenimiento = $ID;
                if (!in_array($ID_Usuario, $Tecnicos)) { array_unshift($Tecnicos, $ID_Usuario); }
                foreach ($Tecnicos as $ID_Tecnico) {
                    $this->Modelo_Mantenimientos->RegistrarMantenimientoCorrectivoTecnico($ID_Mantenimiento, $ID_Tecnico);
                }
                $this->Modelo_Mantenimientos->RegistrarDetallesMantenimientoCorrectivo($ID_Montacargas, $ID_Mantenimiento, $Horometro, $Falla, $Reparacion, $Insumos, $Observaciones, $FechaCorrecion, $FallaC, $Pendiente);
                $this->RegistrarManteniminetosEvidenciaCorrectivo ($ID_Mantenimiento, $ImgFalla, $ImgReparacion);
                $this->GenerarCorreo1($Correo_Supervisor, $Nombre_Supervisor, $ID_Mantenimiento);
                $ID_Usuario1 = $ID_Usuario;
                $ID_Usuario2 = Null;
                $Creo = 'registro';
                $Frase = $NombreCreo.' Creó el mantenimiento correctivo del montacargas con ID: '.$ID_Montacargas;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                return $ID_Mantenimiento;
            }else{
                return false;
            }
        }

        public function RegistrarManteniminetosEvidenciaCorrectivo ($ID_Mantenimiento, $ImgFalla, $ImgReparacion){
            $uploadDir = 'App/Views/Upload/Img/Mantenimientos_Correctivos/'; 
            $allowedTypes = ['image/png', 'image/jpeg', 'image/gif']; 
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // ⚙️ Función reutilizable para evitar repetir código
            $subirArchivos = function($Categoria, $archivos) use ($ID_Mantenimiento, $uploadDir, $allowedTypes){
                $contador = 1;
                if(empty($archivos['name'][0])) return; // No hay archivos
                foreach ($archivos['tmp_name'] as $key => $tmp_name) {
                    $fileType = $archivos['type'][$key];
                    if (in_array($fileType, $allowedTypes)) {
                        $extension = pathinfo($archivos['name'][$key], PATHINFO_EXTENSION);
                        $NombreFoto  = "Mantenimiento{$ID_Mantenimiento}_{$Categoria}{$contador}." . $extension;
                        $uploadFile = $uploadDir . $NombreFoto;

                        if (move_uploaded_file($tmp_name, $uploadFile)) {
                            $this->Modelo_Mantenimientos->RegistrarMantenimientoCorrectivoEvidencia($ID_Mantenimiento, $Categoria, $uploadFile);
                            $contador++;
                        } else {
                            // Error al mover el archivo
                            echo "❌ Error al cargar la imagen: $uploadFile<br>";
                        }
                    }else {
                        echo "⚠️ Tipo de archivo no permitido: {$archivos['name'][$key]}<br>";
                    }
                }

            };

            $subirArchivos('falla', $ImgFalla);
            $subirArchivos('reparacion', $ImgReparacion);        
        }

        public function ObtenerTecnicosMantenimiento ($ID) {
            $Tecnicos = $this->Modelo_Mantenimientos->ObtenerTecnicosMantenimiento($ID);
            return $Tecnicos;
        }

        public function ObtenerMantenimiento ($ID) {
            $DataMantenimiento = $this->Modelo_Mantenimientos->ObtenerMantenimiento($ID);
            return $DataMantenimiento;
        }

        public function FirmarMantenimiento ($ID_Mantenimiento, $Firmas) {
            $totalFirmas = count($Firmas);
            $firmasGuardadas = 0;
            $FechaFirma = date("d/m/Y");
            $EstadoFirmaMecanico = 1;
            foreach ($Firmas as $ID_Mecanico => $Firma) {
                if (!empty($Firma)) {
                    $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimiento($ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
                    if ($Resultado) {
                        $firmasGuardadas++;
                    }
                }
            }
            if ($firmasGuardadas === $totalFirmas && $totalFirmas > 0) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'FirmaOperario?ID={$ID_Mantenimiento}';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }

        }

        public function FirmarMantenimientoOperario ($ID_Mantenimiento, $Firma) {
            $EstadoFirmaOperario = 1;
            $FechaFirma = date("d/m/Y");
            if ($this->Modelo_Mantenimientos->FirmarMantenimientoOperario($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaOperario)) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Inicio';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }
        }
        
        public function FirmarMantenimientoSupervisor ($ID_Mantenimiento, $Firma) {
            $EstadoFirmaSupervisor = 1;
            $FechaFirma = date("d/m/Y");
            if ($this->Modelo_Mantenimientos->FirmarMantenimientoSupervisor($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor)) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Inicio';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }
        }

        public function FirmarMantenimientoCorrectivo ($ID_Mantenimiento, $Firmas) {
            $totalFirmas = count($Firmas);
            $firmasGuardadas = 0;
            $FechaFirma = date("d/m/Y");
            $EstadoFirmaMecanico = 1;
            foreach ($Firmas as $ID_Mecanico => $Firma) {
                if (!empty($Firma)) {
                    $Resultado = $this->Modelo_Mantenimientos->FirmarMantenimientoCorrectivo($ID_Mantenimiento, $ID_Mecanico, $Firma, $FechaFirma, $EstadoFirmaMecanico);
                    if ($Resultado) {
                        $firmasGuardadas++;
                    }
                }
            }
            if ($firmasGuardadas === $totalFirmas && $totalFirmas > 0) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'FirmaOperarioC?ID={$ID_Mantenimiento}';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }

        }

        public function FirmarMantenimientoOperarioCorrectivo ($ID_Mantenimiento, $Firma) {
            $EstadoFirmaOperario = 1;
            $FechaFirma = date("d/m/Y");
            if ($this->Modelo_Mantenimientos->FirmarMantenimientoOperarioCorrectivo($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaOperario)) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Inicio';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }
        }

         public function ObtenerTecnicosMantenimientoC ($ID) {
            $Tecnicos = $this->Modelo_Mantenimientos->ObtenerTecnicosMantenimientoC($ID);
            return $Tecnicos;
        }
        
        public function FirmarMantenimientoSupervisorC ($ID_Mantenimiento, $Firma) {
            $EstadoFirmaSupervisor = 1;
            $FechaFirma = date("d/m/Y");
            if ($this->Modelo_Mantenimientos->FirmarMantenimientoSupervisorC($ID_Mantenimiento, $Firma, $FechaFirma, $EstadoFirmaSupervisor)) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: '¡Firmado Correctamente!',
                        text: 'El mantenimiento ha sido firmado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'Inicio';
                        }
                    });
                </script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la firma. Comuníquese con el área de sistemas.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                </script>";
            }
        }

        public function ObtenerMantenimientoC ($ID) {
            $DataMantenimiento = $this->Modelo_Mantenimientos->ObtenerMantenimientoC($ID);
            return $DataMantenimiento;
        }

        private function GenerarCorreo ($Correo_Supervisor, $Nombre_Supervisor, $ID_Mantenimiento) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $FirmarMantenimiento = "localhost/Outkargo2/Mantenimiento/FirmaSupervisor?ID=$ID_Mantenimiento";
            }else {
                $FirmarMantenimiento = "https://Outkargo.com.co/Mantenimiento/FirmaSupervisor?ID=$ID_Mantenimiento";
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
                $mail->Subject = 'Autorizar Mantenemiento Preventivo';
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
                            <p>Un nuevo Mantenimiento ha sido creado</strong>,</p>
                            <p>Para autorizar de clic en el siguente boton:</p>
                            <a href="'.$FirmarMantenimiento.'" class="button">Autorizar Mantenimiento</a>
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

        private function GenerarCorreo1 ($Correo_Supervisor, $Nombre_Supervisor, $ID_Mantenimiento) {
            $mail = new PHPMailer(true);
            $isLocal = false;
            $serverName = $_SERVER['SERVER_NAME']; 
    
            if ($serverName === 'localhost' || strpos($serverName, 'localhost') !== false) {
                $isLocal = true;
            }
            if ($isLocal === true) {
                $FirmarMantenimiento = "localhost/Outkargo2/Mantenimiento/FirmaSupervisorC?ID=$ID_Mantenimiento";
            }else {
                $FirmarMantenimiento = "https://Outkargo.com.co/Mantenimiento/FirmaSupervisorC?ID=$ID_Mantenimiento";
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
                $mail->Subject = 'Autorizar Mantenemiento Correctivo';
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
                            <p>Un nuevo Mantenimiento ha sido creado</strong>,</p>
                            <p>Para autorizar de clic en el siguente boton:</p>
                            <a href="'.$FirmarMantenimiento.'" class="button">Autorizar Mantenimiento</a>
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
