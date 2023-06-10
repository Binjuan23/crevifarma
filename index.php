<?php
session_start();
include_once "./utiles/configuracion.php";
include_once "./utiles/funciones.php";
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
include_once "./utiles/rutas.php";
include_once "./paginas/encabezado.php";

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
?>
<main>
    <?php
    switch ($id) {
        case "login": include_once "./includes/login.php";
            break;
        case "listado": include_once "./paginas/listado.php";
            break;
        case "buscar": include_once "./paginas/buscar_medicamento.php";
            break;
        case "foro": include_once "./paginas/foro.php";
            break;
        case "tienda": include_once "./paginas/tienda.php";
            break;
        case "carro": include_once "./paginas/carrito.php";
            break;
        case "aniadir": include_once "./paginas/aniadirObjetos.php";
            break;
        case "logout": include_once "./actions/logOut.php";
            break;
        case "perfil": include_once "./paginas/perfil.php";
            break;
        default: include_once "./paginas/inicio.php";
    }
    ?>    

</main>

<?php
include_once "./paginas/pie.php";
?>    

