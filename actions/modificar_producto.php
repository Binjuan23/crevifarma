<?php

include_once '../utiles/funciones.php';
//Archivo para borrar
try {
    $conexion = conexionBD();
    $stock    = htmlspecialchars($_POST['stock']);
    $tipo     = htmlspecialchars($_POST['tipo']);
    $precio   = htmlspecialchars($_POST['precio']);
    $id       = htmlspecialchars($_POST['id']);
    echo json_encode($stock." ".$tipo." ".$precio." ".$id);
    /*
      if (!$stock && !$precio) {

      $tabla = ($tipo === "tipomedicamento") ? "medicamentos" : "productos";

      $condicion = ($stock && !$precio) ? " SET stock=" . $stock : ($stock && $precio) ? " SET stock=" . $stock . " AND precio=" . $precio : " SET precio=" . $precio;

      $resul = $conexion->exec("UPDATE " . $tabla . $condicion . " WHERE ID=" . $id);
      //$resul = $conexion->prepare("DELETE FROM usuarios WHERE id= :id") or die(print($conexion->errorInfo()));
      //$resul->bindParam(':id', $id_user, PDO::PARAM_INT);
      //$resul->execute();
      if ($resul) {
      echo json_encode(true);
      } else {
      echo json_encode(false);
      }
      } else {
      echo json_encode(false);
      }
     
    */
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}

