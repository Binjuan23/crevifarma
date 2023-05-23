<?php

session_start();
$item = explode(",", $_POST["item"]);

$_SESSION['carro'][$item[0]] += 1;

