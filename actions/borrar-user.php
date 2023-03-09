<?php

include_once '../utiles/funciones.php';
//Archivo para borrar
try {
    $conexion = conexionBD();
    $id_user  = htmlspecialchars($_POST['user-id-del']);

    $resul = $conexion->exec("DELETE FROM usuarios WHERE id= 0");
    //$resul = $conexion->prepare("DELETE FROM usuarios WHERE id= :id") or die(print($conexion->errorInfo()));
    //$resul->bindParam(':id', $id_user, PDO::PARAM_INT);
    //$resul->execute();
    if ($resul) {
        cerrarBD($con);
        header("Location: ../index.php?id=listado&eliminado=1");
    } else {
        cerrarBD($con);
        header("Location: ../index.php?id=listado&eliminado=0");
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

