<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $resul = $conexion->query("Select consulta1.fecha fecha, consulta1.nombre nombre, consulta2.direccion direccion from "
                    . "(SELECT res.fecha_reserva fecha, med.nombre_med nombre FROM reservas res inner join "
                    . "medicamentos med on med.ID=res.id_medicamento where res.id_usuario=" . $_SESSION['id'] . ") consulta1 inner join "
                    . "(Select usu.direccion direccion, med.nombre_med nombre from medicamentos med inner join "
                    . "usuarios usu on usu.ID=med.id_farmacia) consulta2 on consulta1.nombre=consulta2.nombre") or die(print($conexion->errorInfo()));

    $row    = $resul->fetch(PDO::FETCH_OBJ);
    $datos2 = [];
    while ($row    = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos    = [
            "1Nombre"    => urldecode($row->nombre),
            "2Fecha"     => $row->fecha,
            "3Direccion" => urldecode($row->direccion)
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

