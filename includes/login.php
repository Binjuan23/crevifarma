<!-- Contiene la estructura de los formularios de login y registro -->
<div class="container-login-register">
    <div class="wrapper">
        <div class="form-login">
            <div class="login-logo">
                <img src="./assets/images/Crevi-IN.gif" >
                <h2 id="indentifica"><?= $lang['login-identifica']; ?></h2>
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
                <input type="submit" value="Entrar" name="login-boton" class="form-boton">

                <div class="login-no-cuenta">
                    <p><?= $lang['login-noCuenta']; ?> <a href="#" class="login-link"><?= $lang['login-registrate']; ?></a></p>
                </div>
            </form>

        </div>



        <div class="form-register">
            <div class="login-logo">

                <img src="./assets/images/Crevi-OUT.gif" >
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

                <input type="submit" id="submit_registro" value="Registrar" name="form-boton" class="form-boton">

                <div class="login-no-cuenta">
                    <p><?= $lang['login-siCuenta'] ?> <a href="#" class="register-link"><?= $lang['login-identifica']; ?></a></p>
                </div>
            </form>

        </div>
    </div>
    <!-- Mensajes de validación -->
    <p class="regiSi rojo" style="display:none"><?= $lang['regiSi'] ?></p>
    <p class="loginNo rojo" style="display:none"><?= $lang['login-fallo'] ?></p>
    <p class="acceso rojo" style="display:none"><?= $lang['acceso'] ?></p>
</div>

<script>
    //Variables usadas
    let noLogin = document.querySelector(".loginNo");
    let acces = document.querySelector(".acceso");
    let registro = document.querySelector(".regiSi");
    //Mensaje de validación
<?php
if (isset($_GET['aviso']) && $_GET['aviso']) {
    ?>
        acces.style.display = "block";
        setTimeout(() => {
            acces.style.display = "none";
        }, 3000);
    <?php
}
?>


    $(document).ready(function () {
//Muestra oculta campos según la opción elegida
        $("input[type=radio]").click(function () {
            const radio = $(this).val();
            if (radio === "farmacia") {
                $(".input-box.cod").show();
            } else {
                $(".input-box.cod").hide();
            }
        });
//Estructura de validación usando jquery validate
        $('#register-form').validate({
            focusCleanup: true,
            errorPlacement: function (error, element) {//Posiciona el mensaje
                error.appendTo(element.parent());
            },
            rules: {//reglas de validacion de cada campo
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
            messages: {//mensajes que se muestras según la validación
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
            if ($formLogin.valid()) {//Comprueba que la validación es correcta o no
                $.ajax({
                    type: 'POST',
                    url: './actions/comprobar_email_login.php',
                    data: {register1: $formLogin.serialize()},//tranforma los datos del formulario en una string que se enviará al servidor
                    success: function (response) {
                        if (response === "true") {
                            location.href = './index.php?id=inicio';
                        } else {
                            noLogin.style.display = "block";
                            setTimeout(() => {
                                noLogin.style.display = "none";
                            }, 3000);
                        }

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
                wrapper.classList.remove("valre");
                $.ajax({
                    type: 'POST',
                    url: './actions/registrar_user.php',
                    data: {register: $formRegister.serialize()},
                    success: function (response) {
                        if (response === "true") {
                            registro.style.display = "block";
                            setTimeout(() => {
                                registro.style.display = "none";
                                location.reload();
                            }, 3000);
                        } else {
                            console.log("No se ha podido registrar");
                        }
                    }
                });
            } else {
                wrapper.classList.add("valre");
                console.log("Faltan campos");
            }


        });
    });

</script>
