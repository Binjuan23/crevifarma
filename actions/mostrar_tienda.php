<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $sql      = "SELECT * FROM productos";

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'id'                  => $row->ID,
            'nombre'              => $row->nombre,
            'categoriaEspañol'    => $row->categoria_es,
            "categoriaCastellano" => $row->categoria_val,
            "precio"              => $row->precio,
            "stock"               => $row->stock,
            "imagen"              => $row->imagen
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