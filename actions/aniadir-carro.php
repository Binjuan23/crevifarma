<?php

session_start();
$item     = htmlspecialchars($_POST["item"]);
$cantidad = (isset($_POST["cantidad"])) ? htmlspecialchars($_POST["cantidad"]) : 0;
$stock    = htmlspecialchars($_POST["stock"]);

if (isset($_POST['vaciar'])) {
    if (isset($_SESSION['carro'])) {
        $_SESSION['carro'] = array();
        header("Location: ../index.php?id=carro");
    }
}

if (isset($_SESSION['carro'][$item])) {
    if ($_SESSION['carro'][$item] < $stock) {
        if ($cantidad) {
            $_SESSION['carro'][$item] = $cantidad;
        } else {
            $_SESSION['carro'][$item] += 1;
        }
    }
} else {
    if ($cantidad) {
        if ($cantidad < $stock) {
            $_SESSION['carro'][$item] = $cantidad;
        }
    } else {
        $_SESSION['carro'][$item] += 1;
    }
}




