<?php
require ('../resources/Conexion.php');

class ReportesServices {

    function Execute($params, $consulta){
        $conector = new Conexion();
        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
        $resultado->execute($params);

        if ($resultado->rowCount()==0){
            var_dump($resultado->errorInfo());
            return $resultado;
        }else
            return $resultado;
    }

    static function displayJSON($res){
        if ($res)
            echo json_encode($res->fetchAll(PDO::FETCH_ASSOC));
        else
            var_dump($res->errorInfo());
    }

    static function ServerError(){
        header($_SERVER['SERVER_PROTOCOL'], self::$serverResponse[500]);
    }

    static $serverResponse = array(
        200 => 'OK',
        400=>'No se pudo acceder a la api',
        403 => 'Verifica los parametros',
        500 => '500 Internal Server Error');
}

/**
 * @api
 * typeServices
 * 1 => allCitasOnIdArea
 */


if (isset($_GET['typeService'])){
    $obt = new ReportesServices();
    switch ($_GET['typeService']){
        case '1':
            if (isset($_GET['idArea']) && isset($_GET['idTramite'])){
                $sql = "
                SELECT ci.idtramite as strIdCita, ci.descripcioncita as strDescripcionCita, ci.retroalimentacioncita as strRepuesta, ci.fechareservadacita as strFechaHoraReservada, s2.matricula as strUser, s.nombretramite as strtramite, s2.nombre as strNombre, ci.horaReservada as strHora, s2.facultad as strPrograma
                       FROM simscitas as ci
                       INNER JOIN sicttramites s on ci.idtramite = s.idtramite
                       INNER JOIN simsalumnos s2 on ci.idhistorialacademico = s2.idhistorialacademico
                WHERE ci.idtramite = :idtramite and ci.idareacampus = :idarea
                ";
                $res = $obt->Execute(array(':idtramite'=>$_GET['idTramite'], ':idarea'=>$_GET['idArea']), $sql);
                ReportesServices::displayJSON($res);
            }else
                ReportesServices::ServerError();
            break;
        case '2':
            if (isset($_GET['idArea'])){
                $sql = "SELECT ci.idcita as strIdCita, ci.descripcioncita as strDescripcionCita, ci.retroalimentacioncita as strRepuesta, ci.fechareservadacita as strFechaHoraReservada, ci.idhistorialacademico as strUser, s2.nombretramite as strtramite, s.facultad as strPrograma, ci.horaReservada as strHora, s.nombre as strNombre
                        FROM simscitas as ci
                            INNER JOIN simsalumnos s on ci.idhistorialacademico = s.idhistorialacademico
                            INNER JOIN sicttramites s2 on ci.idtramite = s2.idtramite
                            WHERE ci.idareacampus = :idareacampus";
                $res = $obt->Execute(array(':idareacampus'=>$_GET['idArea']), $sql);
                ReportesServices::displayJSON($res);
            }else
                ReportesServices::ServerError();
            break;
        case '3':
            if (isset($_GET['fecha']) && isset($_GET['idArea'])){
                $sql = "
                        SELECT ci.idtramite as strIdCita, ci.descripcioncita as strDescripcionCita, ci.retroalimentacioncita as strRepuesta, ci.fechareservadacita as strFechaHoraReservada, s2.matricula as strUser, s.nombretramite as strtramite, s2.nombre as strNombre, ci.horaReservada as strHora, s2.facultad as strPrograma
                               FROM simscitas as ci
                               INNER JOIN sicttramites s on ci.idtramite = s.idtramite
                               INNER JOIN simsalumnos s2 on ci.idhistorialacademico = s2.idhistorialacademico
                               WHERE ci.fechareservadacita = :fecha and ci.idareacampus = :idarea
                        ";
                $res = $obt->Execute(array(':fecha'=>$_GET['fecha'], ':idarea'=>$_GET['idArea']), $sql);
                ReportesServices::displayJSON($res);
            }else
                ReportesServices::ServerError();
            break;
        default:
            ReportesServices::ServerError();
            break;
    }
}else
    ReportesServices::ServerError();
