
window.addEventListener('DomContentLoaded', () => {
    const tableContainer = document.querySelector("#datos-usuario");
    console.log("empieza");
    if (tableContainer) {
        showResults();
    }


    const usersData = async () => {
        try {
            const response = await fetch('./actions/listar.php');
            console.log("funciona");
            return response.json();
        } catch (error) {
            alert(error.message);
            console.log("no funciona");
        }
    };
    const showResults = () => {
        console.log("funciona2");
        usersData()
                .then(dataResults => {
                    /*
                    if (typeof dataResults.data !== 'undefined' && !dataResults.data) {
                        alert("No hay datos");
                    } else {*/
                        let str = '<tbody>';
                        dataResults.map(item => {
                            str += `<tr>
        <td>${item.id}</td><td>${item.usuario}</td><td>${item.contraseña}</td></tr>                        
                    `;
                        });
                        str += "</tbody>";
                        tableContainer.innerHTML += str;
                    /*}*/
                });
    };
});
