<div>
    <div id="contenedorUsuario">

    </div>
    <p class="datosModificados" style="display:none"></p>
    <div id="contenedorModificar">
        <form action="./actions/modificar_user.php" method="post" id="update-form" style="display:none">

            <div class="input-box">
                <label for="user-mod"><?= $lang['usuario']; ?></label>
                <input type="text" name="user-mod" id="user-mod" placeholder="<?= $lang['usuario']; ?>">
            </div>

            <div class="input-box">
                <label for="nombre-mod"><?= $lang['nombre']; ?></label>
                <input type="text" name="nombre-mod" id="nombre-mod" placeholder="<?= $lang['nombre']; ?>">
            </div>

            <div class="input-box">
                <label for="apellidos-mod"><?= $lang['apellidos']; ?></label>
                <input type="text" name="apellidos-mod" id="apellidos-mod" placeholder="<?= $lang['apellidos']; ?>">
            </div>

            <div class="input-box">
                <label for="edad-mod"><?= $lang['edad'] ?></label>
                <input type="number" name="edad-mod" id="edad-mod" step="1" min="18" placeholder="<?= $lang['edad'] ?>">
            </div>

            <div class="input-box">
                <label for="email-mod">Email</label>
                <input type="email" name="email-mod" id="email-mod" placeholder="email">
            </div>

            <div class="input-box">
                <label for="password-mod" title="<?= $lang['login-contraseña-requisitos']; ?>"><?= $lang['contraseña']; ?></label>
                <input type="password" name="password-mod" id="password-mod" placeholder="<?= $lang['contraseña']; ?>">
            </div>  

            <div class="input-box">
                <label for="dinero-mod"><?= $lang['dinero'] ?></label>
                <input type="number" name="dinero-mod" id="dinero-mod" step="any" min="0" max="9999" placeholder="<?= $lang['dinero'] ?>">
            </div>

            <div class="input-box">
                <label for="direccion-mod"><?= $lang['direccion']; ?></label>
                <input type="text" name="direccion-mod" id="direccion-mod" placeholder="<?= $lang['direccion']; ?>">
            </div>

            <div class="input-box para">
                <label for="imagen-mod"><?= $lang['imagen']; ?>(.jpg .jpeg .png .ico .bmp)</label>
                <input type="file" name="imagen-mod" id="imagen-mod">
            </div>

            <input type="submit" id="submit_actualizar" value="Actualizar" name="form-boton">

        </form>
        <button class="mostrarFormMod" onclick="mostrar()">Modificar</button>
    </div>
    <?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "farmacia") { ?>

        <h2><?= $lang['perfil-productos'] ?></h2>
        <table id="contenedorProductos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><?= $lang['nombre']; ?></th>
                    <th><?= $lang['perfil-cantidad']; ?></th>
                    <th>Total</th>
                </tr>
            </thead>

        </table>


    <?php } ?>


    <h2><?= $lang['perfil-pedidos'] ?></h2>
    <table id="contendorPedidos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th><?= $lang['perfil-estado']; ?></th>
                <th></th>
            </tr>
        </thead>

    </table>



    <h2><?= $lang['perfil-reservas'] ?></h2>
    <table id="reservas">
        <thead>
            <tr>
                <th><?= $lang['nombre'] ?></th>
                <th>Fecha</th>
                <th><?= $lang['direccion']; ?></th>
                <th></th>
            </tr>
        </thead>

    </table>

</div>
<script>
    const dat = document.querySelector(".datosModificados");
    const pass = document.getElementById("password-mod");
    const contUsuario = document.getElementById("contenedorUsuario");
    const tPro = document.getElementById("contenedorProductos");
    const contModi = document.getElementById("update-form");
    const butForm = document.querySelector(".mostrarFormMod");
    const tPed = document.getElementById("contendorPedidos");
    const tRes = document.getElementById("reservas");
    let error = document.querySelector(".errorPass");
    let pasa = 0;

