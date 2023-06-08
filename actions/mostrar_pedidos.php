<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $resul = $conexion->query("SELECT * FROM pedidos WHERE id_usuario=" . $_SESSION['id']) or die(print($conexion->errorInfo()));

    $row    = $resul->fetch(PDO::FETCH_OBJ);
    $datos2 = [];
    while ($row    = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos    = [
            "1Id"     => $row->id_pedido,
            "2Fecha"  => $row->fecha,
            "3Estado" => urldecode($row->estado)
        ];
        $datos2[] = $datos;
    }


    if ($datos2) {
        echo json_encode($datos2);
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}


