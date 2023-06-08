<div>

    <div id="contenedor-carrito">

    </div>

    <p class="noObjetos" style="display:none"></p>

    <?php if (isset($_SESSION['usuario'])) { ?>
        <div>
            <button onclick="comprar()">Comprar</button>
        </div>
    <?php } else if (isset($_SESSION['carro']) && count($_SESSION['carro']) >= 1) { ?>
        <div>
            <p><?= $lang["carro-registro"] ?></p>
        </div>
    <?php } ?>
    <div>
        <button onclick="vaciar(0, 0)"><?= $lang['carro-vaciar']; ?></button>
    </div>

    <p class="gracias" style="display:none"><?= $lang["carro-gracias"]; ?></p>
    <p class="loSiento" style="display:none"><?= $lang["carro-siento"]; ?></p>
    <p class="noFondos" style="display:none"><?= $lang['carro-fondos']; ?></p>
</div>

<script>
    const contCarro = document.getElementById("contenedor-carrito");
    const error = document.querySelector(".noObjetos");
    const carro = async () => {
        try {
            const response = await fetch('./actions/mostrar_carro.php');
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                $(".noObjetos").empty();
                error.innerText = "<?= $lang['buscar-medicamento-falloServidor']; ?>";
            }
        } catch (error) {
            console.log(error.message);
        }
    };

    function mostrarTienda() {
        carro()
                .then(datos => {
                    $("#contenedor-carrito").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['carro-noProductos'] . "`);"; ?>
                    } else {
                        error.style.display = 'none';
                        contCarro.style.display = 'block';
                        console.log(datos);
                        let total = 0;
                        datos.map(item => {
                            let linea = document.createElement("div");
                            let elemento1 = document.createElement("div");
                            elemento1.classList.add("productoFoto");
                            elemento1.style.backgroundImage = `url(${item.imagen})`;
                            let elemento2 = document.createElement("div");
                            let parrafoElemento2 = document.createElement("p");
                            parrafoElemento2.innerText = item.nombre;
                            elemento2.appendChild(parrafoElemento2);
                            let elemento3 = document.createElement("div");
                            let parrafoElemento3 = document.createElement("p");
                            parrafoElemento3.innerText =<?php if ($idioma === "es") { ?>item.categoria_es<?php } else { ?>item.categoria_val<?php } ?>;
                            elemento3.appendChild(parrafoElemento3);
                            let elemento4 = document.createElement("div");
                            let parrafoElemento4 = document.createElement("p");
                            parrafoElemento4.innerText = item.precio + "€";
                            elemento4.appendChild(parrafoElemento4);
                            let elemento5 = document.createElement("div");
                            let menos = document.createElement("button");
                            menos.setAttribute("onclick", `cantidad("menos", ${item.stock}, ${item.id})`);
                            menos.innerHTML = "<i class=\"fa-solid fa-minus\"></i>";
                            let mas = document.createElement("button");
                            mas.setAttribute("onclick", `cantidad("mas",${item.stock}, ${item.id})`);
                            mas.innerHTML = "<i class=\"fa-solid fa-plus\"></i>";
                            let valor = document.createElement("input");
                            valor.type = "number";
                            valor.classList.add(`cantidadProducto${item.id}`);
                            valor.min = 1;
                            valor.max = item.stock;
                            valor.step = 1;
                            valor.value = item.cantidad;
                            let eliminar = document.createElement("span");
                            eliminar.innerHTML = "<i class=\"fa-regular fa-xmark\"></i>";
                            eliminar.setAttribute("onclick", `vaciar("eliminar",${item.id})`);
                            elemento5.append(menos, valor, mas, eliminar);
                            let elemento6 = document.createElement("div");
                            let parrafoElemento6 = document.createElement("p");
                            parrafoElemento6.innerText = item.precio * item.cantidad + "€";
                            parrafoElemento6.id = "total";
                            elemento6.appendChild(parrafoElemento6);
                            total += item.precio * item.cantidad;
                            linea.append(elemento1, elemento2, elemento3, elemento4, elemento5, elemento6);
                            contCarro.appendChild(linea);
                        });
                        let elemento7 = document.createElement("div");
                        let parrafoElemento7 = document.createElement("p");
                        parrafoElemento7.innerHTML = "<span>Total:</span> " + total.toFixed(2) + "€";
                        elemento7.appendChild(parrafoElemento7);
                        contCarro.appendChild(elemento7);
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
        contCarro.style.display = 'none';
        error.innerHTML = err;
    }

    mostrarTienda();

    function vaciar(uno, item) {
        try {
            let nuevoItem = new FormData();
            nuevoItem.append("item", item);
            nuevoItem.append("uno", uno);
            fetch('./actions/vaciar-carro.php', {method: "POST", body: nuevoItem});
            location.reload();
        } catch (error) {
            console.log(error.message);
        }
    }

    function cantidad(tipo, stock, item) {
        let valor = document.querySelector(`.cantidadProducto${item}`);
        if (tipo === "mas") {
            valor.value = (+valor.value >= stock) ? stock : +valor.value + 1;
        } else {
            valor.value = (+valor.value <= 1) ? 1 : valor.value - 1;
        }
        try {
            let nuevoItem = new FormData();
            nuevoItem.append("item", item);
            nuevoItem.append("cantidad", valor.value);
            nuevoItem.append("carrito", "carrito");
            fetch('./actions/aniadir-carro.php', {method: "POST", body: nuevoItem});
            location.reload();
        } catch (error) {
            console.log(error.message);
        }
    }

    function comprar() {
        let totalPagar = document.querySelector("#total");
        if (totalPagar) {
            totalPagar = parseFloat(totalPagar.innerText);
            let errorFondos = document.querySelector(".nofondos");
            let gracias = document.querySelector(".gracias");
            let siento = document.querySelector(".loSiento");

            const total = async () => {
                try {
                    let nuevoItem = new FormData();
                    nuevoItem.append("total", totalPagar);
                    const response = await  fetch('./actions/comprar.php', {method: "POST", body: nuevoItem});
                    if (response.status === 200 && response.ok) {
                        return response.json();
                    } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                        $(".noObjetos").empty();
                        error.innerText = "<?= $lang['buscar-medicamento-falloServidor']; ?>";
                    }
                } catch (error) {
                    console.log(error.message);
                }
            };

            total()
                    .then(datos => {
                        if (datos === "fondos") {
                            errorFondos.style.display = "block";
                            setTimeout(() => {
                                errorFondos.style.display = "none";
                            }, 4000);
                        } else {
                            if (datos === "gracias") {
                                gracias.style.display = "block";
                                setTimeout(() => {
                                    gracias.style.display = "none";
                                }, 4000);
                            } else {
                                siento.style.display = "block";
                                setTimeout(() => {
                                    siento.style.display = "none";
                                }, 4000);
                            }
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 4000);
                    })
                    .catch(
                            error => {
                                console.log(error);
                            });
        }

    }
</script>
