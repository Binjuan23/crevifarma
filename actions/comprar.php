<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $idioma   = isset($_GET['idioma']) ? $_GET['idioma'] : "es";
    $codigo   = "#" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

    $cod  = $conexion->query("SELECT id_pedido FROM pedidos") or die(print($conexion->errorInfo()));
    $cods = array_merge($cod->fetchAll());

    while (in_array($codigo, $cods)) {
        $codigo = "#" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
    }

    $id_usuario = $_SESSION['id'];
    $condicion  = '';
    $total      = isset($_POST['total']) ? $_POST['total'] : 0;

    $dinero   = $conexion->query("SELECT dinero FROM usuarios WHERE ID=" . $id_usuario) or die(print($conexion->errorInfo()));
    $cantidad = $dinero->fetch(PDO::FETCH_OBJ);

    if ($total > (float) $cantidad->dinero) {
        echo json_encode("fondos");
        exit;
    }

    foreach ($_SESSION['carro'] as $key => $value) {
        if ($key === array_key_last($_SESSION['carro'])) {
            $condicion .= "('" . $codigo . "'," . $id_usuario . ",'" . $key . "'," . $value . ")";
        } else {
            $condicion .= "('" . $codigo . "'," . $id_usuario . ",'" . $key . "'," . $value . "),";
        }
    }

    $resul = $conexion->query("INSERT INTO productos_comprados (id_pedido,id_usuario,id_producto,cantidad) VALUES " . $condicion) or die(print($conexion->errorInfo()));
    $stock = '';
    foreach ($_SESSION['carro'] as $key => $value) {
        $stock = $conexion->query("UPDATE productos SET stock=stock-" . $value . " WHERE ID=" . $key) or die(print($conexion->errorInfo()));
    }

    $result2 = $conexion->query("INSERT INTO pedidos (id_pedido,id_usuario,estado) VALUES ('" . $codigo . "'," . $id_usuario . ",'enviado')") or die(print($conexion->errorInfo()));

    if ($result2) {
        $_SESSION['carro'] = array();
        echo json_encode("gracias");
    } else {
        echo json_encode("lo siento");
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}


