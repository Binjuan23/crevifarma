<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $foro_id  = $_GET['pregunta'];
    $sql      = "SELECT foro.foro, foro.pregunta, foro.fecha, usuarios.usuario FROM foro foro INNER JOIN usuarios usuarios on foro.foro=usuarios.ID WHERE FORO=" . $foro_id;

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'pregunta' => $row->pregunta,
            'fecha'    => $row->fecha,
            'usuario'  => $row->usuario,
            'foro'     => $row->foro
        ];
    }
    $resul->closeCursor();

    $sql = "SELECT consulta1.id, consulta1.foro_id, consulta1.respuesta respuesta_principal, "
            . "consulta1.fecha, consulta1.usuario, consulta2.respuesta respuesta_secundaria FROM "
            . "(SELECT res.id, res.respuesta, res.foro_id, res.fecha, usu.usuario FROM respuestas res "
            . "INNER JOIN usuarios usu ON res.usuario_id=usu.ID) consulta1 LEFT JOIN (SELECT respu.id, "
            . "estas.respuesta FROM respuestas respu INNER JOIN respuestas estas ON respu.id=estas.respuesta_id)"
            . " consulta2 ON consulta1.id=consulta2.id WHERE consulta1.foro_id=" . $foro_id . " ORDER BY consulta1.id";

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'idrespuesta' => $row->id,
            'respuesta'   => $row->respuesta_principal,
            'fecha'       => $row->fecha,
            'usuario'     => $row->usuario,
            'referencia'  => $row->respuesta_secundaria,
            "foroid"      => $row->foro_id
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