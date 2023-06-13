<?php

include_once "../utiles/funciones.php";

try {
    $conexion  = conexionBD();
    $condicion = htmlspecialchars($_POST['medicamento']);
    $error     = ["data" => false];
    $datos     = [];

    $resul = $conexion->prepare("SELECT u.nombre, u.apellidos, u.direccion, u.email, u.imagen, m.nombre_med, m.stock,m.ID "
            . "FROM medicamentos m inner join usuarios u on m.id_farmacia=u.id WHERE UPPER(m.nombre_med) LIKE :condicion") or die(print($conexion->errorInfo()));
    $resul->bindValue(':condicion', "%$condicion%");
    $resul->execute();
    $row   = $resul->fetch(PDO::FETCH_OBJ);
    if ($row) {
        do {
            $datos [] = [
                'nombre'      => $row->nombre,
                'apellidos'   => $row->apellidos,
                'email'       => $row->email,
                'direccion'   => $row->direccion,
                'medicamento' => $row->nombre_med,
                'stock'       => $row->stock,
                'imagen'      => $row->imagen,
                "idmed"       => $row->ID
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