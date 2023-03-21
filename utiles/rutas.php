<?php

$ruta = ["css" => "./assets/css/styles.css", "listado" => "./index.php?id=listado", "indice" => "./index.php", "login" => "index.php?id=login", 'script' => "./assets/javascript/script.js", "buscar" => "index.php?id=buscar", "jquery" => "./assets/jquery/jquery-3.6.4.min.js", "validate" => "./assets/jquery/jquery.validate.min.js", "validate2" => "./assets/jquery/additional-methods.min.js"];
switch ($id) {
    case "listado": $ruta += ["castellano" => "./index.php?idioma=es&id=listado", "valenciano" => "./index.php?idioma=val&id=listado"];
        break;
    case "login": $ruta += ["castellano" => "./index.php?idioma=es&id=login", "valenciano" => "./index.php?idioma=val&id=login"];
        break;
    case "buscar": $ruta += ["castellano" => "./index.php?idioma=es&id=buscar", "valenciano" => "./index.php?idioma=val&id=buscar"];
        break;
    default: $ruta += ["castellano" => "./index.php?idioma=es", "valenciano" => "./index.php?idioma=val"];
}
