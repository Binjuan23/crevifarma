<?php

session_start();

if (isset($_POST['uno'])&& $_POST['uno']) {
    $eliminar          = array($_POST['item']=>1);
    $_SESSION['carro'] = array_diff_key($_SESSION['carro'], $eliminar);
} else {
    if (isset($_SESSION['carro'])) {
        $_SESSION['carro'] = array();
    }
}
