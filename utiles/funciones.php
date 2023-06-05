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

function filtro($bbdd) {
    $resultado = [];
    try {
        $conexion = conexionBD();
        $resul    = $conexion->prepare("SELECT * FROM " . $bbdd) or die(print($conexion->errorInfo()));
        //$resul->bindParam(1, $bbdd, PDO::PARAM_STR);
        $resul->execute();

        $row = $resul->fetch(PDO::FETCH_OBJ);
        foreach ($row as $key => $value) {
            if ($key === 'imagen') {
                continue;
            }
            $resultado [] = $key;
        }
        return $resultado;
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

//PROBAR
function comprobar_sesion($tipo) {
    if (!isset($_SESSION['usuario']) && $_SESSION['tipo'] !== $tipo) {
        header("Location: ./index.php?id=login&aviso=1");
    }
}

