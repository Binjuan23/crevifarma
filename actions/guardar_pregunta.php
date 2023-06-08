<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $foro = (isset($_POST['pregunta'])) ? htmlspecialchars($_POST['pregunta']) : 0;
    $id   = htmlspecialchars($_SESSION['id']);

    if ($foro) {
        $resul = $conexion->prepare("INSERT INTO foro (pregunta,usuario_id) VALUES "
                        . "(:pregunta,:usuario)") or die(print($conexion->errorInfo()));

        $resul->bindValue(':pregunta', "$foro");
        $resul->bindValue(':usuario', $id, PDO::PARAM_INT);

        $resul->execute();

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