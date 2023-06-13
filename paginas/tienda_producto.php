<?php
session_start();
include_once "../utiles/configuracion.php";
include_once "../utiles/funciones.php";
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
include_once "../utiles/rutas.php";
include_once "./encabezado.php";
?>
<main>
    <div class="tiendaProducto">

        <div class="volver">
            <p>
                <a href="<?= $ruta['tienda']; ?>" ><i class="fa-solid fa-backward"></i><?= $lang['foro-volver']; ?></a>
            </p>
        </div>

        <div id="contenedor-producto">

        </div>

        <p class="noProducto" style="display:none"></p>

    </div>

</main>

<script>
//Variables utilizadas
    const contProducto = document.getElementById("contenedor-producto");
    const error = document.querySelector(".noProducto");
    //Petición a la BBDD guardad en una variable
    const producto = async () => {
        try {
            let productoID = new FormData();
            productoID.append("id", <?= $_GET['producto'] ?>);
            const response = await fetch('../actions/cargar_producto.php', {method: "POST", body: productoID});
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "');"; ?>
                $(".noProducto").empty();
                error.innerText = "<?= $lang['buscar-medicamento-falloServidor']; ?>";
            }
        } catch (error) {
            console.log(error.message);
        }
    };
    //Muestra los datos de la petición
    function mostrarProducto() {
        producto()
                .then(datos => {
                    $("#contenedor-producto").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['tienda-noProductos'] . "`);"; ?>
                    } else {
                        error.style.display = 'none';
                        contProducto.style.display = 'block';
                        console.log(datos);
                        let id = 0;
                        datos.map(item => {
                            let divProducto = document.createElement("div");
                            divProducto.classList.add("ProductoSolo");
                            let divInterior = document.createElement("div");
                            let divIn1 = document.createElement("div");
                            let imagen = new Image;
                            imagen.src = "." + item.imagen;
                            imagen.width = 200;
                            divIn1.appendChild(imagen);
                            let divIn2 = document.createElement("div");
                            let pIn2Nombre = document.createElement("p");
                            pIn2Nombre.innerText = item.nombre;
                            divIn2.appendChild(pIn2Nombre);
                            let divIn4 = document.createElement("div");
                            let pIn4Descripcion = document.createElement("p");
                            pIn4Descripcion.innerHTML = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc luctus, lacus ac viverra suscipit, elit velit sollicitudin mauris, in viverra sapien diam sed turpis. Vestibulum vitae augue venenatis, ornare ligula non, porta velit. Sed porta arcu quis fringilla rutrum. Nam ornare sodales aliquam. Curabitur at vulputate dui. Etiam ac malesuada lectus. Nullam et posuere arcu. Duis sodales, sem et congue convallis, urna odio condimentum ex, a pulvinar dui justo ut odio. Duis porttitor luctus urna, non malesuada magna suscipit nec. Vestibulum efficitur tortor vel malesuada viverra. Nam posuere, libero eget feugiat egestas, nibh massa pharetra nibh, pharetra iaculis ipsum nulla sit amet magna. Donec tincidunt, augue a vestibulum gravida, eros leo porta arcu, at lacinia metus est vel velit.</br></br>Quisque fringilla elementum efficitur. Integer pellentesque scelerisque nisi sed pulvinar. Ut porta non est nec aliquet. Praesent augue justo, auctor eget arcu non, facilisis aliquam erat. Nulla et nulla ut mi ultricies gravida. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus rutrum, erat ut commodo tempus, turpis ligula gravida lorem, nec fringilla eros arcu et ante. Suspendisse potenti. Nam tempor odio nec tortor tincidunt, vitae finibus libero convallis. Integer et ante ac urna laoreet sollicitudin. Donec consequat felis placerat lorem scelerisque interdum id ornare metus. Nulla vulputate, tellus in tristique imperdiet, purus massa pulvinar ex, ac pharetra mauris sapien in augue. Suspendisse dapibus blandit lectus, at mattis augue. Quisque vitae lectus auctor, scelerisque nulla at, posuere risus. Mauris vitae tortor vel felis pharetra vehicula in ut nibh. Maecenas a pharetra ex.";
                            divIn4.appendChild(pIn4Descripcion);
                            let divIn3 = document.createElement("div");
                            let pIn3Precio = document.createElement("p");
                            pIn3Precio.innerText = parseFloat(item.precio).toFixed(2) + " €";
                            divIn3.append(pIn3Precio);
                            let divBotones = document.createElement("div");
                            let cantidad = document.createElement("div");
                            cantidad.classList.add("Cantidad");
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
                            valor.value = 1;
                            cantidad.append(menos, valor, mas);
                            let alCarro = document.createElement("div");
                            let comprar = document.createElement("button");
                            comprar.setAttribute("onclick", `aniadir(${item.id},${item.stock})`);
                            comprar.classList.add("fa-sharp");
                            comprar.innerHTML = "<?= $lang['tienda-boton-aniadir']; ?>";
                            alCarro.append(comprar);
                            divBotones.append(cantidad, comprar);
                            divInterior.append(divIn1, divIn2, divIn3, divIn4);
                            divProducto.append(divInterior, divBotones);
                            contProducto.appendChild(divProducto);
                            id = item.id;
                        });
                        let valor = document.querySelector(`.cantidadProducto${id}`);
                        valor.addEventListener("input", event => {
                            let max = valor.getAttribute("max");
                            if (event.srcElement.value > max) {
                                valor.value = max;
                            }
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
        contProducto.style.display = 'none';
        error.innerHTML = err;
    }

    mostrarProducto();


    function aniadir(item, stock) {
        try {
            let valor = document.querySelector(`.cantidadProducto${item}`);
            let max = valor.getAttribute("max");
            if (valor.value >= +max) {
                return;
            }
            let nuevoItem = new FormData();
            nuevoItem.append("item", item);
            nuevoItem.append("cantidad", valor.value);
            nuevoItem.append("stock", stock);
            fetch('../actions/aniadir-carro.php', {method: "POST", body: nuevoItem});
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
    }

</script>
<?php
include_once "../paginas/pie.php";
?>    

