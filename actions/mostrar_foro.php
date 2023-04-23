<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $sql      = "SELECT foro.foro, foro.pregunta, foro.fecha, usuarios.usuario, count(respuestas.foro_id) cantidad "
            . "FROM foro foro INNER JOIN usuarios usuarios ON foro.usuario_id=usuarios.ID LEFT JOIN respuestas "
            . "respuestas ON respuestas.foro_id=foro.foro GROUP BY foro.foro";

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'pregunta'      => $row->pregunta,
            'usuario'       => $row->usuario,
            'fechaPre'      => $row->fecha,
            "id"            => $row->foro,
            "numRespuestas" => $row->cantidad
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
