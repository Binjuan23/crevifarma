<?php

$idioma = isset($_GET['idioma']) ? $_SESSION['idioma'] = htmlspecialchars($_GET['idioma']) : substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if(isset($_SESSION['idioma'])){
    $idioma = $_SESSION['idioma'];
}

include_once "./languages/" . $idioma . ".php";

