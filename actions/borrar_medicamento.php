<?php

include_once '../utiles/funciones.php';
//Archivo para borrar
try {
    $conexion = conexionBD();
    $id_med   = htmlspecialchars($_POST['medicamento-id-del']);
    $tipo     = htmlspecialchars($_POST['tipo']);

    $tabla = ($tipo === "tipomedicamento") ? "medicamentos" : "productos";

    $resul = $conexion->exec("DELETE FROM " . $tabla . " WHERE ID=" . $id_med);
    //$resul = $conexion->prepare("DELETE FROM usuarios WHERE id= :id") or die(print($conexion->errorInfo()));
    //$resul->bindParam(':id', $id_user, PDO::PARAM_INT);
    //$resul->execute();
    if ($resul) {
        header("Location: ../index.php?id=aniadir&eliminado=1");
    } else {
        header("Location: ../index.php?id=aniadir&eliminado=0");
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}

