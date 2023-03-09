<!-- Este archivo muestra al admin un listado de datos de la tabla usuarios -->
<div>
    <div>
        <span><?= $lang['listado-orden']; ?></span>   
        <select name="filtro" id="filtro">
            <?php
            $columnas = filtro("usuarios");
            foreach ($columnas as $value) {
                echo "<option value='" . $lang[$value] . "'>" . $lang[$value] . "</option>";
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
            </tr>
        </thead>
        <tbody></tbody>
    </table>


</div>
<script>
    //Obtengo los datos de la tabla usuarios
    const select = document.querySelector("#filtro");
    const tbody = document.querySelector("#datos-usuario tbody");
    let valor = select.addEventListener('change',
            function () {
                const selectedOption = this.options[select.selectedIndex];
                let orden = new FormData();
                orden.append("orden", selectedOption);
            });
    //AQUI HAY QUE HACER ALGO
    try {
        fetch('./actions/listar.php', {method: 'POST', body: orden})
                .then(res => res.json())
                .then(data => {

                    data.map(item => {
                        let row = document.createElement("tr");
                        let contador = 0;
                        for (const key in item) {
                            if (item[key] === 'imagen')
                                continue;
                            let dato = document.createElement("td");
                            dato.innerText = (item[key] === null) ? "Null" : item[key];
                            row.appendChild(dato);
                            contador++;
                        }
                        //row.appendChild("<td><form action="./actions/borrar-user.php" method="post"><input type="hidden" name="user-id-del" value="${item.id}"><input type="submit" name"delete" value="Eliminar"></form></td>");
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
                        form.appendChild(input);
                        form.appendChild(input2);
                        dato_form.appendChild(form);
                        row.appendChild(dato_form);
                        tbody.appendChild(row);
                    });
                });
    } catch (error) {
        console.log("Error al listar usuarios " + error.message());
    }

    const userDel = document.createElement("p");
    const body = document.getElementsByTagName("body");
<?php
//Aviso si el usuario ha sido eliminado
if (isset($_GET['eliminado'])) {
    if (htmlspecialchars($_GET['eliminado'])) {
        ?>
            userDel.setAttribute("class", "aviso verde");
        <?php
        echo "userDel.innerHTML ='" . $lang['login-eliminado'] . "';";
        ?>
            body[0].appendChild(userDel);
        <?php
    } else {
        ?>
            userDel.setAttribute("class", "aviso rojo");
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
