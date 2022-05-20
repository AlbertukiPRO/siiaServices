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
        $resultados = $resultado->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function showdata()
    {
        $data = self::getData("SELECT a.idareacampus as intIdAreas, a.nombreArea as strNombreAreas FROM sictareas as a");

        return $data;
    }
}

$obt = new Areas();
$data = $obt->showdata();
$json = json_encode($data);

echo $json;
