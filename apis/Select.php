<?php

require ('../resources/Conexion.php');

Class Select {

    public static function getCortes($consulta)
    {
        $conector = new Conexion();

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute();
        $resultados = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function showdata($sql)
    {
        $data = self::getCortes($sql);

        return $data;
    }
}
