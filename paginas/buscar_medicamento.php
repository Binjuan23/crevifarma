<div>

    <h1><?= $lang['buscar-medicamento-h1']; ?></h1>

    <div class="buscador-medicamentos">
        <input type="search" id="busca-med" name="busca-med" placeholder="<?= $lang['buscar-medicamento-nombre']; ?>">        
    </div>

    <div class="error-medicamento" style="display:none">
        <p></p>
    </div>

    <div class="resultados-busqueda"></div>    

</div>

<script>
    window.addEventListener('DomContentLoaded', () => {
        const resultadoBusqueda = document.querySelector(".resultados-busqueda");
        const error = document.querySelector(".error-medicamento");
        const busca_med = document.querySelector("#busca-med");
        let medicamento = '';

        if (busca_med) {
            busca_med.addEventListener("input", event => {
                medicamento = event.target.value;
                showResults();
            });
        }

        const busquedaMed = async () => {
            try {
                let buscaMedData = new FormData();
                buscaMedData.append("medicamento", medicamento);
                const response = await fetch('./actions/listar.php', {method: "POST", body: buscaMedData});
                return response.json();
            } catch (error) {
                console.log(error.message);
            }
        };
        const showResults = () => {
            busquedaMed()
                    .then(datos => {
                    if (typeof datos.data !== 'undefined' && !datos.data) {
                    error.style.display = 'block';
                            resultadoBusqueda.style.display = 'none';
                            error.querySelector("p").innerText = `No existe o no se encuentra el medicamento: <span class="rojo"> ${medicamento} </span>`;
                    } else {

                    });
                    };
                };
            });
</script>