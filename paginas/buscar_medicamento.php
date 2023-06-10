<div class="medicamento">

    <h1><?= $lang['buscar-medicamento-h1']; ?></h1>

    <p class="reserva" style="display:none"></p>
    <div class="buscador-medicamentos">
        <input type="search" id="busca-med" name="busca-med" placeholder="<?= $lang['buscar-medicamento-nombre']; ?>">        
    </div>

    <div class="error-medicamento" style="display:none">
        <p></p>
    </div>

    <div class="resultados-busqueda"></div>    

</div>

<script>

    const resultadoBusqueda = document.querySelector(".resultados-busqueda");
    const error = document.querySelector(".error-medicamento");
    const busca_med = document.querySelector("#busca-med");
    const reserva = document.querySelector(".reserva");
    let medicamento = '';
    //Controlo que exista el elemento, coloco un evento para cuando se escribe e invoco la función para mostrar resultados
    if (busca_med) {
        busca_med.addEventListener("input", event => {
            medicamento = event.srcElement.value.toUpperCase().trim();
            $(".resultados-busqueda").empty();
            if (medicamento !== '') {
                mostrarResultados();
            }
        });
    }
    //Busca en la bbdd segun lo escrito en el campo de busqueda
    const busquedaMed = async () => {
        try {
            let buscaMedData = new FormData();
            buscaMedData.append("medicamento", medicamento);
            const response = await fetch('./actions/buscar_med.php', {method: "POST", body: buscaMedData});
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "')"; ?>
            }
        } catch (error) {
            console.log(error.message);
        }
    };
    //Muestro los resultados según el criterio de busqueda
    function mostrarResultados() {
        busquedaMed()
                .then(datos => {
                    $(".resultados-busqueda").empty();
                    if (typeof datos.data !== 'undefined' && !datos.data) {
<?php echo "controlError(`" . $lang['buscar-medicamento-noEsta'] . " <span class='rojo'>\${medicamento}</span>`)"; ?>
                    } else {
                        console.log(datos);
                        error.style.display = 'none';
                        resultadoBusqueda.style.display = 'flex';
                        datos.map(item => {
                            let div = document.createElement("div");
                            let picture = document.createElement("picture");
                            let source1 = document.createElement("source");
                            source1.srcset = item.imagen;
                            source1.media = "(min-width: 992px)";
                            picture.appendChild(source1);
                            let source2 = document.createElement("source");
                            source2.srcset = item.imagen;
                            source2.media = "(min-width: 768px)";
                            picture.appendChild(source2);
                            let source3 = document.createElement("source");
                            source3.srcset = item.imagen;
                            source3.media = "(min-width: 576px)";
                            picture.appendChild(source3);
                            let imagenDef = document.createElement("img");
                            imagenDef.src = item.imagen;
<?php echo "imagenDef.alt = '" . $lang['buscar-medicamento-imagenDef'] . "'; " ?>
                            picture.appendChild(imagenDef);
                            div.appendChild(picture);
                            let parrafo1 = document.createElement("p");
                            parrafo1.innerHTML = item.medicamento.toUpperCase().replace(medicamento, '<span class="rojo">$&</i>');
                            div.appendChild(parrafo1);
                            let parrafo2 = document.createElement("p");
<?php echo "parrafo2.innerText =\"" . $lang['direccion'] . ": \"+item.direccion;" ?>
                            div.appendChild(parrafo2);
                            let parrafo3 = document.createElement("p");
<?php echo "parrafo3.innerText =\"" . $lang['email'] . ": \"+item.email;" ?>
                            div.appendChild(parrafo3);
<?php if (isset($_SESSION['usuario'])) { ?>
                                let botonReserva = document.createElement("button");
                                botonReserva.setAttribute("onclick", `reservar(${item.idmed})`);
                                botonReserva.innerText = "Reservar";
                                div.appendChild(botonReserva);
<?php } ?>
                            resultadoBusqueda.appendChild(div);
                        });
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error);
                });
    }
    ;
    function reservar(id) {
        try {
            let nuevoItem = new FormData();
            nuevoItem.append("id", id);
            fetch('./actions/hacer_reserva.php', {method: "POST", body: nuevoItem})
                    .then(datos => {
                        return datos.json();
                    })
                    .then(datos => {
                        if (datos === true) {
                            reserva.style.display = "block";
                            reserva.classList.add("verde");
                            reserva.innerText = "<?= $lang['reserva-si'] ?>";
                            setTimeout(() => {
                                reserva.classList.remove("verde");
                                reserva.style.display = "none";
                                reserva.innerTEXT = '';
                            }, 3000);
                        } else if (datos === true) {
                            reserva.style.display = "block";
                            reserva.classList.add("rojo");
                            reserva.innerText = "<?= $lang['reserva-no'] ?>";
                            setTimeout(() => {
                                reserva.classList.remove("rojo");
                                reserva.style.display = "none";
                                reserva.innerTEXT = '';
                            }, 3000);
                        } else {
                            reserva.style.display = "block";
                            reserva.classList.add("rojo");
                            reserva.innerText = "<?= $lang['reserva-ya'] ?>";
                            setTimeout(() => {
                                reserva.classList.remove("rojo");
                                reserva.style.display = "none";
                                reserva.innerTEXT = '';
                            }, 3000);
                        }
                    });
        } catch (error) {
            console.log(error.message);
        }
    }

    function controlError(err) {
        error.style.display = 'block';
        resultadoBusqueda.style.display = 'none';
        error.querySelector("p").innerHTML = err;
    }
</script>