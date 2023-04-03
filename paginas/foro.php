<div>

    <div id="contenedor-preguntas">
        
    </div>   
    
    <p class="noPreguntas" style="display:none"></p>

</div>

<script>

    const contPre = document.getElementById("contenedor-preguntas");
    const error = document.querySelector(".noPreguntas");
    
    
    
    const preguntas = async () => {
        try {
            const response = await fetch('./actions/mostrar_foro.php');
            if (response.status === 200 && response.ok) {
                return response.json();
            } else {
<?php echo "throw new Error('" . $lang['buscar-medicamento-falloServidor'] . "')"; ?>
            }
        } catch (error) {
            console.log(error.message);
        }
    };

    function mostrarPreguntas() {
        preguntas()
                .then(datos => {
                    $("#contenedor-preguntas").empty();
                    if (typeof datos !== 'undefined' && !datos) {
<?php echo "controlError(`" . $lang['foro-noPreguntas'] . "`)"; ?>
                    } else {
                        console.log(datos);
                        /*
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
                         picture.appendChild(imagenDef);
                         div.appendChild(picture);
                         let parrafo1 = document.createElement("p");
                         parrafo1.innerHTML = item.medicamento.toUpperCase().replace(medicamento, '<span class="rojo">$&</i>');
                         div.appendChild(parrafo1);
                         let parrafo2 = document.createElement("p");
                         div.appendChild(parrafo2);
                         let parrafo3 = document.createElement("p");
                         div.appendChild(parrafo3);
                         resultadoBusqueda.appendChild(div);
                         });*/
                    }
                })
                .catch(error => {
                    console.log(error);
                    controlError(error)
                });
    }
    ;

    function controlError(err) {
        error.style.display = 'block';
        contPre.style.display = 'none';
        error.querySelector("p").innerHTML = err;
    }

    mostrarPreguntas();

</script>