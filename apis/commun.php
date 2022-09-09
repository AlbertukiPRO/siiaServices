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

    public function getNoCitas($user, $tramite){
        $consulta  = "
                    SELECT
                        COUNT(idcita) as num
                    FROM simscitas WHERE idhistorialacademico = $user and idtramite = $tramite
        ";
        return self::getData($consulta);
    }

    public function getCalendarHours($area, $fecha){
        $consulta = "
        SELECT horaexepcion FROM siexcepciones 
        where idareareservada = $area and fechaexcepcion like '%$fecha%' group by horaexepcion
        ";
        return self::getData($consulta);
    }

    public function getSettings($idarea){
        $consulta = "
        select c.horaInicio as horaServicioInicio, c.horaFin as horaServicioFin, c.duracionCita as duracionCitas 
        from configuraciones as c where idArea = $idarea
        ";
        return self::getData($consulta);
    }
}

$obt = new CommunServices();

if (isset($_GET['user'])){
    $res = $obt->getNoCitas($_GET['user'], $_GET['tramite']);

    if ($res){
        foreach ($res as $row){
            echo $row['num'];
        }
    }
}else if(isset($_GET['coomon']) && $_GET['coomon'] == 'hoursdisable'){
    $res = $obt->getCalendarHours($_GET['idarea'], $_GET['fecha']);

    if ($res){
        foreach ($res as $row){
            echo $row['horaexepcion'].",";
        }
    }
}else if (isset($_GET['coomon']) && $_GET['coomon'] == 'settings'){
    $res = $obt->getSettings($_GET['idarea']);

    if ($res){
        echo json_encode($res);
    }
}else
    echo "missing params in url";