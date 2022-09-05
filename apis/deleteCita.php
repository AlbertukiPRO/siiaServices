<?php

require ('../resources/Conexion.php');

class DeleteCita {

    public function Execute($consulta, $param)
    {
        $conector = new Conexion();
        $enlace = $conector->conectar();
        $resultado = $enlace->prepare($consulta, array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY));
        $resultado->execute(array(':id'=>$param[0]));
        return $resultado;
    }
}

if (isset($_GET['idCita'])){
    $obt = new DeleteCita();
    $exe = $obt->Execute("DELETE FROM simscitas WHERE idcita = :id ", array($_GET['idCita']));
    if ($exe)
        echo $exe->rowCount();
    else
        echo "no se pudo ejecutar la consulta".var_dump($exe);
}else{
    echo "faltan parameters";
}