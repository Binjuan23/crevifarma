<?php

include_once '../utiles/funciones.php';

try {
    $conexion  = conexionBD();
    $sql       = "SELECT * FROM foro";

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'id' => $row->foro,
            'pregunta' =>$row->pregunta
        ];       
    }
    
    if($datos){
        echo json_encode($datos);
    }else{
        echo json_encode(false);
    }
    
    
} catch (PDOException $ex) {
    echo $ex->getMessage();
}finally {
    cerrarBD($conexion);
}
