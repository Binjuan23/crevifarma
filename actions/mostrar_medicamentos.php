<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $sql      = "SELECT ID, nombre_med as nombre, stock, \"tipo\" \"medicamento\" FROM medicamentos WHERE id_farmacia=" . $_SESSION['id'] . " UNION ALL SELECT ID, nombre, stock, precio FROM productos WHERE id_farmacia=" . $_SESSION['id'];

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'nombre' => urldecode($row->nombre),
            "stock"  => $row->stock,
            "id"     => $row->ID,
            "tipo"   => $row->tipo
        ];
    }

    if ($datos) {
        echo json_encode($datos);
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}


