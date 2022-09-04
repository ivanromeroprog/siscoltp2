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
                addFormDeleteLink(item);
                updateStock(item);
            });

    //Actualizar stock cuando cambia valor
    /*
     document
     .querySelectorAll('tbody.detalles tr')
     .forEach((item) => {
     
     });
     */

    //Data Table
    if ($('#tabla')) {
        $('#tabla').DataTable({
            language: dtlang,
            order: []
        });
    }
    if ($('#tablaventa')) {
        $('#tablaventa').DataTable({
            language: dtlang,
            order: []
        });
    }
    
    refreshTotal();
});

const newChoisesJs = (item) => {
    return new Choices(item, {
        loadingText: 'Cargando...',
        noResultsText: 'No hay resultados',
        noChoicesText: 'No hay opciones para seleccionar',
        itemSelectText: 'Presione para seleccionar'
    });
};

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('tr');
    item.classList.add('animate__animated')
    item.classList.add('animate__flash')

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
                item.focus();
                tmp = newChoisesJs(item);
            });

    //Actualizar Stock
    updateStock(item);

    //Total
    refreshTotal();

    collectionHolder.dataset.index++;
};

const addFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('td');
    removeFormButton.innerHTML = '<button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>';
    item.append(removeFormButton);
    $(removeFormButton.firstChild).confirmButton({

        confirm: "¿Esta seguro de quitar este producto?",
        canceltxt: "Cancelar",
        confirmtxt: "Confirmar",
        titletxt: "Atención"

    });

    removeFormButton.firstChild.addEventListener('click', (e) => {
        e.preventDefault();
        item.remove();
        refreshTotal();
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
    if (cantEl.value == '') {
        cantEl.value = 1;
    }
    if (parseInt(cantEl.value) > parseInt(stockEl.value)) {
        //alert(cantEl.value + ' ' + stockEl.value + (parseInt(cantEl.value) > parseInt(stockEl.value)));
        cantEl.value = stockEl.value;
    }

    //Agregar esta función al evento de cambio de Valor del Producto
    prodEl.onchange = function () {
        updateStock(item);
        refreshTotal();
    };

    //Agregar refreshTotal al evento de cambio de Valor de Cantidad
    cantEl.onchange = function () {
        refreshTotal();
    };
};

const refreshTotal = () => {

    var total = 0;

    document
            .querySelectorAll('tbody.detalles tr')
            .forEach((item) => {
                var prodEl;
                var cantEl;

                //Buscar el control del producto
                item.querySelectorAll('.js-choice')
                        .forEach((prod) => {
                            prodEl = prod;
                        });

                //Precio
                precio = 0;
                pp.forEach((v) => {
                    if (v.id == prodEl.value) {
                        precio = parseFloat(v.Precio);
                    }
                });

                //Buscar el control de Productos
                item.querySelectorAll('.producto_cantidad')
                        .forEach((cant) => {
                            cantEl = cant;
                        });

                total += (parseFloat(cantEl.value) * precio);
            });

    let nf = Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });

    document.getElementById('totalhtml').innerHTML = nf.format(parseFloat(total));

}


const fechacel = (campo) => {
    var c = document.getElementById(campo);
    var ch =  document.getElementById(campo + '_h');
    //c.type = 'text';
    if (((c.value.match(/:/g) || []).length) < 2)
    {
        ch.value = c.value + ':00';
    }
    else
    {
        ch.value = c.value;
    }
    //c.type = 'datetime-local';
}