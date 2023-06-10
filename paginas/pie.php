
<footer>

    <nav>
        <ul class="nav-foot">            
            <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] !== "admin") { ?>
                <li><a href="<?= $ruta['perfil']; ?>">Perfil</a></li>
            <?php } ?>
            <li><a href="<?= $ruta['buscar']; ?>"><?= $lang['buscar-medicamento'] ?></a></li>

            <li><a href="<?= $ruta['foro']; ?>"><?= $lang['cabecera-foro'] ?></a></li>
            <li><a href="<?= $ruta['indice']; ?>"><img src="./assets/images/LogoPagina.png" alt="Logo" class="logoTitulo-Movil"></a></li>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "farmacia") { ?>
                <li><a href="<?= $ruta['aniadir']; ?>"><?= $lang['cabecera-aniadir'] ?></a></li>
            <?php } ?>
            <li><a href="<?= $ruta['tienda']; ?>"><?= $lang['cabecera-tienda'] ?></a></li>
            <li><a href="<?= $ruta['carro']; ?>"><?= $lang['cabecera-carro'] ?></a></li>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "admin") { ?>
                <li><a href="<?= $ruta['listado']; ?>"><?= $lang['cabecera-listado'] ?></a></li>
            <?php } ?>
        </ul>
    </nav>
    <nav>
        <ul class="nav-icon">
            <li><a href="https://es-es.facebook.com/"><i class="fa-brands fa-square-facebook"></i></a></li>
            <li><a href="https://www.instagram.com/"><i class="fa-brands fa-square-instagram"></i></a></li>
            <li><a href="https://twitter.com/?lang=es"><i class="fa-brands fa-square-twitter"></i></a></li>
        </ul>
    </nav>

    <nav class="politica">
        <a href="./paginas/terminos.html" target="_blank"><?= $lang['terminos'] ?></a><a href="./paginas/privacidad.html" target="_blank"><?= $lang['privacidad'] ?></a><a href="./paginas/bases.html" target="_blank"><?= $lang['bases'] ?></a>
    </nav>


</footer>
<script src="<?= $ruta['script']; ?>"></script> 
</body>

</html>
