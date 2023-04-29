<div>

    <div id="contenedor-preguntas">

    </div>

    <p class="noPreguntas" style="display:none"></p>
    <!--Ocultar botón sino se esta registrado-->
    <div class="crearPregunta">
        <button onclick="mostrarFormPregunta()"><?= $lang["foro-nuevaPregunta"]; ?></button>
    </div>

    <div class="formPregunta" style="display:none">
        <form action="" method="POST">
            <p>
                <label for="pregunt">Pregunta</label>
                <input type="text" name="pregunt" placeholder="<?= $lang["foro-nuevaPregunta-placeholder"] ?>">
            </p>
            <input type="hidden" name="idUsuario" value="">
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
                            pIn2Pregunta.innerText = item.pregunta;
                            pIn2Pregunta.setAttribute("onclick", `mostrarMensajes(${item.id})`);
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

    function controlError2(err, id) {
        eliminar();
        let errorParrafo = document.createElement("p");
        let divError = document.createElement("div");
        let botonResponder = crearBotonReponder(id);
        divError.classList.add("Norespuestas");
        errorParrafo.innerHTML = err;
        divError.append(errorParrafo, botonResponder);
        $(".Pregunta").eq((id - 1)).append(divError);
    }

    function eliminar() {
        const div = document.querySelector(".Norespuestas");
        if (div) {
            $(".Norespuestas").remove();
        }

        const principalRespuestas = document.querySelector(".PrincipalRespuestas");
        if (principalRespuestas) {
            $(".PrincipalRespuestas").remove();
        }
    }

    mostrarPreguntas();

    function mostrarMensajes(id) {
        console.log(id);
        eliminar();
        const formPregunta = document.querySelector(".formPregunta");

        if (formPregunta) {
            formPregunta.style.display = "none";
        }
        const respuestas = async () => {
            try {
                let idPregunta = new FormData();
                idPregunta.append("id", id);
                const response2 = await fetch('./actions/mostrar_foro_respuestas.php', {method: "POST", body: idPregunta});
                if (response2.status === 200 && response2.ok) {
                    return response2.json();
                } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                    $(".noPreguntas").empty();
                    error.innerText = "<?= $lang['buscar-medicamento-falloServidor']; ?>";
                }
            } catch (error) {
                console.log(error.message);
            }
        };
        respuestas()
                .then(datos => {
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError2(`" . $lang['foro-noRespuestas'] . "`,id);"; ?>
                    } else {
                        console.log(datos);
                        let divPrincipalRespuestas = document.createElement("div");
                        divPrincipalRespuestas.classList.add("PrincipalRespuestas");
                        for (let index = 0; index < datos.length; index++) {
                            let divRespuesta = document.createElement("div");
                            let divUsuario = document.createElement("div");
                            divUsuario.classList.add("Usuario");
                            let pUsuario = document.createElement("p");
                            pUsuario.innerText = datos[index].usuario;
                            divUsuario.appendChild(pUsuario);
                            let divFecha = document.createElement("div");
                            divFecha.classList.add("Fecha");
                            let pFecha = document.createElement("p");
                            pFecha.innerText = datos[index].fecha;
                            divFecha.appendChild(pFecha);
                            let divMensaje = document.createElement("div");
                            divMensaje.classList.add("Mensaje");
                            let pMensaje = document.createElement("p");
                            if (index > 0) {
                                if (datos[index - 1].secundaria !== null) {
                                    let pSecundario = document.createElement("p");
                                    pSecundario.innerText = `"${datos[index - 1].principal}"`;
                                    divMensaje.appendChild(pSecundario);
                                }
                            }
                            pMensaje.innerText = datos[index].principal;
                            divMensaje.appendChild(pMensaje);
                            let hiddenID = document.createElement("input");
                            hiddenID.type = "hidden";
                            hiddenID.value = datos[index].id;
                            hiddenID.name = "respuestaID" + datos[index].id;
                            let hiddenforoID = document.createElement("input");
                            hiddenforoID.type = "hidden";
                            hiddenforoID.value = datos[index].foro;
                            hiddenforoID.name = "foroID" + datos[index].foro;
                            /*Este botón en cada mensaje aparece solo para los usuarios con privilegios*/
                            let responder = document.createElement("button");
                            responder.classList.add("referenciar");
                            responder.setAttribute("onclick", `mostrarFormResponder(${datos[index].id},${datos[index].foro})`);
                            responder.innerText = "<?= $lang['foro-boton-referenciar']; ?>";
                            divRespuesta.append(divUsuario, divFecha, divMensaje, hiddenID, hiddenforoID, responder);
                            divPrincipalRespuestas.appendChild(divRespuesta);
                        }
                        let boton = crearBotonReponder(id);
                        divPrincipalRespuestas.appendChild(boton);
                        $(".Pregunta").eq((id - 1)).after(divPrincipalRespuestas);
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error);
                });
    }

    function crearBotonReponder(id) {
        let botonResponder = document.createElement("button");
        botonResponder.classList.add("responder");
        botonResponder.setAttribute("onclick", `mostrarFormResponder(0,${id})`);
        botonResponder.textContent = "<?= $lang['foro-boton-responder']; ?>";
        let divBotonResponder = document.createElement("div");
        divBotonResponder.appendChild(botonResponder);

        return divBotonResponder;
    }
    function mostrarFormPregunta() {
        eliminar();
        const formPregunta = document.querySelector(".formPregunta");
        formPregunta.style.display = "block";
    }

    function mostrarFormResponder(idRespuesta, idForo) {
        console.log(idRespuesta + " " + idForo);

    }


</script>