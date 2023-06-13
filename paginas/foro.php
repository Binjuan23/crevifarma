<div class="foro">
    <!-- En este contenedor se muestran las preguntas que se hayan registrado en el foro. En el caso de no haber ninguna muestra un mensaje -->
    <div id="contenedor-preguntas">

    </div>

    <p class="noPreguntas" style="display:none"></p>
    <!--Ocultar botón sino se esta registrado-->
    <?php if (isset($_SESSION['usuario'])) { ?>
        <div class="botonPregunta">
            <button onclick="mostrarFormPregunta()"><?= $lang["foro-nuevaPregunta"]; ?></button>
        </div>
    <?php } ?>
    <div class="formPregunta" style="display:none">
        <span class="cerral" onclick="cerrar()" ><i class="fa-solid fa-xmark"></i></span>
        <form action="./actions/guardar_pregunta.php" method="POST" id="crearPregunta">
            <p>
                <label for="pregunt">Pregunta</label>
                <input type="text" name="pregunt" id="pregunt" placeholder="<?= $lang["foro-nuevaPregunta-placeholder"] ?>">
            </p>
            <input type="submit" class="pregunta" name="enviarPregunta" value="Enviar">
        </form>
    </div>

</div>

<script>
//constantes que hacen referencia a elementos de la web para su uso
    const contPre = document.getElementById("contenedor-preguntas");
    const error = document.querySelector(".noPreguntas");
    let formPregunta = document.querySelector(".formPregunta");
    const close = document.querySelector(".cerral");
    let boton = document.querySelector(".botonPregunta");
    //Variable que almacena la petición al servidor con los datos requeridos
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
//Muestras los datos solicitados
    function mostrarPreguntas() {
        preguntas()
                .then(datos => {
                    $("#contenedor-preguntas").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['foro-noPreguntas'] . "`);"; ?>
                    } else {
                        error.style.display = 'none';
                        contPre.style.display = 'flex';
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

    //Controla los posibles errores que puedan surgir al realizar la petición
    function controlError(err) {
        error.style.display = 'block';
        contPre.style.display = 'none';
        error.innerHTML = err;
    }

    mostrarPreguntas();
    //Muestra el formulario para redactar una pregunta
    function mostrarFormPregunta() {
        boton.style.display = "none";
        formPregunta.style.display = "block";
    }
    //Cierra el formulario de las preguntas
    function cerrar() {
        boton.style.display = "block";
        formPregunta.style.display = "none";
    }

    $(document).ready(function () {
        //Utilización de jquery ajax para realizar una petición al servidor
        $("#crearPregunta").submit(function (event) {
            event.preventDefault(); //hace que al pulsar el boton de submit no se ejecute el evento predefinido por el formulario
            let form_data = new FormData();//Crea un forumlario para enviar variables mediante POST al servidor
            form_data.append('pregunta', $("input[name='pregunt']").val());
//Realiza la peticion enviando el formulario con las variables que se quieres recoger en el servidor para tratar la información
            $.ajax({
                type: 'POST',
                url: './actions/guardar_pregunta.php',//dirección archivo con el lenguaje PHP para tratar la información
                data: form_data,//formulario que se envia
                contentType: false,
                processData: false,
                success: function (response) {//respuesta del servidor positiva
                    if (response) {
                        formPregunta.style.display = "none";
                        boton.style.display = "block";
                        error.style.display = "block";
                        error.innerTEXT = '<?= $lang["foro-preAnia"] ?>';
                        setTimeout(() => {
                            error.style.display = "none";
                            error.innerTEXT = '';
                            //location.reload();
                        }, 3000);
                    } else {
                        formPregunta.style.display = "none";
                        boton.style.display = "block";
                        error.style.display = "block";
                        error.innerTEXT = '<?= $lang["foro-preNoAnia"] ?>';
                        setTimeout(() => {
                            error.style.display = "none";
                            error.innerTEXT = '';
                        }, 3000);
                    }
                }
            });




        })
                ;
    });

</script>