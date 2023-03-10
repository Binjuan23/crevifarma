<?php

include_once '../utiles/funciones.php';
//Archivo para borrar
try {
    $conexion = conexionBD();
    $id_user  = htmlspecialchars($_POST['user-id-del']);

    $resul = $conexion->exec("DELETE FROM usuarios WHERE id=" . $id_user);
    //$resul = $conexion->prepare("DELETE FROM usuarios WHERE id= :id") or die(print($conexion->errorInfo()));
    //$resul->bindParam(':id', $id_user, PDO::PARAM_INT);
    //$resul->execute();
    if ($resul) {
        header("Location: ../index.php?id=listado&eliminado=1");
    } else {
        header("Location: ../index.php?id=listado&eliminado=0");
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}

