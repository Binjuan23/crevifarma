<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $idMed     = htmlspecialchars($_POST['id']);
    $idUsuario = $_SESSION['id'];

    $resul = $conexion->prepare("SELECT * FROM reservas WHERE id_medicamento=" . $idMed . " AND id_usuario=" . $idUsuario) or die(print($conexion->errorInfo()));

    $resul->execute();
    $row = $resul->fetch(PDO::FETCH_OBJ);
    
    if (!$row) {
        $resul->closeCursor();
        $result = $conexion->exec("INSERT INTO reservas (id_usuario,id_medicamento) VALUE (" . $idUsuario . "," . $idMed . ")") or die(print($conexion->errorInfo()));
        if ($result) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode("Ya tienes una reserva de ese medicamento");
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}



