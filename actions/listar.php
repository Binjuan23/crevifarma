<?php

include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();
    $orden    = htmlspecialchars($_POST['orden']);
    $sql      = "SELECT * FROM usuarios ";// . ($orden === 'nada') ? "" : "ORDER BY " . $orden;

    $resul = $conexion->query($sql) or die(print($conexion->errorInfo()));

    $datos = [];
    $error = ["data" => false];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $datos[] = [
            'id'             => $row->ID,
            'nombre'         => $row->nombre,
            'apellidos'      => $row->apellidos,
            'edad'           => $row->edad,
            'usuario'        => $row->usuario,
            'contraseña'     => $row->contraseña,
            'fecha_creacion' => $row->fecha_creacion,
            'ultimo_login'   => $row->ultimo_login,
            'dinero'         => $row->dinero,
            'tipo'           => $row->tipo,
            'email'          => $row->email,
            'direccion'      => $row->direccion
        ];
    }

    cerrarBD($con);
    echo json_encode($datos);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}