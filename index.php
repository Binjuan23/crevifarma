<?php
session_start();
include_once "./utiles/funciones.php";
include_once "./utiles/configuracion.php";
$id       = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
include_once "./utiles/rutas.php";
include_once "./paginas/encabezado.php";
?>
<main>
    <?php
    switch ($id) {
        case "login": include_once "./includes/login.php";
            break;
        case "listado": include_once "./paginas/listado.php";
            break;
        default: include_once "./paginas/inicio.php";
    }
    ?>    
</main>
<?php
include_once "./paginas/pie.php";
?>    

