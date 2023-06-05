<?php
session_start();
include_once "../utiles/configuracion.php";
include_once "../utiles/funciones.php";
$id       = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$pregunta = (isset($_GET['pregunta'])) ? htmlspecialchars($_GET['pregunta']) : "";
include_once "../utiles/rutas.php";
include_once "./encabezado.php";
?>
<main>
    <div>
        <div>
            <p>
                <a href="<?= $ruta['foro']; ?>" ><i class="fa-solid fa-backward"></i><?= $lang['foro-volver']; ?></a>
            </p>
        </div>

        <div id="contenedor-respuestas">

        </div>

        <p class="noRespuestas" style="display:none"></p>
        <!--Ocultar botón sino se esta registrado-->
        <?php if (isset($_SESSION['usuario'])) { ?>
            <div class="crearRespuesta">
                <button onclick="mostrarFormRespuesta(0, 0)"><?= $lang["foro-boton-responder"]; ?></button>
            </div>
        <?php } ?>
        <div class="formRespuesta" style="display:none">

        </div>
        <?php
        if (isset($_GET["respuestaGuardada"])) {

            echo "<p>Respuesta guardada</p>";
        }
        ?>
    </div>
</main>
<script>

    const contRes = document.getElementById("contenedor-respuestas");
    const error = document.querySelector(".noRespuestas");
    const preguntas = async () => {
        try {
            const response = await fetch('../actions/mostrar_foro_respuestas2.php?pregunta=<?= $pregunta; ?>');
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
    function mostrar() {
        preguntas()
                .then(datos => {
                    console.log(datos);
                    $("#contenedor-preguntas").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['foro-noPreguntas'] . "`);"; ?>
                    } else {
                        error.style.display = 'none';
                        contRes.style.display = 'block';
                        let divPregunta = document.createElement("div");
                        divPregunta.classList.add("Pregunta");
                        let divIn1 = document.createElement("div");
                        let pIn1Id = document.createElement("p");
                        pIn1Id.innerText = datos[0].foro;
                        divIn1.appendChild(pIn1Id);
                        let divIn2 = document.createElement("div");
                        let pIn2Pregunta = document.createElement("p");
                        pIn2Pregunta.innerText = datos[0].pregunta;
                        divIn2.appendChild(pIn2Pregunta);
                        let divIn3 = document.createElement("div");
                        let pIn3Fecha = document.createElement("p");
                        pIn3Fecha.innerText = datos[0].fecha;
                        divIn3.append(pIn3Fecha);
                        let divIn4 = document.createElement("div");
                        let pIn4Usuario = document.createElement("p");
                        pIn4Usuario.innerText = datos[0].usuario;
                        divIn4.append(pIn4Usuario);
                        divPregunta.append(divIn1, divIn2, divIn3, divIn4);
                        contRes.appendChild(divPregunta);
                        if (datos.length > 1) {
                            let divRespuestas = document.createElement("div");
                            divRespuestas.classList.add("PreguntaRes");
                            for (let index = 1; index < datos.length; index++) {
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
                                if (datos[index].referencia !== null) {
                                    let referencia = datos[index].referencia;
                                    for (let inde = 1; inde < datos.length; inde++) {
                                        if (datos[inde].idrespuesta === referencia) {
                                            let pDatosReferencia = document.createElement("p");
                                            pDatosReferencia.classList.add("datosReferencia");
                                            pDatosReferencia.innerText = `Ref a ${datos[inde].usuario} el ${datos[inde].fecha}`;
                                            let pSecundario = document.createElement("p");
                                            pSecundario.classList.add("respuestaReferencia")
                                            pSecundario.innerText = `"${datos[inde].respuesta}"`;
                                            divMensaje.append(pDatosReferencia, pSecundario);
                                        }
                                    }
                                }
                                pMensaje.innerText = datos[index].respuesta;
                                divMensaje.appendChild(pMensaje);
                                let hiddenID = document.createElement("input");
                                hiddenID.type = "hidden";
                                hiddenID.value = datos[index].idrespuesta;
                                hiddenID.name = "respuestaID" + datos[index].idrespuesta;
                                let hiddenforoID = document.createElement("input");
                                hiddenforoID.type = "hidden";
                                hiddenforoID.value = datos[index].foroid;
                                hiddenforoID.name = "foroID" + datos[index].foroid;
                                //Este botón en cada mensaje aparece solo para los usuarios con privilegios
<?php if (isset($_SESSION['usuario'])) { ?>
                                    let responder = document.createElement("button");
                                    responder.classList.add("referenciar");
                                    responder.setAttribute("onclick", `mostrarFormRespuesta(${datos[index].idrespuesta}, "${datos[index].respuesta}", "${datos[index].usuario}")`);
                                    responder.innerText = "<?= $lang['foro-boton-referenciar']; ?>";
<?php } ?>
                                divRespuesta.append(divUsuario, divFecha, divMensaje, hiddenID, hiddenforoID<?php if (isset($_SESSION['usuario'])) { ?>, responder<?php } ?>);
                                divRespuestas.appendChild(divRespuesta);
                            }
                            contRes.appendChild(divRespuestas);
                        } else {
                            controlError2();
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
        contRes.style.display = 'none';
        error.innerHTML = err;
    }

    mostrar();

    function controlError2() {
        let errorParrafo = document.createElement("p");
        let divError = document.createElement("div");
        divError.classList.add("Norespuestas");
        errorParrafo.innerText = "<?= $lang['foro-noRespuestas'] ?>";
        contRes.appendChild(errorParrafo);
    }

    function mostrarFormRespuesta(idMensaje, mensaje, usuario) {
        const formRespuesta = document.querySelector(".formRespuesta");
        const crear = document.querySelector(".crearRespuesta");
        $(".formRespuesta").empty();
        crearFormRespuesta(idMensaje, mensaje, usuario);
        formRespuesta.style.display = "block";
        crear.style.display = "none";
    }

    function salirForm() {
        const formRespuesta = document.querySelector(".formRespuesta");
        const crear = document.querySelector(".crearRespuesta");
        $(".formRespuesta").empty();
        formRespuesta.style.display = "none";
        crear.style.display = "block";
    }

    function crearFormRespuesta(idMensaje, mensaje, usuario) {
        const formRespuesta = document.querySelector(".formRespuesta");
        let etiquetaForm = document.createElement("form");
        etiquetaForm.action = "../actions/guardar_respuesta.php?pregunta=<?= $_GET['pregunta'] . "&idioma=" . $idioma; ?>";
        etiquetaForm.method = "POST";
        let etiquetaP = document.createElement("p");
        let etiquetaLabel = document.createElement("label");
        etiquetaLabel.setAttribute("for", "respuesta");
        etiquetaLabel.innerText = "<?= $lang["foro-respuesta"] ?>";
        let etiquetaTextArea = document.createElement("textarea");
        etiquetaTextArea.name = "respuesta";
        etiquetaTextArea.id = "respuesta";
        etiquetaTextArea.setAttribute("maxlength", 500);
        etiquetaTextArea.placeholder = "<?= $lang['foro-respuesta-placeholder'] ?>";
        etiquetaP.append(etiquetaLabel, etiquetaTextArea);
        let etiquetaInput = document.createElement("input");
        etiquetaInput.type = "hidden";
        etiquetaInput.name = "idUsuario";
        etiquetaInput.value = 1;//HAY QUE PONER AQUI EL ID GUARDADO AL LOGUEARSE
        let etiquetaInput2 = document.createElement("input");
        let etiquetaP2 = document.createElement("p");
        if (idMensaje !== 0) {
            etiquetaInput2.type = "hidden";
            etiquetaInput2.name = "idMensaje";
            etiquetaInput2.id = "idMensaje";
            etiquetaInput2.value = idMensaje;
            etiquetaP2.innerHTML = "<span><?= $lang["foro-form-referencia"] ?> " + usuario + "</span>: <span>\"" + mensaje + "\"</span>";
            etiquetaForm.append(etiquetaInput2, etiquetaP2);
        }
        let etiquetaInput3 = document.createElement("input");
        etiquetaInput3.type = "submit";
        etiquetaInput3.name = "enviarRespuesta";
        etiquetaInput3.value = "Enviar";
        let etiquetaButton = document.createElement("button");
        etiquetaButton.setAttribute("onclick", "salirForm()");
        etiquetaButton.innerText = "<?= $lang["foro-respuesta-cancelar"] ?>";
        etiquetaForm.append(etiquetaP, etiquetaInput, etiquetaInput3);
        formRespuesta.append(etiquetaForm, etiquetaButton);
    }

</script>
<?php
include_once "../paginas/pie.php";
?>    