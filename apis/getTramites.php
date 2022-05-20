<?php


include ("../resources/Conexion.php");

class Tramites {
    public static function getData($consulta)
    {
        $conector = new Conexion();

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute();
        $resultados = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }


    public function showdata($nameTramite)
    {
        return self::getData("SELECT t.idtramite as intIdTramite, t.nombretramite as strNombreTramite FROM sicttramites as t where t.idareacampus = $nameTramite");
    }
}

$nameTramite = $_GET['idTramite'];
$obt = new Tramites();
$data = $obt->showdata($nameTramite);
$json = json_encode($data);

echo $json;

//$json = file_get_contents('php://input');
//$data = json_decode($json, true);
//
//
//var_dump($data);
//
//$matricula = $data['matricula'];
//
//echo $matricula;