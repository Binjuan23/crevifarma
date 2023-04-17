<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $id       = $_POST['id'];
    $sql      = "SELECT consulta1.respuesta respuesta_principal, consulta1.fecha, consulta1.usuario, consulta2.respuesta respuesta_secundaria FROM (SELECT res.id, res.respuesta, res.foro_id, res.fecha, usu.usuario FROM respuestas res INNER JOIN usuarios usu ON res.usuario_id=usu.ID) consulta1 LEFT JOIN (SELECT respu.id, estas.respuesta FROM respuestas respu INNER JOIN respuestas estas ON respu.id=estas.respuesta_id) consulta2 ON consulta1.id=consulta2.id WHERE consulta1.foro_id=" . $id . " ORDER BY consulta1.id";

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos [] = [
            'principal'  => $row->respuesta_principal,
            'fecha'      => $row->fecha,
            'usuario'    => $row->usuario,
            'secundaria' => $row->respuesta_secundaria
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

