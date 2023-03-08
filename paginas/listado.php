<!-- Este archivo muestra al admin un listado de datos de la tabla usuarios -->
<div>
    <table id="datos-usuario">
        <thead>
            <tr>
                <th>ID</th>
                <th><?= $lang['usuario']; ?></th>
                <th><?= $lang['contraseña']; ?></th>
                <th><?= $lang['nombre']; ?></th>
                <th><?= $lang['apellidos']; ?></th>
                <th><?= $lang['edad']; ?></th>
                <th><?= $lang['fecha_creacion']; ?></th>
                <th><?= $lang['ultimo_login']; ?></th>
                <th><?= $lang['tipo']; ?></th>
                <th><?= $lang['email']; ?></th>
                <th><?= $lang['direccion']; ?></th>
                <th><?= $lang['dinero']; ?></th>
            </tr>
        </thead>
    </table>


</div>
<script>
    //Obtengo los datos de la tabla usuarios

    fetch('./actions/listar.php')
            .then(res => res.json())
            .then(data => {

                let str = '<tbody>';
                console.log(data);
                data.map(item => {
                    str += `<tr>
        <td>${item.id}</td>
<td>${item.usuario}</td>
<td class="td-mobile">${item.contraseña}</td>
<td class="td-mobile">${item.nombre}</td>
<td class="td-mobile">${item.apellidos}</td>
<td class="td-mobile">${item.edad}</td>
<td class="td-mobile">${item.fecha_creacion}</td>
<td class="td-mobile">${item.ultimo_login}</td>
<td class="td-mobile">${item.tipo}</td>
<td class="td-mobile">${item.email}</td>
<td class="td-mobile">${item.direccion}</td>
<td class="td-mobile">${item.dinero}</td>
<td><form action="./actions/borrar-user.php" method="post"><input type="hidden" name="user-id-del" value="${item.id}"><input type="submit" name"delete" value="Eliminar"></form></td>
</tr>                        
                    `;
                });
                str += "</tbody>";
                document.getElementById("datos-usuario").innerHTML += str;

            });
    const userDel = document.createElement("p");
    const body = document.getElementsByTagName("body");
<?php
//Aviso si el usuario ha sido eliminado
if (isset($_GET['eliminado'])) {
    if (htmlspecialchars($_GET['eliminado'])) {
        ?>
            userDel.setAttribute("class", "aviso verde");
        <?php
        echo "userDel.innerHTML ='" . $lang['login-eliminado']."';";
        ?>
            body[0].appendChild(userDel);
        <?php
    } else {
        ?>
            userDel.setAttribute("class", "aviso rojo");
        <?php
        echo "userDel.innerHTML =\"" . $lang['login-noEliminado']."\";";
        ?>
            body[0].appendChild(userDel);
        <?php
    }
}
?>
    setTimeout(() => {
        const user_remove = document.getElementsByClassName("aviso");
        body[0].removeChild(user_remove[0]);
    }, 4000);

</script>
