<?php

session_start();
include_once '../utiles/funciones.php';

try {
    $conexion = conexionBD();

    if (isset($_GET['id'])) {
        $ID = htmlspecialchars($_GET['id']);

        $resul = $conexion->prepare("SELECT ID FROM productos WHERE ID=:id") or die(print($conexion->errorInfo()));
        $resul->bindValue(':id', "$ID", PDO::PARAM_INT);

        $resul->execute();

        $row = $resul->fetch(PDO::FETCH_OBJ);

        if ($row) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    } else {

        $datos2 = [];

        $sql = ($_POST["tipo"] !== "medicamento") ? "INSERT INTO productos (ID, nombre, categoria_es,categoria_val,precio,stock,imagen,id_farmacia) VALUE (:id,:nom,:catEs,:catVal,:precio,:stock,:imagen,:idFarm)" : "INSERT INTO medicamentos (id_farmacia, nombre_med, stock) VALUE (:id,:nom,:stock)";

        $nombre = urldecode($_POST['nombre']);
        $stock  = htmlspecialchars($_POST['stock']);

        if ($_POST['tipo'] !== "medicamento") {
            $id            = htmlspecialchars($_POST['id']);
            $categoria_es  = htmlspecialchars($_POST['categoria_es']);
            $categoria_val = htmlspecialchars($_POST['categoria_val']);
            $precio        = htmlspecialchars($_POST['precio']);
            $imagen        = '';
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
                $imagen        = '../assets/images/' . $nuevoNom;
                if (move_uploaded_file($nomTemp, $destino)) {
                    $datos2 ['imagen'] = true;
                } else {
                    $datos2 ['imagen'] = false;
                }
            }

            $resul2 = $conexion->prepare($sql) or die(print($conexion->errorInfo()));
            $resul2->bindValue(':id', $id, PDO::PARAM_INT);
            $resul2->bindValue(':stock', $stock, PDO::PARAM_INT);
            $resul2->bindValue(':nom', "$nombre");
            $resul2->bindValue(':catEs', "$categoria_es");
            $resul2->bindValue(':catVal', "$categoria_val");
            $resul2->bindValue(':precio', $precio, PDO::PARAM_INT);
            $resul2->bindValue(':imagen', "$imagen");
            $resul2->bindValue(':idFarm', $_SESSION['id'], PDO::PARAM_INT);
        } else {
            $resul2 = $conexion->prepare($sql) or die(print($conexion->errorInfo()));
            $resul2->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $resul2->bindValue(':nom', "$nombre");
            $resul2->bindValue(':stock', $stock, PDO::PARAM_INT);
        }

        $resul2->execute();

        if ($resul2) {
            $datos2['insert'] = true;
            echo json_encode($datos2);
        } else {
            $datos2['insert'] = false;
            echo json_encode($datos2);
        }
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}

