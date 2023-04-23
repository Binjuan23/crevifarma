<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $resul = $conexion->prepare("INSERT INTO respuestas (foro_id,respuesta,usuario_id,respuesta_id) VALUES "
            . "(:foro,:respuesta,:usuario,:referencia)") or die(print($conexion->errorInfo()));
    
    $resul->bindValue(':foro', "$foro");
    $resul->bindValue(':respuesta', "$respuesta");
    $resul->bindValue(':usuario', "$usuario");
    $resul->bindValue(':referencia', "$referencia");

    $resul->execute();

    if ($resul) {
        echo json_encode($datos);
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}