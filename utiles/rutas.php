<?php

$ruta = ["css" => $pre . "./assets/css/styles.css", "bootstrap-css" => $pre . "./assets/css/bootstrap.min.css", "listado" => $pre . "./index.php?id=listado", "tienda" => $pre . "./index.php?id=tienda", "indice" => $pre . "./index.php", "login" => $pre . "./index.php?id=login", "foro" => $pre . "./index.php?id=foro", 'script' => $pre . "./assets/javascript/script.js", 'bootstrap-script' => $pre . "./assets/javascript/bootstrap.min.js", "buscar" => $pre . "index.php?id=buscar", "jquery" => $pre . "./assets/jquery/jquery-3.6.4.min.js", "validate" => $pre . "./assets/jquery/jquery.validate.min.js", "validate2" => $pre . "./assets/jquery/additional-methods.min.js", "fontawesome" => $pre . "./assets/fontawesome/css/all.min.css"];
switch ($id) {
    case "listado": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=listado", "valenciano" => $pre . "./index.php?idioma=val&id=listado"];
        break;
    case "login": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=login", "valenciano" => $pre . "./index.php?idioma=val&id=login"];
        break;
    case "buscar": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=buscar", "valenciano" => $pre . "./index.php?idioma=val&id=buscar"];
        break;
    case "foro": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=foro", "valenciano" => $pre . "./index.php?idioma=val&id=foro"];
        break;
    case "foro_respuestas" : $ruta += ["castellano" => "./foro_respuestas.php?idioma=es&id=foro_respuestas&pregunta=" . $pregunta, "valenciano" => "./foro_respuestas.php?idioma=val&id=foro_respuestas&pregunta=" . $pregunta];
        break;
    case "tienda": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=tienda", "valenciano" => $pre . "./index.php?idioma=val&id=tienda"];
        break;
    case "tienda_producto": $ruta += ["castellano" => "./tienda_producto.php?idioma=es&id=tienda_producto&tienda=1", "valenciano" => "./tienda_producto.php?idioma=val&id=tienda_producto&tienda=1"];
        break;
    default: $ruta += ["castellano" => $pre . "./index.php?idioma=es", "valenciano" => $pre . "./index.php?idioma=val"];
}
