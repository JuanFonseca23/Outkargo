<?php
    class Conexion{
        //Atributos
        // private $HOST = "localhost";
        // private $BASE = "u118156411_sistema";
        // private $USER = "u118156411_root";
        // private $PASS = "C8~jHZz0p";
        private $HOST = "localhost";
        private $BASE = "app_outkargo";
        private $USER = "root";
        private $PASS = "";
        //Metodos
        public function Conexion(){
            try {
                $PDO = new PDO("mysql:host=".$this->HOST.";dbname=".$this->BASE,$this->USER,$this->PASS);
                return $PDO;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }
?>