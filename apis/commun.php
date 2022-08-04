<?php

require ('../resources/Conexion.php');

class CommunServices {

    public static function getData($consulta)
    {
        $conector = new Conexion();

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute();
        $resultados = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function getNoCitas($user){
        $consulta  = "
                    SELECT
                        COUNT(idcita) as num
                    FROM simscitas
                    WHERE idhistorialacademico = $user
        ";
        return self::getData($consulta);
    }
}

$obt = new CommunServices();

if (isset($_GET['user'])){

    $res = $obt->getNoCitas($_GET['user']);

    if ($res){
        foreach ($res as $row){
            echo $row['num'];
        }
    }
}else
    echo "missing params in url";