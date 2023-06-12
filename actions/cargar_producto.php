<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $id       = htmlspecialchars($_POST["id"]);
    $sql      = "SELECT * FROM productos WHERE ID=" . $id;

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'nombre' => urldecode($row->nombre),
            'id'     => $row->ID,
            'precio' => $row->precio,
            "stock"  => $row->stock,
            "imagen"  => $row->imagen
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
