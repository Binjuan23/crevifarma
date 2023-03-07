<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $sql      = "SELECT * FROM usuarios";

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos[] = [
            'id'       => $row->id_usuario,
            'usuario'  => $row->usuario,
            'password' => $row->password
        ];
    }

    echo json_encode($datos);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}