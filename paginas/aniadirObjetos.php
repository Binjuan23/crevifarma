<?php
//comprobar_sesion("farmacia");
?>
<div>
    <div>

        <p class="verde" style="display:none"><?= $lang['producto-eliminado'] ?></p>
        <p class="rojo" style="display:none"><?= $lang['producto-noEliminado'] ?></p>

        <table id="medicamentos">
            <thead>
                <tr>
                    <th><?= $lang['nombre'] ?></th>
                    <th>Stock</th>
                    <th><?= $lang['precio'] ?></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>


        </table>

    </div>

    <div id="contenedor-formulario" style="display:none">

        <h2><?= $lang['aniadir-objetos'] ?></h2>

        <form action="./actions/aniadir_producto.php" method="post" id="insertar-form" enctype="multipart/form-data">

            <div class="input-box">
                <label for="parafarmacia">Parafarmacia</label>
                <input type="radio" name="tipo" id="parafarmacia" value='parafarmacia' required checked>
                <label for="medicamento"><?= $lang['aniadir-medicamento']; ?></label>
                <input type="radio" name="tipo" id="medicamento" value='medicamento' required>
            </div> 

            <div class="input-box">
                <label for="nombre"><?= $lang['nombre']; ?></label>
                <input type="text" name="nombre" id="nombre" placeholder="<?= $lang['nombre']; ?>" required>
            </div>

            <div class="input-box">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" step="1" min="0" placeholder="Stock" required>
            </div>

            <div class="input-box para">
                <label for="categoria_es"><?= $lang['categoria-español']; ?></label>
                <input type="text" name="categoria_es" id="categoria_es" placeholder="<?= $lang['categoria-español']; ?>" required>
            </div>

            <div class="input-box para">
                <label for="id">Id</label>
                <input type="number" name="id" id="id" step="1" min="0" max="99999" placeholder="Id" required>
            </div>

            <div class="input-box para">
                <label for="categoria_val"><?= $lang['categoria-valenciano']; ?></label>
                <input type="text" name="categoria_val" id="categoria_val" placeholder="<?= $lang['categoria-valenciano']; ?>" required>
            </div>

            <div class="input-box para">
                <label for="precio"><?= $lang['precio']; ?></label>
                <input type="number" step="any" min="0" name="precio" id="precio" placeholder="<?= $lang['precio']; ?>" required>
            </div>
            <div class="input-box para">
                <label for="imagen"><?= $lang['imagen']; ?>(.jpg .jpeg .png .ico .bmp)</label>
                <input type="file" name="imagen" id="imagen" required>
            </div>


            <input type="submit" value="Agregar" name="insert-boton" class="form-boton">

        </form>
        <button onclick="cerrarForm()"><?= $lang['aniadir-cerrarForm'] ?></button>
    </div>

    <div id="contenedor-modificar" style="display:none">

        <h2><?= $lang['aniadir-objetosModificar'] ?></h2>

        <form action="./actions/modificar_producto.php" method="post" id="modificar-form">

            <div class="input-box">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stockM" step="1" min="0" placeholder="Stock">
            </div>

            <div class="input-box">
                <label for="precio"><?= $lang['precio']; ?></label>
                <input type="number" step="any" min="0" name="precio" id="precioM" placeholder="<?= $lang['precio']; ?>">
            </div>

            <input type="submit" value="Modificar" name="modificar-boton" class="form-boton">

        </form>
        <button onclick="cerrarForm()"><?= $lang['aniadir-cerrarForm'] ?></button>
    </div>
    <div class="botonForm">
        <button onclick="mostrarForm()"><?= $lang['aniadir-botonForm'] ?></button>
    </div>
    <p class="noInsert" style="display:none"></p>


</div>

