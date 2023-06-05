<?php

session_start();
include_once '../utiles/funciones.php';
$_SESSION = array();
session_destroy();
setcookie(session_name(), 123, time() - 1000);

header("Location: ./index.php?id=inicio");
?>