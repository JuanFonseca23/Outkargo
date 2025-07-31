<?php
    include_once  "App/Models/Inspecciones.php";
    date_default_timezone_set('America/Bogota');
    class InspeccionesController {
         // Atributos
        private $Modelo_Inspecciones;
         // Constructor
        public function __construct() {
            $this->Modelo_Inspecciones = new Inspecciones();
        }
        //Metodos
        public function RegistrarInspeccionPuestoDeTrabajo($idCentro, $fecha, $idMontacargas, $idPersonaRegistra, $idPersonaEvaluada, $recomendacionesMedicas, $observaciones, $usoCorrectoEPP, $criterios, $condiciones){
            // Validar que ninguno de los parámetros llegue nulo
            if (is_null($idCentro) || is_null($fecha) || is_null($idMontacargas) || is_null($idPersonaRegistra) || is_null($idPersonaEvaluada) || is_null($recomendacionesMedicas) || is_null($observaciones) || is_null($usoCorrectoEPP) || is_null($criterios) || is_null($condiciones)) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Todos los campos son obligatorios.',
                    });
                </script>";
                return;
            }
            // Aquí puedes continuar con el registro de la inspección
            $result = $this->Modelo_Inspecciones->RegistrarInspeccionPuestoDeTrabajo($idCentro, $fecha, $idMontacargas, $idPersonaRegistra, $idPersonaEvaluada, $recomendacionesMedicas, $observaciones, $usoCorrectoEPP, $criterios);

            if ($result) {
                $result2 = $this->Modelo_Inspecciones->RegistrarCondicionesInspeccionPuestoDeTrabajo($result, $condiciones);
                if ($result2) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Inspección registrada correctamente.',
                        }).then(function() {
                            window.location.href = 'FirmaPersonaUno?Area=Puesto de trabajo&Cod=$result';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al registrar la inspección.',
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al registrar la inspección.',
                    });
                </script>";
            }
            
        }

        public function ObtenerNombreRegistra($ID){
            $result = $this->Modelo_Inspecciones->ObtenerNombreRegistra($ID);
            if ($result) {
                $Nombre = $this->Modelo_Inspecciones->ObtenerElNombre($result['ID_Persona_Registra']);
                if ($Nombre) {
                    return $Nombre['NombreCompleto'];
                }else{
                    echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al registrar la inspección.',
                        });
                    </script>
                    ";
                }
            }else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al registrar la inspección.',
                    });
                </script>
                ";
            }
        }
        
        public function FirmarRegistra($Cod, $Firma){
            $result = $this->Modelo_Inspecciones->FirmarRegistra($Cod, $Firma);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Firma registrada correctamente.',
                    }).then(function() {
                        window.location.href = 'FirmaPersonaDos?Area=Puesto de trabajo&Cod=$Cod';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al registrar la firma.',
                    });
                </script>";
            }
        }

        public function ObtenerNombreEvaluada($ID){
            $result = $this->Modelo_Inspecciones->ObtenerNombreRegistra($ID);
            if ($result) {
                $Nombre = $this->Modelo_Inspecciones->ObtenerElNombre($result['ID_Persona_Evaluada']);
                if ($Nombre) {
                    return $Nombre['NombreCompleto'];
                }else{
                    echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al registrar la inspección.',
                        });
                    </script>
                    ";
                }
            }else {
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al registrar la inspección.',
                    });
                </script>
                ";
            }
        }

        public function FirmarEvaluada($Cod, $Firma){
            $result = $this->Modelo_Inspecciones->FirmarEvaluada($Cod, $Firma);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Inspeccion registrada correctamente.',
                    }).then(function() {
                        window.location.href = 'Inicio';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al registrar la firma.',
                    });
                </script>";
            }
        }
    }
?>