<?php


include ("../resources/Conexion.php");

class SaveCita {
    public static function Insertar($consulta, $arraydata){
        $conector = new Conexion;

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute($arraydata);

        return $resultado;
    }

    public function showData(){
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $matricula = $data['matricula'];

            /**
             * @SQL para insertar la cita
             */
            $consulta = "INSERT INTO simscitas (idhistorialacademico, idareacampus, idtramite, descripcioncita, estatuscitas, fechareservadacita, horaReservada, useraudit) VALUES (:idh,:idareacampus,:idtramite,:descripCita,'Agendada',:fechaCita,:horaCita,$matricula)" ;
            $lista = array(':idh'=>$data['matricula'], ':idareacampus'=>$data['idarea'], ':idtramite'=>$data['idtramite'],':descripCita'=>$data['descripcion'],':fechaCita'=>$data['fecha'],':horaCita'=>$data['hora']);


            /**
             * @SQL para insertar la fecha
             */
            $sql = "INSERT INTO siexcepciones (idareareservada, fechaexcepcion,horaexepcion, useraudit) VALUES (:idarea,:fechareservada, :horareservada, :userid)";

            $lista2 = array(':idarea'=>$data['idarea'], ':fechareservada'=>$data['fecha'], ':horareservada'=>$data['hora'], ':userid'=>$data['matricula']);

            $res = self::Insertar($consulta,$lista);
            $res2 = self::Insertar($sql,$lista2);
            if ($res and $res2){
                return $res;
            }else{
                return false;
            }
        }catch (Throwable $th){
            echo $th;
        }
    }

    public function saveConfig(){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $idarea = $data['idarea'];


        $sql = "update configuraciones set horaFin = :horafin, horaInicio = :horainicio, duracionCita = :duracioncita where idArea = :idarea";

        $arraydata = array(':horainicio'=>$data['horainicion'], ':horafin'=>$data['horafin'],':duracioncita'=>$data['duracion'], ':idarea'=>$idarea);

        return self::Insertar($sql, $arraydata);
    }
}

$obt = new SaveCita();
if (isset($_GET['savesetting'])){
    $res = $obt->saveConfig();
    if ($res)
        echo $res->rowCount();
    else
        echo "No se pudo guardar las configuraciones de area";
}else{

    $res = $obt->showData();
    if ($res){
        echo $res->rowCount();
    }else{
        echo "No se guardo la cita: ";
    }

}
//$json = file_get_contents('php://input');
//$data = json_decode($json, true);
//
//
//var_dump($data);
//
//$matricula = $data['matricula'];
//
//echo $matricula;
