<html>
    <head>        
        <meta charset="UTF-8">        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <title><?= $lang['title']; ?></title>
        <link rel="stylesheet" href="<?= $ruta['bootstrap-css']; ?>"/>
        <link rel="stylesheet" href="<?= $ruta['css']; ?>"/>
        <link rel="stylesheet" href="<?= $ruta['fontawesome']; ?>"/>
        <script src="<?= $ruta['bootstrap-script']; ?>"></script>
        <script src="<?= $ruta['jquery']; ?>"></script>        
        <script src="<?= $ruta['validate']; ?>"></script>
        <script src="<?= $ruta['validate2']; ?>"></script>
    </head>
    <body>
        <header>
            <div class="head-principal">
                <img src="<?= $pre?>./assets/images/LogoPagina.png" alt="Logo" class="logoTitulo-Movil">
                <img src="<?= $pre?>./assets/images/Logo.png" alt="Logo" class="logoTitulo-Pc" style="display:none">
                <nav class="lista-navegacion" style="display:none">
                    <ul>
                        <li><a href="<?= $ruta['indice']; ?>"><?= $lang['cabecera-inicio'] ?></a></li>
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] !== "admin") { ?>
                            <li><a href="<?= $ruta['perfil']; ?>">Perfil</a></li>
                        <?php } ?>
                        <li><a href="<?= $ruta['buscar']; ?>"><?= $lang['buscar-medicamento'] ?></a></li>

                        <li><a href="<?= $ruta['foro']; ?>"><?= $lang['cabecera-foro'] ?></a></li>
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "farmacia") { ?>
                            <li><a href="<?= $ruta['aniadir']; ?>"><?= $lang['cabecera-aniadir'] ?></a></li>
                        <?php } ?>
                        <li><a href="<?= $ruta['tienda']; ?>"><?= $lang['cabecera-tienda'] ?></a></li>
                        <li><a href="<?= $ruta['carro']; ?>"><?= $lang['cabecera-carro'] ?></a></li>
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "admin") { ?>
                            <li><a href="<?= $ruta['listado']; ?>"><?= $lang['cabecera-listado'] ?></a></li>
                        <?php } ?>
                        <li><a href="<?= $ruta['login']; ?>"><?= $lang['cabecera-login'] ?></a></li>
                        <?php if (isset($_SESSION['usuario'])) { ?>
                            <li><a href="<?= $ruta['logout']; ?>"><?= $lang['cabecera-logout'] ?></a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <div class="burguer fa-solid fa-bars">

                </div>                
            </div>
            <div class="idiomas">
                <a href="<?= $ruta['castellano'] ?>">Cas</a>
                <a href="<?= $ruta['valenciano'] ?>">Val</a>
            </div>
            <div class="navMovil" style="display:none">
                <ul>
                    <li><a href="<?= $ruta['indice']; ?>"><?= $lang['cabecera-inicio'] ?></a></li>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] !== "admin") { ?>
                        <li><a href="<?= $ruta['perfil']; ?>">Perfil</a></li>
                    <?php } ?>
                    <li><a href="<?= $ruta['buscar']; ?>"><?= $lang['buscar-medicamento'] ?></a></li>
                    <li><a href="<?= $ruta['foro']; ?>"><?= $lang['cabecera-foro'] ?></a></li>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "farmacia") { ?>
                        <li><a href="<?= $ruta['aniadir']; ?>"><?= $lang['cabecera-aniadir'] ?></a></li>
                    <?php } ?>
                    <li><a href="<?= $ruta['tienda']; ?>"><?= $lang['cabecera-tienda'] ?></a></li>
                    <li><a href="<?= $ruta['carro']; ?>"><?= $lang['cabecera-carro'] ?></a></li>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "admin") { ?>
                        <li><a href="<?= $ruta['listado']; ?>"><?= $lang['cabecera-listado'] ?></a></li>
                    <?php } ?>
                    <?php if (!isset($_SESSION['usuario'])) { ?>
                        <li><a href="<?= $ruta['login']; ?>"><?= $lang['cabecera-login'] ?></a></li>
                    <?php } else { ?>
                        <li><a href="<?= $ruta['logout']; ?>"><?= $lang['cabecera-logout'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>

        </header>
        