<?php if (isset($_SESSION['usuario']) && $_SESSION['tipo'] === "farmacia") { ?>
        const productosComprados = async () => {
            try {
                const response = await fetch('./actions/productos_comprados.php');
                if (response.status === 200 && response.ok) {
                    return response.json();
                } else {
    <?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                    tPro.innerHTML += `<tbody><tr colspan="4"><td><?= $lang['buscar-medicamento-falloServidor']; ?></td></tr></tbody>`;
                }
            } catch (error) {
                console.log(error.message);
            }
        };

        function mostrarProductos() {
            productosComprados()
                    .then(datos => {
                        if (typeof datos !== 'undefined' && !datos) {
                            tPro.innerHTML += `<tbody><tr colspan="4"><td><?= $lang['perfil-NoProductos']; ?></td></tr></tbody>`;
                        } else {
                            let bodi = document.createElement("tbody");
                            datos.map(element => {
                                let linea = document.createElement("tr");
                                for (const propiedad in element) {
                                    if (propiedad === "Farmacia")
                                        continue;
                                    let dato = document.createElement("td");
                                    dato.innerText = (propiedad === "4Total") ? element[propiedad] + "€ " : element[propiedad];
                                    linea.appendChild(dato);
                                }
                                bodi.appendChild(linea);
                            });
                            tPro.appendChild(bodi);


                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
        }
        ;
        mostrarProductos();
<?php } ?>

    const datosUsuario = async () => {
        try {
            const response = await fetch('./actions/mostrar_datos.php');
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                $(".datosModificados").empty();
                dat.innerText = "<?= $lang['buscar-medicamento-falloServidor']; ?>";
                dat.style.display = "block";
            }
        } catch (error) {
            console.log(error.message);
        }
    };

    function mostrarDatos() {
        datosUsuario()
                .then(datos => {
                    $("#contenedorUsuario").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['perfil-noDatos'] . "`);"; ?>
                    } else {
                        dat.style.display = 'none';
                        contUsuario.style.display = 'block';
                        console.log(datos);
                        let divDato1 = document.createElement("div");
                        let imagen = new Image();
                        imagen.src = datos['imagen'];
                        imagen.width = 200;
                        divDato1.appendChild(imagen);
                        for (const propiedad in datos) {
                            if (propiedad === "imagen")
                                continue;
                            let parrafo = document.createElement("p");
                            //parrafo.innerHTML = (propiedad === "91Licencia") ? `<span class='cabeza'>${propiedad.substring(2)}:</span> ${datos[propiedad]}` : (propiedad === "9Dinero") ? `<span class='cabeza'>${propiedad.substring(1)}:</span> ${datos[propiedad]} €` : (datos[propiedad] === "") ? `<span class='cabeza'>${propiedad.substring(1)}:</span> ` : `<span class='cabeza'>${propiedad.substring(1)}:</span> ${datos[propiedad]}`;
                            parrafo.innerHTML = (datos[propiedad] === "" || datos[propiedad] === null) ? `<span class='cabeza'>${propiedad.substring(1)}:</span> ` : (propiedad === "9Dinero") ? `<span class='cabeza'>${propiedad.substring(1)}:</span> ${datos[propiedad]} €` : (propiedad === "91Licencia") ? `<span class='cabeza'>${propiedad.substring(2)}:</span> ${datos[propiedad]}` : `<span class='cabeza'>${propiedad.substring(1)}:</span> ${datos[propiedad]}`;
                            divDato1.appendChild(parrafo);
                        }
                        contUsuario.appendChild(divDato1);
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error);
                });
    }
    ;
    function controlError(err) {
        dat.style.display = 'block';
        contUsuario.style.display = 'none';
        dat.innerHTML = err;
    }

    mostrarDatos();

    const pedidos = async () => {
        try {
            const response = await fetch('./actions/mostrar_pedidos.php');
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                tPed.innerHTML += `<tbody><tr colspan="4"><td class="tdCenter"><?= $lang['buscar-medicamento-falloServidor']; ?></td></tr></tbody>`;
            }
        } catch (error) {
            console.log(error.message);
        }
    };

    function mostrarPedidos() {
        pedidos()
                .then(datos => {
                    if (typeof datos !== 'undefined' && !datos) {
                        tPed.innerHTML += `<tbody><tr colspan="4"><td class="tdCenter"><?= $lang['perfil-noPedidos']; ?></td></tr></tbody>`;
                    } else {
                        console.log(datos);

                        let bodi = document.createElement("tbody");
                        datos.map(element => {
                            let linea = document.createElement("tr");
                            for (const propiedad in element) {
                                if (propiedad === "Farmacia")
                                    continue;
                                let dato = document.createElement("td");
                                dato.innerText = (propiedad === "4Total") ? element[propiedad] + "€ " : element[propiedad];
                                linea.appendChild(dato);
                            }
                            bodi.appendChild(linea);
                        });
                        tPedidos.appendChild(bodi);


                    }
                })
                .catch(error => {
                    console.log(error);
                });
    }
    ;
    mostrarPedidos();

    const reservas = async () => {
        try {
            const response = await fetch('./actions/mostrar_pedidos.php');
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                tRes.innerHTML += `<tbody><tr colspan="4"><td class="tdCenter"><?= $lang['buscar-medicamento-falloServidor']; ?></td></tr></tbody>`;
            }
        } catch (error) {
            console.log(error.message);
        }
    };

    function mostrarReservas() {
        reservas()
                .then(datos => {
                    if (typeof datos !== 'undefined' && !datos) {
                        tRes.innerHTML += `<tbody><tr colspan="4"><td class="tdCenter"><?= $lang['perfil-noReservas']; ?></td></tr></tbody>`;
                    } else {
                        console.log(datos);
                        /*
                         let bodi = document.createElement("tbody");
                         datos.map(element => {
                         let linea = document.createElement("tr");
                         for (const propiedad in element) {
                         if (propiedad === "Farmacia")
                         continue;
                         let dato = document.createElement("td");
                         dato.innerText = (propiedad === "4Total") ? element[propiedad] + "€ " : element[propiedad];
                         linea.appendChild(dato);
                         }
                         bodi.appendChild(linea);
                         });
                         tRes.appendChild(bodi);
                         */

                    }
                })
                .catch(error => {
                    console.log(error);
                });
    }
    ;
    mostrarReservas();

    pass.addEventListener("input", event => {
        const regex = /^(?=(?:.*\d+))(?=(?:.*[a-z]+))(?=(?:.*[A-Z]+))(?=(?:.*\W+))\S{6,}$/;
        let password = event.srcElement.value.trim();
        let valido = regex.test(password);
        if (!valido) {
            $(".errorPass").remove();
            $("#password-mod").parent().append("<span class='errorPass'><?= $lang['registro-contraseña3'] ?></span>");
            if ($("#password-mod").val() == '') {
                $(".errorPass").remove();
                pasa = 0;
            }
        } else {
            $(".errorPass").remove();
            pasa = 1;
        }
    });

    function mostrar() {
        contModi.style.display = "block";
        butForm.style.display = "none";
    }

    $(document).ready(function () {
        $("#update-form").submit(function (event) {
            event.preventDefault();
            let file_data = $('#imagen-mod').prop('files')[0];
            let form_data = new FormData();
            let nom = $("#nombre-mod").val() || 0;
            let ape = $("#apellidos-mod").val() || 0;
            let edad = $("#edad-mod").val() || 0;
            let dire = $("#direccion-mod").val() || 0;
            let dine = $("#dinero-mod").val() || 0;
            let usu = $("#user-mod").val() || 0;
            let pas = $("#password-mod").val() || 0;
            let ema = $("#email-mod").val() || 0;
            form_data.append('imagen', file_data);
            form_data.append('nombre', nom);
            form_data.append('apellidos', ape);
            form_data.append('edad', edad);
            form_data.append('direccion', dire);
            form_data.append('dinero', dine);
            form_data.append('usuario', usu);
            form_data.append('password', pas);
            form_data.append('email', ema);
            form_data.append("si", pasa);
            $.ajax({
                type: 'POST',
                url: './actions/modificar_user.php',
                data: form_data,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response === "true") {
                        $("#update-form").reset;
                        dat.style.display = "block";
                        dat.classList.add("verde");
                        dat.innerText = "<?= $lang['mod-si'] ?>";
                        setTimeout(() => {
                            dat.classList.remove("verde");
                            dat.style.display = "none";
                            dat.innerTEXT = '';
                            location.reload();
                        }, 3000);
                    } else {
                        dat.style.display = "block";
                        dat.classList.add("rojo");
                        dat.innerText = "<?= $lang['mod-no'] ?>";
                        contModi.style.display = "none";
                        butForm.style.display = "block";
                        setTimeout(() => {
                            dat.classList.remove("rojo");
                            dat.style.display = "none";
                            dat.innerTEXT = '';
                        }, 3000);
                    }
                }
            });
        })
                ;
    });
</script>