<?php

session_start();
include_once '../utiles/funciones.php';
//Archivo para borrar
try {
    $conexion  = conexionBD();
    $nombre    = ($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : 0;
    $apellidos = ($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : 0;
    $usuario   = ($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : 0;
    $edad      = ($_POST['edad']) ? (int) htmlspecialchars($_POST['edad']) : 0;
    $direccion = ($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : 0;
    $dinero    = ($_POST['dinero']) ? (float) htmlspecialchars($_POST['dinero']) : 0;
    $email     = ($_POST['email']) ? htmlspecialchars($_POST['email']) : 0;
    $password  = ($_POST['password'] && $_POST['si']) ? md5(htmlspecialchars($_POST['password'])) : 0;
    $si        = ($_POST['si']);
    $datos     = array("nombre" => $nombre, "apellidos" => $apellidos, "usuario" => $usuario, "edad" => $edad, "direccion" => $direccion, "dinero" => $dinero, "email" => $email, "contraseña" => $password, "imagen" => 0);

    if (isset($_FILES['imagen'])) {
        $nomTemp       = $_FILES['imagen']['tmp_name'];
        $nomImagen     = $_FILES['imagen']['name'];
        $tamanio       = $_FILES['imagen']['size'];
        $tipo          = $_FILES['imagen']['type'];
        $nomImagenCmps = explode(".", $nomImagen);
        $extension     = strtolower(end($nomImagenCmps));
        $nuevoNom      = $_SERVER['REQUEST_TIME'] . $nomImagen;
        $directorio    = '../assets/images/';
        $destino       = $directorio . $nuevoNom;
        $imagen        = './assets/images/' . $nuevoNom;
        if (move_uploaded_file($nomTemp, $destino)) {
            $datos2 ['imagen'] = true;
        } else {
            $datos2 ['imagen'] = false;
        }
        $datos["imagen"] = $imagen;
    }

    $datos2 = array("nombre" => 0, "apellidos" => 0, "usuario" => 0, "edad" => 0, "direccion" => 0, "dinero" => 0, "email" => 0, "contraseña" => 0, "imagen" => 0);

    $resultado = array_diff($datos, $datos2);
    $condicion = '';
    $ultimo    = array_key_last($resultado);
    foreach ($resultado as $key => $value) {
        if ($key !== $ultimo) {

            $condicion .= $key . " = '" . $value . "', ";
        } else {

            $condicion .= $key . " = '" . $value . "'";
        }
    }
    if ($si) {
        $resul = $conexion->exec("UPDATE usuarios SET " . $condicion . " WHERE ID=" . $_SESSION['id']);
        if ($resul) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    } else if (!$si && strlen($condicion) > 5) {
        $resul = $conexion->exec("UPDATE usuarios SET " . $condicion . " WHERE ID=" . $_SESSION['id']);

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

