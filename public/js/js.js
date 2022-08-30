window.addEventListener("load", function () {

    //Choises.js aplicar a clase js-choice
    var slides = document.getElementsByClassName("js-choice");
    for (var i = 0; i < slides.length; i++) {
        newChoisesJs(slides.item(i));
    }

    //Boton agregar a clase add_item_link
    document
            .querySelectorAll('.add_item_link')
            .forEach(btn => {
                btn.addEventListener("click", addFormToCollection)
            });

    //Boton eliminar detalles
    //Actualizar Stock al iniciar
    document
            .querySelectorAll('tbody.detalles tr')
            .forEach((item) => {
                addFormDeleteLink(item)
                updateStock(item);
            })

    //Actualizar stock cuando cambia valor
    document
            .querySelectorAll('tbody.detalles tr')
            .forEach((item) => {

            })

});

const newChoisesJs = (item) => {
    return new Choices(item, {
        loadingText: 'Cargando...',
        noResultsText: 'No hay resultados',
        noChoicesText: 'No hay opciones para seleccionar',
        itemSelectText: 'Presione para seleccionar'
    });
}

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('tr');

    item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                    /__name__/g,
                    collectionHolder.dataset.index
                    );
    collectionHolder.insertBefore(item, collectionHolder.firstChild);
    ;

    //Agregar link para borrar
    addFormDeleteLink(item);

    //Agregar choises.js
    item.querySelectorAll('.js-choice')
            .forEach((item) => {
                newChoisesJs(item);

            });

    //Stock
    updateStock(item);

    collectionHolder.dataset.index++;
};

const addFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('td');
    removeFormButton.innerHTML = '<button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>';
    item.append(removeFormButton);
    $(removeFormButton.firstChild).confirmButton({

  confirm:"¿Esta seguro de quitar este producto?",
  canceltxt: "Cancelar",
  confirmtxt: "Confirmar",
  titletxt: "Atención"

});

    removeFormButton.firstChild.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the tr for the form
        //if (confirm('¿Está seguro de eliminar?')) {
            item.remove()
        //}
    });
}

const updateStock = (item) => {

    var stockEl;
    var prodEl;
    var cantEl;

    //Buscar el control de stock
    item.querySelectorAll('.producto_stock')
            .forEach((stock) => {
                stockEl = stock;
            });
    
    //Buscar el control del producto
    item.querySelectorAll('.js-choice')
            .forEach((prod) => {
                prodEl = prod;
            });
            
    //Actualizar el control de Stock con el valor del producto seleccionado
    ps.forEach((v) => {
        if (v.id == prodEl.value) {
            stockEl.value = v.Stock;
        }
    });
    
    //Buscar el control de Cantidad y agregarle el tooltip de Stock
    item.querySelectorAll('.producto_cantidad')
            .forEach((cant) => {
                cantEl = cant;
                cantEl.setAttribute('title', 'Stock Actual: ' + stockEl.value);
                new bootstrap.Tooltip(cantEl);
            });

    //Configurar el valor máximo y el actual para no superar el Stock
    cantEl.setAttribute('max', stockEl.value);
    if(cantEl.value == ''){
        cantEl.value = 1;
    }
    if (parseInt(cantEl.value) > parseInt(stockEl.value)) {
        //alert(cantEl.value + ' ' + stockEl.value + (parseInt(cantEl.value) > parseInt(stockEl.value)));
        cantEl.value = stockEl.value;
    }
    
    //Agregar esta función al vento de cambio de Valor del Producto
    prodEl.onchange = function () {
        updateStock(item);
    }

}