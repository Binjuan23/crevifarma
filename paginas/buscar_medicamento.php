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

    const resultadoBusqueda = document.querySelector(".resultados-busqueda");
    const error = document.querySelector(".error-medicamento");
    const busca_med = document.querySelector("#busca-med");
    let medicamento = '';
    //Controlo que exista el elemento, coloco un evento para cuando se escribe e invoco la función para mostrar resultados
    if (busca_med) {
        busca_med.addEventListener("input", event => {
            medicamento = event.target.value.toUpperCase().trim();
            $(".resultados-busqueda").empty();

            if (medicamento !== '') {
                mostrarResultados();
            }
        });
    }
    //Busca en la bbdd segun lo escrito en el campo de busqueda
    const busquedaMed = async () => {
        try {
            let buscaMedData = new FormData();
            buscaMedData.append("medicamento", medicamento);
            const response = await fetch('./actions/buscar_med.php', {method: "POST", body: buscaMedData});

            return response.json();
        } catch (error) {
            console.log(error.message);
        }
    };
    //Muestro los resultados según el criterio de busqueda
    function mostrarResultados() {
        busquedaMed()
                .then(datos => {
                    $(".resultados-busqueda").empty();
                    if (typeof datos.data !== 'undefined' && !datos.data) {
                        error.style.display = 'block';
                        resultadoBusqueda.style.display = 'none';
                        error.querySelector("p").innerHTML = `No existe o no se encuentra el medicamento: <span class="rojo"> ${medicamento} </span>`;
                    } else {
                        console.log(datos);
                        error.style.display = 'none';
                        resultadoBusqueda.style.display = 'block';
                        datos.map(item => {
                            let div = document.createElement("div");
                            let picture = document.createElement("picture");
                            let source1 = document.createElement("source");
                            source1.srcset = "";
                            source1.media = "(min-width: 992px)";
                            picture.appendChild(source1);
                            let source2 = document.createElement("source");
                            source2.srcset = "";
                            source2.media = "(min-width: 768px)";
                            picture.appendChild(source2);
                            let source3 = document.createElement("source");
                            source3.srcset = "";
                            source3.media = "(min-width: 576px)";
                            picture.appendChild(source3);
                            let imagenDef = document.createElement("img");
                            imagenDef.src = "";
<?php echo "imagenDef.alt = '" . $lang['buscar-medicamento-imagenDef'] . "'; " ?>
                            picture.appendChild(imagenDef);
                            div.appendChild(picture);
                            let parrafo1 = document.createElement("p");
                            parrafo1.innerHTML = item.medicamento.toUpperCase().replace(medicamento, '<i>$&</i>');
                            div.appendChild(parrafo1);
                            resultadoBusqueda.appendChild(div);
                        });
                    }
                });
    }
    ;
</script>