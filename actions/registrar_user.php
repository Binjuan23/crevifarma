<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $datos  = explode("&", $_POST['register']);
    $datos1 = [];
    foreach ($datos as $value) {
        $val             = explode("=", $value);
        $datos1[$val[0]] = $val[1];
    }

    $email      = urldecode($datos1['email']);
    $nick       = $datos1['user-register'];
    $contraseña = md5($datos1['password-register']);
    $tipo       = $datos1['tipo'];
    $codigo     = (isset($datos1['code'])) ? $datos1['code'] : 0;

    $resul = $conexion->prepare("INSERT INTO usuarios (usuario,contraseña,tipo,email) VALUES (:usu,:con,:tip,:em)") or die(print($conexion->errorInfo()));
    $resul->bindValue(':usu', "$nick");
    $resul->bindValue(':con', "$contraseña");
    $resul->bindValue(':tip', "$tipo");
    $resul->bindValue(':em', "$email");

    $resul->execute();

    $resul2 = '';

    if ($codigo) {
        $resul2 = $conexion->prepare("INSERT INTO licencias (ID_usuario) VALUE (:id) WHERE Numero=:cod") or die(print($conexion->errorInfo()));
        $resul2->bindValue(':id', "$row->ID", PDO::PARAM_INT);
        $resul2->bindValue(':cod', "$codigo");
        $resul2->execute();
    }


    if ($tipo === "normal") {
        if ($resul) {
            echo json_encode(true);
            //header("Location: ../index.php?id=login&registrado=1");
        } else {
            echo json_encode(false);
            //header("Location: ../index.php?id=login&registrado=0");
        }
    } else if ($tipo === "farmacia") {
        if ($resul && $resul2) {
            echo json_encode(true);
            //header("Location: ../index.php?id=login&registrado=1");
        } else {
            echo json_encode(false);
            //header("Location: ../index.php?id=login&registrado=0");
        }
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}