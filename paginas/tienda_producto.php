<?php
session_start();
include_once "../utiles/configuracion.php";
include_once "../utiles/funciones.php";
$id       = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
include_once "../utiles/rutas.php";
include_once "./encabezado.php";
?>