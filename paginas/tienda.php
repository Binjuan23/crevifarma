<div>

    <div id="contenedor-tienda">

    </div>

    <p class="noObjetos" style="display:none"></p>

</div>

<script>
    const contTienda = document.getElementById("contenedor-tienda");
    const error = document.querySelector(".noObjetos");
    const productos = async () => {
        try {
            const response = await fetch('./actions/mostrar_tienda.php');
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
        productos()
                .then(datos => {
                    $("#contenedor-tienda").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['tienda-noProductos'] . "`);"; ?>
                    } else {
                        error.style.display = 'none';
                        contTienda.style.display = 'block';
                        console.log(datos);
                        datos.map(item => {
                            let divProducto = document.createElement("div");
                            divProducto.classList.add("Producto");
                            let divInterior = document.createElement("div");
                            divInterior.setAttribute("onclick", `location.href='./paginas/tienda_producto.php?tienda=1&id=tienda_producto&producto=${item.id}'`);
                            let divIn1 = document.createElement("div");
                            let imagen = document.createElement("image");
                            imagen.style = "background-image: url(\"" + item.imagen + "\");";
                            divIn1.appendChild(imagen);
                            let divIn2 = document.createElement("div");
                            let pIn2Nombre = document.createElement("p");
                            pIn2Nombre.innerText = item.nombre;
                            divIn2.appendChild(pIn2Nombre);
                            let divIn3 = document.createElement("div");
                            let pIn3Precio = document.createElement("p");
                            pIn3Precio.innerText = parseFloat(item.precio).toFixed(2) + " €";
                            divIn3.append(pIn3Precio);
                            let comprar = document.createElement("button");
                            comprar.setAttribute("onclick", `aniadir1(${item.id},${item.stock})`);
                            comprar.innerText = "<?= $lang['tienda-boton-aniadir']; ?>";
                            divInterior.append(divIn1, divIn2, divIn3);
                            divProducto.append(divInterior, comprar);
                            contTienda.appendChild(divProducto);
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
        contTienda.style.display = 'none';
        error.innerHTML = err;
    }

    mostrarTienda();

    
</script>
