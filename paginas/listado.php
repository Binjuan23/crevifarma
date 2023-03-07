<div>
    <table id="datos-usuario">
        <thead>
            <tr>
                <th>ID</th>
                <th><?= $lang['usuario']; ?></th>
                <th><?= $lang['contraseña']; ?></th>
            </tr>
        </thead>
    </table>

</div>
<script>
    fetch('./actions/listar.php')
            .then(res => res.json())
            .then(data => {
                let str = '<tbody>';
                console.log(data);
                data.map(item => {
                    str += `<tr>
        <td>${item.id}</td><td>${item.usuario}</td><td>${item.password}</td></tr>                        
                    `;
                });
                str += "</tbody>";
                document.getElementById("datos-usuario").innerHTML += str;
            });
</script>
