<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $licencia = (isset($_GET['code'])) ? htmlspecialchars($_GET['code']) : 0;

    $resul = $conexion->prepare("SELECT * FROM licencias WHERE Numero=:cod") or die(print($conexion->errorInfo()));
    $resul->bindValue(':cod', "$licencia", PDO::PARAM_INT);

    $resul->execute();

    $row = $resul->fetch(PDO::FETCH_OBJ);

    if ($row && $row->ID_usuario === null) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}
