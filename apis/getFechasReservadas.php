<?php


include ("../resources/Conexion.php");

class FechasReservadas {
    public static function getData($consulta)
    {
        $conector = new Conexion();

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);

    }

    public function showdata($idarea, $fecha)
    {
        /**
         * @api para obtener los horarios no disponibles segun el dia
         */
        return self::getData("SELECT
                                        idareareservada,
                                        fechaexcepcion,
                                        horaexepcion
                                    FROM siexcepciones
                                    where idareareservada = $idarea and horaexepcion != 'all' and siexcepciones.fechaexcepcion LIKE '%$fecha%'
                                    group by horaexepcion");
    }

    public function showdata2($value)
    {
        return self::getData("SELECT s.fechaexcepcion as fechaexepcion FROM siexcepciones as s INNER JOIN sictareas as c ON c.idareacampus = s.idareareservada where s.idareareservada = $value and s.horaexepcion = 'all' ");
    }
}

if (isset($_GET['fecha'])){
    $obt = new FechasReservadas();
    $data = $obt->showdata($_GET['idarea'], $_GET['fecha']);

    if(sizeof($data)>1){
        foreach ($data as $row){
            echo $row['horaexepcion'].",";
        }
    }else{
        echo "vacio";
    }
}else if (isset($_GET['idarea'])){
    $obt = new FechasReservadas();
    $data = $obt->showdata2($_GET['idarea']);

    foreach ($data as $row){
        echo $row['fechaexepcion'].",";
    }
}else{
    echo "faltan parametros";
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