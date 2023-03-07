<div class="login-inicio">
    <div class="login-logo">
        <img src="" alt="logoLog">
    </div>

    <div class="login-texto-form">
        <p><?= $lang['login-avisoAcceso']; ?></p>
    </div>
    <form action="" method="post" id="login-form">

        <div class="usu">
            <label for="usuario"><?= $lang['usuario']; ?></label>
            <input type="text" name="usuario" id="usuario" placeholder="<?= $lang['usuario']; ?>" required>
        </div>

        <div class="pass">
            <label for="password"><?= $lang['contraseña']; ?></label>
            <input type="password" name="password" id=password placeholder="<?= $lang['contraseña']; ?>">
        </div>

        <input type="submit" value="Entrar" name="login-entrar">

        <div class="login-no-cuenta">
            <p><?= $lang['login-noCuenta']; ?></p>
            <button><?= $lang['login-registrate']; ?></button>
        </div>
    </form>
</div>


