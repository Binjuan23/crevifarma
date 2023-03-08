<div class="container-login-register">

    <div class="form-login">
        <div class="login-logo">
            <img src="" alt="logoLog">
            <h2><?= $lang['login-identifica']; ?></h2>
        </div>

        <div class="login-texto-form">
            <p><?= $lang['login-avisoAcceso']; ?></p>
        </div>

        <form action="" method="post" id="login-form">

            <div class="input-box">
                <label for="user-login"><?= $lang['usuario']; ?></label>
                <input type="text" name="user-login" id="user-login" placeholder="<?= $lang['usuario']; ?>" required>
            </div>

            <div class="input-box">
                <label for="password-login"><?= $lang['contraseña']; ?></label>
                <input type="password" name="password-login" id="password-login" placeholder="<?= $lang['contraseña']; ?>" required>
            </div>
            <div class="remember-box">
                <label><input type="checkbox" name="remember" id="remember"><?= $lang['login-recordar'] ?></label>
            </div> 
            <input type="submit" value="Entrar" name="login-boton" class="form-boton">

            <div class="login-no-cuenta">
                <p><?= $lang['login-noCuenta']; ?> <a href="#"><?= $lang['login-registrate']; ?></a></p>
            </div>
        </form>

    </div>

    <div class="form-register">
        <div class="login-logo">
            <img src="" alt="logoLog">
            <h2><?= $lang['login-registrate'] ?></h2>
        </div>

        <div class="login-texto-form">
            <p><?= $lang['login-avisoAcceso']; ?></p>
        </div>

        <form action="" method="post" id="register-form">

            <div class="input-box">
                <label for="user-register"><?= $lang['usuario']; ?></label>
                <input type="text" name="user-register" id="user-register" placeholder="<?= $lang['usuario']; ?>" required>
            </div>

            <div class="input-box">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="email" required>
            </div>

            <div class="input-box">
                <label for="password-register"><?= $lang['contraseña']; ?></label>
                <input type="password" name="password-register" id="password-register" placeholder="<?= $lang['contraseña']; ?>">
            </div>   

            <div class="input-box">
                <label for="normal">Normal</label>
                <input type="radio" name="tipo" id="normal">
                <label for="farmacia"><?= $lang['login-farmacia']; ?></label>
                <input type="radio" name="tipo" id="farmacia">
            </div> 

            <div class="input-box">
                <label for="code"><?= $lang['login-codigo']; ?></label>
                <input type="text" name="code" id="code" placeholder="<?= $lang['login-codigo']; ?>" required>
            </div>

            <div class="remember-box">
                <label><input type="checkbox" name="remember2" id="remember2"><?= $lang['login-acuerdo'] ?></label>
            </div> 

            <input type="submit" value="Registrar" name="form-boton">

            <div class="login-no-cuenta">
                <p><?= $lang['login-siCuenta'] ?> <a href="#"><?= $lang['login-identifica']; ?></a></p>
            </div>
        </form>

    </div>
</div>


