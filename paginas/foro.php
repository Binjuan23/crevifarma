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
                            let pIn3Fecha1 = document.createElement("p");
                            let pIn3Fecha2 = document.createElement("p");
                            let splitFecha = item.fechaPre.split(" ");
                            pIn3Fecha1.innerText = splitFecha[0];
                            pIn3Fecha2.innerText = splitFecha[1];
                            divIn3.append(pIn3Fecha1, pIn3Fecha2);
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
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error);
                });
    }
    ;
        
    

</script>