<?php


include ("../resources/Conexion.php");

class SaveCita {
    public static function Insertar($consulta, $lista){
        $conector = new Conexion;

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute(array(':idh'=>$lista[0], ':idareacampus'=>$lista[1], ':idtramite'=>$lista[2],':descripCita'=>$lista[3],':fechaCita'=>$lista[4],':horaCita'=>$lista[5]));

        return $resultado;
    }

    public static function InsertarFechasHorarios($consulta, $lista){
        $conector = new Conexion;

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute(array(':idarea'=>$lista[0], ':fechareservada'=>$lista[1], ':horareservada'=>$lista[2], ':userid'=>$lista[3]));

        return $resultado;
    }

    public function showData(){
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $matricula = $data['matricula'];

            $consulta = "INSERT INTO simscitas (idhistorialacademico, idareacampus, idtramite, descripcioncita, estatuscitas, fechareservadacita, horaReservada, useraudit) VALUES (:idh,:idareacampus,:idtramite,:descripCita,'Agendada',:fechaCita,:horaCita,$matricula)" ;

            $lista = array($data['matricula'],$data['idarea'],$data['idtramite'],$data['descripcion'],$data['fecha'],$data['hora']);

            $sql = "INSERT INTO siexcepciones (idareareservada, fechaexcepcion,horaexepcion, useraudit) VALUES (:idarea,:fechareservada, :horareservada, :userid)";
            $lista2 = array($data['idarea'],$data['fecha'],$data['hora'],$data['matricula']);

            $res = self::Insertar($consulta,$lista);
            $res2 = self::InsertarFechasHorarios($sql,$lista2);
            if ($res and $res2){
                return $res;
            }else{
                return false;
            }
        }catch (\Throwable $th){
            echo $th;
        }
    }

}

$obt = new SaveCita();
$res = $obt->showData();
if ($res){
    echo $res->rowCount();
}else{
    echo "No se guardo la cita: ";
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