<script>
    const medicamentos = document.getElementById("medicamentos");
    const formNuevo = document.getElementById("contenedor-formulario");
    const boton = document.querySelector(".botonForm");
    const formMod = document.getElementById('contenedor-modificar');
    const mostrarMedicamentos = async () => {

        try {
            const response = await fetch('./actions/mostrar_medicamentos.php');

            return response.json();

        } catch (error) {
            console.log("Error al listar medicamentos " + error.message());
        }
    };

    mostrarMedicamentos()
            .then(data => {
                let tbody = document.createElement("tbody");
                data.map(item => {
                    let row = document.createElement("tr");
                    for (const key in item) {
                        if (key !== 'id') {
                            let dato = document.createElement("td");
                            if (key !== "id") {
                                dato.innerText = (key !== "tipo") ? item[key] : (item[key] === "tipomedicamento") ? "" : item[key] + "€";
                            }
                            row.appendChild(dato);
                        }
                    }
                    let dato_mod = document.createElement("td");
                    let modificar = document.createElement("button");
                    modificar.classList.add("modificar");
                    modificar.setAttribute("onclick", `modificar(${item.id},\"${item.tipo}\")`);
                    modificar.innerText = "Modificar";
                    dato_mod.appendChild(modificar);
                    row.appendChild(dato_mod);
                    let dato_form = document.createElement("td");
                    let form = document.createElement("form");
                    form.action = "./actions/borrar_medicamento.php";
                    form.method = "post";
                    form.id = "eliminarProducto";
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "medicamento-id-del";
                    input.value = item.id;
                    let input3 = document.createElement("input");
                    input3.type = "hidden";
                    input3.name = "tipo";
                    input3.value = item.tipo;
                    let input2 = document.createElement("input");
                    input2.type = "submit";
                    input2.name = "delete";
                    input2.value = "Eliminar";
                    form.append(input, input2, input3);
                    dato_form.appendChild(form);
                    row.appendChild(dato_form);
                    tbody.appendChild(row);
                });
                medicamentos.appendChild(tbody);
            });

    function mostrarForm() {
        formNuevo.style.display = "block";
        boton.style.display = "none";
        formMod.style.display = "none";
    }

    function cerrarForm() {
        formNuevo.style.display = "none";
        boton.style.display = "block";
        formMod.style.display = "none";
    }

    function modificar(id, tipo) {
        let hide = document.querySelectorAll("#modificar-form>input[type='hidden']");
        if (hide) {
            hide.forEach(item => item.remove());
        }
        console.log(hide);
        formNuevo.style.display = "none";
        boton.style.display = "none";
        formMod.style.display = "block";
        let modiform = document.getElementById("modificar-form");
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = "id";
        input.value = id;
        let input3 = document.createElement("input");
        input3.type = "hidden";
        input3.name = "tipo";
        input3.value = tipo;
        modiform.append(input, input3);
    }

    const verde = document.querySelector(".verde");
    const rojo = document.querySelector(".rojo");

