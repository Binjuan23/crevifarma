<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    $foro       = htmlspecialchars($_GET['pregunta']);
    $respuesta  = htmlspecialchars($_POST['respuesta']);
    $usuario    = htmlspecialchars($_POST['idUsuario']);
    $referencia = (isset($_POST['idMensaje'])) ? htmlspecialchars($_POST['idMensaje']) : null;

    $resul = $conexion->prepare("INSERT INTO respuestas (foro_id,respuesta,usuario_id,respuesta_id) VALUES "
                    . "(:foro,:respuesta,:usuario,:referencia)") or die(print($conexion->errorInfo()));

    $resul->bindValue(':foro', "$foro");
    $resul->bindValue(':respuesta', "$respuesta");
    $resul->bindValue(':usuario', "$usuario");
    $resul->bindValue(':referencia', "$referencia");

    $resul->execute();

    if ($resul) {
        header("Location: ../paginas/foro_respuestas.php?respuestaGuardada=1&id=foro_respuestas&idioma=" . htmlspecialchars($_GET['idioma']) . "&pregunta=" . $foro);
        echo json_encode(true);
    } else {
        header("Location: ../paginas/foro_respuestas.php?respuestaGuardada=0&id=foro_respuestas&idioma=" . htmlspecialchars($_GET['idioma']) . "&pregunta=" . $foro);
        echo json_encode(false);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}