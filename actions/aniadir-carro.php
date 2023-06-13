<?php
//Añade objetos a la variable de sesión del carro donde la key es el identificador del producto y el valor es la cantidad
session_start();
$item     = htmlspecialchars($_POST["item"]);
$cantidad = (isset($_POST["cantidad"])) ? htmlspecialchars($_POST["cantidad"]) : 0;
$stock    = htmlspecialchars($_POST["stock"]);

if (isset($_POST['carrito'])) {
    $_SESSION['carro'][$item] = $cantidad;
} else {
    if (isset($_SESSION['carro'][$item])) {
        if ($_SESSION['carro'][$item] < $stock) {
            $quedan = $stock - $_SESSION['carro'][$item];
            if ($cantidad && $cantidad < $quedan) {
                $_SESSION['carro'][$item] += $cantidad;
                exit;
            } else {
                $_SESSION['carro'][$item] += 1;
            }
        }
    } else {
        if ($cantidad && $cantidad < $stock) {
            $_SESSION['carro'][$item] += $cantidad;
        } else {
            $_SESSION['carro'][$item] += 1;
        }
    }
}




    