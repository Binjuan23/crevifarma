<?php

$ruta = ["css" => $pre . "./assets/css/styles.css","tiempo" => $pre . "./assets/css/tiempo.css", "bootstrap-css" => $pre . "./assets/css/bootstrap.min.css", "listado" => $pre . "./index.php?id=listado", "perfil" => $pre . "./index.php?id=perfil","aniadir" => $pre . "./index.php?id=aniadir", "carro" => $pre . "./index.php?id=carro", "tienda" => $pre . "./index.php?id=tienda", "indice" => $pre . "./index.php", "login" => $pre . "./index.php?id=login", "logout" => $pre . "./index.php?id=logout", "foro" => $pre . "./index.php?id=foro", 'script' => $pre . "./assets/javascript/script.js", 'bootstrap-script' => $pre . "./assets/javascript/bootstrap.min.js", "buscar" => $pre . "./index.php?id=buscar", "jquery" => $pre . "./assets/jquery/jquery-3.6.4.min.js", "validate" => $pre . "./assets/jquery/jquery.validate.min.js", "validate2" => $pre . "./assets/jquery/additional-methods.min.js", "fontawesome" => $pre . "./assets/fontawesome/css/all.min.css"];
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
    case "tienda_producto": $ruta += ["castellano" => "./tienda_producto.php?idioma=es&id=tienda_producto&tienda=1&producto=".$_GET['producto'], "valenciano" => "./tienda_producto.php?idioma=val&id=tienda_producto&tienda=1&producto=".$_GET['producto']];
        break;
    case "carro": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=carro", "valenciano" => $pre . "./index.php?idioma=val&id=carro"];
        break;
    case "aniadir": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=aniadir", "valenciano" => $pre . "./index.php?idioma=val&id=aniadir"];
        break;
    case "perfil": $ruta += ["castellano" => $pre . "./index.php?idioma=es&id=perfil", "valenciano" => $pre . "./index.php?idioma=val&id=perfil"];
        break;
    default: $ruta += ["castellano" => $pre . "./index.php?idioma=es", "valenciano" => $pre . "./index.php?idioma=val"];
}
