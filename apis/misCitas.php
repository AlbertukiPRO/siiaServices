<?php

require ('../resources/Conexion.php');

class MisCitas{
    public static function getData($consulta)
    {
        $conector = new Conexion();

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute();
        $resultados = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function showdata($idAlumno)
    {
        return self::getData("SELECT ci.idcita as strIdCita, ci.idhistorialacademico as strUser,ci.descripcioncita as strDescripcionCita, s.nombreArea as area, s2.nombretramite as tramite,  ci.retroalimentacioncita as strRepuesta ,CONCAT(ci.fechareservadacita,',', ci.horaReservada) as strFechaHoraReservada, ci.estatuscitas as strEstatus FROM simscitas as ci INNER JOIN sictareas s ON ci.idareacampus = s.idareacampus INNER JOIN sicttramites s2 on ci.idtramite = s2.idtramite WHERE ci.idhistorialacademico = $idAlumno;");
    }

    public function showdata2($idarea, $dia){
        return self::getData("SELECT si.idareacampus as strIdCita, si.idhistorialacademico as strUser, si.descripcioncita as strDescripcionCita, s2.nombreArea as area,s.nombretramite as tramite, si.retroalimentacioncita as strRepuesta, CONCAT(' ',',',si.horaReservada) as strFechaHoraReservada FROM simscitas as si INNER JOIN sicttramites s on si.idtramite = s.idtramite INNER JOIN sictareas s2 on si.idareacampus = s2.idareacampus where si.idareacampus = $idarea and si.fechareservadacita = '$dia' and si.estatuscitas = 'Agendada' ");
    }
}

if (isset($_GET['id'])){
    $obt = new MisCitas;
    $res = $obt->showdata($_GET['id']);
    if ($res){
        echo json_encode($res);
    }
}else if(isset($_GET['idArea']) && isset($_GET['dia'])){
    $obt = new MisCitas;
    $res = $obt->showdata2($_GET['idArea'],$_GET['dia']);

    if ($res){
        echo json_encode($res);
    }
}else{
    echo "Faltan parametros";
}