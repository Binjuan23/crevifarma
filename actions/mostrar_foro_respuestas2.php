<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $foro_id  = $_GET['pregunta'];
    $sql      = "SELECT foro.foro, foro.pregunta, foro.fecha, usuarios.usuario FROM foro foro INNER JOIN usuarios usuarios on foro.usuario_id=usuarios.ID WHERE foro=" . $foro_id;

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

    $sql = "SELECT consulta1.id, consulta1.foro_id, consulta1.respuesta respuesta_principal, consulta1.fecha,"
            . " consulta2.usuario, consulta1.respuesta_id respuesta_secundaria FROM respuestas consulta1 INNER JOIN usuarios consulta2 "
            . "ON consulta1.usuario_id=consulta2.ID WHERE consulta1.foro_id=" . $foro_id . " ORDER BY consulta1.id";

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