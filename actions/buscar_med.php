<?php

include_once "../utiles/funciones.php";

try {
    $conexion  = conexionBD();
    $condicion = htmlspecialchars($_POST['medicamento']);
    $error     = ["data" => false];
    $datos     = [];

    $resul = $conexion->prepare("SELECT u.nombre, u.apellidos, u.direccion, u.email, u.imagen, m.nombre_med, m.stock FROM medicamentos m inner join usuarios u on m.id_farmacia=u.id WHERE m.nombre_med LIKE '%:condicion%'") or die(print($conexion->errorInfo()));
    $resul->bindParam(':condicion', $condicion, PDO::PARAM_INT);
    $resul->execute();
    $count = $resul->fetch(PDO::FETCH_OBJ);
    if ($count) {
        do {
            $datos [] = [
                'nombre'      => $row->nombre,
                'apellidos'   => $row->apellidos,
                'email'       => $row->email,
                'direccion'   => $row->direccion,
                'medicamento' => $row->nombre_med,
                'stock'       => $row->stock
            ];
            $row      = $resul->fetch(PDO::FETCH_OBJ);
        } while ($row);

        echo json_encode($datos);
    } else {
        echo json_encode($error);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}