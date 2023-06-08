<?php

include_once '../utiles/funciones.php';
try {
    $conexion = conexionBD();
    $id_med   = htmlspecialchars($_POST['medicamento-id-del']);
    $tipo     = htmlspecialchars($_POST['tipo']);

    $tabla = ($tipo === "tipomedicamento") ? "medicamentos" : "productos";

    $resul = $conexion->exec("DELETE FROM " . $tabla . " WHERE ID=" . $id_med);

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

