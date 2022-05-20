<?php

class Conexion {

    protected $usuario;
    protected $clave;
    protected $servidor;

    public function __construct()
    {
        $this->servidor="mysql:host=localhost;dbname=siiacitas";
        $this->usuario="root";
        $this->clave="";
    }

    function conectar(){
        try {
            $conector = new PDO($this->servidor, $this->usuario, $this->clave);
            $conector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            $conector->exec("SET CHARACTER SET UTF8");

            return $conector;

            $conector = null;
        } catch (Exception $e) {
            die("<h3><br> ERROR: " . $e->getMessage() . " - al intentar conectar a ala base de datos</h3>");
        }
    }
}
