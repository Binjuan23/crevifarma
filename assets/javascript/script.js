function aniadir1(item, stock) {
    try {
        let nuevoItem = new FormData();
        nuevoItem.append("item", item);
        nuevoItem.append("stock", stock);
        fetch('./actions/aniadir-carro.php', {method: "POST", body: nuevoItem});
    } catch (error) {
        console.log(error.message);
    }

}

function cantidad(tipo, stock, item) {
    let valor = document.querySelector(`.cantidadProducto${item}`);

    if (tipo === "mas") {
        valor.value = (+valor.value >= stock) ? stock : +valor.value + 1;
    } else {
        valor.value = (+valor.value <= 1) ? 1 : valor.value - 1;
    }
    try {
        let nuevoItem = new FormData();
        nuevoItem.append("item", item);
        nuevoItem.append("cantidad", valor.value);
        fetch('./actions/aniadir-carro.php', {method: "POST", body: nuevoItem});
    } catch (error) {
        console.log(error.message);
    }

}

