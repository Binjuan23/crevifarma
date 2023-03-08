<?php

include_once '../utiles/funciones.php';
include_once "../utiles/configuracion.php";
//
try {
    $conexion = conexionBD();
    $id_user  = htmlspecialchars($_POST['user-id-del']);

    $sql = "DELETE FROM usuarios WHERE id=0";

    $resul = $conexion->prepare($sql) or die(print($conexion->errorInfo()));
    $resul->execute();
    if ($resul->rowCount() > 0) {
        cerrarBD($con);
        header("Location: ../index.php?id=listado&eliminado=1");
    } else {
        cerrarBD($con);
        header("Location: ../index.php?id=listado&eliminado=0");
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