<?php if (isset($_GET["eliminado"]) && $_GET["eliminado"]) { ?>
        verde.style.display = "block";
        setTimeout(() => {
            verde.style.display = "none";
        }, 3000);
<?php } else if (isset($_GET["eliminado"]) && !$_GET["eliminado"]) { ?>
        rojo.style.display = "block";
        setTimeout(() => {
            rojo.style.display = "none";
        }, 3000);
<?php } ?>

    $(document).ready(function () {
        let tipo = document.getElementsByName("tipo");
        let datos = document.querySelectorAll(".para");
        tipo.forEach(element => element.addEventListener("click", () => {
                if (element.value === "parafarmacia") {
                    datos.forEach(element => element.style.display = "block");
                } else {
                    datos.forEach(element => element.style.display = "none");
                }
            }));
        $('#insertar-form').validate({
            focusCleanup: true,
            errorPlacement: function (error, element) {
                error.appendTo(element.parent());
            },
            rules: {
                nombre: {
                    required: true
                },
                stock: {
                    required: true
                },
                id: {
                    required: true,
                    maxlength: 5,
                    pattern: /\d{5}/,
                    remote: "./actions/aniadir_producto.php"
                },
                "categoria_es": {
                    required: true
                },
                "categoria_val": {
                    required: true
                },
                precio: {
                    required: true
                },
                imagen: {
                    required: true,
                    extension: "jpg|jpeg|png|ico|bmp"
                }
            },
            messages: {
                nombre: '<?= $lang['aniadir-nombre']; ?>',
                stock: {
                    required: '<?= $lang['aniadir-stock']; ?>'
                },
                id: {
                    required: '<?= $lang['aniadir-id']; ?>',
                    rangelength: '<?= $lang['aniadir-idMax']; ?>',
                    pattern: '<?= $lang['aniadir-idPattern']; ?>',
                    remote: "<?= $lang['aniadir-idRepe']; ?>"
                },
                "categoria_es": {
                    required: '<?= $lang['aniadir-categoriaEs']; ?>'
                },
                "categoria_val": "<?= $lang['aniadir-categoriaVal']; ?>",
                precio: {
                    required: '<?= $lang['aniadir-precio']; ?>'
                },
                imagen: {
                    required: '<?= $lang['aniadir-imagen']; ?>',
                    extension: '<?= $lang['aniadir-imagenExt']; ?>'
                }

            }
        });
        $('#insertar-form').submit(function (event) {
            event.preventDefault();
            let $formInsert = $('#insertar-form');

            if ($formInsert.valid()) {
                let file_data = $('#imagen').prop('files')[0];
                let form_data = new FormData();
                form_data.append('imagen', file_data);
                form_data.append('nombre', $("#nombre").val());
                form_data.append('id', $("#id").val());
                form_data.append('categoria_es', $("#categoria_es").val());
                form_data.append('categoria_val', $("#categoria_val").val());
                form_data.append('precio', $("#precio").val());
                form_data.append('stock', $("#stock").val());
                form_data.append('tipo', $("input[name='tipo']").val());
                $.ajax({
                    type: 'POST',
                    url: './actions/aniadir_producto.php',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        const aniadido = document.querySelector(".noInsert");
                        formNuevo.style.display = "none";
                        boton.style.display = "block";
                        aniadido.style.display = "block";
                        aniadido.innerText = "<?= $lang['aniadir-bien'] ?>";
                        setTimeout(() => {
                            aniadido.style.display = "none";
                            aniadido.innerTEXT = '';
                            location.reload();
                        }, 3000);
                    }
                });

            } else {
                console.log("Faltan campos");
            }


        })
                ;
        $('#modificar-form').submit(function (event) {
            event.preventDefault();
            let form = new FormData();
            let stock = $("#stockM").val() || 0;
            let precio = $("#precioM").val() || 0;
            let tipo = $("#modificar-form>input[name='tipo']").val() || 0;
            let id = $("#modificar-form>input[name='id']").val() || 0;
            form.append("stock", stock);
            form.append("tipo", tipo);
            form.append("id", id);
            form.append("precio", precio);
            $.ajax({
                type: 'POST',
                url: './actions/modificar_producto.php',
                data: form,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response === "true") {
                        const aniadido = document.querySelector(".noInsert");
                        formNuevo.style.display = "none";
                        formMod.style.display = "none";
                        boton.style.display = "block";
                        aniadido.style.display = "block";
                        aniadido.innerText = "<?= $lang['aniadir-mod'] ?>";
                        setTimeout(() => {
                            aniadido.style.display = "none";
                            aniadido.innerTEXT = '';
                            location.reload();
                        }, 3000);
                    } else {
                        const aniadido = document.querySelector(".noInsert");
                        formNuevo.style.display = "none";
                        formMod.style.display = "none";
                        boton.style.display = "block";
                        aniadido.style.display = "block";
                        aniadido.innerText = "<?= $lang['aniadir-nada'] ?>";
                        setTimeout(() => {
                            aniadido.style.display = "none";
                            aniadido.innerTEXT = '';
                            
                        }, 3000);

                    }

                }
            });
        })
                ;
    });
</script>

