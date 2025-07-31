<?php
    include_Once "App/Models/ActividadUsuario.php";
    date_default_timezone_set('America/Bogota');
    

    class ActividadUsuarioController{
        //Atributos
        private $Modelo_ActividadUsuario;

         // Constructor
        public function __construct() {
            $this->Modelo_ActividadUsuario = new ActividadUsuario();
        }

        // Métodos
        public function TraerActividad($ID_Usuario){
            if ($DataActidad = $this->Modelo_ActividadUsuario->TraerActividad($ID_Usuario)) {
                return $DataActidad;
            }else{
                return false;
            }
        }

        public function RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase){
            $Hora = date('H:i:s');
            $Fecha = date('Y-m-d');
            if($ID = $this->Modelo_ActividadUsuario->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase,$Fecha,$Hora)){
                return $ID;
            }else{
                return false;
            }
        }

        public function CalcularFechaActivad($Fecha) {
            $fecha_dada = $Fecha;
            $fecha_dada_obj = new DateTime($fecha_dada);
            $fecha_actual_obj = new DateTime();
            $diferencia = $fecha_actual_obj->diff($fecha_dada_obj);
        
            $minutos = ($diferencia->y * 365 * 24 * 60) + ($diferencia->m * 30 * 24 * 60) + ($diferencia->d * 24 * 60) + ($diferencia->h * 60) + $diferencia->i;
            $horas = ($diferencia->y * 365 * 24) + ($diferencia->m * 30 * 24) + ($diferencia->d * 24) + $diferencia->h;
            $dias = ($diferencia->y * 365) + ($diferencia->m * 30) + $diferencia->d;
            $semanas = floor($dias / 7);
            $meses = ($diferencia->y * 12) + $diferencia->m;
            $anios = $diferencia->y;
        
            // Determinar la unidad más relevante
            if ($anios > 0) {
                echo $anios . " años";
            } elseif ($meses > 0) {
                echo $meses . " meses";
            } elseif ($semanas > 0) {
                echo $semanas . " semanas";
            } elseif ($dias > 0) {
                echo $dias . " días";
            } elseif ($horas > 0) {
                echo $horas . " horas";
            } elseif ($minutos > 0) {
                echo $minutos . " minutos";
            } else {
                echo "La fecha es hoy";
            }
        }
        
    }
?>