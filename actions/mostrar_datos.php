<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $resul    = '';
    if ($_SESSION['tipo'] === "farmacia") {
        $resul = $conexion->query("SELECT * FROM usuarios usu, licencias li WHERE usu.ID=" . $_SESSION['id'] . " AND li.ID_usuario=" . $_SESSION['id']) or die(print($conexion->errorInfo()));
    } else {
        $resul = $conexion->query("SELECT * FROM usuarios WHERE ID=" . $_SESSION['id']) or die(print($conexion->errorInfo()));
    }

    $row   = $resul->fetch(PDO::FETCH_OBJ);
    //echo json_encode($row);
    $datos = [
        "1Usuario"   => urldecode($row->usuario),
        "2Nombre"    => urldecode($row->nombre),
        "3Apellidos" => urldecode($row->apellidos),
        "4Edad"      => $row->edad,
        "5Direccion" => urldecode($row->direccion),
        "6Email"     => urldecode($row->email),
        "9Dinero"    => $row->dinero,
        "imagen"    => urldecode($row->imagen),
        "7Creado"    => $row->fecha_creacion,
        "8Ultimo"    => $row->ultimo_login
    ];

    if ($_SESSION['tipo'] === "farmacia") {
        $datos['91Licencia'] = $row->Numero;
    }

    if ($row) {
        echo json_encode($datos);
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}
