<?php

include_once '../utiles/funciones.php';
//Archivo para borrar
try {
    $conexion = conexionBD();
    $stock    = htmlspecialchars($_POST['stock']);
    $tipo     = htmlspecialchars($_POST['tipo']);
    $precio   = htmlspecialchars($_POST['precio']);
    $id       = htmlspecialchars($_POST['id']);

    if ($stock || $precio) {

        $tabla = ($tipo === "tipomedicamento") ? "medicamentos" : "productos";

        $condicion = ($precio) ? ($stock) ? " SET stock=" . $stock . ", precio=" . $precio : " SET precio=" . $precio : " SET stock=" . $stock;
        $resul     = $conexion->exec("UPDATE " . $tabla . $condicion . " WHERE ID=" . $id);

        if ($resul) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}

