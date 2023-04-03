<?php
session_start();
include_once "./utiles/configuracion.php";
include_once "./utiles/funciones.php";
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
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
        case "buscar": include_once "./paginas/buscar_medicamento.php";
            break;
        case "foro": include_once "./paginas/foro.php";
            break;
        default: include_once "./paginas/inicio.php";
    }
    ?>    
</main>
<?php
include_once "./paginas/pie.php";
?>    

