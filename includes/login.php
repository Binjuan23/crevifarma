<div class="container-login-register">

    <div class="form-login">
        <div class="login-logo">
            <img src="" alt="logoLog">
            <h2><?= $lang['login-identifica']; ?></h2>
        </div>

        <div class="login-texto-form" style="display:none">
            <p><?= $lang['login-avisoAcceso']; ?></p>
        </div>

        <form action="./actions/comprobar_email_login.php" method="post" id="login-form">

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

        <div class="login-texto-form" style="display:none">
            <p><?= $lang['login-avisoAcceso']; ?></p>
        </div>

        <form action="./actions/registrar_user.php" method="post" id="register-form">

            <div class="input-box">
                <label for="user-register"><?= $lang['usuario']; ?></label>
                <input type="text" name="user-register" id="user-register" placeholder="<?= $lang['usuario']; ?>" required>
            </div>

            <div class="input-box">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="email" required>
            </div>

            <div class="input-box">
                <label for="password-register" title="<?= $lang['login-contraseña-requisitos']; ?>"><?= $lang['contraseña']; ?></label>
                <input type="password" name="password-register" id="password-register" placeholder="<?= $lang['contraseña']; ?>" required>
            </div>  

            <div class="input-box">
                <label for="password-register2"><?= $lang['login-contraseña']; ?></label>
                <input type="password" name="password-register2" id="password-register2" placeholder="<?= $lang['login-contraseña']; ?>" required>
            </div>   

            <div class="input-box">
                <label for="normal">Normal</label>
                <input type="radio" name="tipo" id="normal" value='normal' required>
                <label for="farmacia"><?= $lang['login-farmacia']; ?></label>
                <input type="radio" name="tipo" id="farmacia" value='farmacia' required>
            </div> 

            <div class="input-box cod" style="display:none">
                <label for="code"><?= $lang['login-codigo']; ?></label>
                <input type="text" name="code" id="code" placeholder="<?= $lang['login-codigo']; ?>" required>
            </div>

            <div class="remember-box">
                <input type="checkbox" name="remember2" id="remember2">
                <label for="remember2"><?= $lang['login-acuerdo'] ?></label>                
            </div> 

            <input type="submit" id="submit_registro" value="Registrar" name="form-boton">

            <div class="login-no-cuenta">
                <p><?= $lang['login-siCuenta'] ?> <a href="#"><?= $lang['login-identifica']; ?></a></p>
            </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function () {

        $("input[type=radio]").click(function () {
            const radio = $(this).val();
            if (radio === "farmacia") {
                $(".input-box.cod").show();
            } else {
                $(".input-box.cod").hide();
            }
        });

        $('#register-form').validate({
            focusCleanup: true,
            errorPlacement: function (error, element) {
                error.appendTo(element.parent());
            },
            rules: {
                "user-register": {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: "./actions/comprobar_email_login.php"
                },
                "password-register": {
                    required: true,
                    minlength: 6,
                    pattern: /^(?=(?:.*\d+))(?=(?:.*[a-z]+))(?=(?:.*[A-Z]+))(?=(?:.*\W+))\S{6,}$/,
                    remote: "./actions/comprobar_email_login.php"
                },
                "password-register2": {
                    required: true,
                    equalTo: "#password-register"
                },
                remember2: {
                    required: true
                },
                tipo: {
                    required: true
                },
                code: {
                    required: true,
                    remote: "./actions/comprobar_licencia.php"
                }
            },
            messages: {
                "user-register": '<?= $lang['registro-user']; ?>',
                email: {
                    required: '<?= $lang['registro-email']; ?>',
                    email: '<?= $lang['registro-email2']; ?>',
                    remote: "<?= $lang['registro-email3']; ?>"
                },
                "password-register": {
                    required: '<?= $lang['registro-contraseña']; ?>',
                    minlength: '<?= $lang['registro-contraseña2']; ?>',
                    pattern: '<?= $lang['registro-contraseña3']; ?>',
                    remote: '<?= $lang['registro-contraseña4']; ?>'
                },
                "password-register2": {
                    required: '<?= $lang['registro-repite']; ?>',
                    equalTo: '<?= $lang['registro-repite2']; ?>'
                },
                tipo: "<?= $lang['registro-tipo']; ?>",
                code: {
                    required: '<?= $lang['registro-codigo']; ?>',
                    remote: '<?= $lang['registro-codigo2']; ?>'
                },
                remember2: '<?= $lang['registro-politica']; ?>'
            }
        });

        $('#login-form').validate({
            focusCleanup: true,
            errorPlacement: function (error, element) {
                error.appendTo(element.parent());
            },
            rules: {
                "user-login": {
                    required: true
                },
                "password-login": {
                    required: true
                }
            },
            messages: {
                "user-login": '<?= $lang['user-login']; ?>',
                "password-login": '<?= $lang["password-login"]; ?>'
            }
        });

        $('#login-form').submit(function (event) {
            event.preventDefault();

            let $formLogin = $("#login-form");
            if ($formLogin.valid()) {
                $.ajax({
                    type: 'POST',
                    url: './actions/comprobar_email_login.php',
                    data: {register1: $formLogin.serialize()},
                    success: function (response) {
                        console.log(response);                        
                        location.href = './index.php?id=inicio';
                    }
                });
            } else {
                console.log("Faltan campos");
            }

        });
        $('#register-form').submit(function (event) {
            event.preventDefault();
            let $formRegister = $('#register-form');

            if ($formRegister.valid()) {
                $.ajax({
                    type: 'POST',
                    url: './actions/registrar_user.php',
                    data: {register: $formRegister.serialize()},
                    success: function (response) {
                        console.log(response);
                    }
                });
            } else {
                console.log("Faltan campos");
            }


        });
    });

</script>
