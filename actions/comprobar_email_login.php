<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $datos    = isset($_POST['register1']) ? explode("&", $_POST['register1']) : 0;
    $datos1   = [];

    if (isset($_POST['register1'])) {
        foreach ($datos as $value) {
            $val             = explode("=", $value);
            $datos1[$val[0]] = $val[1];
        }
    }

    $email     = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : 0;
    $nick      = isset($_POST['register1']) ? $datos1['user-login'] : 0;
    $password  = isset($_GET['password-register']) ? md5(htmlspecialchars($_GET['password-register'])) : (isset($_POST['register1']) ? md5($datos1['password-login']) : 0);
    
    $sql = '';
    if ($password && $nick) {
        $sql = "SELECT * FROM usuarios WHERE usuario=:nick AND contraseña=:contra";
    } else if ($email) {
        $sql = "SELECT * FROM usuarios WHERE email=:email";
    } else if($password) {
        $sql = "SELECT * FROM usuarios WHERE contraseña=:contra";
    }

    $resul = $conexion->prepare($sql) or die(print($conexion->errorInfo()));

    if ($email) {
        $resul->bindValue(':email', $email);
    }
    
    if ($password) {
        $resul->bindValue(':contra', $password);
    }

    if ($nick) {
        $resul->bindValue(':nick', "$nick");
    }

    $resul->execute();

    $row = $resul->fetch(PDO::FETCH_OBJ);

    if ($row) {
        if ($password && $nick) {            
            //$_SESSION['usuario'] = $row->usuario;
            //$_SESSION['tipo']    = $row->tipo;
        }
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}