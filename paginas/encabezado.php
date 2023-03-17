<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $lang['title']; ?></title>
        <link rel="stylesheet" href="<?= $ruta['css']; ?>"/>
        <script src="<?= $ruta['jquery']; ?>"></script>
        <script src="<?= $ruta['validate']; ?>"></script>
    </head>
    <body>
        <header>
            <div class="head-princiapl">
                <div class="logo titulo">
                    <p><?= $lang['titulo'] ?></p>
                </div>
                <nav class="lista-navegacion">
                    <ul>
                        <li><a href="<?= $ruta['listado']; ?>"><?= $lang['cabecera-listado'] ?></a></li>
                        <li><a href="<?= $ruta['indice']; ?>"><?= $lang['cabecera-inicio'] ?></a></li>
                        <li><a href="<?= $ruta['login']; ?>"><?= $lang['cabecera-login'] ?></a></li>
                        <li><a href="<?= $ruta['login']; ?>">foro</a></li>
                        <li><a href="<?= $ruta['login']; ?>">FAQ</a></li>
                        <li><a href="<?= $ruta['buscar']; ?>"><?= $lang['buscar-medicamento'] ?></a></li>
                    </ul>
                </nav>
                <div class="burguer fa-solid fa-bars">

                </div>                
            </div>
            <div class="idiomas">
                <div>
                    <a href="<?= $ruta['castellano'] ?>">Cas</a>
                    <a href="<?= $ruta['valenciano'] ?>">Val</a>
                </div>
            </div>

        </header>