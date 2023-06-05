<?php

session_start();
include_once '../utiles/funciones.php';

try {


    if (isset($_SESSION['carro']) && count($_SESSION['carro']) >= 1) {
        $condicion = " WHERE ";
        foreach ($_SESSION['carro'] as $key => $value) {
            if ($key === array_key_last($_SESSION['carro'])) {
                $condicion .= "ID=" . $key;
            } else {
                $condicion .= "ID=" . $key . " OR ";
            }
        }

        $conexion = conexionBD();
        $sql      = "SELECT nombre,ID,categoria_es,categoria_val,precio,stock,imagen FROM productos" . $condicion;

        $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

        $datos = [];

        while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
            $datos [] = [
                "nombre"        => urldecode($row->nombre),
                "id"            => $row->ID,
                "categoria_es"  => $row->categoria_es,
                'categoria_val' => $row->categoria_val,
                "precio"        => $row->precio,
                "stock"         => $row->stock,
                "imagen"        => $row->imagen,
                "cantidad"      => $_SESSION['carro'][$row->ID]
            ];
        }


        echo json_encode($datos);
    } else {
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}


