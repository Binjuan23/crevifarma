<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $resul = $conexion->query("SELECT id_producto producto,nombre, id_farmacia farmacia, count(id_producto) AS cantidad,"
                    . " sum(precio) total FROM productos pro INNER JOIN productos_comprados poco ON pro.ID=poco.id_producto WHERE "
                    . "pro.id_farmacia=" . $_SESSION['id'] . " GROUP BY 1") or die(print($conexion->errorInfo()));
    $datos2=[];
    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos = [
            "1Producto" => urldecode($row->producto),
            "2Nombre"   => urldecode($row->nombre),
            "Farmacia"  => $row->farmacia,
            "3Cantidad" => $row->cantidad,
            "4Total"    => $row->total
        ];
        $datos2[]=$datos;
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


