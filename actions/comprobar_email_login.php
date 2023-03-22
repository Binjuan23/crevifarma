<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion   = conexionBD();
    $email      = (isset($_GET['email'])) ? htmlspecialchars($_GET['email']) : 0;
    $nick       = (isset($_POST['user_register'])) ? htmlspecialchars($_POST['nick']) : 0;
    $conjuncion = ($email && $nick) ? " AND usuario=:nick" : "";

    $resul = $conexion->prepare("SELECT * FROM usuarios WHERE email=:email" . $conjuncion) or die(print($conexion->errorInfo()));
    $resul->bindValue(':email', "$email");

    if (isset($_POST['user_register'])) {
        $resul->bindValue(':nick', "$nick");
    }

    $resul->execute();

    $row = $resul->fetch(PDO::FETCH_OBJ);

    if ($row) {
        echo json_encode(false);
    } else {
        if ($email && $nick) {
            $_SESSION['usuario'] = $row->usuario;
            $_SESSION['tipo']    = $row->tipo;
        }
        echo json_encode(true);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}