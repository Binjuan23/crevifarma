<?php

$ruta = ["css" => "./assets/css/styles.css", "listado" => "./index.php?id=listado", "indice" => "./index.php", "login" => "index.php?id=login",'script'=>"./assets/javascript/script.js"];
switch ($id) {
    case "listado": $ruta += ["castellano" => "./index.php?idioma=es&id=listado", "valenciano" => "./index.php?idioma=val&id=listado"];
        break;
    case "login": $ruta += ["castellano" => "./index.php?idioma=es&id=login", "valenciano" => "./index.php?idioma=val&id=login"];
        break;
    default: $ruta += ["castellano" => "./index.php?idioma=es", "valenciano" => "./index.php?idioma=val"];
}
