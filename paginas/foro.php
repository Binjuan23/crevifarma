<div>

    <div id="contenedor-preguntas">

    </div>   

    <p class="noPreguntas" style="display:none"></p>

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
                            divIn2.appendChild(pIn2Pregunta);
                            let divIn3 = document.createElement("div");
                            let pIn3Fecha = document.createElement("p");
                            pIn3Fecha.innerText = item.fechaPre;
                            divIn3.append(pIn3Fecha);
                            divPrincipal.append(divIn1, divIn2, divIn3);
                            contPre.appendChild(divPrincipal);
                        });
                        const preguntas = document.querySelector(".Pregunta");
                        if (preguntas) {
                            preguntas.addEventListener("click", mostrarMensajes);
                        }
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
    function mostrarMensajes() {

        let id = $(this).children().eq(0).children().eq(0).text();
        const respuestas = async () => {
            try {
                let idPregunta = new FormData();
                idPregunta.append("id", id);
                const response = await fetch('./actions/mostrar_foro_respuestas.php', {method: "POST", body: idPregunta});
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
        respuestas()
                .then(datos => {
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['foro-noPreguntas'] . "`);"; ?>
                    } else {
                        console.log(datos);
                        $("#contenedor-preguntas div:odd").remove();
                        let divPrincipalrespuestas = document.createElement("div");
                        for (let index = 0; index < datos.length; index++) {
                            let divRespuesta = document.createElement("div");
                            let divUsuario = document.createElement("div");
                            let pUsuario = document.createElement("p");
                            pUsuario.innerText = datos[index].usuario;
                            divUsuario.appendChild(pUsuario);
                            let divFecha = document.createElement("div");
                            let pFecha = document.createElement("p");
                            pFecha.innerText = datos[index].fecha;
                            divFecha.appendChild(pFecha);
                            let divMensaje = document.createElement("div");
                            let pMensaje = document.createElement("p");
                            if (index > 0) {
                                if (datos[index - 1].secundaria !== null) {
                                    let pSecundario = document.createElement("p");
                                    pSecundario.innerText = datos[index - 1].principal;
                                    divMensaje.appendChild(pSecundario);
                                }
                            }
                            pMensaje.innerText = datos[index].principal;
                            divMensaje.appendChild(pMensaje);
                            divRespuesta.append(divUsuario, divFecha, divMensaje);
                            divPrincipalrespuestas.appendChild(divRespuesta);
                        }
                        /*
                         datos.map((item, index) => {
                         let divRespuesta = document.createElement("div");
                         let divUsuario = document.createElement("div");
                         let pUsuario = document.createElement("p");
                         pUsuario.innerText = item.usuario;
                         divUsuario.appendChild(pUsuario);
                         let divFecha = document.createElement("div");
                         let pFecha = document.createElement("p");
                         pFecha.innerText = item.fecha;
                         divFecha.appendChild(pFecha);
                         let divMensaje = document.createElement("div");
                         let pMensaje = document.createElement("p");
                         console.log(datos[2].secundaria);
                         if (index !== 0) {
                         if (datos[--index].secundario !== null) {
                         let pSecundario = document.createElement("p");
                         console.log(datos[index].secundaria);
                         pSecundario.innerText = '"' + datos[index].secundaria + '"';
                         pMensaje.appendChild(pSecundario);
                         }
                         }
                         pMensaje.innerText = item.principal;
                         divMensaje.appendChild(pMensaje);
                         divRespuesta.append(divUsuario, divFecha, divMensaje);
                         divPrincipalrespuestas.appendChild(divRespuesta);
                         });
                         */
                        $(this).after(divPrincipalrespuestas);
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error);
                });
    }



</script>