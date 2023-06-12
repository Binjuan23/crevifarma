
<?php
    comprobar_sesion("admin");
?>

<div class="listado">
    <div class="filtro-busqueda"> 
        <select name="filtro" id="filtro">
            <?php
            $columnas = filtro("usuarios");
            foreach ($columnas as $value) {
                if ($value === "ID") {
                    echo "<option value='' disabled selected>" . $lang['listado-orden'] . "</option>";
                    echo "<option value='$value'>" . $value . "</option>";
                } else {
                    echo "<option value='$value'>" . $lang[$value] . "</option>";
                }
            }
            ?>
        </select>
    </div>

    <table id="datos-usuario">
        <thead>
            <tr>
                <th>ID</th>
                <?php
                foreach ($columnas as $value) {
                    if ($value === 'ID') {
                        continue;
                    }
                    echo "<th>" . $lang[$value] . "</th>";
                }
                ?>
                <th></th>
            </tr>
        </thead>

    </table>


</div>
<script>
    //Obtengo los datos de la tabla usuarios
    const select = document.querySelector("#filtro");
    const table = document.getElementById("datos-usuario");

    const mostrarUsuarios = async (varOrden) => {
        let orden = new FormData();
        orden.append("orden", varOrden);
        try {
            const response = await fetch('./actions/listar.php', {method: 'POST', body: orden});

            return response.json();

        } catch (error) {
            console.log("Error al listar usuarios " + error.message());
        }
    };

    select.addEventListener('change',
            function () {
                const tableBody = document.querySelector("#datos-usuario tbody");
                const opcionSelecionada = this.options[select.selectedIndex];
                table.removeChild(tableBody);
                mostrarUsuarios(opcionSelecionada.value)
                        .then(data => {
                            crearTbody(data);
                        });

            });

    mostrarUsuarios("nada")
            .then(data => {
                crearTbody(data);
            });

    function crearTbody(data) {
        let tbody = document.createElement("tbody");
        data.map(item => {

            let row = document.createElement("tr");
            for (const key in item) {
                if (item[key] === 'imagen')
                    continue;
                let dato = document.createElement("td");
                dato.innerText = (item[key] === null) ? "Null" : item[key];
                row.appendChild(dato);
            }

            let dato_form = document.createElement("td");
            let form = document.createElement("form");
            form.action = "./actions/borrar-user.php";
            form.method = "post";
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "user-id-del";
            input.value = item.id;
            let input2 = document.createElement("input");
            input2.type = "submit";
            input2.name = "delete";
            input2.value = "Eliminar";
            input2.classList.add("botonEliminarUsuario");
            form.appendChild(input);
            form.appendChild(input2);
            dato_form.appendChild(form);
            row.appendChild(dato_form);
            tbody.appendChild(row);
        });
        table.appendChild(tbody);
    }


    const userDel = document.createElement("p");
    const body = document.getElementsByTagName("body");
<?php
//Aviso si el usuario ha sido eliminado
if (isset($_GET['eliminado'])) {
    if (htmlspecialchars($_GET['eliminado'])) {
        ?>
            userDel.className = "aviso verde";
        <?php
        echo "userDel.innerHTML ='" . $lang['login-eliminado'] . "';";
        ?>
            body[0].appendChild(userDel);
        <?php
    } else {
        ?>
            userDel.className = "aviso rojo";
        <?php
        echo "userDel.innerHTML =\"" . $lang['login-noEliminado'] . "\";";
        ?>
            body[0].appendChild(userDel);
        <?php
    }
}
?>
    const user_remove = document.querySelector(".aviso");
    if (user_remove) {
        setTimeout(() => {
            body[0].removeChild(user_remove);
        }, 4000);
    }


</script>
