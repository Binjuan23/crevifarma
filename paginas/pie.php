<!-- Template del footer con etiquetas semánticas -->
<footer>

    <nav>
        <ul class="nav-foot">
            <li><a href="<?= $ruta['buscar']; ?>"><?= $lang['buscar-medicamento'] ?></a></li>
            <li><a href="<?= $ruta['foro']; ?>"><?= $lang['cabecera-foro'] ?></a></li>
            <li><a href="<?= $ruta['indice']; ?>"><img src="<?= $pre ?>./assets/images/LogoPagina.png" alt="Logo" class="foot-logoTitulo-Movil"></a></li>
            <li><a href="<?= $ruta['tienda']; ?>"><?= $lang['cabecera-tienda'] ?></a></li>
            <li><a href="<?= $ruta['carro']; ?>"><?= $lang['cabecera-carro'] ?></a></li>
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
        <a href="<?= $ruta['terminos']?>" target="_blank"><?= $lang['terminos'] ?></a><a href="<?= $ruta['privacidad']?>" target="_blank"><?= $lang['privacidad'] ?></a><a href="<?= $ruta['bases']?>" target="_blank"><?= $lang['bases'] ?></a>
    </nav>


</footer>
<script src="<?= $ruta['script']; ?>"></script> 
</body>

</html>
