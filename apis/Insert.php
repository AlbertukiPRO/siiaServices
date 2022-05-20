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

    public function showData(){
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $matricula = $data['matricula'];


            $consulta = "INSERT INTO simscitas (idhistorialacademico, idareacampus, idtramite, descripcioncita, estatuscitas, fechareservadacita, horaReservada, useraudit) VALUES (:idh,:idareacampus,:idtramite,:descripCita,'Agendada',:fechaCita,:horaCita,$matricula)" ;


            $lista = array($data['matricula'],$data['idarea'],$data['idtramite'],$data['descripcion'],$data['fecha'],$data['hora']);

            return self::Insertar($consulta,$lista);
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
