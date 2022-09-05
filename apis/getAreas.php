<?php


include("../resources/Conexion.php");

class Areas
{
    public static function getData($consulta)
    {
        $conector = new Conexion();

        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showdata()
    {
        return self::getData("SELECT a.idareacampus as intIdAreas, a.nombreArea as strNombreAreas FROM sictareas as a");
    }
}

$obt = new Areas();
$data = $obt->showdata();
$json = json_encode($data);

echo $json;
