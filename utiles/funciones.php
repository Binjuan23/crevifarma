<?php

function conexionBD() {
    $dsn     = "mysql:host=localhost;port=3307;dbname=crevi_farma";
    $usuario = "root";
    $pass    = "";
    try {
        $conexion = new PDO($dsn, $usuario, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $conexion;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        die();
    }
}

function cerrarBD(&$con) {
    $con = null;
}

