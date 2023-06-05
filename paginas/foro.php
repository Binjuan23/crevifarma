<div>

    <div id="contenedor-preguntas">

    </div>

    <p class="noPreguntas" style="display:none"></p>
    <!--Ocultar botón sino se esta registrado-->
    <?php if (isset($_SESSION['usuario'])) { ?>
        <div class="crearPregunta">
            <button onclick="mostrarFormPregunta()"><?= $lang["foro-nuevaPregunta"]; ?></button>
        </div>
    <?php } ?>
    <div class="formPregunta" style="display:none">
        <form action="" method="POST">
            <p>
                <label for="pregunt">Pregunta</label>
                <input type="text" name="pregunt" placeholder="<?= $lang["foro-nuevaPregunta-placeholder"] ?>">
            </p>
            <input type="hidden" name="idUsuario" value="<?php
            if (isset($_SESSION['usuario'])) {
                echo $_SESSION['id'];
            }
            ?>">
            <input type="submit" name="enviarPregunta" value="Enviar">
        </form>
    </div>

</div>

<script>

    const contPre = document.getElementById("contenedor-preguntas");
    const error = document.querySelector(".noPreguntas");
    const preguntas = async () => {
        try {
            const response = await fetch('./actions/mostrar_foro.php');
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                $(".noPreguntas").empty();
                error.innerText = "<?= $lang['buscar-medicamento-falloServidor']; ?>";
            }
        } catch (error) {
            console.log(error.message);
        }
    };

    function mostrarPreguntas() {
        preguntas()
                .then(datos => {
                    $("#contenedor-preguntas").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['foro-noPreguntas'] . "`);"; ?>
                    } else {
                        error.style.display = 'none';
                        contPre.style.display = 'block';
                        datos.map(item => {
                            let divPrincipal = document.createElement("div");
                            divPrincipal.classList.add("Pregunta");
                            let divIn1 = document.createElement("div");
                            let pIn1Id = document.createElement("p");
                            pIn1Id.innerText = item.id;
                            divIn1.appendChild(pIn1Id);
                            let divIn2 = document.createElement("div");
                            let pIn2Pregunta = document.createElement("p");
                            let aIn = document.createElement("a");
                            aIn.href = "./paginas/foro_respuestas.php?id=foro_respuestas&pregunta=" + item.id;
                            aIn.innerText = item.pregunta;
                            //pIn2Pregunta.setAttribute("onclick", `mostrarMensajes(${item.id})`);
                            pIn2Pregunta.appendChild(aIn);
                            divIn2.appendChild(pIn2Pregunta);
                            let divIn3 = document.createElement("div");
                            let pIn3Fecha = document.createElement("p");
                            pIn3Fecha.innerText = item.fechaPre;
                            divIn3.append(pIn3Fecha);
                            let divIn4 = document.createElement("div");
                            let pIn4Usuario = document.createElement("p");
                            pIn4Usuario.innerText = item.usuario;
                            divIn4.append(pIn4Usuario);
                            let divIn5 = document.createElement("div");
                            let pIn5Cantidad = document.createElement("p");
                            pIn5Cantidad.innerText = "<?= $lang['foro-respuestas-cantidad']; ?>: " + item.numRespuestas;
                            divIn5.append(pIn5Cantidad);
                            divPrincipal.append(divIn1, divIn2, divIn3, divIn4, divIn5);
                            contPre.appendChild(divPrincipal);
                        });
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error);
                });
    }
    ;
    function controlError(err) {
        error.style.display = 'block';
        contPre.style.display = 'none';
        error.innerHTML = err;
    }

    mostrarPreguntas();

</script>